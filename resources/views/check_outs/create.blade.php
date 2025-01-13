@extends('layouts.dashboard')

@section('content')
<div class="container">
    <h1>Check-Out</h1>
    <form action="{{ route('check_outs.store', $checkIn->id) }}" method="POST">
        @csrf

        <h3>Booking Details</h3>
        <p>Customer: {{ $checkIn->booking->customer->name }}</p>
        <p>Rooms: {{ $checkIn->booking->rooms->pluck('room_number')->join(', ') }}</p>

        <h3>Additional Charges</h3>
        @foreach ($additionalCharges as $charge)
            <div class="mb-3">
                <label>
                    <input type="checkbox" name="additional_charges[{{ $charge->id }}][id]" value="{{ $charge->id }}">
                    {{ $charge->name }} (Default: {{ number_format($charge->default_amount, 2) }})
                </label>
                <input type="number" name="additional_charges[{{ $charge->id }}][amount]" class="form-control" placeholder="Enter amount" step="0.01">
            </div>
        @endforeach

        <button type="submit" class="btn btn-primary">Complete Check-Out</button>
    </form>
</div>
@endsection
