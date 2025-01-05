@extends('layouts.dashboard')

@section('content')
<div class="container">
    <h1>Additional Charges</h1>
    <a href="{{ route('additional_charges.create') }}" class="btn btn-primary">Add New Charge</a>

    @if(session('success'))
        <div class="alert alert-success mt-3">{{ session('success') }}</div>
    @endif

    <table class="table table-striped mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Amount</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($charges as $charge)
                <tr>
                    <td>{{ $charge->id }}</td>
                    <td>{{ $charge->name }}</td>
                    <td>{{ $charge->description }}</td>
                    <td>{{ $charge->amount }}</td>
                    <td>
                        <a href="{{ route('additional_charges.edit', $charge) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('additional_charges.destroy', $charge) }}" method="POST" style="display:inline;">
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
