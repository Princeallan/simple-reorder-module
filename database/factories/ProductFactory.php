<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        Product::truncate();

        $name = fake()->word;

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'quantity' => fake()->numberBetween(0,10),
            'fulfilled_orders_count' => fake()->numberBetween(0,20),
            'order_number' => null,
        ];
    }
}
