<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckOut extends Model
{
    use HasFactory;
    protected $fillable = [
        'check_in_id',
        'additional_charges',
        'discount',
        'discount_remarks',
        'gst',
        'rest_payment',
        'payment_status',
    ];
public function checkIn()
{
    return $this->belongsTo(CheckIn::class);
}
    
}
