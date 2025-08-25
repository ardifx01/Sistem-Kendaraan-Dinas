<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Vehicle;
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
        $availStatuses = ['tersedia', 'dipinjam', 'service', 'tidak_tersedia'];

        for ($i = 0; $i < 50; $i++) {
            $type = $faker->randomElement($types);
            $brand = $faker->randomElement($brands[$type]);
            $model = $faker->randomElement($models[$brand] ?? ['Generic Model']);

            Vehicle::create([
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
        }
    }
}
