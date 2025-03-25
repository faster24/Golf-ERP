<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Customer;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
 */
class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $holes = $this->faker->randomElement([9, 18]);
        $golfers = $this->faker->numberBetween(1, 4);
        $hole_price = $this->faker->randomFloat(2, 10, 100);
        $total_price = $hole_price * $holes * $golfers;
        $created_at = $this->faker->dateTimeBetween('-1 month', 'now');
        $updated_at = $this->faker->dateTimeBetween($created_at, 'now');

        return [
            'customer_id' => Customer::factory(),
            'booking_date' => $this->faker->date('Y-m-d', 'now +30 days'),
            'booking_time' => $this->faker->time('H:i'),
            'location_city' => $this->faker->city(),
            'location_country' => $this->faker->country(),
            'course_id' => rand(1 , 5),
            'golfers' => $golfers,
            'holes' => $holes,
            'package_id' => rand(1 , 3),
            'hole_price' => $hole_price,
            'total_price' => $total_price,
            'status' => $this->faker->randomElement(['confirmed', 'canceled']),
            'created_at' => $created_at,
            'updated_at' => $updated_at,
            'canceled_at' => $this->faker->optional(0.2)->dateTimeThisYear(),
        ];
    }
}
