@extends('layouts.dashboard')

@section('content')
<div class="container">
    <h1>Create Booking</h1>
    <form action="{{ route('bookings.store') }}" method="POST" id="bookingForm">
        @csrf

        @if($reservation)
            <input type="hidden" name="reservation_id" value="{{ $reservation->id }}">
        @endif

        <!-- Customer Selection -->
        <div class="mb-3">
            <label for="customer_id" class="form-label">Customer</label>
            <select class="form-select select2-customer" name="customer_id" id="customer_id" required>
                <option value="">Search or Select Customer</option>
                @foreach($customers as $customer)
                    <option value="{{ $customer->id }}"
                        {{ old('customer_id', $reservation->customer_id ?? '') == $customer->id ? 'selected' : '' }}>
                        {{ $customer->f_name }} {{ $customer->l_name }} - {{ $customer->mobile }}
                    </option>
                @endforeach
            </select>
            <button type="button" class="btn btn-outline-primary mt-2" data-bs-toggle="modal" data-bs-target="#newCustomerModal">
                Add New Customer
            </button>
        </div>

        <!-- Date and Room Details -->
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="check_in" class="form-label">Check-in</label>
                <input type="text" class="form-control flatpickr" name="check_in_date" id="check_in"
                       value="{{ old('check_in_date', $reservation->check_in ?? '') }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="check_out" class="form-label">Check-out</label>
                <input type="text" class="form-control flatpickr" name="check_out_date" id="check_out"
                       value="{{ old('check_out_date', $reservation->check_out ?? '') }}" required>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="number_of_days" class="form-label">Number of Days</label>
                <input type="number" class="form-control" id="number_of_days" name="number_of_days" readonly>
            </div>
            <div class="col-md-6 mb-3">
                <label for="room_type_filter" class="form-label">Filter by Room Type</label>
                <select class="form-select" id="room_type_filter">
                    <option value="">All Room Types</option>
                    @foreach($roomTypes as $roomType)
                        <option value="{{ $roomType->id }}">{{ $roomType->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Available Rooms -->
        <div class="mb-3">
            <label for="room_ids" class="form-label">Rooms</label>
            <select class="form-select select2" name="room_ids[]" id="room_ids" multiple required>
                @foreach($vacantRooms as $room)
                    <option value="{{ $room->id }}"
                        data-room-type="{{ $room->room_type_id }}"
                        data-base-price="{{ $room->base_price }}">
                        {{ $room->room_number }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Meal Plan -->
        <div class="mb-3">
            <label for="meal_plan" class="form-label">Meal Plan</label>
            <input type="text" class="form-control" name="meal_plan" id="meal_plan"
                   value="{{ old('meal_plan', $reservation->meal_plan ?? '') }}" placeholder="e.g., Breakfast Only">
        </div>

        <!-- Agent Name -->
        <div class="mb-3">
            <label for="agent_name" class="form-label">Agent Name</label>
            <input type="text" class="form-control" name="agent_name" id="agent_name"
                   value="{{ old('agent_name', $reservation->agent_name ?? '') }}" placeholder="Enter agent name">
        </div>

        <!-- Fare and Payment Details -->
        <hr>
        <h4>Fare Details</h4>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="room_charge" class="form-label">Room Charge Per Day</label>
                <input type="number" class="form-control" id="room_charge" name="room_charge" readonly>
            </div>
            <div class="col-md-6 mb-3">
                <label for="advance_payment" class="form-label">Advance Payment</label>
                <input type="number" class="form-control" name="advance_payment" id="advance_payment"
                       value="{{ old('advance_payment', $reservation->advance_payment ?? '') }}" placeholder="Enter advance payment">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="total_charge" class="form-label">Total Charge</label>
                <input type="number" class="form-control" id="total_charge" name="total_charge" readonly>
            </div>
        </div>

        <button type="submit" class="btn btn-success">Create Booking</button>
    </form>
</div>
<div class="modal fade" id="newCustomerModal" tabindex="-1" aria-labelledby="newCustomerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="newCustomerForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="newCustomerModalLabel">Add New Customer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @csrf
                    <div class="mb-3">
                        <label for="f_name" class="form-label">First Name</label>
                        <input type="text" class="form-control" name="f_name" id="f_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="l_name" class="form-label">Last Name</label>
                        <input type="text" class="form-control" name="l_name" id="l_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" id="email">
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" class="form-control" name="phone" id="phone" required>
                    </div>
                    <div class="mb-3">
                        <label for="gender" class="form-label">Gender</label>
                        <select class="form-select" name="gender" id="gender" required>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Save Customer</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    flatpickr("#check_in", {
        dateFormat: "Y-m-d", // Customize date format as needed
        onChange: function(selectedDates, dateStr, instance) {
            // Optional: Trigger calculation when date is selected
            calculateDaysAndTotal();
        }
    });

    flatpickr("#check_out", {
        dateFormat: "Y-m-d", // Customize date format as needed
        onChange: function(selectedDates, dateStr, instance) {
            // Optional: Trigger calculation when date is selected
            calculateDaysAndTotal();
        }
    });
});
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const checkInField = document.getElementById('check_in');
        const checkOutField = document.getElementById('check_out');
        const daysField = document.getElementById('number_of_days');
        const roomChargeField = document.getElementById('room_charge');
        const totalChargeField = document.getElementById('total_charge');
        const roomSelect = document.getElementById('room_ids');

        function calculateDaysAndTotal() {
            const checkInDate = new Date(checkInField.value);
            const checkOutDate = new Date(checkOutField.value);

            if (checkInDate && checkOutDate && checkOutDate > checkInDate) {
                const days = (checkOutDate - checkInDate) / (1000 * 3600 * 24);
                daysField.value = days;

                const roomCharge = Array.from(roomSelect.selectedOptions)
                    .reduce((sum, option) => sum + parseFloat(option.dataset.basePrice || 0), 0);

                roomChargeField.value = roomCharge.toFixed(2);
                totalChargeField.value = (roomCharge * days).toFixed(2);
            }
        }

        checkInField.addEventListener('change', calculateDaysAndTotal);
        checkOutField.addEventListener('change', calculateDaysAndTotal);
        roomSelect.addEventListener('change', calculateDaysAndTotal);
    });
</script>
@endsection
