<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $fillable = [
        'name' , 'price' , 'features', 'is_featured' , 'visibility'
    ];

    protected $casts = [
        'features' => 'array',
        'is_featured' => 'boolean',
        'visibility'=> 'boolean'
    ];
}
