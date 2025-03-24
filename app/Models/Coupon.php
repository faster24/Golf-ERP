<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $guarded = [];

    protected $casts = [
        'is_active' => 'boolean',
        'expiration_date' => 'date',
    ];
}
