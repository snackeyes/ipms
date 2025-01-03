@extends('layouts.dashboard')

@section('content')
<div class="container">
    <h1>Edit Customer</h1>
    <form action="{{ route('customers.update', $customer->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row mb-3">
            <div class="col">
                <label for="f_name" class="form-label">First Name</label>
                <input type="text" name="f_name" id="f_name" class="form-control" value="{{ old('f_name', $customer->f_name) }}" required>
            </div>
            <div class="col">
                <label for="l_name" class="form-label">Last Name</label>
                <input type="text" name="l_name" id="l_name" class="form-control" value="{{ old('l_name', $customer->l_name) }}" required>
            </div>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $customer->email) }}" required>
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">Phone</label>
            <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone', $customer->phone) }}" required>
        </div>

        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <input type="text" name="address" id="address" class="form-control" value="{{ old('address', $customer->address) }}" required>
        </div>

        <div class="row mb-3">
            <div class="col">
                <label for="city" class="form-label">City</label>
                <input type="text" name="city" id="city" class="form-control" value="{{ old('city', $customer->city) }}" required>
            </div>
            <div class="col">
                <label for="state" class="form-label">State</label>
                <input type="text" name="state" id="state" class="form-control" value="{{ old('state', $customer->state) }}" required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col">
                <label for="country" class="form-label">Country</label>
                <input type="text" name="country" id="country" class="form-control" value="{{ old('country', $customer->country) }}" required>
            </div>
            <div class="col">
                <label for="gender" class="form-label">Gender</label>
                <select name="gender" id="gender" class="form-control" required>
                    <option value="Male" {{ old('gender', $customer->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                    <option value="Female" {{ old('gender', $customer->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                    <option value="Other" {{ old('gender', $customer->gender) == 'Other' ? 'selected' : '' }}>Other</option>
                </select>
            </div>
        </div>

        <div class="mb-3">
            <label for="dob" class="form-label">Date of Birth</label>
            <input type="date" name="dob" id="dob" class="form-control" value="{{ old('dob', $customer->dob) }}" required>
        </div>

        <div class="mb-3">
            <label for="nationality" class="form-label">Nationality</label>
            <input type="text" name="nationality" id="nationality" class="form-control" value="{{ old('nationality', $customer->nationality) }}" required>
        </div>

        <div class="mb-3">
            <label for="identity_type" class="form-label">Identity Type</label>
            <input type="text" name="identity_type" id="identity_type" class="form-control" value="{{ old('identity_type', $customer->identity_type) }}" required>
        </div>

        <div class="mb-3">
            <label for="id" class="form-label">Identity Number</label>
            <input type="text" name="id_no" id="id_no" class="form-control" value="{{ old('id_no', $customer->id_no) }}" required>
        </div>

        <div class="mb-3">
            <label for="id_front" class="form-label">ID Front</label>
            <input type="file" name="id_front" id="id_front" class="form-control">
            @if($customer->id_front)
                <img src="{{ asset('storage/' . $customer->id_front) }}" alt="ID Front" class="img-thumbnail mt-2" width="150">
            @endif
        </div>

        <div class="mb-3">
            <label for="id_back" class="form-label">ID Back</label>
            <input type="file" name="id_back" id="id_back" class="form-control">
            @if($customer->id_back)
                <img src="{{ asset('storage/' . $customer->id_back) }}" alt="ID Back" class="img-thumbnail mt-2" width="150">
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Update Customer</button>
    </form>
</div>
@endsection
