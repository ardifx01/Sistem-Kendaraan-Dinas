<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Insert some sample returned borrowings
        DB::table('borrowings')->insert([
            [
                'user_id' => 1,
                'vehicle_id' => 1,
                'borrower_type' => 'internal',
                'borrower_name' => 'John Doe',
                'borrower_institution' => 'IT Department',
                'borrower_contact' => '08123456789',
                'destination' => 'Kantor Pusat',
                'purpose' => 'Rapat koordinasi',
                'location_type' => 'dalam_kota',
                'start_date' => now()->subDays(10)->format('Y-m-d'),
                'end_date' => now()->subDays(8)->format('Y-m-d'),
                'status' => 'returned',
                'checked_out_by' => 1,
                'checked_out_at' => now()->subDays(10),
                'checked_in_by' => 1,
                'checked_in_at' => now()->subDays(8),
                'notes' => 'Perjalanan selesai dengan baik',
                'created_at' => now()->subDays(10),
                'updated_at' => now()->subDays(8)
            ],
            [
                'user_id' => 1,
                'vehicle_id' => 1,
                'borrower_type' => 'internal',
                'borrower_name' => 'Jane Smith',
                'borrower_institution' => 'Finance Department',
                'borrower_contact' => '08987654321',
                'destination' => 'Bank Mandiri',
                'purpose' => 'Urusan perbankan',
                'location_type' => 'dalam_kota',
                'start_date' => now()->subDays(7)->format('Y-m-d'),
                'end_date' => now()->subDays(5)->format('Y-m-d'),
                'status' => 'returned',
                'checked_out_by' => 1,
                'checked_out_at' => now()->subDays(7),
                'checked_in_by' => 1,
                'checked_in_at' => now()->subDays(5),
                'notes' => 'Kendaraan dikembalikan dalam kondisi baik',
                'created_at' => now()->subDays(7),
                'updated_at' => now()->subDays(5)
            ]
        ]);
    }

    public function down()
    {
        DB::table('borrowings')->where('status', 'returned')->delete();
    }
};
