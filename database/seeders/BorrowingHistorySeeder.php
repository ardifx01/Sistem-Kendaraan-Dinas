<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Borrowing;
use App\Models\User;
use App\Models\Vehicle;
use Carbon\Carbon;

class BorrowingHistorySeeder extends Seeder
{
    public function run()
    {
        // Get sample users and vehicles
        $user = User::where('role', 'operator')->first();
        $admin = User::where('role', 'admin')->first();
        $vehicle = Vehicle::first();

        if (!$user || !$admin || !$vehicle) {
            $this->command->info('Please ensure you have users and vehicles seeded first.');
            return;
        }

        // Create some returned borrowings for history
        $borrowings = [
            [
                'user_id' => $user->id,
                'vehicle_id' => $vehicle->id,
                'borrower_name' => 'John Doe',
                'borrower_phone' => '08123456789',
                'borrower_department' => 'IT Department',
                'destination' => 'Kantor Pusat',
                'purpose' => 'Rapat koordinasi',
                'start_date' => Carbon::now()->subDays(10),
                'end_date' => Carbon::now()->subDays(8),
                'status' => 'dikembalikan',
                'checked_out_by' => $admin->id,
                'checked_out_at' => Carbon::now()->subDays(10),
                'checked_in_by' => $admin->id,
                'checked_in_at' => Carbon::now()->subDays(8),
                'returned_at' => Carbon::now()->subDays(8),
                'notes' => 'Perjalanan selesai dengan baik',
                'created_at' => Carbon::now()->subDays(10),
                'updated_at' => Carbon::now()->subDays(8)
            ],
            [
                'user_id' => $user->id,
                'vehicle_id' => $vehicle->id,
                'borrower_name' => 'Jane Smith',
                'borrower_phone' => '08987654321',
                'borrower_department' => 'Finance',
                'destination' => 'Bank Mandiri',
                'purpose' => 'Urusan perbankan',
                'start_date' => Carbon::now()->subDays(7),
                'end_date' => Carbon::now()->subDays(5),
                'status' => 'dikembalikan',
                'checked_out_by' => $admin->id,
                'checked_out_at' => Carbon::now()->subDays(7),
                'checked_in_by' => $admin->id,
                'checked_in_at' => Carbon::now()->subDays(5),
                'returned_at' => Carbon::now()->subDays(5),
                'notes' => 'Kendaraan dikembalikan dalam kondisi baik',
                'created_at' => Carbon::now()->subDays(7),
                'updated_at' => Carbon::now()->subDays(5)
            ],
            [
                'user_id' => $user->id,
                'vehicle_id' => $vehicle->id,
                'borrower_name' => 'Bob Wilson',
                'borrower_phone' => '08111222333',
                'borrower_department' => 'HR',
                'destination' => 'Gedung Sate Bandung',
                'purpose' => 'Rekrutmen pegawai',
                'start_date' => Carbon::now()->subDays(3),
                'end_date' => Carbon::now()->subDays(1),
                'status' => 'dikembalikan',
                'checked_out_by' => $admin->id,
                'checked_out_at' => Carbon::now()->subDays(3),
                'checked_in_by' => $admin->id,
                'checked_in_at' => Carbon::now()->subDays(1),
                'returned_at' => Carbon::now()->subDays(1),
                'notes' => 'Perjalanan dinas sukses',
                'created_at' => Carbon::now()->subDays(3),
                'updated_at' => Carbon::now()->subDays(1)
            ]
        ];

        foreach ($borrowings as $borrowingData) {
            Borrowing::create($borrowingData);
        }

        $this->command->info('Borrowing history data seeded successfully!');
    }
}
