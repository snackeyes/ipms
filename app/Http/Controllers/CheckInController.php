<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\CheckIn;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CheckInController extends Controller
{
   public function index()
    {
        $checkIns = CheckIn::with('booking.customer')->get();

    foreach ($checkIns as $checkIn) {
        $checkIn->room_numbers = Room::whereIn('id', $checkIn->room_ids)->pluck('room_number')->toArray();
    }

    return view('check_ins.index', compact('checkIns'));
    }

  public function create()
{
    $bookings = Booking::whereDoesntHave('checkIns', function ($query) {
        $query->where('status', 'Checked In');
    })->with('rooms', 'customer')->get();

    $checkedInBookings = Booking::whereHas('checkIns', function ($query) {
        $query->where('status', 'Checked In');
    })->with('rooms', 'customer', 'checkIns')->get();

    return view('check_ins.create', compact('bookings', 'checkedInBookings'));
}

   public function store(Request $request)
{
    $request->validate([
        'booking_id' => 'required|exists:bookings,id',
        'check_in_date' => 'required|date',
    ]);

    // Fetch the booking details
    $booking = Booking::with('rooms')->findOrFail($request->booking_id);

    // Retrieve the associated room IDs
    $roomIds = $booking->rooms->pluck('id')->toArray();

    // Create the check-in
    $checkIn = CheckIn::create([
        'booking_id' => $request->booking_id,
        'check_in_date' => $request->check_in_date,
        'room_ids' => $roomIds, // Store room IDs as JSON
        'status' => 'Checked In',
    ]);

    return redirect()->route('check_ins.index')->with('success', 'Check-in created successfully.');
}


    public function destroy(CheckIn $checkIn)
    {
        $checkIn->delete();
        return redirect()->route('check_ins.index')->with('success', 'Check-in record deleted!');
    }

}
