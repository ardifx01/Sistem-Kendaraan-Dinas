@extends('layouts.app')

@section('title', 'Detail Peminjaman Kendaraan')

@php
use Illuminate\Support\Facades\Storage;
@endphp

@section('content')
<div class="max-w-6xl mx-auto px-2 sm:px-4 lg:px-6 py-2 sm:py-4">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-3">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Detail Peminjaman Kendaraan</h1>
            <p class="mt-1 text-xs text-gray-600">Informasi lengkap pengajuan peminjaman kendaraan dinas</p>
        </div>
        <div class="flex items-center space-x-2 mt-2 sm:mt-0">
            @if($borrowing->status == 'pending')
                <a href="{{ route('operator.borrowings.edit', $borrowing) }}"
                   class="inline-flex items-center px-3 py-1.5 bg-green-600 hover:bg-green-700 text-white text-xs font-medium rounded-md shadow-sm transition-colors duration-200">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit Pengajuan
                </a>
            @endif
            <a href="{{ route('operator.borrowings.print', $borrowing) }}" target="_blank"
               class="inline-flex items-center px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium rounded-md shadow-sm transition-colors duration-200">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                </svg>
                Cetak
            </a>
            <a href="{{ route('operator.borrowings.index') }}"
               class="inline-flex items-center px-3 py-1.5 bg-gray-600 hover:bg-gray-700 text-white text-xs font-medium rounded-md shadow-sm transition-colors duration-200">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali
            </a>
        </div>
    </div>

    <!-- Status Alert -->
    @php
        $statusAlerts = [
            'pending' => ['color' => 'yellow', 'icon' => 'clock', 'title' => 'Menunggu Persetujuan', 'message' => 'Pengajuan peminjaman sedang menunggu persetujuan dari admin.'],
            'approved' => ['color' => 'green', 'icon' => 'check', 'title' => 'Disetujui', 'message' => 'Pengajuan peminjaman telah disetujui dan dapat digunakan.'],
            'rejected' => ['color' => 'red', 'icon' => 'x', 'title' => 'Ditolak', 'message' => 'Pengajuan peminjaman ditolak. Silakan periksa catatan penolakan.'],
            'in_use' => ['color' => 'blue', 'icon' => 'truck', 'title' => 'Sedang Digunakan', 'message' => 'Kendaraan sedang dalam masa peminjaman.'],
            'returned' => ['color' => 'gray', 'icon' => 'archive', 'title' => 'Telah Dikembalikan', 'message' => 'Kendaraan telah dikembalikan dan peminjaman selesai.']
        ];
        $alert = $statusAlerts[$borrowing->status] ?? $statusAlerts['pending'];
    @endphp

    <div class="bg-{{ $alert['color'] }}-50 border border-{{ $alert['color'] }}-200 rounded-md p-2 mb-3">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                @if($alert['icon'] == 'clock')
                    <svg class="w-4 h-4 text-{{ $alert['color'] }}-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                @elseif($alert['icon'] == 'check')
                    <svg class="w-4 h-4 text-{{ $alert['color'] }}-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                @elseif($alert['icon'] == 'x')
                    <svg class="w-4 h-4 text-{{ $alert['color'] }}-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                @elseif($alert['icon'] == 'truck')
                    <svg class="w-4 h-4 text-{{ $alert['color'] }}-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                @else
                    <svg class="w-4 h-4 text-{{ $alert['color'] }}-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8l6 6V5l6 6V3"></path>
                    </svg>
                @endif
            </div>
            <div class="ml-2">
                <h3 class="text-xs font-medium text-{{ $alert['color'] }}-800">{{ $alert['title'] }}</h3>
                <p class="text-xs text-{{ $alert['color'] }}-700 mt-0.5">{{ $alert['message'] }}</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-4">
            <!-- Borrower Information -->
            <div class="bg-white rounded-md shadow-sm border border-gray-200 p-3 sm:p-4">
                <div class="flex items-center mb-3">
                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                        @if($borrowing->borrower_type == 'internal')
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        @else
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        @endif
                    </div>
                    <h3 class="text-sm font-semibold text-gray-900">Informasi Peminjam</h3>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="text-xs font-medium text-gray-500">Nama Peminjam</label>
                        <p class="text-sm text-gray-900 mt-0.5 font-medium">{{ $borrowing->borrower_name }}</p>
                    </div>

                    <div>
                        <label class="text-xs font-medium text-gray-500">Tipe Peminjam</label>
                        <p class="text-sm text-gray-900 mt-0.5">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $borrowing->borrower_type == 'internal' ? 'bg-blue-100 text-blue-800' : 'bg-orange-100 text-orange-800' }}">
                                {{ $borrowing->borrower_type == 'internal' ? 'Internal (Pegawai)' : 'Eksternal (Tamu)' }}
                            </span>
                        </p>
                    </div>

                    @if($borrowing->borrower_type == 'internal' && $borrowing->borrower_nip)
                        <div>
                            <label class="text-xs font-medium text-gray-500">NIP</label>
                            <p class="text-sm text-gray-900 mt-0.5">{{ $borrowing->borrower_nip }}</p>
                        </div>
                    @endif

                    @if($borrowing->borrower_type == 'external' && $borrowing->borrower_institution)
                        <div>
                            <label class="text-xs font-medium text-gray-500">Asal Instansi</label>
                            <p class="text-sm text-gray-900 mt-0.5">{{ $borrowing->borrower_institution }}</p>
                        </div>
                    @endif

                    <div>
                        <label class="text-xs font-medium text-gray-500">Nomor Kontak</label>
                        <p class="text-sm text-gray-900 mt-0.5">{{ $borrowing->borrower_contact }}</p>
                    </div>
                </div>
            </div>

            <!-- Vehicle Information -->
            <div class="bg-white rounded-md shadow-sm border border-gray-200 p-3 sm:p-4">
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center mr-3">
                            <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </div>
                        <h3 class="text-sm font-semibold text-gray-900">Informasi Kendaraan</h3>
                    </div>
                    <div>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                            {{ $borrowing->unit_count }} Unit{{ $borrowing->unit_count > 1 ? '' : '' }}
                        </span>
                    </div>
                </div>

                @php
                    // Decode vehicles_data if it's a JSON string
                    $vehiclesData = null;
                    if ($borrowing->vehicles_data) {
                        if (is_string($borrowing->vehicles_data)) {
                            $vehiclesData = json_decode($borrowing->vehicles_data, true);
                        } elseif (is_array($borrowing->vehicles_data)) {
                            $vehiclesData = $borrowing->vehicles_data;
                        }
                    }
                @endphp

                @if($borrowing->unit_count == 1)
                    <!-- Single Vehicle Display -->
                    <div class="space-y-3">
                        @php
                            $displayVehicle = null;

                            // Try to get vehicle from vehicles_data first (new format)
                            if ($vehiclesData && is_array($vehiclesData) && count($vehiclesData) > 0) {
                                $firstVehicleData = $vehiclesData[0];
                                if (isset($firstVehicleData['vehicle_id'])) {
                                    $displayVehicle = \App\Models\Vehicle::find($firstVehicleData['vehicle_id']);
                                }
                            }
                            // Fallback to vehicle_id (old format)
                            if (!$displayVehicle && $borrowing->vehicle_id) {
                                $displayVehicle = $borrowing->vehicle;
                            }
                        @endphp

                        @if($displayVehicle)
                            <div class="bg-gray-50 border border-gray-200 rounded-md p-3">
                                <div class="flex items-center justify-between mb-3">
                                    <h4 class="text-sm font-medium text-gray-700">Detail Kendaraan</h4>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $displayVehicle->availability_status === 'tersedia' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ ucfirst($displayVehicle->availability_status ?? 'tersedia') }}
                                    </span>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    <div>
                                        <label class="text-xs font-medium text-gray-500">Kendaraan</label>
                                        <p class="text-sm text-gray-900 mt-0.5 font-medium">
                                            {{ $displayVehicle->brand }} {{ $displayVehicle->model }}
                                        </p>
                                    </div>

                                    <div>
                                        <label class="text-xs font-medium text-gray-500">Plat Nomor</label>
                                        <p class="text-sm text-gray-900 mt-0.5 font-mono bg-white px-2 py-1 rounded text-center border">
                                            {{ $displayVehicle->license_plate }}
                                        </p>
                                    </div>

                                    <div>
                                        <label class="text-xs font-medium text-gray-500">Jenis & Tahun</label>
                                        <p class="text-sm text-gray-900 mt-0.5">{{ ucfirst($displayVehicle->type) }} {{ $displayVehicle->year }}</p>
                                    </div>

                                    <div>
                                        <label class="text-xs font-medium text-gray-500">Warna</label>
                                        <p class="text-sm text-gray-900 mt-0.5">{{ $displayVehicle->color }}</p>
                                    </div>

                                    @if($displayVehicle->fuel_type)
                                        <div class="sm:col-span-2">
                                            <label class="text-xs font-medium text-gray-500">Jenis Bahan Bakar</label>
                                            <p class="text-sm text-gray-900 mt-0.5">{{ ucfirst($displayVehicle->fuel_type) }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @else
                            <div class="bg-red-50 border border-red-200 rounded-md p-4">
                                <div class="text-center">
                                    <svg class="w-8 h-8 text-red-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                    </svg>
                                    <p class="text-sm text-red-600 font-medium">Kendaraan tidak ditemukan</p>
                                    <p class="text-xs text-red-500 mt-1">Kendaraan mungkin telah dihapus atau data rusak</p>
                                </div>
                            </div>
                        @endif
                    </div>
                @else
                    <!-- Multiple Vehicles Display -->
                    <div class="space-y-3">
                        <div class="bg-blue-50 border border-blue-200 rounded-md p-3">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <p class="text-xs text-blue-800">
                                    <span class="font-medium">{{ $borrowing->unit_count }} unit kendaraan</span> telah dipilih untuk peminjaman ini
                                </p>
                            </div>
                        </div>

                        @if($vehiclesData && is_array($vehiclesData) && count($vehiclesData) > 0)
                            <div class="grid grid-cols-1 gap-3">
                                @foreach($vehiclesData as $index => $vehicleData)
                                    @php
                                        $vehicle = \App\Models\Vehicle::find($vehicleData['vehicle_id'] ?? null);
                                    @endphp
                                    <div class="border border-gray-200 rounded-md p-3 bg-gray-50">
                                        <div class="flex items-center justify-between mb-2">
                                            <h4 class="text-xs font-medium text-gray-700">
                                                Kendaraan {{ $index + 1 }}
                                                @if(isset($vehicleData['unit_number']))
                                                    (Unit {{ $vehicleData['unit_number'] }})
                                                @endif
                                            </h4>
                                            @if($vehicle)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $vehicle->availability_status === 'tersedia' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                    {{ ucfirst($vehicle->availability_status ?? 'tersedia') }}
                                                </span>
                                            @endif
                                        </div>

                                        @if($vehicle)
                                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                                <div>
                                                    <label class="text-xs text-gray-500">Kendaraan</label>
                                                    <p class="text-xs font-medium text-gray-900">{{ $vehicle->brand }} {{ $vehicle->model }}</p>
                                                </div>
                                                <div>
                                                    <label class="text-xs text-gray-500">Plat Nomor</label>
                                                    <p class="text-xs font-mono bg-white px-2 py-1 rounded border text-center">{{ $vehicle->license_plate }}</p>
                                                </div>
                                                <div>
                                                    <label class="text-xs text-gray-500">Jenis & Tahun</label>
                                                    <p class="text-xs text-gray-900">{{ ucfirst($vehicle->type) }} {{ $vehicle->year }}</p>
                                                </div>
                                                <div>
                                                    <label class="text-xs text-gray-500">Warna</label>
                                                    <p class="text-xs text-gray-900">{{ $vehicle->color }}</p>
                                                </div>
                                                @if($vehicle->fuel_type)
                                                    <div class="sm:col-span-2">
                                                        <label class="text-xs text-gray-500">Jenis Bahan Bakar</label>
                                                        <p class="text-xs text-gray-900">{{ ucfirst($vehicle->fuel_type) }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                        @elseif(isset($vehicleData['vehicle_info']))
                                            <!-- Show stored vehicle info if vehicle is deleted -->
                                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                                <div>
                                                    <label class="text-xs text-gray-500">Kendaraan</label>
                                                    <p class="text-xs font-medium text-gray-900">
                                                        {{ $vehicleData['vehicle_info']['brand'] ?? 'N/A' }}
                                                        {{ $vehicleData['vehicle_info']['model'] ?? 'N/A' }}
                                                    </p>
                                                </div>
                                                <div>
                                                    <label class="text-xs text-gray-500">Plat Nomor</label>
                                                    <p class="text-xs font-mono bg-white px-2 py-1 rounded border text-center">
                                                        {{ $vehicleData['vehicle_info']['license_plate'] ?? 'N/A' }}
                                                    </p>
                                                </div>
                                                <div>
                                                    <label class="text-xs text-gray-500">Tahun</label>
                                                    <p class="text-xs text-gray-900">{{ $vehicleData['vehicle_info']['year'] ?? 'N/A' }}</p>
                                                </div>
                                                @if(isset($vehicleData['vehicle_info']['fuel_type']))
                                                    <div>
                                                        <label class="text-xs text-gray-500">Jenis Bahan Bakar</label>
                                                        <p class="text-xs text-gray-900">{{ ucfirst($vehicleData['vehicle_info']['fuel_type']) }}</p>
                                                    </div>
                                                @endif
                                                <div class="sm:col-span-2">
                                                    <div class="text-center py-1">
                                                        <p class="text-xs text-orange-600 font-medium">⚠️ Kendaraan telah dihapus</p>
                                                        <p class="text-xs text-gray-500">Data ditampilkan dari arsip</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="text-center py-2">
                                                <p class="text-xs text-red-600">Kendaraan tidak ditemukan atau telah dihapus</p>
                                                <p class="text-xs text-gray-500 mt-1">ID: {{ $vehicleData['vehicle_id'] ?? 'N/A' }}</p>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <!-- Generate vehicles data from existing single vehicle for multiple units -->
                            @if($borrowing->vehicle_id)
                                @php
                                    $singleVehicle = \App\Models\Vehicle::find($borrowing->vehicle_id);
                                @endphp
                                <div class="grid grid-cols-1 gap-3">
                                    @for($i = 1; $i <= $borrowing->unit_count; $i++)
                                        <div class="border border-gray-200 rounded-md p-3 bg-gray-50">
                                            <div class="flex items-center justify-between mb-2">
                                                <h4 class="text-xs font-medium text-gray-700">Kendaraan {{ $i }} (Unit {{ $i }})</h4>
                                                @if($singleVehicle)
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $singleVehicle->availability_status === 'tersedia' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                        {{ ucfirst($singleVehicle->availability_status ?? 'tersedia') }}
                                                    </span>
                                                @endif
                                            </div>

                                            @if($singleVehicle)
                                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                                    <div>
                                                        <label class="text-xs text-gray-500">Kendaraan</label>
                                                        <p class="text-xs font-medium text-gray-900">{{ $singleVehicle->brand }} {{ $singleVehicle->model }}</p>
                                                    </div>
                                                    <div>
                                                        <label class="text-xs text-gray-500">Plat Nomor</label>
                                                        <p class="text-xs font-mono bg-white px-2 py-1 rounded border text-center">{{ $singleVehicle->license_plate }}</p>
                                                    </div>
                                                    <div>
                                                        <label class="text-xs text-gray-500">Jenis & Tahun</label>
                                                        <p class="text-xs text-gray-900">{{ ucfirst($singleVehicle->type) }} {{ $singleVehicle->year }}</p>
                                                    </div>
                                                    <div>
                                                        <label class="text-xs text-gray-500">Warna</label>
                                                        <p class="text-xs text-gray-900">{{ $singleVehicle->color }}</p>
                                                    </div>
                                                    @if($singleVehicle->fuel_type)
                                                        <div class="sm:col-span-2">
                                                            <label class="text-xs text-gray-500">Jenis Bahan Bakar</label>
                                                            <p class="text-xs text-gray-900">{{ ucfirst($singleVehicle->fuel_type) }}</p>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="mt-2 p-2 bg-yellow-50 border border-yellow-200 rounded">
                                                    <p class="text-xs text-yellow-700">
                                                        <strong>Catatan:</strong> Data ini menggunakan format lama. Semua unit menggunakan kendaraan yang sama.
                                                    </p>
                                                </div>
                                            @else
                                                <div class="text-center py-2">
                                                    <p class="text-xs text-red-600">Kendaraan tidak ditemukan atau telah dihapus</p>
                                                    <p class="text-xs text-gray-500 mt-1">ID: {{ $borrowing->vehicle_id }}</p>
                                                </div>
                                            @endif
                                        </div>
                                    @endfor
                                </div>
                            @else
                                <!-- No vehicle data available at all -->
                                <div class="border border-gray-200 rounded-md p-3 bg-gray-50">
                                    <div class="text-center py-4">
                                        <svg class="w-8 h-8 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6-4h6m2 5.291A7.962 7.962 0 0112 15c-2.34 0-4.469-.844-6.126-2.239C7.07 11.348 9.432 10 12 10c2.568 0 4.93 1.348 6.126 2.761zM6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                        <p class="text-sm text-gray-600 font-medium">Data kendaraan tidak tersedia</p>
                                        <p class="text-xs text-gray-500 mt-1">Tidak ada informasi kendaraan yang tersimpan untuk peminjaman ini</p>
                                    </div>
                                </div>
                            @endif
                        @endif
                    </div>
                @endif
            </div>

            <!-- Period & Location -->
            <div class="bg-white rounded-md shadow-sm border border-gray-200 p-3 sm:p-4">
                <div class="flex items-center mb-3">
                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-3">
                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-sm font-semibold text-gray-900">Periode & Lokasi</h3>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="text-xs font-medium text-gray-500">Tanggal Mulai</label>
                        <p class="text-sm text-gray-900 mt-0.5 font-medium">{{ $borrowing->start_date->format('d F Y') }}</p>
                    </div>

                    <div>
                        <label class="text-xs font-medium text-gray-500">Tanggal Selesai</label>
                        <p class="text-sm text-gray-900 mt-0.5 font-medium">{{ $borrowing->end_date->format('d F Y') }}</p>
                    </div>

                    <div>
                        <label class="text-xs font-medium text-gray-500">Durasi</label>
                        <p class="text-sm text-gray-900 mt-0.5">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ $borrowing->start_date->diffInDays($borrowing->end_date) + 1 }} Hari
                            </span>
                        </p>
                    </div>

                    <div>
                        <label class="text-xs font-medium text-gray-500">Tipe Lokasi</label>
                        <p class="text-sm text-gray-900 mt-0.5">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $borrowing->location_type == 'dalam_kota' ? 'bg-green-100 text-green-800' : 'bg-purple-100 text-purple-800' }}">
                                {{ $borrowing->location_type == 'dalam_kota' ? 'Dalam Kota' : 'Luar Kota' }}
                            </span>
                        </p>
                    </div>

                    @if($borrowing->location_type == 'luar_kota' && $borrowing->destination)
                        @php
                            // Handle both array (with casting) and string format
                            $destinationData = $borrowing->destination;
                            $province = null;
                            $city = null;

                            if (is_array($destinationData)) {
                                $province = $destinationData['province'] ?? null;
                                $city = $destinationData['city'] ?? null;
                            } elseif (is_string($destinationData)) {
                                // Try to decode JSON string
                                $decoded = json_decode($destinationData, true);
                                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                                    $province = $decoded['province'] ?? null;
                                    $city = $decoded['city'] ?? null;
                                }
                            }
                        @endphp

                        @if($province && $city)
                            <div class="sm:col-span-2">
                                <label class="text-xs font-medium text-gray-500 mb-2 block">Destinasi Tujuan</label>
                                <div class="bg-gradient-to-r from-purple-50 to-blue-50 border border-purple-200 rounded-lg p-3">
                                    <div class="flex items-start space-x-3">
                                        <div class="flex-shrink-0">
                                            <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                                                <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center space-x-2 mb-1">
                                                <h4 class="text-sm font-semibold text-gray-900">{{ $city }}</h4>
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                                    Kota/Kabupaten
                                                </span>
                                            </div>
                                            <div class="flex items-center space-x-1 text-xs text-gray-600">
                                                <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                                </svg>
                                                <span>Provinsi {{ $province }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @elseif($province || $city)
                            <!-- Partial data available -->
                            <div class="sm:col-span-2">
                                <label class="text-xs font-medium text-gray-500 mb-2 block">Destinasi Tujuan</label>
                                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3">
                                    <div class="flex items-start space-x-3">
                                        <div class="flex-shrink-0">
                                            <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-sm text-gray-900">
                                                @if($province && $city)
                                                    {{ $city }}, {{ $province }}
                                                @elseif($province)
                                                    Provinsi: {{ $province }}
                                                @elseif($city)
                                                    Kota/Kabupaten: {{ $city }}
                                                @endif
                                            </p>
                                            <p class="text-xs text-yellow-600 mt-1">Data destinasi tidak lengkap</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <!-- Fallback for unstructured data -->
                            <div class="sm:col-span-2">
                                <label class="text-xs font-medium text-gray-500 mb-2 block">Destinasi Tujuan</label>
                                <div class="bg-gray-50 border border-gray-200 rounded-lg p-3">
                                    <div class="flex items-start space-x-3">
                                        <div class="flex-shrink-0">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-sm text-gray-900">
                                                @if(is_string($borrowing->destination))
                                                    {{ $borrowing->destination }}
                                                @else
                                                    {{ json_encode($borrowing->destination) }}
                                                @endif
                                            </p>
                                            <p class="text-xs text-gray-500 mt-1">Format data lama atau tidak terstruktur</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
            </div>

            <!-- Purpose -->
            <div class="bg-white rounded-md shadow-sm border border-gray-200 p-3 sm:p-4">
                <div class="flex items-center mb-3">
                    <div class="w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center mr-3">
                        <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-sm font-semibold text-gray-900">Keperluan Penggunaan</h3>
                </div>

                <div class="bg-gray-50 rounded-md p-3">
                    <p class="text-sm text-gray-700 leading-relaxed">{{ $borrowing->purpose }}</p>
                </div>
            </div>

            @if($borrowing->notes)
                <!-- Notes -->
                <div class="bg-white rounded-md shadow-sm border border-gray-200 p-3 sm:p-4">
                    <div class="flex items-center mb-3">
                        <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center mr-3">
                            <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                            </svg>
                        </div>
                        <h3 class="text-sm font-semibold text-gray-900">Catatan Tambahan</h3>
                    </div>

                    <div class="bg-yellow-50 rounded-md p-3">
                        <p class="text-sm text-gray-700 leading-relaxed">{{ $borrowing->notes }}</p>
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-4">
            <!-- Status Card -->
            <div class="bg-white rounded-md shadow-sm border border-gray-200 p-3 sm:p-4">
                <h3 class="text-sm font-semibold text-gray-900 mb-3">Status Peminjaman</h3>

                <div class="text-center">
                    @php
                        $statusLabels = [
                            'pending' => 'Menunggu Persetujuan',
                            'approved' => 'Disetujui',
                            'rejected' => 'Ditolak',
                            'in_use' => 'Sedang Digunakan',
                            'returned' => 'Telah Dikembalikan'
                        ];
                        $statusColors = [
                            'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                            'approved' => 'bg-green-100 text-green-800 border-green-200',
                            'rejected' => 'bg-red-100 text-red-800 border-red-200',
                            'in_use' => 'bg-blue-100 text-blue-800 border-blue-200',
                            'returned' => 'bg-gray-100 text-gray-800 border-gray-200'
                        ];
                    @endphp

                    <div class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium border {{ $statusColors[$borrowing->status] ?? 'bg-gray-100 text-gray-800 border-gray-200' }}">
                        {{ $statusLabels[$borrowing->status] ?? $borrowing->status }}
                    </div>

                    <div class="mt-3 space-y-2">
                        <div class="text-xs text-gray-500">
                            <span class="font-medium">Diajukan:</span> {{ $borrowing->created_at->format('d/m/Y H:i') }}
                        </div>
                        <div class="text-xs text-gray-500">
                            <span class="font-medium">Diperbarui:</span> {{ $borrowing->updated_at->format('d/m/Y H:i') }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Vehicle Summary Card -->
            <div class="bg-white rounded-md shadow-sm border border-gray-200 p-3 sm:p-4">
                <h3 class="text-sm font-semibold text-gray-900 mb-3">Ringkasan Kendaraan</h3>

                <div class="space-y-3">
                    <div class="flex items-center justify-between p-2 bg-purple-50 rounded border border-purple-200">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 text-purple-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            <span class="text-xs font-medium text-purple-800">Total Unit</span>
                        </div>
                        <span class="text-sm font-bold text-purple-900">{{ $borrowing->unit_count }}</span>
                    </div>

                    @php
                        // Decode vehicles_data if it's a JSON string (same logic as main section)
                        $vehiclesData = null;
                        if ($borrowing->vehicles_data) {
                            if (is_string($borrowing->vehicles_data)) {
                                $vehiclesData = json_decode($borrowing->vehicles_data, true);
                            } elseif (is_array($borrowing->vehicles_data)) {
                                $vehiclesData = $borrowing->vehicles_data;
                            }
                        }
                    @endphp

                    @if($borrowing->unit_count == 1)
                        <!-- Single Vehicle Summary -->
                        @php
                            $displayVehicle = null;

                            // Try to get vehicle from vehicles_data first (new format)
                            if ($vehiclesData && is_array($vehiclesData) && count($vehiclesData) > 0) {
                                $firstVehicleData = $vehiclesData[0];
                                if (isset($firstVehicleData['vehicle_id'])) {
                                    $displayVehicle = \App\Models\Vehicle::find($firstVehicleData['vehicle_id']);
                                }
                            }
                            // Fallback to vehicle_id (old format)
                            if (!$displayVehicle && $borrowing->vehicle_id) {
                                $displayVehicle = $borrowing->vehicle;
                            }
                        @endphp

                        @if($displayVehicle)
                            <div class="border border-gray-200 rounded p-2 bg-gray-50">
                                <div class="text-center">
                                    <p class="text-xs font-medium text-gray-900">{{ $displayVehicle->brand }} {{ $displayVehicle->model }}</p>
                                    <p class="text-xs text-gray-600 font-mono">{{ $displayVehicle->license_plate }}</p>
                                    <div class="flex items-center justify-center mt-1">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $displayVehicle->availability_status === 'tersedia' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ ucfirst($displayVehicle->availability_status ?? 'tersedia') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-3">
                                <svg class="w-6 h-6 text-red-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                                <p class="text-xs text-red-600 font-medium">Kendaraan tidak ditemukan</p>
                            </div>
                        @endif
                    @elseif($borrowing->unit_count > 1)
                        <!-- Multiple Vehicles Summary -->
                        @if($vehiclesData && is_array($vehiclesData) && count($vehiclesData) > 0)
                            <div class="space-y-2">
                                @foreach(array_slice($vehiclesData, 0, 3) as $index => $vehicleData)
                                    @php
                                        $vehicle = \App\Models\Vehicle::find($vehicleData['vehicle_id'] ?? null);
                                    @endphp
                                    @if($vehicle)
                                        <div class="border border-gray-200 rounded p-2 bg-gray-50">
                                            <div class="flex items-center justify-between">
                                                <div>
                                                    <p class="text-xs font-medium text-gray-900">{{ $vehicle->brand }} {{ $vehicle->model }}</p>
                                                    <p class="text-xs text-gray-600 font-mono">{{ $vehicle->license_plate }}</p>
                                                </div>
                                                <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-xs font-medium {{ $vehicle->availability_status === 'tersedia' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                    {{ ucfirst($vehicle->availability_status ?? 'tersedia') }}
                                                </span>
                                            </div>
                                        </div>
                                    @elseif(isset($vehicleData['vehicle_info']))
                                        <!-- Show stored vehicle info if vehicle is deleted -->
                                        <div class="border border-gray-200 rounded p-2 bg-orange-50">
                                            <div class="flex items-center justify-between">
                                                <div>
                                                    <p class="text-xs font-medium text-gray-900">
                                                        {{ $vehicleData['vehicle_info']['brand'] ?? 'N/A' }}
                                                        {{ $vehicleData['vehicle_info']['model'] ?? 'N/A' }}
                                                    </p>
                                                    <p class="text-xs text-gray-600 font-mono">{{ $vehicleData['vehicle_info']['license_plate'] ?? 'N/A' }}</p>
                                                </div>
                                                <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                                    Terhapus
                                                </span>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach

                                @if(count($vehiclesData) > 3)
                                    <div class="text-center py-1">
                                        <p class="text-xs text-gray-500">dan {{ count($vehiclesData) - 3 }} kendaraan lainnya</p>
                                    </div>
                                @endif
                            </div>
                        @else
                            <!-- Fallback for old data structure with multiple units -->
                            @if($borrowing->vehicle_id)
                                @php
                                    $singleVehicle = \App\Models\Vehicle::find($borrowing->vehicle_id);
                                @endphp
                                <div class="space-y-2">
                                    @for($i = 1; $i <= min($borrowing->unit_count, 3); $i++)
                                        <div class="border border-gray-200 rounded p-2 bg-yellow-50">
                                            <div class="flex items-center justify-between">
                                                <div>
                                                    @if($singleVehicle)
                                                        <p class="text-xs font-medium text-gray-900">{{ $singleVehicle->brand }} {{ $singleVehicle->model }}</p>
                                                        <p class="text-xs text-gray-600 font-mono">{{ $singleVehicle->license_plate }}</p>
                                                    @else
                                                        <p class="text-xs font-medium text-red-600">Kendaraan tidak ditemukan</p>
                                                    @endif
                                                </div>
                                                <div class="text-right">
                                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                        Unit {{ $i }}
                                                    </span>
                                                    @if($singleVehicle)
                                                        <div class="mt-1">
                                                            <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-xs font-medium {{ $singleVehicle->availability_status === 'tersedia' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                                {{ ucfirst($singleVehicle->availability_status ?? 'tersedia') }}
                                                            </span>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endfor

                                    @if($borrowing->unit_count > 3)
                                        <div class="text-center py-1">
                                            <p class="text-xs text-yellow-600">dan {{ $borrowing->unit_count - 3 }} unit lainnya (data lama)</p>
                                        </div>
                                    @endif
                                </div>
                            @else
                                <div class="text-center py-3">
                                    <svg class="w-6 h-6 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <p class="text-xs text-gray-500">Data kendaraan tidak tersedia</p>
                                </div>
                            @endif
                        @endif
                    @else
                        <!-- No vehicle data available -->
                        <div class="text-center py-3">
                            <svg class="w-6 h-6 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="text-xs text-gray-500">Data kendaraan tidak tersedia</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Documents -->
            <div class="bg-white rounded-md shadow-sm border border-gray-200 p-3 sm:p-4">
                <h3 class="text-sm font-semibold text-gray-900 mb-3">Dokumen Pendukung</h3>

                <div class="space-y-3">
                    @if($borrowing->surat_permohonan)
                        <div class="flex items-center justify-between p-2 bg-gray-50 rounded">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <span class="text-xs text-gray-700">Surat Permohonan</span>
                            </div>
                            <a href="{{ Storage::url($borrowing->surat_permohonan) }}" target="_blank"
                               class="text-xs text-blue-600 hover:text-blue-800 underline">Lihat</a>
                        </div>
                    @endif

                    @if($borrowing->surat_tugas)
                        <div class="flex items-center justify-between p-2 bg-gray-50 rounded">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <span class="text-xs text-gray-700">Surat Tugas</span>
                            </div>
                            <a href="{{ Storage::url($borrowing->surat_tugas) }}" target="_blank"
                               class="text-xs text-blue-600 hover:text-blue-800 underline">Lihat</a>
                        </div>
                    @endif

                    @if(!$borrowing->surat_permohonan && !$borrowing->surat_tugas)
                        <div class="text-center py-4">
                            <svg class="w-8 h-8 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                            <p class="text-xs text-gray-500">Tidak ada dokumen</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-white rounded-md shadow-sm border border-gray-200 p-3 sm:p-4">
                <h3 class="text-sm font-semibold text-gray-900 mb-3">Aksi</h3>

                <div class="space-y-2">
                    @if($borrowing->status == 'pending')
                        <a href="{{ route('operator.borrowings.edit', $borrowing) }}"
                           class="w-full inline-flex items-center justify-center px-3 py-2 bg-green-600 hover:bg-green-700 text-white text-xs font-medium rounded-md transition-colors duration-200">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Edit Pengajuan
                        </a>
                    @endif

                    @if(in_array($borrowing->status, ['pending', 'rejected']))
                        <button type="button"
                                class="w-full inline-flex items-center justify-center px-3 py-2 bg-red-600 hover:bg-red-700 text-white text-xs font-medium rounded-md transition-colors duration-200 delete-btn"
                                data-borrowing-id="{{ $borrowing->id }}"
                                data-borrowing-name="{{ $borrowing->borrower_name }}"
                                data-borrowing-period="{{ $borrowing->start_date->format('d/m/Y') }} - {{ $borrowing->end_date->format('d/m/Y') }}"
                                data-delete-url="{{ route('operator.borrowings.destroy', $borrowing) }}">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Hapus Pengajuan
                        </button>
                    @endif

                    <a href="{{ route('operator.borrowings.index') }}"
                       class="w-full inline-flex items-center justify-center px-3 py-2 bg-gray-600 hover:bg-gray-700 text-white text-xs font-medium rounded-md transition-colors duration-200">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Kembali ke Daftar
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
            </div>
            <h3 class="text-lg leading-6 font-medium text-gray-900 mt-4">Konfirmasi Hapus Data</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500 mb-3">Apakah Anda yakin ingin menghapus pengajuan peminjaman berikut?</p>
                <div class="bg-gray-50 p-3 rounded-md text-left">
                    <div class="text-sm">
                        <div class="font-medium text-gray-900" id="deleteBorrowingName"></div>
                        <div class="text-gray-600 mt-1" id="deleteBorrowingDetails"></div>
                    </div>
                </div>
                <p class="text-xs text-red-600 mt-3 font-medium">⚠️ Tindakan ini tidak dapat dibatalkan!</p>
            </div>
            <div class="items-center px-4 py-3 space-x-3 flex justify-center">
                <button id="cancelDelete" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 text-base font-medium rounded-md w-auto shadow-sm transition-colors duration-200">
                    Batal
                </button>
                <button id="confirmDelete" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-base font-medium rounded-md w-auto shadow-sm transition-colors duration-200">
                    Ya, Hapus
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle delete button
    const deleteBtn = document.querySelector('.delete-btn');
    if (deleteBtn) {
        deleteBtn.addEventListener('click', function(e) {
            e.preventDefault();
            const borrowingId = this.dataset.borrowingId;
            const borrowingName = this.dataset.borrowingName;
            const borrowingPeriod = this.dataset.borrowingPeriod;
            const deleteUrl = this.dataset.deleteUrl;

            showDeleteConfirm(borrowingId, borrowingName, borrowingPeriod, deleteUrl);
        });
    }
});

function showDeleteConfirm(borrowingId, borrowingName, borrowingPeriod, deleteUrl) {
    const modal = document.getElementById('deleteModal');
    const borrowingNameEl = document.getElementById('deleteBorrowingName');
    const borrowingDetailsEl = document.getElementById('deleteBorrowingDetails');
    const confirmBtn = document.getElementById('confirmDelete');
    const cancelBtn = document.getElementById('cancelDelete');

    if (borrowingNameEl) {
        borrowingNameEl.textContent = borrowingName;
    }

    if (borrowingDetailsEl) {
        borrowingDetailsEl.innerHTML = `
            <div class="space-y-1">
                <div><span class="font-medium">Periode:</span> ${borrowingPeriod}</div>
            </div>
        `;
    }

    // Remove previous event listeners
    const newConfirmBtn = confirmBtn.cloneNode(true);
    confirmBtn.parentNode.replaceChild(newConfirmBtn, confirmBtn);

    // Add new event listeners
    newConfirmBtn.addEventListener('click', () => {
        hideModal();
        performDelete(deleteUrl);
    });

    cancelBtn.addEventListener('click', () => {
        hideModal();
    });

    showModal();
}

function performDelete(deleteUrl) {
    fetch(deleteUrl, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Data peminjaman berhasil dihapus!');
            window.location.href = '{{ route("operator.borrowings.index") }}';
        } else {
            alert(data.message || 'Terjadi kesalahan saat menghapus data');
        }
    })
    .catch(error => {
        alert('Terjadi kesalahan koneksi. Silakan coba lagi.');
        console.error('Error:', error);
    });
}

function showModal() {
    const modal = document.getElementById('deleteModal');
    if (modal) {
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
}

function hideModal() {
    const modal = document.getElementById('deleteModal');
    if (modal) {
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
}

// Close modal on backdrop click
document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) {
        hideModal();
    }
});

// Close on Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        hideModal();
    }
});
</script>

