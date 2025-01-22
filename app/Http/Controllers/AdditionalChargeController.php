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
   public function create($checkInId)
{
    $checkIn = CheckIn::with('booking.customer', 'booking.rooms', 'additionalCharges')->findOrFail($checkInId);
    $additionalCharges = AdditionalCharge::all();

    return view('check_outs.create', compact('checkIn', 'additionalCharges'));
}

public function store(Request $request, $checkInId)
{
    $checkIn = CheckIn::findOrFail($checkInId);

    $validatedData = $request->validate([
        'additional_charges' => 'array',
        'additional_charges.*.id' => 'required|exists:additional_charges,id',
        'additional_charges.*.amount' => 'required|numeric',
    ]);

    // Sync additional charges with amounts
    $checkIn->additionalCharges()->sync(
        collect($validatedData['additional_charges'])->mapWithKeys(function ($charge) {
            return [$charge['id'] => ['amount' => $charge['amount']]];
        })->toArray()
    );

    // Redirect with success message
    return redirect()->route('check_ins.index')->with('success', 'Check-out completed with additional charges.');
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
