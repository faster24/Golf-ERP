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
                'course_name' => 'Amata Spring Country Club',
                'sub_description' => 'A prestigious golf course in the heart of Thailand.',
                'yard' => 7300,
                'city' => 'Chonburi',
                'country' => 'Thailand',
                'description' => 'Amata Spring is known for its exclusive atmosphere and its challenging 18-hole layout. The course offers wide fairways and large greens, surrounded by serene lakes and carefully designed bunkers. The course has hosted multiple international tournaments, making it one of Thailand\'s premier golfing destinations. Golfers can expect a visually stunning and strategically demanding experience.',
                'image_url' => 'https://res.cloudinary.com/dt28nxrrx/image/upload/v1740416673/6_wqlcd1.jpg',
                'rating' => 4.9,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'course_name' => 'Black Mountain Golf Club',
                'sub_description' => 'A world-class golf course located in Hua Hin.',
                'yard' => 7200,
                'city' => 'Hua Hin',
                'country' => 'Thailand',
                'description' => 'Set against the backdrop of the mountain, Black Mountain Golf Club is often regarded as one of the best in Asia. This championship course is challenging yet fair, with natural landscapes that create a picturesque golfing experience. The course is well-maintained, with lush fairways, strategically placed water hazards, and impressive bunkers, ensuring a thrilling game from start to finish.',
                'image_url' => 'https://res.cloudinary.com/dt28nxrrx/image/upload/v1740416673/11_dyeaei.jpg',
                'rating' => 4.9,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'course_name' => 'Siam Country Club Pattaya Old Course',
                'sub_description' => 'One of the most well-known courses in Pattaya.',
                'yard' => 7100,
                'city' => 'Pattaya',
                'country' => 'Thailand',
                'description' => 'This iconic course is steeped in history, having hosted many prestigious tournaments. With its beautiful, manicured fairways, the Old Course at Siam Country Club offers a challenging layout that includes water features, narrow fairways, and elevated greens. The views of the surrounding countryside add to the tranquil atmosphere, making it a must-play for both locals and international visitors.',
                'image_url' => 'https://res.cloudinary.com/dt28nxrrx/image/upload/v1740416669/13_ncxofz.jpg',
                'rating' => 4.7,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'course_name' => 'Chiang Mai Highlands Golf and Spa Resort',
                'sub_description' => 'A peaceful resort course surrounded by nature.',
                'yard' => 6700,
                'city' => 'Chiang Mai',
                'country' => 'Thailand',
                'description' => 'Located in the lush mountains of Chiang Mai, this resort offers a beautiful and tranquil golfing experience. The 18-hole championship course is designed to challenge golfers of all skill levels. The course weaves through the natural landscape, with rolling hills, water features, and scenic views of the nearby mountains. It\'s an ideal destination for golfers looking to combine a relaxing vacation with a challenging round of golf.',
                'image_url' => 'https://res.cloudinary.com/dt28nxrrx/image/upload/v1740416648/10_fc5cws.jpg',
                'rating' => 4.6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'course_name' => 'The Royal Gems Golf City',
                'sub_description' => 'A luxurious golf course designed with international standards.',
                'yard' => 7400,
                'city' => 'Nakhon Pathom',
                'country' => 'Thailand',
                'description' => 'The Royal Gems Golf City is a unique course that stands out for its replicas of famous holes from around the world. This exclusive golf resort offers an exciting challenge for golfers, with each hole thoughtfully designed to mirror some of the most iconic golf courses globally. The course features beautiful landscaping, water hazards, and strategic bunkering, creating a unique golfing experience in the heart of Thailand.',
                'image_url' => 'https://res.cloudinary.com/dt28nxrrx/image/upload/v1740416666/12_ggc0hs.jpg',
                'rating' => 4.8,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'course_name' => 'Laem Chabang International Country Club',
                'sub_description' => 'A renowned golf course near Pattaya.',
                'yard' => 7100,
                'city' => 'Pattaya',
                'country' => 'Thailand',
                'description' => 'Laem Chabang is a beautifully designed course set amidst lush hills, offering an exceptional golfing experience. With three distinct nines, the course challenges golfers with strategic water hazards, narrow fairways, and doglegs. The breathtaking views of the surrounding countryside make it a perfect destination for both golfers and those seeking to relax in a serene environment. Its design by Jack Nicklaus ensures that it remains one of Thailand’s top golf destinations.',
                'image_url' => 'https://res.cloudinary.com/dt28nxrrx/image/upload/v1740416598/1_wf4dbh.jpg',
                'rating' => 4.7,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'course_name' => 'Red Mountain Golf Club',
                'sub_description' => 'A stunning course located in Phuket.',
                'yard' => 6800,
                'city' => 'Phuket',
                'country' => 'Thailand',
                'description' => 'Red Mountain Golf Club is an exciting and challenging course, renowned for its stunning landscape and dramatic elevation changes. Situated in the heart of Phuket, it offers breathtaking views of the island’s natural beauty. The course’s tight fairways, well-placed water hazards, and challenging greens ensure golfers are tested from every angle, making it a must-visit for golf enthusiasts in Thailand.',
                'image_url' => 'https://res.cloudinary.com/dt28nxrrx/image/upload/v1740416669/9_ms5hah.jpg',
                'rating' => 4.9,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'course_name' => 'Banyan Golf Club Hua Hin',
                'sub_description' => 'A scenic and challenging course in Hua Hin.',
                'yard' => 7200,
                'city' => 'Hua Hin',
                'country' => 'Thailand',
                'description' => 'Banyan Golf Club is one of the most modern and scenic courses in Thailand. With its wide fairways, well-placed water features, and undulating greens, it offers a mix of challenges that will appeal to golfers of all levels. The course’s design maximizes the natural beauty of the area, with panoramic views of the sea and surrounding hills. It’s a perfect blend of challenging play and stunning scenery.',
                'image_url' => 'https://res.cloudinary.com/dt28nxrrx/image/upload/v1740416641/8_qdzvzq.jpg',
                'rating' => 4.8,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'course_name' => 'The Pinehurst Golf and Country Club',
                'sub_description' => 'An elite course with a blend of natural beauty and challenge.',
                'yard' => 7300,
                'city' => 'Bangkok',
                'country' => 'Thailand',
                'description' => 'The Pinehurst Golf and Country Club combines natural beauty with a challenging layout designed to test even the most seasoned golfers. The course features lush fairways, tricky water hazards, and large greens. Located just outside of Bangkok, it provides an ideal escape from the city’s hustle and bustle, offering golfers an enjoyable yet demanding round of golf amidst a tranquil setting.',
                'image_url' => 'https://res.cloudinary.com/dt28nxrrx/image/upload/v1740416640/5_zz52h0.jpg',
                'rating' => 4.6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'course_name' => 'Santiburi Samui Country Club',
                'sub_description' => 'A stunning course on the island of Koh Samui.',
                'yard' => 6800,
                'city' => 'Koh Samui',
                'country' => 'Thailand',
                'description' => 'Santiburi Samui offers an unforgettable golfing experience on one of Thailand’s most picturesque islands. The course is set in a tropical paradise, with panoramic views of the ocean, and features a variety of challenging holes that wind through the hills. Golfers will enjoy a relaxing yet challenging round, with water hazards and strategic bunkering adding to the challenge. It’s a golfer’s haven surrounded by nature.',
                'image_url' => 'https://res.cloudinary.com/dt28nxrrx/image/upload/v1740416635/7_l3iizw.jpg',
                'rating' => 4.7,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'course_name' => 'Phuket Country Club',
                'sub_description' => 'A scenic and affordable course in Phuket.',
                'yard' => 6600,
                'city' => 'Phuket',
                'country' => 'Thailand',
                'description' => 'Phuket Country Club offers golfers a more relaxed and affordable experience without compromising on quality. Set in lush tropical surroundings, this course is easy to walk and ideal for golfers who want a fun yet challenging round. With wide fairways, water hazards, and fast greens, it provides a fun test of skill for golfers of all levels, all while being just minutes away from the vibrant beach town of Phuket.',
                'image_url' => 'https://res.cloudinary.com/dt28nxrrx/image/upload/v1740416608/4_qzb5ne.jpg',
                'rating' => 4.5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'course_name' => 'Rayong Green Valley Country Club',
                'sub_description' => 'An exceptional course in Rayong.',
                'yard' => 6700,
                'city' => 'Rayong',
                'country' => 'Thailand',
                'description' => 'Rayong Green Valley Country Club is one of the hidden gems of Thailand’s golf scene. The course is set among rolling hills, lush landscapes, and tranquil lakes, providing a peaceful and challenging environment. The layout features wide fairways, strategically placed water hazards, and well-maintained greens, ensuring that golfers of all levels are challenged. The natural beauty of the course enhances its appeal, making it a must-play for golf enthusiasts.',
                'image_url' => 'https://res.cloudinary.com/dt28nxrrx/image/upload/v1740416628/3_hc80sd.jpg',
                'rating' => 4.6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'course_name' => 'Alpine Golf Club',
                'sub_description' => 'A challenging golf course with a picturesque backdrop.',
                'yard' => 6900,
                'city' => 'Saraburi',
                'country' => 'Thailand',
                'description' => 'Alpine Golf Club is known for its beautiful mountainous setting and challenging course layout. With its dramatic elevation changes, narrow fairways, and strategically placed water hazards, Alpine provides a tough yet rewarding round of golf. The course’s stunning views of the surrounding mountains and pristine landscaping make it a memorable golfing experience. It’s a must-play for golfers looking for a challenge in an extraordinary location.',
                'image_url' => 'https://res.cloudinary.com/dt28nxrrx/image/upload/v1740416602/2_roabds.jpg',
                'rating' => 4.7,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'course_name' => 'Royal Hua Hin Golf Course',
                'sub_description' => 'Thailand’s oldest golf course, established in 1924.',
                'yard' => 6678,
                'city' => 'Hua Hin',
                'country' => 'Thailand',
                'description' => 'A historic course with scenic mountain views and classic design.',
                'image_url' => 'https://res.cloudinary.com/dt28nxrrx/image/upload/v1740666617/new2_xndafk.jpg',
                'rating' => 4.4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'course_name' => 'Santiburi Samui Country Club',
                'sub_description' => 'Koh Samui’s premier golf destination.',
                'yard' => 6800,
                'city' => 'Koh Samui',
                'country' => 'Thailand',
                'description' => 'A stunning course with ocean views and hilly terrain.',
                'image_url' => 'https://res.cloudinary.com/dt28nxrrx/image/upload/v1740666626/new1_n4xvw9.jpg',
                'rating' => 4.7,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'course_name' => 'Khao Kheow Country Club',
                'sub_description' => 'A 27-hole championship course in Chonburi.',
                'yard' => 7100,
                'city' => 'Chonburi',
                'country' => 'Thailand',
                'description' => 'Designed by Pete Dye, featuring challenging layouts and water hazards.',
                'image_url' => 'https://res.cloudinary.com/dt28nxrrx/image/upload/v1740666628/new5_ehmojb.jpg',
                'rating' => 4.6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'course_name' => 'Gassan Khuntan Golf & Resort',
                'sub_description' => 'A hidden gem in northern Thailand.',
                'yard' => 7200,
                'city' => 'Lampang',
                'country' => 'Thailand',
                'description' => 'Surrounded by mountains and rivers, offering a scenic golf experience.',
                'image_url' => 'https://res.cloudinary.com/dt28nxrrx/image/upload/v1740666633/new6_dljaxk.jpg',
                'rating' => 4.5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'course_name' => 'Rajpruek Club',
                'sub_description' => 'A private, top-tier course in Bangkok.',
                'yard' => 7000,
                'city' => 'Bangkok',
                'country' => 'Thailand',
                'description' => 'An elite golf club known for its exclusivity and well-kept greens.',
                'image_url' => 'https://res.cloudinary.com/dt28nxrrx/image/upload/v1740666633/new4_wexb4z.jpg',
                'rating' => 4.8,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'course_name' => 'Phoenix Gold Golf & Country Club',
                'sub_description' => 'A 27-hole championship course in Pattaya.',
                'yard' => 7072,
                'city' => 'Pattaya',
                'country' => 'Thailand',
                'description' => 'Hosts professional tournaments and features scenic fairways.',
                'image_url' => 'https://res.cloudinary.com/dt28nxrrx/image/upload/v1740666637/new3_jdnnxd.jpg',
                'rating' => 4.6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'course_name' => 'Waterford Valley Golf Club',
                'sub_description' => 'A peaceful golf retreat in Chiang Rai.',
                'yard' => 6930,
                'city' => 'Chiang Rai',
                'country' => 'Thailand',
                'description' => 'Nestled in lush greenery, offering a relaxing golfing experience.',
                'image_url' => 'https://res.cloudinary.com/dt28nxrrx/image/upload/v1740666649/new7_f3zcdt.jpg',
                'rating' => 4.5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'course_name' => 'Sea Pines Golf Course',
                'sub_description' => 'A stunning beachfront golf course in Hua Hin.',
                'yard' => 6780,
                'city' => 'Hua Hin',
                'country' => 'Thailand',
                'description' => 'A links-style course with breathtaking ocean views.',
                'image_url' => 'https://res.cloudinary.com/dt28nxrrx/image/upload/v1740666649/new8_ivxmj0.jpg',
                'rating' => 4.7,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($courses as $data) {
            $course = Courses::create([
                'course_name' => $data['course_name'],
                'sub_description' => $data['sub_description'],
                'yard' => $data['yard'],
                'location_city' => $data['city'],
                'location_country' => $data['country'],
                'description' => $data['description'],
                'rating' => $data['rating'],
                'image_url' => $data['image_url'],
                'discount' => 20,
            ]);
        }
    }
}