<style>
/* Print styles */
@media print {
    .no-print {
        display: none !important;
    }

    body {
        background: white !important;
    }

    .bg-gray-50,
    .bg-blue-50,
    .bg-green-50,
    .bg-yellow-50,
    .bg-red-50,
    .bg-purple-50,
    .bg-indigo-50 {
        background: #f9fafb !important;
    }

    .shadow-sm,
    .shadow {
        box-shadow: none !important;
    }

    .border {
        border: 1px solid #e5e7eb !important;
    }
}

/* Responsive enhancements */
@media (max-width: 1024px) {
    .lg\\:col-span-2 {
        grid-column: span 1;
    }
}

/* Card hover effects */
.bg-white {
    transition: all 0.3s ease;
}

.bg-white:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

/* Badge animations */
.rounded-full {
    transition: all 0.2s ease-in-out;
}

.rounded-full:hover {
    transform: scale(1.05);
}

/* Link hover effects */
a:hover {
    text-decoration: none;
}

.underline:hover {
    text-decoration: underline;
}

/* Button hover effects */
button:hover,
.inline-flex:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
}

/* Status alert animations */
.bg-yellow-50,
.bg-green-50,
.bg-red-50,
.bg-blue-50,
.bg-gray-50 {
    animation: fadeIn 0.5s ease-in-out;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
@endsection
