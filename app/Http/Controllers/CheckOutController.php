<?php

namespace App\Http\Controllers;

use App\Models\CheckOut;
use App\Models\CheckIn;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CheckOutController extends Controller
{
    public function index()
{
    $checkOuts = CheckOut::with('checkIn.booking.customer')->get();
    return view('check_outs.index', compact('checkOuts'));
}

public function create($checkInId)
{
    Log::info("Starting check-out creation for CheckIn ID: {$checkInId}");

    try {
        $checkIn = CheckIn::with('booking', 'booking.customer', 'booking.additionalCharges')
            ->findOrFail($checkInId);
//dd($checkIn);
        Log::info("CheckIn data retrieved:", $checkIn->toArray());

        // Convert dates to Carbon instances
        $checkInDate = Carbon::parse($checkIn->booking->check_in_date);
        $checkOutDate = Carbon::parse($checkIn->booking->check_out_date);

        Log::info("Check-in date: {$checkInDate}, Check-out date: {$checkOutDate}");

        // Fetch additional charges from the pivot table
        $additionalCharges = $checkIn->booking->additionalCharges->map(function ($charge) {
            return [
                'description' => $charge->description,
                'amount' => $charge->amount,
            ];
        });

        Log::info("Additional Charges:", $additionalCharges->toArray());

        // Calculate room details. Room tariff is now from the booking table
        $roomDetails = collect($checkIn->booking->rooms)->map(function ($room) use ($checkInDate, $checkOutDate, $checkIn) {
            $days = $checkInDate->diffInDays($checkOutDate) ?: 1;
            // Access tariff from the booking table using a relationship or attribute.
            $tariff = $checkIn->booking->room_tariff; 
            $total = $tariff * $days;
            $tax = $total * 0.12;

            Log::info("Room Details - Room Number: {$room->room_number}, Tariff: {$tariff}, Days: {$days}, Total: {$total}, Tax: {$tax}");

            return [
                'room_number' => $room->room_number,
                'room_type' => $room->roomType->name ?? 'N/A', // Null safe operator in case roomType is not set
                'tariff' => $tariff,
                'days' => $days,
                'total' => $total,
                'tax' => $tax,
            ];
        });


        Log::info("All Room Details:", $roomDetails->toArray());

        // Totals
        $totalTariff = $roomDetails->sum('total');
        $totalTax = $roomDetails->sum('tax');
        $totalAdditionalCharges = $additionalCharges->sum('amount');
        $advance = $checkIn->booking->advance_payment;

        Log::info("Totals - Tariff: {$totalTariff}, Tax: {$totalTax}, Additional Charges: {$totalAdditionalCharges}, Advance: {$advance}");

        return view('check_outs.create', compact(
            'checkIn',
            'roomDetails',
            'additionalCharges',
            'totalTariff',
            'totalTax',
            'totalAdditionalCharges',
            'advance'
        ));

    } catch (\Exception $e) {
        Log::error("Error during check-out creation: " . $e->getMessage());
        Log::error("Stack Trace: " . $e->getTraceAsString());
        abort(500, "An error occurred during check-out creation.");
    }
}

public function store(Request $request, $checkInId)
{
    /*$request->validate([
        'additional_charges' => 'required|array',
        'additional_charges.*.amount' => 'required|numeric|min:0',
        'discount' => 'nullable|numeric|min:0',
        'discount_remarks' => 'nullable|string|max:255',
        'gst' => 'required|numeric|min:0',
    ]);*/

    Log::info("Starting check-out store process for CheckIn ID: {$checkInId}");

    try {
        $checkIn = CheckIn::findOrFail($checkInId);
        Log::info("CheckIn record retrieved: ", $checkIn->toArray());

        $booking = $checkIn->booking;
        Log::info("Associated Booking record retrieved: ", $booking->toArray());

        $roomTariff = $booking->room_tariff;
        $advanceAmount = $booking->advance_payment;
        Log::info("Room Tariff: {$roomTariff}, Advance Payment: {$advanceAmount}");

        $additionalCharges = collect($request->additional_charges);
        Log::info("Additional Charges from request: ", $additionalCharges->toArray());

        $totalAdditionalCharges = $additionalCharges->sum('amount');
        Log::info("Total Additional Charges: {$totalAdditionalCharges}");

        $discount = $request->discount ?? 0;
        $gst = $request->gst;
        Log::info("Discount: {$discount}, GST Rate: {$gst}%");

        // Calculate total GST
        $gstAmount = ($roomTariff + $totalAdditionalCharges) * ($gst / 100);
        Log::info("Calculated GST Amount: {$gstAmount}");

        // Calculate Remaining Payment
        $restPayment = $roomTariff + $totalAdditionalCharges + $gstAmount - $discount - $advanceAmount;
        //dd($restPayment);
        $restPayment = max(0, $restPayment);
       
        Log::info("Final Rest Payment (after adjustments): {$restPayment}");

        // Create Check-Out Record
        $checkOut = CheckOut::create([
            'check_in_id' => $checkIn->id,
            'additional_charges' => $additionalCharges->toJson(),
            'discount' => $discount,
            'discount_remarks' => $request->discount_remarks,
            'gst' => $gst,
            'rest_payment' => $restPayment,
            'final_amount' => $restPayment, // Ensure final_amount is set
            'payment_status' => $restPayment <= 0 ? 'Paid' : 'Pending',
        ]);
        Log::info("Check-Out record created: ", $checkOut->toArray());

        // Record Payment Transaction (if applicable)
        if ($restPayment > 0) {
            $transaction = Transaction::create([
                'check_out_id' => $checkOut->id,
                'amount' => $restPayment,
                'type' => 'Debit',
                'remarks' => 'Check-Out Payment',
            ]);
            Log::info("Transaction record created: ", $transaction->toArray());
        }

        // Update Check-In Status
        $checkIn->update(['status' => 'Checked Out']);
        Log::info("Check-In status updated to 'Checked Out' for ID: {$checkIn->id}");

        return redirect()->route('bookings.index')->with('success', 'Check-Out completed successfully.');

    } catch (Exception $e) {
        Log::error("Error during check-out store: " . $e->getMessage());
        Log::error("Stack Trace: " . $e->getTraceAsString());
        return redirect()->back()->withErrors('An error occurred while processing the check-out. Please try again.');
    }
}


}
