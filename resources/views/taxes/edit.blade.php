@extends('layouts.dashboard')

@section('content')
<div class="container">
    <h1>Edit Tax</h1>
    <form action="{{ route('taxes.update', $tax->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Tax Name</label>
            <input type="text" class="form-control" name="name" id="name" value="{{ $tax->name }}" required>
        </div>

        <div class="mb-3">
            <label for="rate" class="form-label">Rate (%)</label>
            <input type="number" step="0.01" class="form-control" name="rate" id="rate" value="{{ $tax->rate }}" required>
        </div>

        <button type="submit" class="btn btn-success">Update Tax</button>
        <a href="{{ route('taxes.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
