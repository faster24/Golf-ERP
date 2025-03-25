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

    public function users()
    {
        return $this->belongsToMany(User::class, 'coupon_customer');
    }

    public function isValid(): bool
    {
        return $this->is_active &&
               $this->expiration_date->isFuture();
    }

    public function applyDiscount(float $amount): float
    {
        if ($this->discount_type === 'percentage') {
            return $amount * (1 - $this->discount_value / 100);
        }
        return max(0, $amount - $this->discount_value);
    }
}
