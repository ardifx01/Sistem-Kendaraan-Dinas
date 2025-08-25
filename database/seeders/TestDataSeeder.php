<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class TestDataSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin',
                'username' => 'admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'is_active' => true,
            ]
        );

        // Create operator users
        User::firstOrCreate(
            ['email' => 'operator1@gmail.com'],
            [
                'name' => 'Operator 1',
                'username' => 'operator1',
                'password' => Hash::make('password'),
                'role' => 'operator',
                'is_active' => true,
            ]
        );

        User::firstOrCreate(
            ['email' => 'operator2@gmail.com'],
            [
                'name' => 'Operator 2',
                'username' => 'operator2',
                'password' => Hash::make('password'),
                'role' => 'operator',
                'is_active' => true,
            ]
        );
    }
}