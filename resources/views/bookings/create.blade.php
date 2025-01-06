@extends('layouts.dashboard')

@section('content')
<div class="container">
    <h1>Create Booking</h1>
    <form action="{{ route('bookings.store') }}" method="POST" id="bookingForm">
        @csrf

        @if($reservation)
            <input type="hidden" name="reservation_id" value="{{ $reservation->id }}">
        @endif

        <!-- Customer Selection -->
        <div class="mb-3">
            <label for="customer_id" class="form-label">Customer</label>
            <select class="form-select select2-customer" name="customer_id" id="customer_id" required>
                <option value="">Search or Select Customer</option>
                @foreach($customers as $customer)
                    <option value="{{ $customer->id }}"
                        {{ old('customer_id', $reservation->customer_id ?? '') == $customer->id ? 'selected' : '' }}>
                        {{ $customer->f_name }} {{ $customer->l_name }} - {{ $customer->mobile }}
                    </option>
                @endforeach
            </select>
            <button type="button" class="btn btn-outline-primary mt-2" data-bs-toggle="modal" data-bs-target="#newCustomerModal">
                Add New Customer
            </button>
        </div>

        <!-- Date and Room Details -->
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="check_in" class="form-label">Check-in</label>
                <input type="text" class="form-control flatpickr" name="check_in_date" id="check_in"
                       value="{{ old('check_in_date', $reservation->check_in ?? '') }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="check_out" class="form-label">Check-out</label>
                <input type="text" class="form-control flatpickr" name="check_out_date" id="check_out"
                       value="{{ old('check_out_date', $reservation->check_out ?? '') }}" required>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="number_of_days" class="form-label">Number of Days</label>
                <input type="number" class="form-control" id="number_of_days" name="number_of_days" readonly>
            </div>
            <div class="col-md-6 mb-3">
                <label for="room_type_filter" class="form-label">Filter by Room Type</label>
                <select class="form-select" id="room_type_filter">
                    <option value="">All Room Types</option>
                    @foreach($roomTypes as $roomType)
                        <option value="{{ $roomType->id }}">{{ $roomType->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Available Rooms -->
        <div class="mb-3">
            <label for="room_ids" class="form-label">Rooms</label>
            <select class="form-select select2" name="room_ids[]" id="room_ids" multiple required>
                @foreach($vacantRooms as $room)
                    <option value="{{ $room->id }}"
                        data-room-type="{{ $room->room_type_id }}"
                        data-base-price="{{ $room->base_price }}">
                        {{ $room->room_number }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Meal Plan -->
        <div class="mb-3">
            <label for="meal_plan" class="form-label">Meal Plan</label>
            <select class="form-select" name="meal_plan" id="meal_plan">
                <option value="">Select Meal Plan</option>
                <option value="EP">EP</option>
                <option value="CP">CP</option>
                <option value="MAP">MAP</option>
                <option value="AP">AP</option>
            </select>
        </div>

        <!-- Agent Name -->
        <div class="mb-3">
            <label for="agent_name" class="form-label">Agent Name</label>
            <input type="text" class="form-control" name="agent_name" id="agent_name"
                   value="{{ old('agent_name', $reservation->agent_name ?? '') }}" placeholder="Enter agent name">
        </div>

        <!-- Fare and Payment Details -->
        <hr>
        <h4>Fare Details</h4>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="room_charge" class="form-label">Room Charge Per Day (Tax Inclusive)</label>
                <input type="number" class="form-control" id="room_charge" name="room_charge">
            </div>
            <div class="col-md-6 mb-3">
                <label for="advance_payment" class="form-label">Advance Payment</label>
                <input type="number" class="form-control" name="advance_payment" id="advance_payment"
                       value="{{ old('advance_payment', $reservation->advance_payment ?? '') }}" placeholder="Enter advance payment">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="tax_amount" class="form-label">Tax Amount</label>
                <input type="number" class="form-control" id="tax_amount" name="tax_amount" readonly>
            </div>
            <div class="col-md-6 mb-3">
                <label for="total_charge" class="form-label">Total Charge (Tax Inclusive)</label>
                <input type="number" class="form-control" id="total_charge" name="total_charge" readonly>
            </div>
        </div>
        <!-- Payment Method -->
<div class="mb-3">
    <label for="payment_method" class="form-label">Payment Method</label>
    <select class="form-select" name="payment_method_id" id="payment_method" required>
        <option value="">Select Payment Method</option>
        @foreach($paymentMethods as $paymentMethod)
            <option value="{{ $paymentMethod->id }}"
                {{ old('payment_method_id', $reservation->payment_method_id ?? '') == $paymentMethod->id ? 'selected' : '' }}>
                {{ $paymentMethod->name }}
            </option>
        @endforeach
    </select>
</div>

        <button type="submit" class="btn btn-success">Create Booking</button>
    </form>
</div>
<!-- Add New Customer Modal -->
<div class="modal fade" id="newCustomerModal" tabindex="-1" aria-labelledby="newCustomerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="newCustomerForm" method="POST" action="{{ route('customers.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="newCustomerModalLabel">Add New Customer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <!-- First Name -->
                        <div class="col-md-6 mb-3">
                            <label for="first_name" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="f_name" name="f_name" required>
                        </div>

                        <!-- Last Name -->
                        <div class="col-md-6 mb-3">
                            <label for="last_name" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="l_name" name="l_name" required>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Email -->
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email">
                        </div>

                        <!-- Phone -->
                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone" required>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Address -->
                        <div class="col-md-12 mb-3">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control" id="address" name="address">
                        </div>
                    </div>

                    <div class="row">
                        <!-- City -->
                        <div class="col-md-4 mb-3">
                            <label for="city" class="form-label">City</label>
                            <input type="text" class="form-control" id="city" name="city">
                        </div>

                        <!-- State -->
                        <div class="col-md-4 mb-3">
                            <label for="state" class="form-label">State</label>
                            <input type="text" class="form-control" id="state" name="state">
                        </div>

                        <!-- Country -->
                        <div class="col-md-4 mb-3">
                            <label for="country" class="form-label">Country</label>
                            <input type="text" class="form-control" id="country" name="country">
                        </div>
                    </div>

                    <div class="row">
                        <!-- Gender -->
                        <div class="col-md-6 mb-3">
                            <label for="gender" class="form-label">Gender</label>
                            <select class="form-select" id="gender" name="gender">
                                <option value="">Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>

                        <!-- Date of Birth -->
                        <div class="col-md-6 mb-3">
                            <label for="dob" class="form-label">Date of Birth</label>
                            <input type="date" class="form-control" id="dob" name="dob">
                        </div>
                    </div>

                    <div class="row">
                        <!-- Nationality -->
                        <div class="col-md-6 mb-3">
                            <label for="nationality" class="form-label">Nationality</label>
                            <input type="text" class="form-control" id="nationality" name="nationality">
                        </div>

                        <!-- Identity Type -->
                        <div class="col-md-6 mb-3">
                            <label for="identity_type" class="form-label">Identity Type</label>
                            <select class="form-select" id="identity_type" name="identity_type">
                                <option value="">Select Identity Type</option>
                                <option value="Passport">Passport</option>
                                <option value="Driver's License">Driver's License</option>
                                <option value="National ID">National ID</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Identity Number -->
                        <div class="col-md-6 mb-3">
                            <label for="identity_number" class="form-label">Identity Number</label>
                            <input type="text" class="form-control" id="identity_number" name="identity_number">
                        </div>

                        <!-- Identity Front Image -->
                        <div class="col-md-6 mb-3">
                            <label for="identity_front" class="form-label">Identity Front Image</label>
                            <input type="file" class="form-control" id="identity_front" name="identity_front">
                        </div>
                    </div>

                    <div class="row">
                        <!-- Identity Back Image -->
                        <div class="col-md-6 mb-3">
                            <label for="identity_back" class="form-label">Identity Back Image</label>
                            <input type="file" class="form-control" id="identity_back" name="identity_back">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Customer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // DOM Elements
    const checkInField = document.getElementById('check_in');
    const checkOutField = document.getElementById('check_out');
    const roomSelect = document.getElementById('room_ids');
    const daysField = document.getElementById('number_of_days');
    const roomChargeField = document.getElementById('room_charge');
    const advancePaymentField = document.getElementById('advance_payment');
    const taxAmountField = document.getElementById('tax_amount');
    const totalChargeField = document.getElementById('total_charge');
    const availableRoomsUrl = "{{ url('/rooms/available') }}"; // URL for fetching available rooms

    // Helper functions
    function log(message, data = null) {
        console.log(message, data);
    }

    function getGSTRate(roomTariff) {
        const gstRate = roomTariff < 7500 ? 12 : 18; // GST rates: 12% below ₹7500, 18% otherwise
        log("GST rate determined", { roomTariff, gstRate });
        return gstRate;
    }

    function isValidDateRange(checkIn, checkOut) {
        const isValid = checkIn && checkOut && checkOut > checkIn;
        log("Date range validation", { checkIn, checkOut, isValid });
        return isValid;
    }

    function calculateDays(checkIn, checkOut) {
        const days = Math.ceil((checkOut - checkIn) / (1000 * 3600 * 24));
        log("Calculated days between dates", { checkIn, checkOut, days });
        return days;
    }

    function calculateRoomCharges() {
        let inclusiveCharge = 0;
        let taxAmount = 0;

        Array.from(roomSelect.selectedOptions).forEach(option => {
            const roomTariff = parseFloat(option.dataset.basePrice || 0);
            const gstRate = getGSTRate(roomTariff);
            const exclusiveCharge = roomTariff / (1 + gstRate / 100);
            inclusiveCharge += roomTariff;
            taxAmount += (roomTariff - exclusiveCharge);
        });

        log("Room charges calculation", { inclusiveCharge, taxAmount });
        return { inclusiveCharge, taxAmount };
    }

    function updateFields(days, inclusiveCharge, taxAmount) {
        daysField.value = days;
        roomChargeField.value = inclusiveCharge.toFixed(2);
        taxAmountField.value = (taxAmount * days).toFixed(2);
        totalChargeField.value = (inclusiveCharge * days).toFixed(2);
        log("Updated fields with calculated values", { days, inclusiveCharge, taxAmount });
    }

    function clearFields() {
        daysField.value = '';
        roomChargeField.value = '';
        taxAmountField.value = '';
        totalChargeField.value = '';
        log("Cleared fields");
    }

    function calculateGST() {
        const checkInDate = new Date(checkInField.value);
        const checkOutDate = new Date(checkOutField.value);
        const advancePayment = parseFloat(advancePaymentField.value || 0);

        if (isValidDateRange(checkInDate, checkOutDate)) {
            const days = calculateDays(checkInDate, checkOutDate);
            const roomCharges = calculateRoomCharges();
            const taxAmount = roomCharges.taxAmount;
            const inclusiveCharge = roomCharges.inclusiveCharge;

            // Subtract advance payment from total charge
            const totalCharge = inclusiveCharge * days;
            const finalTotalCharge = totalCharge - advancePayment;

            updateFields(days, inclusiveCharge, taxAmount);

            // Update total charge field after deducting advance payment
            totalChargeField.value = finalTotalCharge.toFixed(2);
            log("Total charge after subtracting advance payment", finalTotalCharge);
        } else {
            clearFields(); // Clear fields if dates are invalid
        }
    }

    function fetchAvailableRooms() {
        const checkIn = checkInField.value;
        const checkOut = checkOutField.value;

        if (!checkIn || !checkOut) {
            roomSelect.innerHTML = '<option value="">Select a room</option>';
            log("Fetch rooms aborted", { checkIn, checkOut });
            return;
        }

        const url = `${availableRoomsUrl}?check_in=${encodeURIComponent(checkIn)}&check_out=${encodeURIComponent(checkOut)}`;
        log("Fetching available rooms from URL", url);

        fetch(url)
            .then(response => {
                log("Received response", response);
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                log("Fetched available rooms data", data);
                roomSelect.innerHTML = ''; // Clear previous options

                if (data.length === 0) {
                    roomSelect.innerHTML = '<option value="">No rooms available</option>';
                    return;
                }

                data.forEach(room => {
                    const option = document.createElement('option');
                    option.value = room.id; // Room ID
                    option.textContent = room.room_number; // Display room number
                    option.setAttribute('data-room-type', room.room_type_id || ""); // Room type
                    option.setAttribute('data-base-price', room.base_price || ""); // Base price
                    roomSelect.appendChild(option);
                });
            })
            .catch(error => {
                log('Error fetching available rooms', error);
                roomSelect.innerHTML = '<option value="">Error fetching rooms</option>';
            });
    }

    // Event listeners
    checkInField.addEventListener('change', calculateGST);
    checkOutField.addEventListener('change', calculateGST);
    roomSelect.addEventListener('change', calculateGST);
    advancePaymentField.addEventListener('input', calculateGST); // Recalculate when advance payment changes

    // Initialize Flatpickr
    flatpickr("#check_in", {
        dateFormat: "Y-m-d",
        onChange: calculateGST,
    });

    flatpickr("#check_out", {
        dateFormat: "Y-m-d",
        onChange: calculateGST,
    });
});

</script>
<script>
   document.addEventListener('DOMContentLoaded', function () {
    // DOM Elements
    const checkInField = document.getElementById('check_in');
    const checkOutField = document.getElementById('check_out');
    const roomSelect = document.getElementById('room_ids');
    const availableRoomsUrl = "{{ url('/rooms/available') }}"; // URL for fetching available rooms

    /**
     * Fetch available rooms based on check-in and check-out dates.
     */
    function fetchAvailableRooms() {
        const checkIn = checkInField.value;
        const checkOut = checkOutField.value;

        if (!checkIn || !checkOut) {
            roomSelect.innerHTML = '<option value="">Select a room</option>';
            console.warn("Check-in or Check-out date is missing.");
            return;
        }

        const url = `${availableRoomsUrl}?check_in=${encodeURIComponent(checkIn)}&check_out=${encodeURIComponent(checkOut)}`;
        console.log("Fetching available rooms from URL:", url);

        fetch(url)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log("Available rooms data:", data);
                roomSelect.innerHTML = ''; // Clear previous options

                if (data.length === 0) {
                    roomSelect.innerHTML = '<option value="">No rooms available</option>';
                    return;
                }

                data.forEach(room => {
                    const option = document.createElement('option');
                    option.value = room.id; // Room ID
                    option.textContent = room.room_number; // Display room number
                    option.setAttribute('data-room-type', room.room_type_id || ""); // Room type
                    option.setAttribute('data-base-price', room.base_price || ""); // Base price

                    roomSelect.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Error fetching available rooms:', error);
                roomSelect.innerHTML = '<option value="">Error fetching rooms</option>';
            });
    }

    /**
     * Attach event listeners to fields.
     */
    checkInField.addEventListener('change', fetchAvailableRooms);
    checkOutField.addEventListener('change', fetchAvailableRooms);
});

    </script>
    <script>
      document.getElementById("newCustomerForm").addEventListener("submit", function (e) {
    e.preventDefault();

    const form = e.target;
    const formData = new FormData(form);

    fetch("{{ route('customers.store') }}", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
            "X-Requested-With": "XMLHttpRequest",
        },
        body: formData,
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.status === "success") {
                // Hide the modal
                const modal = bootstrap.Modal.getInstance(document.getElementById("customerModal"));
                modal.hide();

                // Add the new customer to the dropdown
                const customerDropdown = document.getElementById("customer_id");
                const newOption = new Option(data.customer.f_name + " " + data.customer.l_name, data.customer.id, true, true);
                customerDropdown.add(newOption);

                // Clear the form fields
                form.reset();

                // Show success message
                alert("Customer created and selected successfully!");
            } else {
                alert("Something went wrong. Please try again.");
            }
        })
        .catch((error) => {
            console.error("Error:", error);
            alert("An error occurred while processing your request.");
        });
});


    </script>
@endsection
