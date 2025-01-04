<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    public function index()
    {
        $paymentMethods = PaymentMethod::all();
        return view('payment_methods.index', compact('paymentMethods'));
    }

    // Show the form to create a new payment method
    public function create()
    {
        return view('payment_methods.create');
    }

    // Store a newly created payment method in the database
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'payment_option' => 'required|in:None,Credit Card,Check,Loyalty',
            'surcharge_amount' => 'nullable|numeric|min:0',
            'surcharge_percentage' => 'nullable|numeric|min:0|max:100',
        ]);

        PaymentMethod::create($request->all());

        return redirect()->route('payment-methods.index')->with('success', 'Payment method created successfully.');
    }

    // Show the form to edit an existing payment method
    public function edit(PaymentMethod $paymentMethod)
    {
        return view('payment_methods.edit', compact('paymentMethod'));
    }

    // Update the specified payment method in the database
    public function update(Request $request, PaymentMethod $paymentMethod)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'payment_option' => 'required|in:None,Credit Card,Check,Loyalty',
            'surcharge_amount' => 'nullable|numeric|min:0',
            'surcharge_percentage' => 'nullable|numeric|min:0|max:100',
        ]);

        $paymentMethod->update($request->all());

        return redirect()->route('payment-methods.index')->with('success', 'Payment method updated successfully.');
    }

    // Remove the specified payment method from the database
    public function destroy(PaymentMethod $paymentMethod)
    {
        $paymentMethod->delete();
        return redirect()->route('payment-methods.index')->with('success', 'Payment method deleted successfully.');
    }
}
