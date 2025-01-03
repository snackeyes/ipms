<?php

namespace App\Http\Controllers;

use App\Models\Floor;
use Illuminate\Http\Request;

class FloorController extends Controller
{
    public function index()
    {
        $floors = Floor::all();
        return view('floors.index', compact('floors'));
    }

    public function create()
    {
        return view('floors.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:floors,name|max:255',
        ]);

        Floor::create($request->all());

        return redirect()->route('floors.index')->with('success', 'Floor created successfully.');
    }

    public function edit(Floor $floor)
    {
        return view('floors.edit', compact('floor'));
    }

    public function update(Request $request, Floor $floor)
    {
        $request->validate([
            'name' => 'required|unique:floors,name,' . $floor->id . '|max:255',
        ]);

        $floor->update($request->all());

        return redirect()->route('floors.index')->with('success', 'Floor updated successfully.');
    }

    public function destroy(Floor $floor)
    {
        $floor->delete();

        return redirect()->route('floors.index')->with('success', 'Floor deleted successfully.');
    }
}


