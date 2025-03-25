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
        return (!$this->expires_at || $this->expires_at->isFuture()) &&
               ($this->usage_limit === 0 || $this->times_used < $this->usage_limit);
    }

    public function applyDiscount(float $amount): float
    {
        if ($this->discount_percentage) {
            return $amount * (1 - $this->discount_percentage / 100);
        }
        return max(0, $amount - $this->discount);
    }
}
