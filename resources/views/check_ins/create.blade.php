@extends('layouts.dashboard')

@section('content')
<div class="container">
    <h1>New Check-In</h1>
    <form action="{{ route('check_ins.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="booking_id" class="form-label">Select Booking</label>
            <select name="booking_id" id="booking_id" class="form-control" required>
                <option value="">-- Select Booking --</option>
                @foreach($bookings as $booking)
                <option value="{{ $booking->id }}">
                    Booking #{{ $booking->id }} - {{ $booking->customer->name }} 
                    (Rooms: {{ $booking->rooms->pluck('room_number')->join(', ') }})
                </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="check_in_date" class="form-label">Check-In Date</label>
            <input type="date" name="check_in_date" id="check_in_date" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Check In</button>
    </form>
</div>
@endsection
