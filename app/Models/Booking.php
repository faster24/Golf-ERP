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
}
