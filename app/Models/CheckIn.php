<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckIn extends Model
{
    use HasFactory;

    protected $fillable = ['booking_id', 'room_ids', 'check_in_date', 'status'];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function rooms()
{
    return $this->hasMany(Room::class, 'id', 'room_ids');
}
    protected $casts = [
        'room_ids' => 'array', // Automatically convert JSON to array
    ];
}
