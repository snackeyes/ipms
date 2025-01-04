@extends('layouts.dashboard')

@section('content')
<div class="container">
    <h1>{{ isset($reservation) ? 'Edit' : 'Create' }} Reservation</h1>
    <form action="{{ isset($reservation) ? route('reservations.update', $reservation->id) : route('reservations.store') }}" method="POST">
        @csrf
        @if(isset($reservation))
            @method('PUT')
        @endif

        <div class="mb-3">
    <label for="customer_id" class="form-label">Customer</label>
   <select class="form-select select2-customer" name="customer_id" id="customer_id" required>
    <option value="">Search or Select Customer</option>
    @foreach($customers as $customer)
        <option value="{{ $customer->id }}">{{ $customer->f_name }} {{ $customer->l_name }} - {{ $customer->mobile }}</option>
    @endforeach
</select>

    <button type="button" class="btn btn-outline-primary mt-2" data-bs-toggle="modal" data-bs-target="#newCustomerModal">
        Add New Customer
    </button>
</div>


        <div class="mb-3">
            <label for="room_type_id" class="form-label">Room Type</label>
            <select class="form-select" name="room_type_id" id="room_type_id" required>
                <option value="">Select Room Type</option>
                @foreach($roomTypes as $type)
                    <option value="{{ $type->id }}" {{ isset($reservation) && $reservation->room_type_id == $type->id ? 'selected' : '' }}>
                        {{ $type->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="adults" class="form-label">Adults</label>
            <input type="number" class="form-control" name="adults" id="adults" value="{{ $reservation->adults ?? 1 }}" min="1" required>
        </div>

        <div class="mb-3">
            <label for="children" class="form-label">Children</label>
            <input type="number" class="form-control" name="children" id="children" value="{{ $reservation->children ?? 0 }}" min="0">
        </div>

        <div class="mb-3">
            <label for="check_in" class="form-label">Check-in</label>
            <input type="text" class="form-control flatpickr" name="check_in_date" id="check_in"
                   value="{{ old('check_in_date', $reservation->check_in ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label for="check_out" class="form-label">Check-out</label>
            <input type="text" class="form-control flatpickr" name="check_out_date" id="check_out"
                   value="{{ old('check_out_date', $reservation->check_out ?? '') }}" required>
        </div>

        <div class="mb-3">
    <label for="room_tariff" class="form-label">Room Tariff</label>
    <input type="number" step="0.01" class="form-control" name="room_tariff" id="room_tariff"
           value="{{ $reservation->room_tariff ?? '' }}" placeholder="Enter room tariff">
</div>

<div class="mb-3">
    <label for="meal_plan" class="form-label">Meal Plan</label>
    <select class="form-select" name="meal_plan" id="meal_plan">
        <option value="">Select Meal Plan</option>
        <option value="EP" {{ isset($reservation) && $reservation->meal_plan == 'EP' ? 'selected' : '' }}>EP</option>
        <option value="CP" {{ isset($reservation) && $reservation->meal_plan == 'CP' ? 'selected' : '' }}>CP</option>
        <option value="MAP" {{ isset($reservation) && $reservation->meal_plan == 'MAP' ? 'selected' : '' }}>MAP</option>
        <option value="AP" {{ isset($reservation) && $reservation->meal_plan == 'AP' ? 'selected' : '' }}>AP</option>
    </select>
</div>

<div class="mb-3">
    <label for="advance_payment" class="form-label">Advance Payment</label>
    <input type="number" step="0.01" class="form-control" name="advance_payment" id="advance_payment"
           value="{{ $reservation->advance_payment ?? '' }}" placeholder="Enter advance payment">
</div>

<div class="mb-3">
    <label for="agent_name" class="form-label">Agent Name</label>
    <input type="text" class="form-control" name="agent_name" id="agent_name"
           value="{{ $reservation->agent_name ?? '' }}" placeholder="Enter agent name (if any)">
</div>

        <button type="submit" class="btn btn-success">{{ isset($reservation) ? 'Update' : 'Create' }} Reservation</button>
        <a href="{{ route('reservations.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
<!-- New Customer Modal -->
<!-- New Customer Modal -->
<div class="modal fade" id="newCustomerModal" tabindex="-1" aria-labelledby="newCustomerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="newCustomerForm" onsubmit="addNewCustomer(event)">
                <div class="modal-header">
                    <h5 class="modal-title" id="newCustomerModalLabel">Add New Customer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @csrf
                    <div class="mb-3">
                        <label for="f_name" class="form-label">First Name</label>
                        <input type="text" class="form-control" name="f_name" id="f_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="l_name" class="form-label">Last Name</label>
                        <input type="text" class="form-control" name="l_name" id="l_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" id="email">
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" class="form-control" name="phone" id="phone" required>
                    </div>
                    <div class="mb-3">
                        <label for="gender" class="form-label">Gender</label>
                        <select class="form-select" name="gender" id="gender" required>
                            <option value="">Select Gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Save Customer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Handle form submission
$('#newCustomerForm').on('submit', function (e) {
    e.preventDefault();

    var formData = new FormData(this);

    $.ajax({
        url: "{{ route('customers.store') }}",
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            if (response.status === 'success') {
                // Close modal and reset form only if necessary
                $('#newCustomerModal').modal('hide');
                $('#customer_id').append(new Option(response.customer.f_name + ' ' + response.customer.l_name + ' - ' + response.customer.phone, response.customer.id)).trigger('change');
                $('#newCustomerForm')[0].reset();  // Only reset if needed
            } else {
                alert('Error: ' + response.message);
            }
        },
        error: function (response) {
            alert('Something went wrong, please try again.');
        }
    });
});
</script>

@endsection
