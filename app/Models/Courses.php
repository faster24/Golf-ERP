<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Courses extends Model implements HasMedia
{
    use HasFactory , InteractsWithMedia;

    protected $table = "golf_courses";

    protected $casts = [
        'visibility' => 'boolean',
        'is_featured' => 'boolean'
    ];

    protected $fillable = [
        'course_name',
        'sub_description',
        'yard',
        'location_city',
        'location_country',
        'description',
        'rating',
        'image_url',
        'discount',
        'visibility',
        'is_featured'
    ];
}
