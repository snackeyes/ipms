@extends('layouts.dashboard')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Check-In Records</h1>
        <a href="{{ route('check_ins.create') }}" class="btn btn-primary">Check In</a>
    </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Booking ID</th>
                <th>Customer Name</th>
                <th>Rooms</th>
                <th>Check-In Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($checkIns as $checkIn)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $checkIn->booking_id }}</td>
                <td>{{ $checkIn->booking->customer->fullName() }}</td>
                <td>{{ implode(', ', $checkIn->room_numbers) }}</td>
                <td>{{ $checkIn->check_in_date }}</td>
                <td>{{ $checkIn->status }}</td>
                <td>
                    <form action="{{ route('check_ins.destroy', $checkIn->id) }}" method="POST">
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
