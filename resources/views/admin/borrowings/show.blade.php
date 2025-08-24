@extends('layouts.app')

@section('title', 'Detail Peminjaman')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Detail Peminjaman</h1>
                <p class="text-gray-600 mt-1">{{ $borrowing->borrower_name }}</p>
            </div>
            <a href="{{ route('admin.borrowings.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-800 px-4 py-2 rounded-lg">
                ← Kembali
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Status & Actions -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Status Peminjaman</h3>
                    @if($borrowing->status == 'pending')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                            Menunggu Persetujuan
                        </span>
                    @elseif($borrowing->status == 'approved')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                            Disetujui
                        </span>
                    @elseif($borrowing->status == 'rejected')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                            Ditolak
                        </span>
                    @elseif($borrowing->status == 'returned')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                            Dikembalikan
                        </span>
                    @elseif($borrowing->status == 'in_use')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                            Sedang Digunakan
                        </span>
                    @else
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                            {{ ucfirst($borrowing->status) }}
                        </span>
                    @endif
                </div>

                @if($borrowing->status == 'pending')
                    <div class="flex space-x-3">
                        <button type="button"
                                onclick="approveBorrowing({{ $borrowing->id }})"
                                class="flex-1 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg">
                            Setujui Peminjaman
                        </button>
                        <button type="button"
                                onclick="rejectBorrowing({{ $borrowing->id }})"
                                class="flex-1 bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg">
                            Tolak Peminjaman
                        </button>
                    </div>
                @endif
            </div>

            <!-- Borrower Information -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Peminjam</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Nama Peminjam</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $borrowing->borrower_name }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Kontak</label>
                        <p class="mt-1 text-sm text-gray-900">
                            @if($borrowing->borrower_contact)
                                {{ $borrowing->borrower_contact }}
                            @elseif($borrowing->user && $borrowing->user->email)
                                {{ $borrowing->user->email }}
                                <span class="text-xs text-gray-500 ml-1">(email user)</span>
                            @else
                                <span class="text-gray-500">Kontak tidak tersedia</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <!-- Vehicle Information -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Informasi Kendaraan</h3>
                    <div class="flex items-center space-x-2">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                            {{ $borrowing->unit_count }} Unit
                        </span>
                    </div>
                </div>

                @php
                    $vehiclesData = [];
                    if ($borrowing->vehicles_data) {
                        if (is_string($borrowing->vehicles_data)) {
                            $vehiclesData = json_decode($borrowing->vehicles_data, true) ?: [];
                        } elseif (is_array($borrowing->vehicles_data)) {
                            $vehiclesData = $borrowing->vehicles_data;
                        }
                    }
                @endphp

                @if(!empty($vehiclesData) && count($vehiclesData) > 0)
                    <!-- Multiple Vehicles -->
                    <div class="space-y-4">
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 mb-4">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-sm font-medium text-blue-800">{{ count($vehiclesData) }} kendaraan spesifik dipinjam</span>
                            </div>
                        </div>

                        @foreach($vehiclesData as $index => $vehicleData)
                            @php
                                // Handle different data structures
                                $vehicleInfo = $vehicleData['vehicle_info'] ?? $vehicleData;
                                $brand = $vehicleInfo['brand'] ?? 'N/A';
                                $model = $vehicleInfo['model'] ?? '';
                                $licensePlate = $vehicleInfo['license_plate'] ?? 'N/A';
                                $year = $vehicleInfo['year'] ?? 'N/A';
                                $type = $vehicleInfo['type'] ?? null;
                                $fuelType = $vehicleInfo['fuel_type'] ?? null;
                                $capacity = $vehicleInfo['capacity'] ?? null;
                            @endphp

                            <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition-colors">
                                <div class="flex items-start justify-between mb-3">
                                    <h4 class="text-sm font-semibold text-gray-900">Kendaraan {{ $index + 1 }}</h4>
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-700">
                                        <svg class="w-2 h-2 mr-1" fill="currentColor" viewBox="0 0 8 8">
                                            <circle cx="4" cy="4" r="3"/>
                                        </svg>
                                        Dikembalikan
                                    </span>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                    <div class="space-y-1">
                                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide">Plat Nomor</label>
                                        <p class="text-sm font-semibold text-gray-900 bg-gray-100 px-2 py-1 rounded">{{ $licensePlate }}</p>
                                    </div>
                                    <div class="space-y-1">
                                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide">Merk & Model</label>
                                        <p class="text-sm text-gray-900">{{ $brand }} {{ $model }}</p>
                                    </div>
                                    <div class="space-y-1">
                                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide">Tahun</label>
                                        <p class="text-sm text-gray-900">{{ $year }}</p>
                                    </div>
                                </div>

                                @if($type || $fuelType || $capacity)
                                    <div class="mt-3 pt-3 border-t border-gray-200">
                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                            @if($type)
                                                <div class="space-y-1">
                                                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide">Jenis</label>
                                                    <p class="text-sm text-gray-900">{{ ucfirst($type) }}</p>
                                                </div>
                                            @endif
                                            @if($fuelType)
                                                <div class="space-y-1">
                                                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide">Bahan Bakar</label>
                                                    <p class="text-sm text-gray-900">{{ ucfirst($fuelType) }}</p>
                                                </div>
                                            @endif
                                            @if($capacity)
                                                <div class="space-y-1">
                                                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide">Kapasitas</label>
                                                    <p class="text-sm text-gray-900">{{ $capacity }} orang</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>

                @elseif($borrowing->vehicle)
                    <!-- Single Vehicle -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 mb-4">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-sm font-medium text-blue-800">1 kendaraan spesifik dipinjam</span>
                        </div>
                    </div>

                    <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                        <div class="flex items-start justify-between mb-3">
                            <h4 class="text-sm font-semibold text-gray-900">Detail Kendaraan</h4>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                <svg class="w-2 h-2 mr-1" fill="currentColor" viewBox="0 0 8 8">
                                    <circle cx="4" cy="4" r="3"/>
                                </svg>
                                Dipinjam
                            </span>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <div class="space-y-1">
                                <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide">Plat Nomor</label>
                                <p class="text-sm font-semibold text-gray-900 bg-white px-2 py-1 rounded">{{ $borrowing->vehicle->license_plate }}</p>
                            </div>
                            <div class="space-y-1">
                                <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide">Merk & Model</label>
                                <p class="text-sm text-gray-900">{{ $borrowing->vehicle->brand }} {{ $borrowing->vehicle->model }}</p>
                            </div>
                            <div class="space-y-1">
                                <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide">Tahun</label>
                                <p class="text-sm text-gray-900">{{ $borrowing->vehicle->year }}</p>
                            </div>
                        </div>

                        <div class="mt-3 pt-3 border-t border-gray-200">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="space-y-1">
                                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide">Jenis</label>
                                    <p class="text-sm text-gray-900">{{ ucfirst($borrowing->vehicle->type) }}</p>
                                </div>
                                <div class="space-y-1">
                                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide">Bahan Bakar</label>
                                    <p class="text-sm text-gray-900">{{ ucfirst($borrowing->vehicle->fuel_type) }}</p>
                                </div>
                                <div class="space-y-1">
                                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide">Kapasitas</label>
                                    <p class="text-sm text-gray-900">{{ $borrowing->vehicle->capacity }} orang</p>
                                </div>
                            </div>
                        </div>
                    </div>

                @else
                    <!-- Fallback: No detailed vehicle data available -->
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-yellow-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 19c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                            <div>
                                <p class="text-sm font-medium text-yellow-800">Peminjaman Umum</p>
                                <p class="text-xs text-yellow-700">Membutuhkan {{ $borrowing->unit_count }} unit kendaraan (detail kendaraan akan ditentukan kemudian)</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Borrowing Details -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Detail Peminjaman</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Tanggal Mulai</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $borrowing->start_date ? \Carbon\Carbon::parse($borrowing->start_date)->format('d F Y') : '-' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Tanggal Selesai</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $borrowing->end_date ? \Carbon\Carbon::parse($borrowing->end_date)->format('d F Y') : '-' }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-500">Keperluan</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $borrowing->purpose }}</p>
                    </div>

                    <!-- Destination -->
                    @if($borrowing->destination)
                        <div class="md:col-span-2">
                            <div class="flex items-center mb-2">
                                <svg class="w-4 h-4 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <label class="block text-sm font-medium text-gray-500">Tujuan Perjalanan</label>
                            </div>

                            @php
                                // Parse destination data if it's a JSON string
                                $destinationData = $borrowing->destination;
                                if (is_string($destinationData)) {
                                    $destinationData = json_decode($destinationData, true);
                                }

                                // Convert single destination to array for uniform processing
                                if (!is_array($destinationData) || (is_array($destinationData) && !isset($destinationData[0]))) {
                                    $destinationData = [$destinationData];
                                }
                            @endphp

                            <div class="space-y-3">
                                @foreach($destinationData as $index => $dest)
                                    @php
                                        $isOutOfTown = false;
                                        $province = '';
                                        $city = '';
                                        $address = '';

                                        if (is_array($dest)) {
                                            $province = $dest['province'] ?? '';
                                            $city = $dest['city'] ?? '';
                                            $address = $dest['address'] ?? $dest['destination'] ?? '';
                                            // Check if it's out of town (not in local area)
                                            $isOutOfTown = !empty($province) && strtolower($province) !== 'jawa timur';
                                        } else {
                                            $address = $dest;
                                            // Check if contains "luar_kota" or similar indicators
                                            $isOutOfTown = strpos(strtolower($address), 'luar') !== false;
                                        }
                                    @endphp

                                    <div class="relative p-4 bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-lg">
                                        @if(count($destinationData) > 1)
                                            <div class="absolute top-2 right-2">
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-700">
                                                    {{ $index + 1 }}
                                                </span>
                                            </div>
                                        @endif

                                        <!-- Location Badge -->
                                        <div class="flex items-center justify-between mb-3">
                                            <div class="flex items-center space-x-2">
                                                @if($isOutOfTown)
                                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-700">
                                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"/>
                                                        </svg>
                                                        Luar Kota
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                                        </svg>
                                                        Dalam Kota
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Address -->
                                        @if($address)
                                            <div class="mb-2">
                                                <p class="text-sm font-medium text-gray-900">{{ $address }}</p>
                                            </div>
                                        @endif

                                        <!-- Location Details -->
                                        @if($province || $city)
                                            <div class="flex items-center text-xs text-gray-600">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                </svg>
                                                @if($city && $province)
                                                    <span>{{ $city }}, {{ $province }}</span>
                                                @elseif($city)
                                                    <span>{{ $city }}</span>
                                                @elseif($province)
                                                    <span>{{ $province }}</span>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Notes -->
            @if($borrowing->notes)
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Catatan</h3>
                    <p class="text-sm text-gray-900">{{ $borrowing->notes }}</p>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Quick Info -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Cepat</h3>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500">Dibuat:</span>
                        <span class="text-sm text-gray-900">{{ $borrowing->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500">Peminjam:</span>
                        <span class="text-sm text-gray-900">{{ $borrowing->borrower_type ?? 'N/A' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500">Lokasi:</span>
                        <span class="text-sm text-gray-900">
                            @if($borrowing->location_type == 'luar_kota')
                                Luar Kota
                            @elseif($borrowing->location_type == 'dalam_kota')
                                Dalam Kota
                            @else
                                {{ ucwords(str_replace('_', ' ', $borrowing->location_type ?? 'N/A')) }}
                            @endif
                        </span>
                    </div>
                </div>
            </div>

            <!-- Documents -->
            @if($borrowing->surat_permohonan || $borrowing->surat_tugas)
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Dokumen</h3>
                    <div class="space-y-3">
                        @if($borrowing->surat_permohonan)
                            <div>
                                <a href="{{ Storage::url($borrowing->surat_permohonan) }}" target="_blank"
                                   class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50">
                                    <svg class="w-5 h-5 text-red-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <span class="text-sm text-gray-900">Surat Permohonan</span>
                                </a>
                            </div>
                        @endif
                        @if($borrowing->surat_tugas)
                            <div>
                                <a href="{{ Storage::url($borrowing->surat_tugas) }}" target="_blank"
                                   class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50">
                                    <svg class="w-5 h-5 text-blue-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <span class="text-sm text-gray-900">Surat Tugas</span>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Setujui -->
<div id="approveModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
            <div class="p-6">
                <div class="flex items-center justify-center w-12 h-12 mx-auto bg-green-100 rounded-full mb-4">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 text-center mb-2">Konfirmasi Persetujuan</h3>
                <p class="text-sm text-gray-500 text-center mb-6">Apakah Anda yakin ingin menyetujui peminjaman kendaraan ini?</p>

                <div class="flex space-x-3">
                    <button type="button" onclick="closeApproveModal()"
                            class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg">
                        Batal
                    </button>
                    <button type="button" onclick="confirmApprove()"
                            class="flex-1 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg">
                        Ya, Setujui
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Tolak -->
<div id="rejectModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
            <div class="p-6">
                <div class="flex items-center justify-center w-12 h-12 mx-auto bg-red-100 rounded-full mb-4">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 text-center mb-2">Konfirmasi Penolakan</h3>
                <p class="text-sm text-gray-500 text-center mb-4">Apakah Anda yakin ingin menolak peminjaman kendaraan ini?</p>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Alasan Penolakan (Opsional)</label>
                    <textarea id="rejectReason"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-red-500 focus:border-red-500"
                              rows="3"
                              placeholder="Masukkan alasan penolakan..."></textarea>
                </div>

                <div class="flex space-x-3">
                    <button type="button" onclick="closeRejectModal()"
                            class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg">
                        Batal
                    </button>
                    <button type="button" onclick="confirmReject()"
                            class="flex-1 bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg">
                        Ya, Tolak
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Variables untuk menyimpan borrowing ID
let currentBorrowingId = null;

// Fungsi untuk membuka modal approve
function approveBorrowing(borrowingId) {
    currentBorrowingId = borrowingId;
    document.getElementById('approveModal').classList.remove('hidden');
}

// Fungsi untuk menutup modal approve
function closeApproveModal() {
    document.getElementById('approveModal').classList.add('hidden');
    currentBorrowingId = null;
}

// Fungsi untuk membuka modal reject
function rejectBorrowing(borrowingId) {
    currentBorrowingId = borrowingId;
    document.getElementById('rejectReason').value = '';
    document.getElementById('rejectModal').classList.remove('hidden');
}

// Fungsi untuk menutup modal reject
function closeRejectModal() {
    document.getElementById('rejectModal').classList.add('hidden');
    currentBorrowingId = null;
}

// Fungsi konfirmasi approve
function confirmApprove() {
    if (!currentBorrowingId) return;

    // Loading state
    const approveBtn = document.querySelector('#approveModal button[onclick="confirmApprove()"]');
    const originalText = approveBtn.innerHTML;
    approveBtn.innerHTML = '<svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Memproses...';
    approveBtn.disabled = true;

    fetch(`/admin/borrowings/${currentBorrowingId}/approve`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            status: 'approved'
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Success feedback
            approveBtn.innerHTML = '<svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Berhasil!';
            approveBtn.classList.remove('bg-green-600', 'hover:bg-green-700');
            approveBtn.classList.add('bg-green-500');

            setTimeout(() => {
                closeApproveModal();
                window.location.reload();
            }, 1500);
        } else {
            throw new Error(data.message || 'Terjadi kesalahan!');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        approveBtn.innerHTML = originalText;
        approveBtn.disabled = false;
        alert('Terjadi kesalahan saat memproses permintaan!');
    });
}

// Fungsi konfirmasi reject
function confirmReject() {
    if (!currentBorrowingId) return;

    const reason = document.getElementById('rejectReason').value;

    // Loading state
    const rejectBtn = document.querySelector('#rejectModal button[onclick="confirmReject()"]');
    const originalText = rejectBtn.innerHTML;
    rejectBtn.innerHTML = '<svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Memproses...';
    rejectBtn.disabled = true;

    fetch(`/admin/borrowings/${currentBorrowingId}/reject`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            status: 'rejected',
            notes: reason
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Success feedback
            rejectBtn.innerHTML = '<svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Berhasil!';
            rejectBtn.classList.remove('bg-red-600', 'hover:bg-red-700');
            rejectBtn.classList.add('bg-red-500');

            setTimeout(() => {
                closeRejectModal();
                window.location.reload();
            }, 1500);
        } else {
            throw new Error(data.message || 'Terjadi kesalahan!');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        rejectBtn.innerHTML = originalText;
        rejectBtn.disabled = false;
        alert('Terjadi kesalahan saat memproses permintaan!');
    });
}

// Event listener untuk menutup modal ketika klik di luar modal
document.addEventListener('click', function(event) {
    const approveModal = document.getElementById('approveModal');
    const rejectModal = document.getElementById('rejectModal');

    if (event.target === approveModal) {
        closeApproveModal();
    }

    if (event.target === rejectModal) {
        closeRejectModal();
    }
});

// Event listener untuk ESC key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeApproveModal();
        closeRejectModal();
    }
});
</script>
@endsection
