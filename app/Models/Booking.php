<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = ['reservation_id', 'room_id', 'guest_count', 'check_in_date', 'check_out_date', 'status'];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

   public function rooms()
{
    return $this->belongsToMany(Room::class, 'booking_room')
        ->withPivot('check_in_date', 'check_out_date')
        ->withTimestamps();
}
public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
    public function checkIns()
{
    return $this->hasMany(CheckIn::class);
}
public function additionalCharges()
{
    return $this->belongsToMany(AdditionalCharge::class, 'additional_charge_booking')
                ->withPivot('amount')
                ->withTimestamps();
}
}
