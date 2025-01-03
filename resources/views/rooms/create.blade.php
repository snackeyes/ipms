@extends('layouts.dashboard')

@section('content')
<div class="container">
    <h1>Create Room</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('rooms.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="room_number" class="form-label">Room Number</label>
            <input type="text" class="form-control" id="room_number" name="room_number" value="{{ old('room_number') }}" required>
        </div>

        <div class="mb-3">
            <label for="floor_id" class="form-label">Floor</label>
            <select class="form-select" id="floor_id" name="floor_id" required>
                <option value="">Select Floor</option>
                @foreach ($floors as $floor)
                    <option value="{{ $floor->id }}" {{ old('floor_id') == $floor->id ? 'selected' : '' }}>{{ $floor->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="room_type_id" class="form-label">Room Type</label>
            <select class="form-select" id="room_type_id" name="room_type_id" required>
                <option value="">Select Room Type</option>
                @foreach ($roomTypes as $roomType)
                    <option value="{{ $roomType->id }}" {{ old('room_type_id') == $roomType->id ? 'selected' : '' }}>{{ $roomType->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="base_price" class="form-label">Base Price</label>
            <input type="number" class="form-control" id="base_price" name="base_price" value="{{ old('base_price') }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Save</button>
        <a href="{{ route('rooms.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
