<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Room;

class DashboardController extends Controller
{
    public function dashboard()
{
    $today = now()->toDateString();
    $bookedRoomsCount = Booking::whereDate('check_in_date', $today)->count();
    $availableRoomsCount = Room::where('status', 'available')->count();

    return view('dashboard', compact('bookedRoomsCount', 'availableRoomsCount'));
}

}
