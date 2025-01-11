@extends('layouts.dashboard')

@section('content')
<div class="container">
    <h1>Check-Out Records</h1>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Check-In ID</th>
                <th>Customer</th>
                <th>Total Payment</th>
                <th>Discount</th>
                <th>Additional Charges</th>
                <th>Payment Status</th>
                <th>Check-Out Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($checkOuts as $checkOut)
            <tr>
                <td>{{ $checkOut->check_in_id }}</td>
                <td>{{ $checkOut->checkIn->booking->customer->name }}</td>
                <td>{{ $checkOut->rest_payment }}</td>
                <td>{{ $checkOut->discount }}</td>
                <td>{{ $checkOut->additional_charges }}</td>
                <td>{{ $checkOut->payment_status }}</td>
                <td>{{ $checkOut->created_at->format('Y-m-d') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
