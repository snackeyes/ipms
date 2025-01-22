@extends('layouts.dashboard')

@section('content')
<div class="container">
    <h1>Check Out Summary</h1>
    <form action="{{ route('check_outs.store', $checkIn->id) }}" method="POST">
        @csrf

        <!-- Customer Details -->
        <div class="mb-3">
            <h5>Customer Details</h5>
            <p><strong>Name:</strong> {{ $checkIn->booking->customer->f_name }} {{ $checkIn->booking->customer->l_name }}</p>
            <p><strong>Booking ID:</strong> {{ $checkIn->booking->id }}</p>
        </div>

        <!-- Room Summary -->
        <div class="mb-3">
            <h5>Room Details</h5>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Room Number</th>
                        <th>Room Type</th>
                        <th>Tariff (Per Day)</th>
                        <th>Days</th>
                        <th>Total</th>
                        <th>Tax (18%)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($roomDetails as $room)
                    <tr>
                        <td>{{ $room['room_number'] }}</td>
                        <td>{{ $room['room_type'] }}</td>
                        <td>{{ number_format($room['tariff'], 2) }}</td>
                        <td>{{ $room['days'] }}</td>
                        <td>{{ number_format($room['total'], 2) }}</td>
                        <td>{{ number_format($room['tax'], 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Additional Charges -->
        <div class="mb-3">
            <h5>Additional Charges</h5>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Description</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($additionalCharges as $charge)
                    <tr>
                        <td>{{ $charge['description'] }}</td>
                        <td>{{ number_format($charge['amount'], 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Totals -->
        <div class="mb-3">
            <h5>Summary</h5>
            <p><strong>Total Room Tariff:</strong> ₹{{ number_format($totalTariff, 2) }}</p>
            <p><strong>Total Tax (GST):</strong> ₹{{ number_format($totalTax, 2) }}</p>
            <p><strong>Total Additional Charges:</strong> ₹{{ number_format($totalAdditionalCharges, 2) }}</p>
            <p><strong>Advance Amount:</strong> ₹{{ number_format($advance, 2) }}</p>
        </div>

        <!-- Final Calculation -->
        @php
            $finalAmount = $totalTariff + $totalTax + $totalAdditionalCharges - $advance;
        @endphp

        <div class="mb-3">
            <h5>Final Calculation</h5>
            <p><strong>Final Payable Amount:</strong> ₹{{ number_format($finalAmount, 2) }}</p>
        </div>

        <!-- Discount -->
        <div class="mb-3">
            <label for="discount" class="form-label">Discount (Amount)</label>
            <input type="number" name="discount" id="discount" class="form-control" placeholder="Enter discount amount">
        </div>

        <div class="mb-3">
            <label for="discount_remarks" class="form-label">Discount Remarks</label>
            <input type="text" name="discount_remarks" id="discount_remarks" class="form-control" placeholder="Remarks for discount">
        </div>

        <!-- Confirm Check Out -->
        <button type="submit" class="btn btn-success">Confirm Check Out</button>
    </form>
</div>
@endsection
