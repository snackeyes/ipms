@extends('layouts.dashboard')

@section('content')
<div class="container">
    <h1>Edit Floor</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('floors.update', $floor->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Floor Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $floor->name) }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('floors.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
