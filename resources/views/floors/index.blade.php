@extends('layouts.dashboard')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Floors</h1>
        <a href="{{ route('floors.create') }}" class="btn btn-primary">Add New Floor</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($floors as $floor)
            <tr>
                <td>{{ $floor->id }}</td>
                <td>{{ $floor->name }}</td>
                <td>
                    <a href="{{ route('floors.edit', $floor->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('floors.destroy', $floor->id) }}" method="POST" class="d-inline">
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
