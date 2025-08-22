<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;
use App\Models\Vehicle;
use App\Models\User;
use Carbon\Carbon;
use Faker\Factory as Faker;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // Hapus data service lama dengan aman
        Service::query()->delete();
        $this->command->info('Data service lama berhasil dihapus.');

        // Ambil HANYA kendaraan yang statusnya 'service' (yang sudah diset oleh admin)
        $serviceVehicles = Vehicle::where('availability_status', 'service')->get();

        if ($serviceVehicles->isEmpty()) {
            $this->command->info('Tidak ada kendaraan dengan status "service". Silakan set status kendaraan menjadi "service" melalui admin terlebih dahulu.');
            return;
        }

        $this->command->info("Ditemukan {$serviceVehicles->count()} kendaraan dengan status 'service'.");

        // Ambil user operator
        $operators = User::where('role', 'operator')->where('is_active', true)->get();

        if ($operators->isEmpty()) {
            $this->command->error('Tidak ada user operator yang aktif!');
            return;
        }

        $serviceTypes = [
            'mobil' => [
                'Service Berkala',
                'Ganti Oli Mesin',
                'Tune Up',
                'Service AC',
                'Ganti Ban',
                'Service Rem',
                'Perbaikan Mesin',
                'Ganti Filter Udara',
                'Service Transmisi',
                'General Checkup'
            ],
            'motor' => [
                'Service Berkala',
                'Ganti Oli',
                'Tune Up',
                'Ganti Ban',
                'Service Rem',
                'Perbaikan Mesin',
                'Ganti Filter',
                'Service CVT',
                'Ganti Kampas Rem',
                'General Maintenance'
            ]
        ];

        $serviceStatuses = ['pending', 'in_progress', 'completed'];

        $damageDescriptions = [
            'mobil' => [
                'Oli mesin sudah hitam dan kental',
                'Rem blong saat diinjak dalam',
                'AC tidak dingin, freon habis',
                'Suara mesin kasar saat idle',
                'Ban depan sudah gundul',
                'Filter udara kotor dan tersumbat',
                'Kampas rem tipis berbunyi',
                'Oli transmisi bocor dari seal',
                'Lampu depan redup/mati',
                'Radiator bocor coolant'
            ],
            'motor' => [
                'Oli mesin sudah hitam',
                'Rem tidak pakem',
                'Suara mesin kasar',
                'Ban belakang gundul',
                'Filter udara kotor',
                'Kampas rem aus',
                'CVT bermasalah',
                'Rantai kendor',
                'Lampu sein mati',
                'Karburator kotor'
            ]
        ];

        $repairDescriptions = [
            'mobil' => [
                'Ganti oli mesin SAE 10W-40 dan filter oli',
                'Perbaikan sistem rem dan ganti kampas rem',
                'Service AC lengkap dan isi freon R134a',
                'Tune up mesin lengkap dengan ganti busi',
                'Ganti ban michelin ukuran sesuai standar',
                'Ganti filter udara dengan yang original',
                'Ganti kampas rem depan dan belakang',
                'Perbaikan transmisi dan ganti oli ATF',
                'Ganti lampu halogen dan cek kelistrikan',
                'Perbaikan radiator dan ganti coolant'
            ],
            'motor' => [
                'Ganti oli mesin 10W-30 dan filter oli',
                'Perbaikan sistem rem dan ganti kampas',
                'Tune up mesin dan bersihkan karburator',
                'Ganti ban belakang tubeless',
                'Ganti filter udara racing',
                'Ganti kampas rem depan',
                'Service CVT dan ganti belt',
                'Setting rantai dan ganti stel',
                'Ganti lampu LED dan cek sistem',
                'Bersihkan karburator dan setting angin'
            ]
        ];

        $partsReplaced = [
            'mobil' => [
                'Oli mesin 4 liter, Filter oli',
                'Kampas rem depan dan belakang',
                'Freon R134a 500gram',
                'Busi NGK, Filter udara, Oli mesin',
                'Ban Michelin 185/65R15',
                'Filter udara Toyota original',
                'Brake pad depan belakang',
                'Oli transmisi ATF 4 liter',
                'Lampu halogen H4',
                'Radiator dan coolant 5 liter'
            ],
            'motor' => [
                'Oli mesin 800ml, Filter oli',
                'Kampas rem depan',
                'Busi NGK, Filter udara',
                'Ban belakang 80/90-14',
                'Filter udara racing',
                'Brake pad depan',
                'V-belt CVT',
                'Rantai dan gear set',
                'Lampu LED 12V',
                'Karburator kit'
            ]
        ];

        foreach ($serviceVehicles as $vehicle) {
            // Buat 1 service record untuk setiap kendaraan yang statusnya 'service'
            $serviceDate = $faker->dateTimeBetween('-3 months', 'now');

            // Pilih service type berdasarkan tipe kendaraan
            $vehicleType = $vehicle->type; // mobil atau motor
            $serviceType = $faker->randomElement($serviceTypes[$vehicleType]);

            Service::create([
                'vehicle_id' => $vehicle->id,
                'user_id' => $faker->randomElement($operators)->id,
                'service_type' => $serviceType,
                'service_date' => $serviceDate,
                'damage_description' => $faker->randomElement($damageDescriptions[$vehicleType]),
                'repair_description' => $faker->randomElement($repairDescriptions[$vehicleType]),
                'parts_replaced' => $faker->randomElement($partsReplaced[$vehicleType]),
                'description' => "Service {$serviceType} untuk {$vehicle->brand} {$vehicle->model} ({$vehicle->license_plate}). " . $faker->sentence(),
                'documents' => null,
                'photos' => null,
                'created_at' => $serviceDate,
                'updated_at' => Carbon::parse($serviceDate)->addDays(rand(0, 7))
            ]);
        }

        $serviceCount = Service::count();
        $this->command->info("Service data berhasil dibuat untuk {$serviceCount} service records dari {$serviceVehicles->count()} kendaraan dengan status 'service'");
    }
}
