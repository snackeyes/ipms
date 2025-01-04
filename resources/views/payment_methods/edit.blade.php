@extends('layouts.dashboard')

@section('content')
<div class="container">
    <h1>Edit Payment Method</h1>

    <form action="{{ route('payment-methods.update', $paymentMethod) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Payment Method Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $paymentMethod->name) }}" required>
        </div>

        <div class="form-group">
            <label for="payment_option">Payment Option</label>
            <select name="payment_option" id="payment_option" class="form-control" required>
                <option value="None" {{ $paymentMethod->payment_option == 'None' ? 'selected' : '' }}>None</option>
                <option value="Credit Card" {{ $paymentMethod->payment_option == 'Credit Card' ? 'selected' : '' }}>Credit Card</option>
                <option value="Check" {{ $paymentMethod->payment_option == 'Check' ? 'selected' : '' }}>Check</option>
                <option value="Loyalty" {{ $paymentMethod->payment_option == 'Loyalty' ? 'selected' : '' }}>Loyalty</option>
            </select>
        </div>

        <div class="form-group">
            <label for="surcharge_amount">Surcharge Amount</label>
            <input type="number" name="surcharge_amount" id="surcharge_amount" class="form-control" step="0.01" value="{{ old('surcharge_amount', $paymentMethod->surcharge_amount) }}">
        </div>

        <div class="form-group">
            <label for="surcharge_percentage">Surcharge Percentage</label>
            <input type="number" name="surcharge_percentage" id="surcharge_percentage" class="form-control" step="0.01" min="0" max="100" value="{{ old('surcharge_percentage', $paymentMethod->surcharge_percentage) }}">
        </div>

        <button type="submit" class="btn btn-warning">Update Payment Method</button>
    </form>
</div>
@endsection
