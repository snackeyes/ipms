<?php

namespace App\Http\Controllers;

use App\Models\CheckOut;
use App\Models\CheckIn;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class CheckOutController extends Controller
{
   public function index()
{
    $checkOuts = CheckOut::with('checkIn.booking.customer')->get();
    return view('check_outs.index', compact('checkOuts'));
}

 public function create($checkInId)
{
    // Fetch the check-in details along with booking, rooms, and additional charges
    $checkIn = CheckIn::with('booking.customer', 'booking.rooms', 'additionalCharges')
        ->findOrFail($checkInId);

    $rooms = $checkIn->booking->rooms; // Associated rooms
    $customer = $checkIn->booking->customer; // Customer details
    $advancePayment = $checkIn->booking->advance_payment; // Advance payment
    $additionalCharges = $checkIn->additionalCharges; // Fetched additional charges

    return view('check_outs.create', compact('checkIn', 'rooms', 'customer', 'advancePayment', 'additionalCharges'));
}

    public function store(Request $request, $checkInId)
    {
        $request->validate([
            'additional_charges' => 'nullable|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'rest_payment' => 'required|numeric|min:0',
        ]);

        $checkIn = CheckIn::findOrFail($checkInId);

        // Calculate total charges
        $totalCharges = $checkIn->booking->total_tariff + $request->additional_charges - $request->discount;

        // Store check-out details
        CheckOut::create([
            'check_in_id' => $checkIn->id,
            'additional_charges' => $request->additional_charges,
            'discount' => $request->discount,
            'rest_payment' => $totalCharges,
            'payment_status' => 'Pending',
        ]);

        // Update check-in status
        $checkIn->update(['status' => 'Checked Out']);

        return redirect()->route('check_outs.index')->with('success', 'Check-out completed successfully.');
    }
}
