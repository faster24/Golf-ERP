<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'booking_date',
        'booking_time',
        'location_city',
        'location_country',
        'course_name',
        'course_id',
        'golfers',
        'holes',
        'package_id',
        'hole_price',
        'total_price',
        'coupon_id',
    ];

    protected $casts = [
        'booking_date' => 'date',
        'canceled_at' => 'datetime',
        'hole_price' => 'decimal:2',
        'total_price' => 'decimal:2',
    ];

    public function course()
    {
        return $this->belongsTo(Courses::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class , 'customer_id');
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    public function calculateTotalPrice()
    {
        $basePrice = $this->hole_price * $this->holes * $this->golfers;
        if ($this->coupon && $this->coupon->isValid()) {
            return $this->coupon->applyDiscount($basePrice);
        }
        return $basePrice;
    }
}
