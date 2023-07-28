<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        Product::factory(10)->create();
//        Order::factory(20)->create();

        $this->call([
            StatusSeeder::class,
            OrderSeeder::class
        ]);

        User::factory()->create([
            'email' => 'demoadmin@example.com',
            'name' => 'Demo Admin',
            'password' => bcrypt('Secret123!'),
            'email_verified_at' => Carbon::now()
        ]);
    }
}
