@extends('layouts.dashboard')

@section('content')
<div class="container">
    <h1>Create Tax</h1>
    <form action="{{ route('taxes.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Tax Name</label>
            <input type="text" class="form-control" name="name" id="name" required>
        </div>

        <div class="mb-3">
            <label for="rate" class="form-label">Rate (%)</label>
            <input type="number" step="0.01" class="form-control" name="rate" id="rate" required>
        </div>

        <button type="submit" class="btn btn-success">Save Tax</button>
        <a href="{{ route('taxes.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
