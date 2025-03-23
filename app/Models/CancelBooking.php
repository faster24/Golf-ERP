<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CancelBooking extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'course_name',
        'golf_pic',
        'total_price',
        'cancel_date',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
