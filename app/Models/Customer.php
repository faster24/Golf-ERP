<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Authenticatable
{
    use HasApiTokens, Notifiable , HasFactory;

    protected $fillable = [
        'email',
        'full_name',
        'password',
        'profile_pic',
        'phone',
        'bio',
        'linkedin_url',
        'facebook_url',
        'x_url',
        'allowed_networking',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function coupons()
    {
        return $this->belongsToMany(Coupon::class, 'coupon_customer', 'user_id', 'coupon_id');
    }
}
