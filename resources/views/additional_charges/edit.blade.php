@extends('layouts.dashboard')

@section('content')
<div class="container">
    <h1>{{ isset($additionalCharge) ? 'Edit Charge' : 'Add New Charge' }}</h1>
    <form action="{{ isset($additionalCharge) ? route('additional_charges.update', $additionalCharge) : route('additional_charges.store') }}" method="POST">
        @csrf
        @if(isset($additionalCharge))
            @method('PUT')
        @endif

        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $additionalCharge->name ?? '') }}" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description">{{ old('description', $additionalCharge->description ?? '') }}</textarea>
        </div>
        <div class="mb-3">
            <label for="amount" class="form-label">Amount</label>
            <input type="number" class="form-control" id="amount" name="amount" step="0.01" value="{{ old('amount', $additionalCharge->amount ?? '') }}" required>
        </div>

        <button type="submit" class="btn btn-success">{{ isset($additionalCharge) ? 'Update' : 'Save' }}</button>
        <a href="{{ route('additional_charges.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
