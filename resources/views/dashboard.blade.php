@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row g-4">
        <!-- Today's Booked Rooms -->
        <div class="col-lg-6 col-md-12">
            <div class="card stat-card bg-primary text-white">
                <div class="card-body">
                    <i class="fas fa-bed stat-icon"></i>
                    <h5>Today's Booked Rooms</h5>
                    <p class="display-4">{{ $bookedRoomsCount }}</p>
                </div>
            </div>
        </div>

        <!-- Available Rooms -->
        <div class="col-lg-6 col-md-12">
            <div class="card stat-card bg-success text-white">
                <div class="card-body">
                    <i class="fas fa-door-open stat-icon"></i>
                    <h5>Available Rooms</h5>
                    <p class="display-4">{{ $availableRoomsCount }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
