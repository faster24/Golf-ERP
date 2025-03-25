<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition(): array
    {
        $created_at = $this->faker->dateTimeBetween('-5 years', 'now');
        $updated_at = $this->faker->dateTimeBetween($created_at, 'now');

        return [
            'email' => $this->faker->unique()->safeEmail(),
            'full_name' => $this->faker->name(),
            'password' => Hash::make('password'),
            'profile_pic' => $this->faker->optional()->imageUrl(200, 200, 'people'),
            'phone' => $this->faker->optional()->phoneNumber(),
            'created_at' => $created_at,
            'updated_at' => $updated_at
        ];
    }
}
