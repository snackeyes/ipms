<?php

namespace App\Http\Controllers;

use App\Models\AdditionalCharge;
use Illuminate\Http\Request;

class AdditionalChargeController extends Controller
{
   public function index()
    {
        $charges = AdditionalCharge::all();
        return view('additional_charges.index', compact('charges'));
    }

    public function create()
    {
        return view('additional_charges.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'amount' => 'required|numeric|min:0',
        ]);

        AdditionalCharge::create($request->all());
        return redirect()->route('additional_charges.index')->with('success', 'Charge created successfully.');
    }

    public function show(AdditionalCharge $additionalCharge)
    {
        return view('additional_charges.show', compact('additionalCharge'));
    }

    public function edit(AdditionalCharge $additionalCharge)
    {
        return view('additional_charges.edit', compact('additionalCharge'));
    }

    public function update(Request $request, AdditionalCharge $additionalCharge)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'amount' => 'required|numeric|min:0',
        ]);

        $additionalCharge->update($request->all());
        return redirect()->route('additional_charges.index')->with('success', 'Charge updated successfully.');
    }

    public function destroy(AdditionalCharge $additionalCharge)
    {
        $additionalCharge->delete();
        return redirect()->route('additional_charges.index')->with('success', 'Charge deleted successfully.');
    }
}
