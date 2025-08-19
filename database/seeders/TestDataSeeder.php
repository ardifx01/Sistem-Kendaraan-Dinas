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
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::firstOrCreate(
            ['email' => 'admin@kemenpora.go.id'],
            [
                'name' => 'Admin Kemenpora',
                'username' => 'admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'is_active' => true,
            ]
        );

        // Create operator users
        User::firstOrCreate(
            ['email' => 'operator1@kemenpora.go.id'],
            [
                'name' => 'Operator 1',
                'username' => 'operator1',
                'password' => Hash::make('password'),
                'role' => 'operator',
                'is_active' => true,
            ]
        );

        User::firstOrCreate(
            ['email' => 'operator2@kemenpora.go.id'],
            [
                'name' => 'Operator 2',
                'username' => 'operator2',
                'password' => Hash::make('password'),
                'role' => 'operator',
                'is_active' => true,
            ]
        );

        // Create sample vehicles
        $vehicles = [
            [
                'type' => 'mobil',
                'brand' => 'Toyota',
                'model' => 'Avanza',
                'year' => 2020,
                'license_plate' => 'B 1234 AB',
                'color' => 'Putih',
                'tax_expiry_date' => Carbon::now()->addDays(15), // Akan habis dalam 15 hari
                'document_status' => 'lengkap',
                'availability_status' => 'tersedia',
                'driver_name' => 'Budi Santoso',
                'user_name' => 'Unit Pemuda',
            ],

            [
                'type' => 'mobil',
                'brand' => 'Honda',
                'model' => 'Civic',
                'year' => 2019,
                'license_plate' => 'B 5678 CD',
                'color' => 'Hitam',
                'tax_expiry_date' => Carbon::now()->addDays(25), // Akan habis dalam 25 hari
                'document_status' => 'lengkap',
                'availability_status' => 'dipinjam',
                'driver_name' => 'Andi Wijaya',
                'user_name' => 'Unit Olahraga',
            ],

            [
                'type' => 'motor',
                'brand' => 'Yamaha',
                'model' => 'Vixion',
                'year' => 2021,
                'license_plate' => 'B 9876 EF',
                'color' => 'Biru',
                'tax_expiry_date' => Carbon::now()->addMonths(6),
                'document_status' => 'lengkap',
                'availability_status' => 'tersedia',
                'driver_name' => 'Citra Dewi',
                'user_name' => 'Unit Administrasi',
            ],

            [
                'type' => 'mobil',
                'brand' => 'Suzuki',
                'model' => 'Ertiga',
                'year' => 2018,
                'license_plate' => 'B 1111 GH',
                'color' => 'Silver',
                'tax_expiry_date' => Carbon::now()->addDays(5), // Akan habis dalam 5 hari
                'document_status' => 'lengkap',
                'availability_status' => 'service',
                'driver_name' => 'Dedi Kurniawan',
                'user_name' => 'Unit Prasarana',
            ],

            [
                'type' => 'mobil',
                'brand' => 'Mitsubishi',
                'model' => 'Pajero',
                'year' => 2022,
                'license_plate' => 'B 2222 IJ',
                'color' => 'Putih',
                'tax_expiry_date' => Carbon::now()->addYear(),
                'document_status' => 'lengkap',
                'availability_status' => 'tersedia',
                'driver_name' => 'Eko Prasetyo',
                'user_name' => 'Unit Sekretariat',
            ],
        ];

        foreach ($vehicles as $vehicleData) {
            Vehicle::firstOrCreate(
                ['license_plate' => $vehicleData['license_plate']],
                $vehicleData
            );
        }
    }
}
