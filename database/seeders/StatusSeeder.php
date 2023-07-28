<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Status::truncate();

        Status::create([
            'name' => 'Pending',
            'is_active' => 1,
        ]);
        Status::create([
            'name' => 'Fulfilled',
            'is_active' => 1,
        ]);
    }
}
