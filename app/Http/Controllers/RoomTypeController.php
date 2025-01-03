<?php

namespace App\Http\Controllers;

use App\Models\RoomType;
use Illuminate\Http\Request;

class RoomTypeController extends Controller
{
    public function index()
    {
        $roomTypes = RoomType::all();
        return view('room_types.index', compact('roomTypes'));
    }

    public function create()
    {
        return view('room_types.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:room_types,name|max:255',
            'base_adult' => 'required|integer|min:0',
            'base_child' => 'required|integer|min:0',
            'max_adult' => 'required|integer|min:1',
            'max_child' => 'required|integer|min:0',
        ]);

        RoomType::create($request->all());

        return redirect()->route('room_types.index')->with('success', 'Room Type created successfully.');
    }

    public function edit(RoomType $roomType)
    {
        return view('room_types.edit', compact('roomType'));
    }

    public function update(Request $request, RoomType $roomType)
    {
        $request->validate([
            'name' => 'required|unique:room_types,name,' . $roomType->id . '|max:255',
            'base_adult' => 'required|integer|min:0',
            'base_child' => 'required|integer|min:0',
            'max_adult' => 'required|integer|min:1',
            'max_child' => 'required|integer|min:0',
        ]);

        $roomType->update($request->all());

        return redirect()->route('room_types.index')->with('success', 'Room Type updated successfully.');
    }

    public function destroy(RoomType $roomType)
    {
        $roomType->delete();

        return redirect()->route('room_types.index')->with('success', 'Room Type deleted successfully.');
    }
}
