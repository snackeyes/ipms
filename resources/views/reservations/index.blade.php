@extends('layouts.dashboard')

@section('content')
<div class="container">
    <h1>Reservations</h1>
    <a href="{{ route('reservations.create') }}" class="btn btn-primary mb-3">Create Reservation</a>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Customer</th>
                <th>Check-in</th>
                <th>Check-out</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reservations as $reservation)
            <tr>
                <td>{{ $reservation->id }}</td>
                <td>{{ $reservation->customer->f_name }} {{ $reservation->customer->l_name }}</td>
                <td>{{ $reservation->check_in }}</td>
                <td>{{ $reservation->check_out }}</td>
                <td>{{ $reservation->status }}</td>
                <td>
                    <a href="{{ route('reservations.edit', $reservation->id) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('reservations.destroy', $reservation->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
                <td>
                    @if($reservation->status != 'converted')
    <a href="{{ route('bookings.create', ['reservation_id' => $reservation->id]) }}" class="btn btn-success">
        Convert to Booking
    </a>
@endif</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
