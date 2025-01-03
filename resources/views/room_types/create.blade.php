@extends('layouts.dashboard')

@section('content')
<div class="container">
    <h1>Create Room Type</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('room_types.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Room Type Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
        </div>

        <div class="mb-3">
            <label for="base_adult" class="form-label">Base Adult</label>
            <input type="number" class="form-control" id="base_adult" name="base_adult" value="{{ old('base_adult') }}" required>
        </div>

        <div class="mb-3">
            <label for="base_child" class="form-label">Base Child</label>
            <input type="number" class="form-control" id="base_child" name="base_child" value="{{ old('base_child') }}" required>
        </div>

        <div class="mb-3">
            <label for="max_adult" class="form-label">Max Adult</label>
            <input type="number" class="form-control" id="max_adult" name="max_adult" value="{{ old('max_adult') }}" required>
        </div>

        <div class="mb-3">
            <label for="max_child" class="form-label">Max Child</label>
            <input type="number" class="form-control" id="max_child" name="max_child" value="{{ old('max_child') }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Save</button>
        <a href="{{ route('room_types.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
