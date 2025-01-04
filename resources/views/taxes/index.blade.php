@extends('layouts.dashboard')

@section('content')
<div class="container">
    <h1>Tax List</h1>
    <a href="{{ route('taxes.create') }}" class="btn btn-primary mb-3">Add New Tax</a>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Rate (%)</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($taxes as $tax)
                    <tr>
                        <td>{{ $tax->name }}</td>
                        <td>{{ $tax->rate }}%</td>
                        <td>
                            <a href="{{ route('taxes.edit', $tax->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('taxes.destroy', $tax->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this tax?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
