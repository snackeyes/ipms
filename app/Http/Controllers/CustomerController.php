<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
     public function index()
    {
        $customers = Customer::all();
        return view('customers.index', compact('customers'));
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'f_name' => 'required|string|max:255',
        'l_name' => 'required|string|max:255',
        'email' => 'nullable|email|unique:customers',
        'phone' => 'required|string|max:15|unique:customers',
        'address' => 'nullable|string',
        'city' => 'nullable|string',
        'state' => 'nullable|string',
        'country' => 'nullable|string',
        'gender' => 'required|string',
        'dob' => 'nullable|date',
        'nationality' => 'nullable|string',
        'identity_type' => 'nullable|string',
        'id_no' => 'nullable|string',
        'id_front' => 'nullable|file|mimes:jpeg,png,jpg',
        'id_back' => 'nullable|file|mimes:jpeg,png,jpg',
    ]);

    $data = $request->all();

    // Handle file uploads
    if ($request->hasFile('id_front')) {
        $data['id_front'] = $request->file('id_front')->store('uploads/customers', 'public');
    }
    if ($request->hasFile('id_back')) {
        $data['id_back'] = $request->file('id_back')->store('uploads/customers', 'public');
    }

    $customer = Customer::create($data);

    // Check if the request is an AJAX request
    if ($request->ajax()) {
        return response()->json([
            'status' => 'success',
            'message' => 'Customer created successfully.',
            'customer' => $customer
        ]);
    }

    return redirect()->route('customers.index')->with('success', 'Customer created successfully.');
}


    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        return view('customers.edit', compact('customer'));
    }

    public function update(Request $request, $id)
    {
        
        $customer = Customer::findOrFail($id);
//dd($request);
        $request->validate([
            'f_name' => 'required|string|max:255',
            'l_name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email,' . $customer->id,
            'phone' => 'required|string|max:15',
            'address' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'country' => 'required|string',
            'gender' => 'required|string',
            'dob' => 'required|date',
            'nationality' => 'required|string',
            'identity_type' => 'required|string',
            'id_no' => 'required|string',
            'id_front' => 'nullable|file|mimes:jpeg,png,jpg',
            'id_back' => 'nullable|file|mimes:jpeg,png,jpg',
        ]);

        $data = $request->all();

        // Handle file uploads
        if ($request->hasFile('id_front')) {
            $data['id_front'] = $request->file('id_front')->store('uploads/customers', 'public');
        }
        if ($request->hasFile('id_back')) {
            $data['id_back'] = $request->file('id_back')->store('uploads/customers', 'public');
        }
//dd("hello00");
       try {
    $customer->update($request->all());
    return redirect()->route('customers.index')->with('success', 'Customer updated successfully.');
} catch (\Exception $e) {
    \Log::error('Customer update failed: ' . $e->getMessage());
    return redirect()->route('customers.index')->with('error', 'Failed to update customer.');
}
    }

    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);

        // Delete files if they exist
        if ($customer->id_front) {
            \Storage::delete('public/' . $customer->id_front);
        }
        if ($customer->id_back) {
            \Storage::delete('public/' . $customer->id_back);
        }

        $customer->delete();

        return redirect()->route('customers.index')->with('success', 'Customer deleted successfully.');
    }

   public function search(Request $request)
{
    $query = $request->get('query', '');

    if (!$query) {
        return response()->json([]);
    }

    $customers = Customer::where('f_name', 'LIKE', "%{$query}%")
        ->orWhere('l_name', 'LIKE', "%{$query}%")
        ->orWhere('email', 'LIKE', "%{$query}%")
        ->orWhere('phone', 'LIKE', "%{$query}%")
        ->select('id', 'f_name', 'l_name', 'email', 'phone')
        ->get();

    $results = $customers->map(function ($customer) {
        return [
            'id' => $customer->id,
            'text' => "{$customer->f_name} {$customer->l_name} ({$customer->email})",
        ];
    });

    return response()->json($results);
}

}
