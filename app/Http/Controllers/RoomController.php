<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Floor;
use App\Models\RoomType;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;


class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::with(['floor', 'roomType'])->get();
        return view('rooms.index', compact('rooms'));
    }

    public function create()
    {
        $floors = Floor::all();
        $roomTypes = RoomType::all();
        return view('rooms.create', compact('floors', 'roomTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'room_number' => 'required|unique:rooms,room_number|max:255',
            'floor_id' => 'required|exists:floors,id',
            'room_type_id' => 'required|exists:room_types,id',
            'base_price' => 'required|numeric|min:0',
        ]);

        Room::create($request->all());

        return redirect()->route('rooms.index')->with('success', 'Room created successfully.');
    }

    public function edit(Room $room)
    {
        $floors = Floor::all();
        $roomTypes = RoomType::all();
        return view('rooms.edit', compact('room', 'floors', 'roomTypes'));
    }

    public function update(Request $request, Room $room)
    {
        $request->validate([
            'room_number' => 'required|unique:rooms,room_number,' . $room->id . '|max:255',
            'floor_id' => 'required|exists:floors,id',
            'room_type_id' => 'required|exists:room_types,id',
            'base_price' => 'required|numeric|min:0',
        ]);

        $room->update($request->all());

        return redirect()->route('rooms.index')->with('success', 'Room updated successfully.');
    }

    public function destroy(Room $room)
    {
        $room->delete();

        return redirect()->route('rooms.index')->with('success', 'Room deleted successfully.');
    }

    public function getAvailableRooms(Request $request)
{
    $checkIn = $request->query('check_in');
    $checkOut = $request->query('check_out');

    $vacantRooms = DB::table('rooms')
    ->leftJoin('room_types', 'rooms.room_type_id', '=', 'room_types.id') // Join with room_types table
    ->select('rooms.id', 'rooms.room_number', 'room_types.name as room_type_name', 'rooms.base_price') // Fetch room type name
    ->whereNotExists(function ($query) use ($checkIn, $checkOut) {
        $query->select(DB::raw(1))
            ->from('bookings')
            ->join('booking_room', 'bookings.id', '=', 'booking_room.booking_id')
            ->whereRaw('rooms.id = booking_room.room_id')
            ->where('bookings.check_in_date', '<', $checkOut)
            ->where('bookings.check_out_date', '>', $checkIn);
    })
    ->get();

    return response()->json($vacantRooms);
}
public function getRoomStatus(Request $request)
{
    $startDate = $request->query('start_date', now()->format('Y-m-d'));
    $endDate = $request->query('end_date', now()->addWeek()->format('Y-m-d'));

    // Fetch all rooms
    $rooms = DB::table('rooms')->select('id', 'room_number')->orderBy('room_number')->get();

    // Fetch bookings within the date range
    $bookings = DB::table('bookings')
        ->join('booking_room', 'bookings.id', '=', 'booking_room.booking_id')
        ->select('booking_room.room_id', 'bookings.check_in_date', 'bookings.check_out_date')
        ->where('bookings.check_in_date', '<=', $endDate)
        ->where('bookings.check_out_date', '>=', $startDate)
        ->get();

    // Organize room statuses by date
    $roomStatus = [];
    foreach ($rooms as $room) {
        $roomStatus[$room->id] = [
            'room_number' => $room->room_number,
            'dates' => [],
        ];

        $currentDate = Carbon::parse($startDate);
        while ($currentDate->format('Y-m-d') <= $endDate) {
            $dateStr = $currentDate->format('Y-m-d');
            $isBooked = $bookings->contains(function ($booking) use ($room, $dateStr) {
                return $booking->room_id == $room->id &&
                       $dateStr >= $booking->check_in_date &&
                       $dateStr <= $booking->check_out_date;
            });

            $roomStatus[$room->id]['dates'][$dateStr] = $isBooked ? 'booked' : 'vacant';
            $currentDate->addDay();
        }
    }

    return response()->json($roomStatus);
}

}
