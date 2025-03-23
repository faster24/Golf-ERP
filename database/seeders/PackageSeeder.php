<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Package;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $packages = [
            [
                'name' => 'Golf Juniors\' Package',
                'price' => 3000,
                'features' => json_encode([
                    'Access to Rental Golf Set',
                    '2 rounds of Range and Green',
                    'Meals Plan (Buffet)',
                    'Golf Cart service',
                    'Carrier Services',
                ]),
            ],
            [
                'name' => 'Lesson Golf Package',
                'price' => 2000,
                'features' => json_encode([
                    'Access to Rental Golf Set',
                    'One trial Green Session',
                    'Meals Plan(Buffet)',
                    'Carrier Services + Golf Cart',
                    'Video lessons + Progress Report',
                ]),
            ],
            [
                'name' => 'Senior Golf Package',
                'price' => 4000,
                'features' => json_encode([
                    'Access to Rental Golf Set',
                    'One trial Coaching Session',
                    'Meals Plan(Buffet)',
                    'Golf Cart and Carrier Services',
                    '3 rounds of Green Fees and Ranges',
                ]),
            ],
        ];

        // Insert data into the packages table
        foreach ($packages as $package) {
            Package::create($package);
        }
    }
}
