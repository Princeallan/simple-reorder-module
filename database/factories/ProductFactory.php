<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
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
        Product::trucate();

        $name = fake()->realText(50);
        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'quantity' => fake()->numberBetween(0,10),
            'fulfilled_orders_count' => fake()->numberBetween(0,20),
            'order_number' => Str::padLeft(fake()->numberBetween(0,20),6,"0"),
        ];
    }
}
