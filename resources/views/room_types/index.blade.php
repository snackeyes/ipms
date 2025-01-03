@extends('layouts.dashboard')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Room Types</h1>
        <a href="{{ route('room_types.create') }}" class="btn btn-primary">Add New Room Type</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Base Adult</th>
                <th>Base Child</th>
                <th>Max Adult</th>
                <th>Max Child</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($roomTypes as $roomType)
            <tr>
                <td>{{ $roomType->id }}</td>
                <td>{{ $roomType->name }}</td>
                <td>{{ $roomType->base_adult }}</td>
                <td>{{ $roomType->base_child }}</td>
                <td>{{ $roomType->max_adult }}</td>
                <td>{{ $roomType->max_child }}</td>
                <td>
                    <a href="{{ route('room_types.edit', $roomType->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('room_types.destroy', $roomType->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
