@extends('layouts.dashboard')

@section('content')
<div class="container">
    <h1>Payment Methods</h1>
    <a href="{{ route('payment-methods.create') }}" class="btn btn-primary">Create Payment Method</a>

    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>Name</th>
                <th>Payment Option</th>
                <th>Surcharge Amount</th>
                <th>Surcharge Percentage</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($paymentMethods as $paymentMethod)
            <tr>
                <td>{{ $paymentMethod->name }}</td>
                <td>{{ $paymentMethod->payment_option }}</td>
                <td>{{ $paymentMethod->surcharge_amount }}</td>
                <td>{{ $paymentMethod->surcharge_percentage }}</td>
                <td>
                    <a href="{{ route('payment-methods.edit', $paymentMethod) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('payment-methods.destroy', $paymentMethod) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
