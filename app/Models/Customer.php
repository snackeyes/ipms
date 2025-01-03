<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
     use HasFactory;

    protected $fillable = [
        'f_name',
        'l_name',
        'email',
        'phone',
        'address',
        'city',
        'state',
        'country',
        'gender',
        'dob',
        'nationality',
        'identity_type',
        'id_no',
        'id_front',
        'id_back',
    ];

    public function fullName()
    {
        return $this->f_name . ' ' . $this->l_name;
    }
    public function bookings()
{
    return $this->hasMany(Booking::class);
}
}
