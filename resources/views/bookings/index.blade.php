@extends('layouts.dashboard')

@section('content')
<div class="container">
    <h1>Bookings</h1>
    <a href="{{ route('bookings.create') }}" class="btn btn-primary mb-3">Create Booking</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Customer</th>
                <th>Rooms</th>
                <th>Check-in</th>
                <th>Check-out</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bookings as $booking)
            <tr>
                <td>{{ $booking->id }}</td>
                <td>{{ $booking->customer->f_name ?? 'N/A' }} {{ $booking->customer->l_name ?? '' }}</td>
                <td>
                    @foreach($booking->rooms as $room)
                        <span class="badge bg-secondary">{{ $room->room_number }}</span>
                    @endforeach
                </td>
                <td>{{ $booking->check_in_date }}</td>
                <td>{{ $booking->check_out_date }}</td>
                <td>
                    @if($booking->checkIns->count() > 0)
                        <span class="badge bg-success">Checked In</span>
                    @else
                        <span class="badge bg-warning">Not Checked In</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('bookings.edit', $booking->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('bookings.destroy', $booking->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>

                    <!-- Show "Manage Additional Charges" button only if booking is checked in -->
                    @if($booking->checkIns->count() > 0)
                        <a href="{{ route('bookings.addChargesToBooking', $booking->id) }}" class="btn btn-primary btn-sm mt-1">
                            Manage Additional Charges
                        </a>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
