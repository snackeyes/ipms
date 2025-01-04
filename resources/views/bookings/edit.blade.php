@extends('layouts.dashboard')

@section('content')
<div class="container">
    <h1>Edit Booking</h1>
    <form action="{{ route('bookings.update', $booking->id) }}" method="POST" id="bookingForm">
        @csrf
        @method('PUT')

        <!-- Customer Selection -->
        <div class="mb-3">
            <label for="customer_id" class="form-label">Customer</label>
            <select class="form-select select2-customer" name="customer_id" id="customer_id" required>
                <option value="">Search or Select Customer</option>
                @foreach($customers as $customer)
                    <option value="{{ $customer->id }}"
                        {{ old('customer_id', $booking->customer_id) == $customer->id ? 'selected' : '' }}>
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
                       value="{{ old('check_in_date', $booking->check_in_date) }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="check_out" class="form-label">Check-out</label>
                <input type="text" class="form-control flatpickr" name="check_out_date" id="check_out"
                       value="{{ old('check_out_date', $booking->check_out_date) }}" required>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="number_of_days" class="form-label">Number of Days</label>
                <input type="number" class="form-control" id="number_of_days" name="number_of_days" value="{{ old('number_of_days', $booking->number_of_days) }}" readonly>
            </div>
            <div class="col-md-6 mb-3">
                <label for="room_type_filter" class="form-label">Filter by Room Type</label>
                <select class="form-select" id="room_type_filter">
                    <option value="">All Room Types</option>
                    @foreach($roomTypes as $roomType)
                        <option value="{{ $roomType->id }}" {{ old('room_type_filter', $booking->room_type_id) == $roomType->id ? 'selected' : '' }}>{{ $roomType->name }}</option>
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
                        {{ in_array($room->id, $booking->rooms->pluck('id')->toArray()) ? 'selected' : '' }}
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
                <option value="EP" {{ old('meal_plan', $booking->meal_plan) == 'EP' ? 'selected' : '' }}>EP</option>
                <option value="CP" {{ old('meal_plan', $booking->meal_plan) == 'CP' ? 'selected' : '' }}>CP</option>
                <option value="MAP" {{ old('meal_plan', $booking->meal_plan) == 'MAP' ? 'selected' : '' }}>MAP</option>
                <option value="AP" {{ old('meal_plan', $booking->meal_plan) == 'AP' ? 'selected' : '' }}>AP</option>
            </select>
        </div>

        <!-- Agent Name -->
        <div class="mb-3">
            <label for="agent_name" class="form-label">Agent Name</label>
            <input type="text" class="form-control" name="agent_name" id="agent_name"
                   value="{{ old('agent_name', $booking->agent_name) }}" placeholder="Enter agent name">
        </div>

        <!-- Fare and Payment Details -->
        <hr>
        <h4>Fare Details</h4>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="room_charge" class="form-label">Room Charge Per Day (Tax Inclusive)</label>
                <input type="number" class="form-control" id="room_charge" name="room_charge" value="{{ old('room_charge', $booking->room_charge) }}">
            </div>
            <div class="col-md-6 mb-3">
                <label for="advance_payment" class="form-label">Advance Payment</label>
                <input type="number" class="form-control" name="advance_payment" id="advance_payment"
                       value="{{ old('advance_payment', $booking->advance_payment) }}" placeholder="Enter advance payment">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="tax_amount" class="form-label">Tax Amount</label>
                <input type="number" class="form-control" id="tax_amount" name="tax_amount" value="{{ old('tax_amount', $booking->tax_amount) }}" readonly>
            </div>
            <div class="col-md-6 mb-3">
                <label for="total_charge" class="form-label">Total Charge (Tax Inclusive)</label>
                <input type="number" class="form-control" id="total_charge" name="total_charge" value="{{ old('total_charge', $booking->total_charge) }}" readonly>
            </div>
        </div>

        <button type="submit" class="btn btn-success">Update Booking</button>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
      // DOM Elements
      const checkInField = document.getElementById('check_in');
      const checkOutField = document.getElementById('check_out');
      const roomSelect = document.getElementById('room_ids');
      const daysField = document.getElementById('number_of_days');
      const roomChargeField = document.getElementById('room_charge');
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

          if (isValidDateRange(checkInDate, checkOutDate)) {
              const days = calculateDays(checkInDate, checkOutDate);
              const roomCharges = calculateRoomCharges();
              const taxAmount = roomCharges.taxAmount;
              const inclusiveCharge = roomCharges.inclusiveCharge;

              updateFields(days, inclusiveCharge, taxAmount);
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

      roomChargeField.addEventListener('input', function () {
          const newRoomCharge = parseFloat(roomChargeField.value || 0);
          const gstRate = getGSTRate(newRoomCharge);
          const exclusiveCharge = newRoomCharge / (1 + gstRate / 100);
          const taxAmount = newRoomCharge - exclusiveCharge;
          totalChargeField.value = (newRoomCharge * parseInt(daysField.value || 0)).toFixed(2);
          taxAmountField.value = (taxAmount * parseInt(daysField.value || 0)).toFixed(2);
          log("Updated room charge manually", { newRoomCharge, exclusiveCharge, taxAmount });
      });

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

@endsection
