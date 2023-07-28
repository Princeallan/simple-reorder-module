<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Order::truncate();
        $orders = [[
            'product_id' => fake()->numberBetween(0, 10),
            'status_id' => fake()->numberBetween(1, 2),
            'order_number' => Str::padLeft(1, 6, "0"),
        ], [
            'product_id' => fake()->numberBetween(0, 10),
            'status_id' => fake()->numberBetween(1, 2),
            'order_number' => Str::padLeft(2, 6, "0"),
        ], [
            'product_id' => fake()->numberBetween(0, 10),
            'status_id' => fake()->numberBetween(1, 2),
            'order_number' => Str::padLeft(3, 6, "0"),
        ], [
            'product_id' => fake()->numberBetween(0, 10),
            'status_id' => fake()->numberBetween(1, 2),
            'order_number' => Str::padLeft(4, 6, "0"),
        ]];
        foreach ($orders as $order) {
            Order::create($order);
        }
    }
}
