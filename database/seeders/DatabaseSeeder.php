<?php

namespace Database\Seeders;

use App\Models\Attendee;
use App\Models\Booking;
use App\Models\Customer;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Attendee::factory()->count(53)->create();

        Customer::factory()->count(55)->create();

        Booking::factory()->count(51)->create();

        $this->call([
            UserSeeder::class,
            CourseSeeder::class,
            // PackageSeeder::class,
        ]);
    }
}
