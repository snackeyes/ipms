@extends('layouts.dashboard')

@section('content')
<div class="container">
    <h1>Create Payment Method</h1>

    <form action="{{ route('payment-methods.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="name">Payment Method Name</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="payment_option">Payment Option</label>
            <select name="payment_option" id="payment_option" class="form-control" required>
                <option value="None">None</option>
                <option value="Credit Card">Credit Card</option>
                <option value="Check">Check</option>
                <option value="Loyalty">Loyalty</option>
            </select>
        </div>

        <div class="form-group">
            <label for="surcharge_amount">Surcharge Amount</label>
            <input type="number" name="surcharge_amount" id="surcharge_amount" class="form-control" step="0.01">
        </div>

        <div class="form-group">
            <label for="surcharge_percentage">Surcharge Percentage</label>
            <input type="number" name="surcharge_percentage" id="surcharge_percentage" class="form-control" step="0.01" min="0" max="100">
        </div>

        <button type="submit" class="btn btn-success">Save Payment Method</button>
    </form>
</div>
@endsection
