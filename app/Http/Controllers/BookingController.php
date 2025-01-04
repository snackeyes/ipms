<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use App\Models\Customer;
use App\Models\Tax;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Reservation;
use App\Models\RoomType;
use App\Models\PaymentMethod;
use DB;

class BookingController extends Controller
{
    public function index()
    {
        try {
            $bookings = Booking::with(['rooms', 'customer'])->latest()->get();
            return view('bookings.index', compact('bookings'));
        } catch (\Exception $e) {
            Log::error("Error fetching bookings: " . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return back()->withErrors('Unable to fetch bookings at this time.');
        }
    }

    public function create(Request $request)
    {
        try {
            $reservationId = $request->query('reservation_id', null);
            $reservation = $reservationId ? Reservation::with('customer')->findOrFail($reservationId) : null;

            $customers = Customer::all();

            // Pre-fill check-in and check-out dates from the reservation
            $checkIn = $reservation ? $reservation->check_in : now()->toDateString();
            $checkOut = $reservation ? $reservation->check_out : now()->addDay()->toDateString();
            $roomTypes = RoomType::all();
            // Fetch vacant rooms for the given dates
            $vacantRooms = DB::table('rooms')
                ->whereNotExists(function ($query) use ($checkIn, $checkOut) {
                    $query->select(DB::raw(1))
                        ->from('bookings')
                        ->join('booking_room', 'bookings.id', '=', 'booking_room.booking_id')
                        ->whereRaw('rooms.id = booking_room.room_id')
                        ->where(function ($query) use ($checkIn, $checkOut) {
                            $query->whereBetween('bookings.check_in_date', [$checkIn, $checkOut])
                                  ->orWhereBetween('bookings.check_out_date', [$checkIn, $checkOut])
                                  ->orWhereRaw('? BETWEEN bookings.check_in_date AND bookings.check_out_date', [$checkIn])
                                  ->orWhereRaw('? BETWEEN bookings.check_in_date AND bookings.check_out_date', [$checkOut]);
                        });
                })
                ->get();
                $gstTax = Tax::where('name', 'GST12')->first(); // Replace 'GST' with your actual tax name
            $taxPercentage = $gstTax ? $gstTax->rate : 0; // Fallback to 0 if no tax found
            $paymentMethods = PaymentMethod::all();

            return view('bookings.create', compact('reservation', 'customers', 'vacantRooms','roomTypes', 'taxPercentage','paymentMethods'));
        } catch (\Exception $e) {
            \Log::error("Error displaying booking creation form: " . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return back()->withErrors('Unable to display the booking creation form at this time.');
        }
    }


    public function store(Request $request)
    {dd($request);
        \Log::info('Store method initiated.');

        try {
            // Log incoming request data
            \Log::info('Incoming request data:', $request->all());

            // Validate the request input
            $request->validate([
                'customer_id' => 'required|exists:customers,id',
                'check_in_date' => 'required|date',
                'check_out_date' => 'required|date|after_or_equal:check_in_date',
                'room_ids' => 'required|array',
                'room_ids.*' => 'exists:rooms,id',
                'meal_plan' => 'nullable|string|max:255',
                'advance_payment' => 'nullable|numeric|min:0',
                'agent_name' => 'nullable|string|max:255',
            ]);

            \Log::info('Validation successful.');

            // Insert booking data into the `bookings` table
            $bookingData = [
                'customer_id' => $request->customer_id,
                'check_in_date' => $request->check_in_date,
                'check_out_date' => $request->check_out_date,
                'meal_plan_id' => $request->meal_plan,
                'advance_payment' => $request->advance_payment,
                'agent_id' => $request->agent_name,
                'total_amount'=>$request->total_charge,
                'status' => 'confirmed',
                'created_at' => now(),
                'updated_at' => now(),
            ];
            \Log::info('Booking data prepared:', $bookingData);

            $bookingId = \DB::table('bookings')->insertGetId($bookingData);
            \Log::info('Booking created with ID: ' . $bookingId);

            // Insert room assignments into the `booking_room` table
            foreach ($request->room_ids as $roomId) {
                $roomAssignment = [
                    'booking_id' => $bookingId,
                    'room_id' => $roomId,
                    'check_in_date' => $request->check_in_date,
                    'check_out_date' => $request->check_out_date,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                \DB::table('booking_room')->insert($roomAssignment);
                \Log::info('Room assigned:', $roomAssignment);
            }

            \Log::info('All rooms assigned successfully for booking ID: ' . $bookingId);

            // Return success response
            return redirect()->route('bookings.index')->with('success', 'Booking created successfully.');
        } catch (\Illuminate\Validation\ValidationException $validationException) {
            // Log validation errors
            \Log::error('Validation error:', $validationException->errors());

            return redirect()->back()
                ->withErrors($validationException->errors())
                ->withInput();
        } catch (\Exception $e) {
            // Log unexpected errors
            \Log::error('Unexpected error occurred during booking storage:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()->back()
                ->with('error', 'An unexpected error occurred while storing the booking. Please try again later.');
        }
    }




    public function edit($id)
    {
        try {
            // Fetch the booking, including related rooms and customer data
            $booking = Booking::with(['rooms', 'customer'])->findOrFail($id);

            // Fetch all customers for the customer dropdown
            $customers = Customer::all();

            // Fetch the vacant rooms, excluding those already booked for the specified date range
            $vacantRooms = DB::table('rooms')
                ->whereNotExists(function ($query) use ($booking) {
                    $query->select(DB::raw(1))
                        ->from('bookings')
                        ->join('booking_room', 'bookings.id', '=', 'booking_room.booking_id')
                        ->whereRaw('rooms.id = booking_room.room_id')
                        ->where(function ($query) use ($booking) {
                            // Check for overlapping booking dates
                            $query->whereBetween('bookings.check_in_date', [$booking->check_in_date, $booking->check_out_date])
                                  ->orWhereBetween('bookings.check_out_date', [$booking->check_in_date, $booking->check_out_date]);
                        });
                })
                ->orWhereIn('id', $booking->rooms->pluck('id')) // Include already selected rooms in the edit view
                ->get();
                $roomTypes = RoomType::all();
            return view('bookings.edit', compact('booking', 'customers', 'vacantRooms','roomTypes'));

        } catch (\Exception $e) {
            \Log::error("Error fetching booking for edit: " . $e->getMessage());
            return redirect()->back()->with('error', 'Unable to fetch booking details for editing.');
        }
    }


    public function update(Request $request, $id)
{
    $request->validate([
        'customer_id' => 'required',
        'check_in_date' => 'required|date',
        'check_out_date' => 'required|date|after_or_equal:check_in_date',
        'room_ids' => 'required|array',
    ]);

    try {
        \Log::info("Updating booking with ID: $id", $request->all());

        $booking = Booking::findOrFail($id);
        $booking->update([
            'customer_id' => $request->customer_id,
            'check_in_date' => $request->check_in_date,
            'check_out_date' => $request->check_out_date,
            'meal_plan' => $request->meal_plan,
            'advance_payment' => $request->advance_payment,
            'agent_name' => $request->agent_name,
        ]);

        // Prepare data for the pivot table
        $roomsData = [];
        foreach ($request->room_ids as $roomId) {
            $roomsData[$roomId] = [
                'check_in_date' => $request->check_in_date,
                'check_out_date' => $request->check_out_date,
            ];
        }

        // Sync rooms with pivot data
        $booking->rooms()->sync($roomsData);

        \Log::info("Booking updated successfully with ID: $id");
        return redirect()->route('bookings.index')->with('success', 'Booking updated successfully.');
    } catch (\Exception $e) {
        \Log::error("Error updating booking with ID: $id", ['message' => $e->getMessage()]);
        return redirect()->back()->with('error', 'Error updating booking: ' . $e->getMessage());
    }
}


    public function destroy(Booking $booking)
    {
        try {
            $booking->rooms()->detach();
            $booking->delete();

            Log::info("Booking deleted successfully", ['booking_id' => $booking->id]);
            return redirect()->route('bookings.index')->with('success', 'Booking deleted successfully.');
        } catch (\Exception $e) {
            Log::error("Error deleting booking: " . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return back()->withErrors('Unable to delete the booking at this time.');
        }
    }
}
