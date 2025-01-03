<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
     use HasFactory;

    protected $fillable = ['room_number', 'floor_id', 'room_type_id', 'base_price'];

    public function floor()
    {
        return $this->belongsTo(Floor::class);
    }

    public function roomType()
    {
        return $this->belongsTo(RoomType::class);
    }
    public function reservations()
    {
        return $this->belongsToMany(Reservation::class);
    }

    public function bookings()
{
    return $this->belongsToMany(Booking::class, 'booking_room')
        ->withPivot('check_in', 'check_out')
        ->withTimestamps();
}

    
}
