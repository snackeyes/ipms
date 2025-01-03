@extends('layouts.dashboard')

@section('content')
<div class="container">
    <h1>{{ isset($reservation) ? 'Edit' : 'Create' }} Reservation</h1>
    <form action="{{ isset($reservation) ? route('reservations.update', $reservation->id) : route('reservations.store') }}" method="POST">
        @csrf
        @if(isset($reservation))
            @method('PUT')
        @endif

        <div class="mb-3">
            <label for="customer_id" class="form-label">Customer</label>
            <select class="form-select" name="customer_id" id="customer_id">
                <option value="">Select Customer</option>
                @foreach($customers as $customer)
                    <option value="{{ $customer->id }}" {{ isset($reservation) && $reservation->customer_id == $customer->id ? 'selected' : '' }}>
                        {{ $customer->f_name }} {{ $customer->l_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="room_type_id" class="form-label">Room Type</label>
            <select class="form-select" name="room_type_id" id="room_type_id" required>
                <option value="">Select Room Type</option>
                @foreach($roomTypes as $type)
                    <option value="{{ $type->id }}" {{ isset($reservation) && $reservation->room_type_id == $type->id ? 'selected' : '' }}>
                        {{ $type->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="adults" class="form-label">Adults</label>
            <input type="number" class="form-control" name="adults" id="adults" value="{{ $reservation->adults ?? 1 }}" min="1" required>
        </div>

        <div class="mb-3">
            <label for="children" class="form-label">Children</label>
            <input type="number" class="form-control" name="children" id="children" value="{{ $reservation->children ?? 0 }}" min="0">
        </div>

        <div class="mb-3">
            <label for="check_in" class="form-label">Check-in</label>
            <input type="date" class="form-control" name="check_in" id="check_in" value="{{ $reservation->check_in ?? '' }}" required>
        </div>

        <div class="mb-3">
            <label for="check_out" class="form-label">Check-out</label>
            <input type="date" class="form-control" name="check_out" id="check_out" value="{{ $reservation->check_out ?? '' }}" required>
        </div>
        <div class="mb-3">
    <label for="room_tariff" class="form-label">Room Tariff</label>
    <input type="number" step="0.01" class="form-control" name="room_tariff" id="room_tariff" 
           value="{{ $reservation->room_tariff ?? '' }}" placeholder="Enter room tariff">
</div>

<div class="mb-3">
    <label for="meal_plan" class="form-label">Meal Plan</label>
    <select class="form-select" name="meal_plan" id="meal_plan">
        <option value="">Select Meal Plan</option>
        <option value="breakfast_only" {{ isset($reservation) && $reservation->meal_plan == 'breakfast_only' ? 'selected' : '' }}>Breakfast Only</option>
        <option value="half_board" {{ isset($reservation) && $reservation->meal_plan == 'half_board' ? 'selected' : '' }}>Half Board</option>
        <option value="full_board" {{ isset($reservation) && $reservation->meal_plan == 'full_board' ? 'selected' : '' }}>Full Board</option>
    </select>
</div>

<div class="mb-3">
    <label for="advance_payment" class="form-label">Advance Payment</label>
    <input type="number" step="0.01" class="form-control" name="advance_payment" id="advance_payment" 
           value="{{ $reservation->advance_payment ?? '' }}" placeholder="Enter advance payment">
</div>

<div class="mb-3">
    <label for="agent_name" class="form-label">Agent Name</label>
    <input type="text" class="form-control" name="agent_name" id="agent_name" 
           value="{{ $reservation->agent_name ?? '' }}" placeholder="Enter agent name (if any)">
</div>

        <button type="submit" class="btn btn-success">{{ isset($reservation) ? 'Update' : 'Create' }} Reservation</button>
        <a href="{{ route('reservations.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
