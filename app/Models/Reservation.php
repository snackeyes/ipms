<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
     use HasFactory;

  protected $fillable = [
    'customer_id', 'room_type_id', 'adults', 'children', 
    'check_in', 'check_out', 'status', 'remarks',
    'purpose_of_visit', 'source_of_booking', 'arrival_from', 
    'room_tariff', 'meal_plan', 'advance_payment', 'agent_name'
];

public function roomType()
{
    return $this->belongsTo(RoomType::class);
}

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
    public function rooms()
    {
        return $this->belongsToMany(Room::class, 'reservation_room')
                    ->withPivot('reservation_date') // Add any other pivot columns if needed
                    ->withTimestamps(); // Automatically manage created_at and updated_at
    }
}
