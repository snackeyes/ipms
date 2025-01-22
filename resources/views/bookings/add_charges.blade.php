@extends('layouts.dashboard')

@section('content')
<div class="container">
    <h1>Add Additional Charges to Booking #{{ $booking->id }}</h1>

    <form action="{{ route('bookings.addChargesToBooking', $booking->id) }}" method="POST">
        @csrf

        <div id="charges-container">
            <div class="mb-3">
                <label for="charge-0-id" class="form-label">Charge</label>
                <select name="charges[0][id]" id="charge-0-id" class="form-control" required>
                    <option value="">-- Select Charge --</option>
                    @foreach ($allCharges as $charge)
                        <option value="{{ $charge->id }}">{{ $charge->name }} - {{ number_format($charge->default_amount, 2) }}</option>
                    @endforeach
                </select>

                <label for="charge-0-amount" class="form-label">Amount</label>
                <input type="number" name="charges[0][amount]" id="charge-0-amount" class="form-control" step="0.01" required>
            </div>
        </div>

        <button type="button" id="add-charge-btn" class="btn btn-secondary">Add Another Charge</button>
        <button type="submit" class="btn btn-success">Save Charges</button>
    </form>

    <h3>Existing Charges</h3>
    <ul>
        @foreach ($booking->additionalCharges as $charge)
            <li>
                {{ $charge->name }} - {{ number_format($charge->pivot->amount, 2) }}
                <form action="{{ route('bookings.removeChargeFromBooking', [$booking->id, $charge->id]) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                </form>
            </li>
        @endforeach
    </ul>
</div>

<script>
    document.getElementById('add-charge-btn').addEventListener('click', function () {
        const container = document.getElementById('charges-container');
        const index = container.children.length;
        const html = `
            <div class="mb-3">
                <label for="charge-${index}-id" class="form-label">Charge</label>
                <select name="charges[${index}][id]" id="charge-${index}-id" class="form-control" required>
                    <option value="">-- Select Charge --</option>
                    @foreach ($allCharges as $charge)
                        <option value="{{ $charge->id }}">{{ $charge->name }} - {{ number_format($charge->default_amount, 2) }}</option>
                    @endforeach
                </select>

                <label for="charge-${index}-amount" class="form-label">Amount</label>
                <input type="number" name="charges[${index}][amount]" id="charge-${index}-amount" class="form-control" step="0.01" required>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', html);
    });
</script>
@endsection
