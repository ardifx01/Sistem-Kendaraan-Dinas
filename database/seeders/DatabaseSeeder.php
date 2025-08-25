<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Call the seeders
        $this->call([
            TestDataSeeder::class,
            VehicleSeeder::class
        ]);
    }
}
