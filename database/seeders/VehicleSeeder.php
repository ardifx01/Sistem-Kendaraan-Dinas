<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Vehicle;
use App\Models\Service;
use App\Models\Borrowing;
use App\Models\User;
use Carbon\Carbon;
use Faker\Factory as Faker;

class VehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        $types = ['mobil', 'motor'];
        $brands = [
            'mobil' => ['Toyota', 'Honda', 'Mitsubishi', 'Suzuki', 'Nissan'],
            'motor' => ['Honda', 'Yamaha', 'Suzuki', 'Kawasaki']
        ];
        $models = [
            'Toyota' => ['Avanza', 'Innova', 'Fortuner'],
            'Honda' => ['HR-V', 'CR-V', 'Jazz', 'Beat', 'PCX'],
            'Mitsubishi' => ['Pajero Sport', 'Xpander'],
            'Suzuki' => ['Ertiga', 'Carry', 'Satria'],
            'Nissan' => ['X-Trail', 'Livina'],
            'Yamaha' => ['NMAX', 'Aerox', 'Mio'],
            'Kawasaki' => ['Ninja 250', 'W175']
        ];
        $colors = ['Hitam', 'Putih', 'Merah', 'Biru', 'Silver', 'Abu-abu'];
        $docStatuses = ['lengkap', 'tidak_lengkap'];
        $availStatuses = ['tersedia', 'dipinjam', 'service', 'digunakan_pejabat'];

        for ($i = 0; $i < 50; $i++) {
            $type = $faker->randomElement($types);
            $brand = $faker->randomElement($brands[$type]);
            $model = $faker->randomElement($models[$brand] ?? ['Generic Model']);

            $vehicle = Vehicle::create([
                'type' => $type,
                'brand' => $brand,
                'model' => $model,
                'year' => $faker->numberBetween(2015, 2023),
                'license_plate' => strtoupper($faker->bothify('B #### ??')),
                'color' => $faker->randomElement($colors),
                'tax_expiry_date' => Carbon::now()->addDays(rand(30, 365)),
                'document_status' => $faker->randomElement($docStatuses),
                'document_notes' => $faker->boolean(20) ? 'STNK perlu diperpanjang' : null,
                'driver_name' => $type === 'mobil' ? $faker->name() : null,
                'user_name' => $faker->randomElement([
                    'Direktur', 'Manager', 'Staff Operasional',
                    'Staff IT', 'Staff Humas', 'Kepala Bagian Umum'
                ]),
                'availability_status' => $faker->randomElement($availStatuses),
                'bpkb_number' => strtoupper($faker->bothify('BPKB####??')),
                'chassis_number' => strtoupper($faker->bothify('CHS####??')),
                'engine_number' => strtoupper($faker->bothify('ENG####??')),
                'cc_amount' => $faker->numberBetween(100, 2500),
            ]);

            // Ensure there is at least one user to associate with service/borrowing records
            $operator = User::inRandomOrder()->first();
            if (!$operator) {
                // create a basic admin/operator user if none exist
                $operator = User::factory()->create([
                    'name' => 'Operator1',
                    'email' => 'operator1@gmail.com',
                    'role' => 'operator',
                ]);
            }

            // --- Ensure each vehicle has at least one historical service older than 90 days ---
            $oldServiceDate = Carbon::now()->subDays(rand(91, 400));
            $oldServiceData = [
                'vehicle_id' => $vehicle->id,
                'user_id' => $operator->id,
                'service_type' => $faker->randomElement([
                    'service_rutin', 'kerusakan', 'perbaikan', 'penggantian_part'
                ]),
                'payment_type' => $faker->randomElement(['asuransi', 'kantor']),
                'damage_description' => $faker->boolean(20) ? $faker->sentence() : null,
                'repair_description' => $faker->boolean(25) ? $faker->sentence() : null,
                'parts_replaced' => $faker->boolean(15) ? $faker->word() : null,
                'description' => $faker->sentence(),
                'documents' => null,
                'photos' => null,
                'service_date' => $oldServiceDate->toDateString(),
            ];

            if (\Illuminate\Support\Facades\Schema::hasColumn('services', 'license_plate')) {
                $oldServiceData['license_plate'] = $vehicle->license_plate;
            }
            if (\Illuminate\Support\Facades\Schema::hasColumn('services', 'brand')) {
                $oldServiceData['brand'] = $vehicle->brand;
            }
            if (\Illuminate\Support\Facades\Schema::hasColumn('services', 'model')) {
                $oldServiceData['model'] = $vehicle->model;
            }
            if (\Illuminate\Support\Facades\Schema::hasColumn('services', 'status')) {
                // historical services are likely completed
                $oldServiceData['status'] = 'completed';
            }

            Service::create($oldServiceData);


            // Create at least one historical service record per vehicle where the
            // service_date is older than 90 days (91-400 days). This ensures the
            // "needs service (>=90 days)" logic can find vehicles that require service.
            $historicalServiceDate = Carbon::now()->subDays(rand(91, 400));

            $historicalServiceData = [
                'vehicle_id' => $vehicle->id,
                'user_id' => $operator->id,
                'service_type' => $faker->randomElement([
                    'service_rutin', 'kerusakan', 'perbaikan', 'penggantian_part'
                ]),
                'payment_type' => $faker->randomElement(['asuransi', 'kantor']),
                'damage_description' => $faker->boolean(30) ? $faker->sentence() : null,
                'repair_description' => $faker->boolean(40) ? $faker->sentence() : null,
                'parts_replaced' => $faker->boolean(25) ? $faker->word() : null,
                'description' => $faker->sentence(),
                'documents' => null,
                'photos' => null,
                'service_date' => $historicalServiceDate->toDateString(),
            ];

            // Add optional snapshot fields if the schema contains them
            if (\Illuminate\Support\Facades\Schema::hasColumn('services', 'license_plate')) {
                $historicalServiceData['license_plate'] = $vehicle->license_plate;
            }
            if (\Illuminate\Support\Facades\Schema::hasColumn('services', 'brand')) {
                $historicalServiceData['brand'] = $vehicle->brand;
            }
            if (\Illuminate\Support\Facades\Schema::hasColumn('services', 'model')) {
                $historicalServiceData['model'] = $vehicle->model;
            }
            if (\Illuminate\Support\Facades\Schema::hasColumn('services', 'status')) {
                // mark historical services as completed by default
                $historicalServiceData['status'] = 'completed';
            }

            Service::create($historicalServiceData);

            // If the vehicle availability was marked 'service' and you still want a
            // recent service record (optional), you can create it here. For now we
            // keep only historical records so "needs service" shows correctly.
        }
    }
}