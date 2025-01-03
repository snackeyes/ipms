<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Room;
use App\Models\Customer;
use App\Models\RoomType;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reservations = Reservation::with('customer')->latest()->get();
        return view('reservations.index', compact('reservations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
{
    $customers = Customer::all();
    $roomTypes = RoomType::all();
    return view('reservations.create', compact('customers', 'roomTypes'));
}

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
{
    $request->validate([
        'customer_id' => 'required|exists:customers,id',
        'room_type_id' => 'required|exists:room_types,id',
        'adults' => 'required|integer|min:1',
        'children' => 'nullable|integer|min:0',
        'check_in' => 'required|date',
        'check_out' => 'required|date|after_or_equal:check_in',
        'room_tariff' => 'nullable|numeric|min:0',
        'meal_plan' => 'nullable|string|max:255',
        'advance_payment' => 'nullable|numeric|min:0',
        'agent_name' => 'nullable|string|max:255',
    ]);

    Reservation::create($request->all());

    return redirect()->route('reservations.index')->with('success', 'Reservation created successfully!');
}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reservation $reservation)
{
    $customers = Customer::all();
    $roomTypes = RoomType::all();
    return view('reservations.edit', compact('reservation', 'customers', 'roomTypes'));
}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reservation $reservation)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'room_type_id' => 'required|exists:room_types,id',
            'adults' => 'required|integer|min:1',
            'children' => 'nullable|integer|min:0',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after_or_equal:check_in',
            'room_tariff' => 'nullable|numeric|min:0',
            'meal_plan' => 'nullable|string|max:255',
            'advance_payment' => 'nullable|numeric|min:0',
            'agent_name' => 'nullable|string|max:255',
    ]);

    $reservation->update($request->all());

    return redirect()->route('reservations.index')->with('success', 'Reservation updated successfully!');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reservation $reservation)
    {
        $reservation->delete();
        return redirect()->route('reservations.index')->with('success', 'Reservation deleted successfully.');
    }
}
