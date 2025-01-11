@extends('layouts.dashboard')

@section('content')
<div class="container">
    <h1>Check-Out</h1>
    <form action="{{ route('check_outs.store', $checkIn->id) }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="customer_name" class="form-label">Customer</label>
            <input type="text" id="customer_name" class="form-control" value="{{ $checkIn->booking->customer->name }}" disabled>
        </div>

        <div class="mb-3">
            <label for="rooms" class="form-label">Rooms</label>
            <input type="text" id="rooms" class="form-control" value="{{ $checkIn->booking->rooms->pluck('room_number')->join(', ') }}" disabled>
        </div>

        <div class="mb-3">
            <label for="additional_charges" class="form-label">Additional Charges</label>
            <input type="number" name="additional_charges" id="additional_charges" class="form-control" step="0.01">
        </div>

        <div class="mb-3">
            <label for="discount" class="form-label">Discount</label>
            <input type="number" name="discount" id="discount" class="form-control" step="0.01">
        </div>

        <div class="mb-3">
            <label for="rest_payment" class="form-label">Total Payment Due</label>
            <input type="number" name="rest_payment" id="rest_payment" class="form-control" step="0.01" value="{{ $checkIn->booking->total_tariff }}" readonly>
        </div>

        <button type="submit" class="btn btn-primary">Complete Check-Out</button>
    </form>
</div>
@endsection
