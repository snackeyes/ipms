@extends('layouts.dashboard')

@section('content')
<div class="container">
    <h1>Room Booking Status</h1>

    <!-- Filters -->
    <form id="filterForm" class="row g-3 mb-4">
        <div class="col-md-4">
            <label for="start_date" class="form-label">Start Date</label>
            <input type="date" class="form-control" id="start_date" name="start_date" value="{{ now()->format('Y-m-d') }}">
        </div>
        <div class="col-md-4">
            <label for="end_date" class="form-label">End Date</label>
            <input type="date" class="form-control" id="end_date" name="end_date" value="{{ now()->addWeek()->format('Y-m-d') }}">
        </div>
        <div class="col-md-4 align-self-end">
            <button type="button" class="btn btn-primary" onclick="fetchRoomStatus()">Filter</button>
        </div>
    </form>

    <!-- Room Status Table -->
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Room Number</th>
                    <!-- Dynamically add date columns -->
                </tr>
            </thead>
            <tbody id="roomStatusTable">
                <!-- Room status rows -->
            </tbody>
        </table>
    </div>
</div>

<script>
    function fetchRoomStatus() {
        const startDate = document.getElementById('start_date').value;
        const endDate = document.getElementById('end_date').value;

        fetch(`{{ route('rooms.status') }}?start_date=${startDate}&end_date=${endDate}`)
            .then(response => response.json())
            .then(data => renderRoomStatusTable(data))
            .catch(error => console.error('Error fetching room status:', error));
    }

    function renderRoomStatusTable(data) {
        const tableBody = document.getElementById('roomStatusTable');
        tableBody.innerHTML = '';

        const startDate = document.getElementById('start_date').value;
        const endDate = document.getElementById('end_date').value;
        const dates = [];
        let currentDate = new Date(startDate);

        while (currentDate <= new Date(endDate)) {
            dates.push(currentDate.toISOString().split('T')[0]);
            currentDate.setDate(currentDate.getDate() + 1);
        }

        // Render headers
        const headerRow = document.querySelector('thead tr');
        headerRow.innerHTML = '<th>Room Number</th>';
        dates.forEach(date => {
            const th = document.createElement('th');
            th.textContent = date;
            headerRow.appendChild(th);
        });

        // Render rows
        Object.values(data).forEach(room => {
            const row = document.createElement('tr');

            // Room number
            const roomCell = document.createElement('td');
            roomCell.textContent = room.room_number;
            row.appendChild(roomCell);

            // Dates
            dates.forEach(date => {
                const dateCell = document.createElement('td');
                dateCell.textContent = room.dates[date] === 'booked' ? 'Booked' : 'Vacant';
                dateCell.classList.add(room.dates[date] === 'booked' ? 'table-danger' : 'table-success');
                row.appendChild(dateCell);
            });

            tableBody.appendChild(row);
        });
    }

    // Fetch initial data
    fetchRoomStatus();
</script>
@endsection
