<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        Order::truncate();

        return [
            'product_id' => fake()->numberBetween(0,20),
            'status_id' => fake()->numberBetween(1,2),
        ];
    }
}
