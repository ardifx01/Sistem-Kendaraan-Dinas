<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Administrator',
            'username' => 'admin',
            'email' => 'admin@kementpora.go.id',
            'role' => 'admin',
            'is_active' => true,
            'password' => Hash::make('admin123'),
            'email_verified_at' => now(),
        ]);

        // Create sample operator
        User::create([
            'name' => 'Operator Kendaraan',
            'username' => 'operator',
            'email' => 'operator@kementpora.go.id',
            'role' => 'operator',
            'is_active' => true,
            'password' => Hash::make('operator123'),
            'email_verified_at' => now(),
        ]);
    }
}
