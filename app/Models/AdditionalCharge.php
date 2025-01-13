<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdditionalCharge extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'amount'];
    public function checkIns()
    {
        return $this->belongsToMany(CheckIn::class, 'check_in_additional_charges')
                    ->withPivot('amount')
                    ->withTimestamps();
    }
}
