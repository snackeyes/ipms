@extends('layouts.dashboard')

@section('content')
<div class="container">
    <h1>Create New Role</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('roles.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Role Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Permissions</label>
            <div class="form-check">
                @foreach ($permissions as $permission)
                <div>
                    <input type="checkbox" class="form-check-input" id="permission-{{ $permission->id }}" name="permissions[]" value="{{ $permission->id }}">
                    <label class="form-check-label" for="permission-{{ $permission->id }}">{{ $permission->name }}</label>
                </div>
                @endforeach
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Save Role</button>
        <a href="{{ route('roles.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
