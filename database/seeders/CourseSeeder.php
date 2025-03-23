<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Courses;
use Illuminate\Support\Facades\DB;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $courses = [
            [
                'course_name' => "Amata Spring Country Club",
                'sub_description' => "A prestigious golf course in the heart of Thailand.",
                'yard' => "7300",
                'location_city' => "Chonburi",
                'location_country' => "Thailand",
                'description' => "Amata Spring is known for its exclusive atmosphere and its challenging 18-hole layout...",
                'rating' => 4.8,
                'discount' => 0,
                'visibility' => true,
                'is_featured' => false,
                'image_url' => "https://res.cloudinary.com/dt28nxrrx/image/upload/v1740416673/6_wqlcd1.jpg",
            ],
            [
                'course_name' => "Black Mountain Golf Club",
                'sub_description' => "A world-class golf course located in Hua Hin.",
                'yard' => "7200",
                'location_city' => "Hua Hin",
                'location_country' => "Thailand",
                'description' => "Set against the backdrop of the mountain, Black Mountain Golf Club is often regarded...",
                'rating' => 4.9,
                'discount' => 0,
                'visibility' => true,
                'is_featured' => false,
                'image_url' => "https://res.cloudinary.com/dt28nxrrx/image/upload/v1740416673/11_dyeaei.jpg",
            ],
            [
                'course_name' => "Siam Country Club Pattaya Old Course",
                'sub_description' => "One of the most well-known courses in Pattaya.",
                'yard' => "7100",
                'location_city' => "Pattaya",
                'location_country' => "Thailand",
                'description' => "This iconic course is steeped in history, having hosted many prestigious tournaments...",
                'rating' => 4.7,
                'discount' => 0,
                'visibility' => true,
                'is_featured' => false,
                'image_url' => "https://res.cloudinary.com/dt28nxrrx/image/upload/v1740416669/13_ncxofz.jpg",
            ],
            [
                'course_name' => "Chiang Mai Highlands Golf and Spa Resort",
                'sub_description' => "A peaceful resort course surrounded by nature.",
                'yard' => "6700",
                'location_city' => "Chiang Mai",
                'location_country' => "Thailand",
                'description' => "Located in the lush mountains of Chiang Mai, this resort offers a beautiful and tranquil golfing experience...",
                'rating' => 4.6,
                'discount' => 0,
                'visibility' => true,
                'is_featured' => false,
                'image_url' => "https://res.cloudinary.com/dt28nxrrx/image/upload/v1740416648/10_fc5cws.jpg",
            ],
        ];

        foreach ($courses as $data) {
            $course = Courses::create([
                'course_name' => $data['course_name'],
                'sub_description' => $data['sub_description'],
                'yard' => $data['yard'],
                'location_city' => $data['location_city'],
                'location_country' => $data['location_country'],
                'description' => $data['description'],
                'rating' => $data['rating'],
                'image' => $data['image_url'],
                'discount' => $data['discount'],
                'visibility' => $data['visibility'],
                'is_featured' => $data['is_featured'],
            ]);

            // Attach image using Spatie Media Library
            $course->addMediaFromUrl($data['image_url'])->toMediaCollection('course_images');
        }
    }
}
