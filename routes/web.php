<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\FloorController;
use App\Http\Controllers\RoomTypeController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TaxController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\AdditionalChargeController;
use App\Http\Controllers\CheckInController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('roles', RoleController::class);
Route::middleware(['auth'])->group(function () {
    // Floor Routes
    Route::resource('floors', FloorController::class);

    // Room Type Routes
    Route::resource('room_types', RoomTypeController::class);

    // Room Routes
    Route::resource('rooms', RoomController::class)->except(['show']);
    Route::resource('customers', CustomerController::class);
     Route::resource('bookings', BookingController::class);
      Route::resource('reservations', ReservationController::class);
       Route::get('/customers/search', [CustomerController::class, 'search'])->name('customers.search');
Route::get('/rooms/available', [RoomController::class, 'getAvailableRooms'])->name('rooms.available');
Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store');
Route::get('rooms/data/',function () {
    return view('rooms/status');
});
Route::get('/rooms/status', [RoomController::class, 'getRoomStatus'])->name('rooms.status');
Route::resource('taxes', TaxController::class);
Route::resource('payment-methods', PaymentMethodController::class);
Route::resource('additional_charges', AdditionalChargeController::class);
Route::resource('check_ins', CheckInController::class);


});


require __DIR__.'/auth.php';
