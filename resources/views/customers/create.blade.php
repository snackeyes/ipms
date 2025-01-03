@extends('layouts.dashboard')

@section('content')
<div class="container">
    <h1>Create Customer</h1>
    <form action="{{ route('customers.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="f_name" class="form-label">First Name</label>
            <input type="text" class="form-control" id="f_name" name="f_name" required>
        </div>
        <div class="mb-3">
            <label for="l_name" class="form-label">Last Name</label>
            <input type="text" class="form-control" id="l_name" name="l_name" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Phone</label>
            <input type="text" class="form-control" id="phone" name="phone" required>
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <input type="text" class="form-control" id="address" name="address" required>
        </div>
        <div class="mb-3">
            <label for="city" class="form-label">City</label>
            <input type="text" class="form-control" id="city" name="city" required>
        </div>
        <div class="mb-3">
            <label for="state" class="form-label">State</label>
            <input type="text" class="form-control" id="state" name="state" required>
        </div>
        <div class="mb-3">
            <label for="country" class="form-label">Country</label>
            <input type="text" class="form-control" id="country" name="country" required>
        </div>
        <div class="mb-3">
            <label for="gender" class="form-label">Gender</label>
            <select class="form-select" id="gender" name="gender" required>
                <option value="">Select Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="dob" class="form-label">Date of Birth</label>
            <input type="date" class="form-control" id="dob" name="dob" required>
        </div>
        <div class="mb-3">
            <label for="nationality" class="form-label">Nationality</label>
            <input type="text" class="form-control" id="nationality" name="nationality" required>
        </div>
        <div class="mb-3">
            <label for="identity_type" class="form-label">Identity Type</label>
            <select class="form-select" id="identity_type" name="identity_type" required>
                <option value="">Select Identity Type</option>
                <option value="Passport">Passport</option>
                <option value="Driver's License">Driver's License</option>
                <option value="National ID">National ID</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="id" class="form-label">Identity Number</label>
            <input type="text" class="form-control" id="id_no" name="id_no" required>
        </div>
        <div class="mb-3">
            <label for="id_front" class="form-label">Identity Front Image</label>
            <input type="file" class="form-control" id="id_front" name="id_front" accept="image/*" required>
        </div>
        <div class="mb-3">
            <label for="id_back" class="form-label">Identity Back Image</label>
            <input type="file" class="form-control" id="id_back" name="id_back" accept="image/*" required>
        </div>
        <button type="submit" class="btn btn-success">Create Customer</button>
        <a href="{{ route('customers.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
