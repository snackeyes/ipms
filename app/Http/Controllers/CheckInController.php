<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\CheckIn;
use App\Models\Room;
use Illuminate\Http\Request;

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
        $bookings = Booking::with(['customer', 'rooms'])->where('status', 'confirmed')->get();
        return view('check_ins.create', compact('bookings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'check_in_date' => 'required|date',
        ]);

        $booking = Booking::with('rooms')->findOrFail($request->booking_id);

        // Create or update check-in record
        CheckIn::updateOrCreate(
            ['booking_id' => $booking->id],
            [
                'check_in_date' => $request->check_in_date,
                'room_ids' => $booking->rooms->pluck('id')->toArray(), // Store room IDs as JSON
                'status' => 'Checked In',
            ]
        );

        return redirect()->route('check_ins.index')->with('success', 'Check-in completed for the booking!');
    }

    public function destroy(CheckIn $checkIn)
    {
        $checkIn->delete();
        return redirect()->route('check_ins.index')->with('success', 'Check-in record deleted!');
    }

}
