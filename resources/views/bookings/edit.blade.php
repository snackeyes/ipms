@extends('layouts.dashboard')

@section('content')
<div class="container">
    <h1>Edit Booking</h1>
    <form action="{{ route('bookings.update', $booking->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="customer_id" class="form-label">Customer</label>
            <select class="form-select select2-customer" name="customer_id" id="customer_id" required>
                @foreach($customers as $customer)
                    <option value="{{ $customer->id }}" {{ $booking->customer_id == $customer->id ? 'selected' : '' }}>
                        {{ $customer->f_name }} {{ $customer->l_name }} - {{ $customer->mobile }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="check_in_date" class="form-label">Check-in</label>
            <input type="date" class="form-control" name="check_in_date" id="check_in_date"
                   value="{{ $booking->check_in_date }}" required>
        </div>

        <div class="mb-3">
            <label for="check_out_date" class="form-label">Check-out</label>
            <input type="date" class="form-control" name="check_out_date" id="check_out_date"
                   value="{{ $booking->check_out_date }}" required>
        </div>

        <div class="mb-3">
            <label for="room_ids" class="form-label">Rooms</label>
            <select class="form-select select2" name="room_ids[]" id="room_ids" multiple required>
                @foreach($vacantRooms as $room)
                    <option value="{{ $room->id }}"
                        {{ in_array($room->id, $booking->rooms->pluck('id')->toArray()) ? 'selected' : '' }}>
                        {{ $room->room_number }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="meal_plan" class="form-label">Meal Plan</label>
            <input type="text" class="form-control" name="meal_plan" id="meal_plan"
                   value="{{ $booking->meal_plan_id }}" placeholder="e.g., Breakfast Only">
        </div>

        <div class="mb-3">
            <label for="advance_payment" class="form-label">Advance Payment</label>
            <input type="number" class="form-control" name="advance_payment" id="advance_payment"
                   value="{{ $booking->advance_payment }}" placeholder="Enter advance payment">
        </div>

        <div class="mb-3">
            <label for="agent_name" class="form-label">Agent Name</label>
            <input type="text" class="form-control" name="agent_name" id="agent_name"
                   value="{{ $booking->agent_id }}" placeholder="Enter agent name">
        </div>

        <button type="submit" class="btn btn-primary">Update Booking</button>
    </form>
</div>
@endsection
