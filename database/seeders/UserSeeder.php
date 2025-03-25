<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Administrator',
                'email' => 'admin@cismo.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('password'),
                'remember_token' => \Str::random(10),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Jane Doe',
                'email' => 'jane.doe@admin.com',
                'email_verified_at' => null,
                'password' => Hash::make('password123'),
                'remember_token' => \Str::random(10),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'John Smith',
                'email' => 'john.smith@admin.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('secret456'),
                'remember_token' => \Str::random(10),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
