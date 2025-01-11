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
                <th>ID</th>
                <th>Booking ID</th>
                <th>Customer</th>
                <th>Rooms</th>
                <th>Check-In Date</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($checkIns as $checkIn)
            <tr>
                <td>{{ $checkIn->id }}</td>
                <td>{{ $checkIn->booking->id }}</td>
                <td>{{ $checkIn->booking->customer->fullName() }}</td>
                <td>{{ $checkIn->booking->rooms->pluck('room_number')->join(', ') }}</td>
                <td>{{ $checkIn->check_in_date }}</td>
                <td>{{ $checkIn->status }}</td>
                <td>
                    @if($checkIn->status === 'Checked In')
                        <a href="{{ route('check_outs.create', $checkIn->id) }}" class="btn btn-primary">Check Out</a>
                    @else
                        <span class="text-muted">Already Checked Out</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
