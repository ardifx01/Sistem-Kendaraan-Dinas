@extends('layouts.app')

@section('title', 'Data Kendaraan')

@php
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
// Set locale ke Indonesia
Carbon::setLocale('id');
@endphp

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="sm:flex sm:items-center sm:justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Data Kendaraan</h1>
            <p class="mt-2 text-sm text-gray-700">Kelola semua kendaraan dinas</p>
        </div>
        <div class="mt-4 sm:mt-0">
            <a href="{{ route('admin.vehicles.create') }}" class="btn btn-primary">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Tambah Kendaraan
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="card mb-6 p-4 sm:p-6">
        <form method="GET" action="{{ route('admin.vehicles.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Cari</label>
                <input type="text"
                       name="search"
                       id="search"
                       placeholder="Plat nomor, merk, model..."
                       value="{{ request('search') }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
            </div>
            <div>
                <label for="type" class="block text-sm font-medium text-gray-700 mb-2">Jenis</label>
                <select name="type" id="type" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    <option value="">Semua Jenis</option>
                    <option value="motor" {{ request('type') == 'motor' ? 'selected' : '' }}>Motor</option>
                    <option value="mobil" {{ request('type') == 'mobil' ? 'selected' : '' }}>Mobil</option>
                </select>
            </div>
            <div>
                <label for="availability" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select name="availability" id="availability" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    <option value="">Semua Status</option>
                    <option value="tersedia" {{ request('availability') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                    <option value="dipinjam" {{ request('availability') == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                    <option value="service" {{ request('availability') == 'service' ? 'selected' : '' }}>Service</option>
                    <option value="tidak_tersedia" {{ request('availability') == 'tidak_tersedia' ? 'selected' : '' }}>Tidak Tersedia</option>
                </select>
            </div>
            <div class="flex flex-col sm:flex-row items-end space-y-2 sm:space-y-0 sm:space-x-2">
                <button type="submit" class="w-full sm:w-auto btn btn-secondary">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    Filter
                </button>
                @if(request()->hasAny(['search', 'type', 'availability']))
                    <a href="{{ route('admin.vehicles.index') }}" class="w-full sm:w-auto btn bg-gray-500 hover:bg-gray-600 text-white">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Table Desktop & Card Mobile -->
    <div class="card overflow-hidden">
        <!-- Desktop Table View -->
        <div class="hidden lg:block">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Foto</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kendaraan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Plat Nomor</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pajak</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Driver</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($vehicles as $vehicle)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($vehicle->photo)
                                        <img src="{{ Storage::url($vehicle->photo) }}"
                                             alt="Foto {{ $vehicle->brand }} {{ $vehicle->model }}"
                                             class="h-12 w-12 rounded-lg object-cover">
                                    @else
                                        <div class="h-12 w-12 rounded-lg bg-gray-100 flex items-center justify-center">
                                            <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13l-3 3 3 3m-6-6l3 3-3 3"></path>
                                            </svg>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $vehicle->brand }} {{ $vehicle->model }}</div>
                                    <div class="text-sm text-gray-500">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ ucfirst($vehicle->type) }}
                                        </span>
                                        <span class="ml-2">{{ $vehicle->year }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $vehicle->license_plate }}</div>
                                    <div class="text-sm text-gray-500">{{ $vehicle->color }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $statusColors = [
                                            'tersedia' => 'bg-green-100 text-green-800',
                                            'dipinjam' => 'bg-yellow-100 text-yellow-800',
                                            'service' => 'bg-red-100 text-red-800',
                                            'tidak_tersedia' => 'bg-gray-100 text-gray-800'
                                        ];
                                        $statusTexts = [
                                            'tersedia' => 'Tersedia',
                                            'dipinjam' => 'Dipinjam',
                                            'service' => 'Service',
                                            'tidak_tersedia' => 'Tidak Tersedia'
                                        ];
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusColors[$vehicle->availability_status] ?? 'bg-gray-100 text-gray-800' }}">
                                        {{ $statusTexts[$vehicle->availability_status] ?? $vehicle->availability_status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($vehicle->tax_expiry_date)
                                        <div class="text-sm text-gray-900">{{ $vehicle->tax_expiry_date->translatedFormat('d F Y') }}</div>
                                        @if($vehicle->isTaxExpiringSoon())
                                            <div class="text-xs text-red-600 font-medium">Segera Expired!</div>
                                        @endif
                                    @else
                                        <span class="text-sm text-gray-500">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $vehicle->driver_name ?: '-' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('admin.vehicles.show', $vehicle) }}"
                                           class="text-indigo-600 hover:text-indigo-900 transition-colors"
                                           title="Detail">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </a>
                                        <a href="{{ route('admin.vehicles.edit', $vehicle) }}"
                                           class="text-yellow-600 hover:text-yellow-900 transition-colors"
                                           title="Edit">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>
                                        <form method="POST"
                                              action="{{ route('admin.vehicles.destroy', $vehicle) }}"
                                              onsubmit="event.preventDefault(); confirmAndDelete(this, '{{ $vehicle->brand }}', '{{ $vehicle->model }}', '{{ $vehicle->license_plate }}')"
                                              class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="text-red-600 hover:text-red-900 transition-colors"
                                                    title="Hapus">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                    <div class="flex flex-col items-center justify-center py-8">
                                        <svg class="w-12 h-12 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13l-3 3 3 3m-6-6l3 3-3 3"></path>
                                        </svg>
                                        <p class="text-gray-500">Tidak ada data kendaraan</p>
                                        <a href="{{ route('admin.vehicles.create') }}" class="mt-2 btn btn-primary">
                                            Tambah Kendaraan Pertama
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Mobile Card View -->
        <div class="lg:hidden">
            @forelse($vehicles as $vehicle)
                <div class="border-b border-gray-200 p-3 sm:p-4 hover:bg-gray-50 transition-colors">
                    <!-- Header Row: Photo and Main Info -->
                    <div class="flex items-start space-x-3">
                        <!-- Photo -->
                        <div class="flex-shrink-0">
                            @if($vehicle->photo)
                                <img src="{{ Storage::url($vehicle->photo) }}"
                                     alt="Foto {{ $vehicle->brand }} {{ $vehicle->model }}"
                                     class="h-12 w-12 sm:h-16 sm:w-16 rounded-lg object-cover">
                            @else
                                <div class="h-12 w-12 sm:h-16 sm:w-16 rounded-lg bg-gray-100 flex items-center justify-center">
                                    <svg class="h-6 w-6 sm:h-8 sm:w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13l-3 3 3 3m-6-6l3 3-3 3"></path>
                                    </svg>
                                </div>
                            @endif
                        </div>

                        <!-- Main Content - Full Width -->
                        <div class="flex-1 min-w-0">
                            <h3 class="text-sm font-medium text-gray-900 truncate pr-2">
                                {{ $vehicle->brand }} {{ $vehicle->model }}
                            </h3>
                            <p class="text-sm text-gray-500">{{ $vehicle->license_plate }}</p>
                        </div>
                    </div>

                    <!-- Details Row -->
                    <div class="mt-3">
                        <div class="flex flex-wrap gap-2">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ ucfirst($vehicle->type) }}
                            </span>
                            @php
                                $statusColors = [
                                    'tersedia' => 'bg-green-100 text-green-800',
                                    'dipinjam' => 'bg-yellow-100 text-yellow-800',
                                    'service' => 'bg-red-100 text-red-800',
                                    'tidak_tersedia' => 'bg-gray-100 text-gray-800'
                                ];
                                $statusTexts = [
                                    'tersedia' => 'Tersedia',
                                    'dipinjam' => 'Dipinjam',
                                    'service' => 'Service',
                                    'tidak_tersedia' => 'Tidak Tersedia'
                                ];
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusColors[$vehicle->availability_status] ?? 'bg-gray-100 text-gray-800' }}">
                                {{ $statusTexts[$vehicle->availability_status] ?? $vehicle->availability_status }}
                            </span>
                        </div>

                        <div class="mt-2 grid grid-cols-2 gap-2 text-xs text-gray-500">
                            <div>
                                <span class="font-medium">Tahun:</span> {{ $vehicle->year }}
                            </div>
                            <div>
                                <span class="font-medium">Warna:</span> {{ $vehicle->color }}
                            </div>
                            @if($vehicle->tax_expiry_date)
                                <div class="col-span-2">
                                    <span class="font-medium">Pajak:</span>
                                    {{ $vehicle->tax_expiry_date->translatedFormat('d F Y') }}
                                    @if($vehicle->isTaxExpiringSoon())
                                        <span class="text-red-600 font-medium ml-1">Segera Expired!</span>
                                    @endif
                                </div>
                            @endif
                            @if($vehicle->driver_name)
                                <div class="col-span-2">
                                    <span class="font-medium">Driver:</span> {{ $vehicle->driver_name }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Action Buttons Row - Separate Row for Better Mobile Experience -->
                    <div class="mt-3 pt-3 border-t border-gray-100">
                        <div class="flex justify-center space-x-4">
                            <a href="{{ route('admin.vehicles.show', $vehicle) }}"
                               class="flex items-center justify-center px-3 py-2 text-sm text-indigo-600 hover:text-indigo-900 hover:bg-indigo-50 rounded-md transition-colors">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                <span class="hidden xs:inline">Detail</span>
                            </a>
                            <a href="{{ route('admin.vehicles.edit', $vehicle) }}"
                               class="flex items-center justify-center px-3 py-2 text-sm text-yellow-600 hover:text-yellow-900 hover:bg-yellow-50 rounded-md transition-colors">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                <span class="hidden xs:inline">Edit</span>
                            </a>
                            <form method="POST"
                                  action="{{ route('admin.vehicles.destroy', $vehicle) }}"
                                  onsubmit="event.preventDefault(); confirmAndDelete(this, '{{ $vehicle->brand }}', '{{ $vehicle->model }}', '{{ $vehicle->license_plate }}')"
                                  class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="flex items-center justify-center px-3 py-2 text-sm text-red-600 hover:text-red-900 hover:bg-red-50 rounded-md transition-colors">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    <span class="hidden xs:inline">Hapus</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-8 text-center">
                    <svg class="w-12 h-12 text-gray-300 mb-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13l-3 3 3 3m-6-6l3 3-3 3"></path>
                    </svg>
                    <p class="text-gray-500 mb-4">Tidak ada data kendaraan</p>
                    <a href="{{ route('admin.vehicles.create') }}" class="btn btn-primary">
                        Tambah Kendaraan Pertama
                    </a>
                </div>
            @endforelse
        </div>

        <!-- Enhanced Pagination Component -->
        <!-- Enhanced Pagination Component -->
        @if($vehicles->hasPages())
            <div class="bg-white px-3 py-3 border-t border-gray-200 sm:px-6">
                <!-- Mobile-First Responsive Layout -->
                <div class="flex flex-col space-y-3 lg:flex-row lg:items-center lg:justify-between lg:space-y-0">
                    <!-- Pagination Info - Hidden on very small screens, visible on sm+ -->
                    <div class="hidden sm:flex items-center text-xs sm:text-sm text-gray-700 order-2 lg:order-1">
                        <span class="whitespace-nowrap">
                            Menampilkan
                            <span class="font-medium">{{ $vehicles->firstItem() ?? 0 }}</span>
                            sampai
                            <span class="font-medium">{{ $vehicles->lastItem() ?? 0 }}</span>
                            dari
                            <span class="font-medium">{{ $vehicles->total() }}</span>
                            kendaraan
                        </span>
                    </div>

                    <!-- Main Pagination Controls -->
                    <div class="flex flex-col space-y-3 sm:space-y-2 lg:space-y-0 lg:flex-row lg:items-center lg:space-x-4 order-1 lg:order-2">
                        <!-- Items per page selector - Full width on mobile, auto on larger screens -->
                        <div class="flex items-center justify-center sm:justify-start space-x-2 w-full sm:w-auto">
                            <label for="per_page" class="text-xs sm:text-sm text-gray-700 whitespace-nowrap">Tampilkan:</label>
                            <select name="per_page"
                                    id="per_page"
                                    onchange="changePerPage(this.value)"
                                    class="text-xs sm:text-sm border border-gray-300 rounded px-2 py-1 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent min-w-0 flex-1 sm:flex-initial">
                                <option value="10" {{ request('per_page') == '10' ? 'selected' : '' }}>10</option>
                                <option value="25" {{ request('per_page') == '25' ? 'selected' : '' }}>25</option>
                                <option value="50" {{ request('per_page') == '50' ? 'selected' : '' }}>50</option>
                                <option value="100" {{ request('per_page') == '100' ? 'selected' : '' }}>100</option>
                            </select>
                        </div>

                        <!-- Desktop Page Navigation - Hidden on mobile/tablet, visible on lg+ -->
                        <nav class="hidden lg:inline-flex relative z-0 rounded-md shadow-sm -space-x-px" aria-label="Pagination">

                            <!-- First Page Button -->
                            @if($vehicles->currentPage() > 1)
                                <a href="{{ $vehicles->appends(request()->query())->url(1) }}"
                                   class="relative inline-flex items-center px-1.5 md:px-2 py-1.5 md:py-2 rounded-l-md border border-gray-300 bg-white text-xs md:text-sm font-medium text-gray-500 hover:bg-gray-50 transition-colors"
                                   title="Halaman Pertama">
                                    <svg class="h-4 w-4 md:h-5 md:w-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M15.707 15.707a1 1 0 01-1.414 0l-5-5a1 1 0 010-1.414l5-5a1 1 0 111.414 1.414L11.414 9H17a1 1 0 110 2h-5.586l4.293 4.293a1 1 0 010 1.414zM9 4a1 1 0 01-1 1H3a1 1 0 110-2h5a1 1 0 011 1z" clip-rule="evenodd"/>
                                    </svg>
                                </a>
                            @else
                                <span class="relative inline-flex items-center px-1.5 md:px-2 py-1.5 md:py-2 rounded-l-md border border-gray-300 bg-gray-100 text-xs md:text-sm font-medium text-gray-300 cursor-not-allowed">
                                    <svg class="h-4 w-4 md:h-5 md:w-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M15.707 15.707a1 1 0 01-1.414 0l-5-5a1 1 0 010-1.414l5-5a1 1 0 111.414 1.414L11.414 9H17a1 1 0 110 2h-5.586l4.293 4.293a1 1 0 010 1.414zM9 4a1 1 0 01-1 1H3a1 1 0 110-2h5a1 1 0 011 1z" clip-rule="evenodd"/>
                                    </svg>
                                </span>
                            @endif

                            <!-- Previous Page Button -->
                            @if($vehicles->onFirstPage())
                                <span class="relative inline-flex items-center px-1.5 md:px-2 py-1.5 md:py-2 border border-gray-300 bg-gray-100 text-xs md:text-sm font-medium text-gray-300 cursor-not-allowed"
                                      title="Halaman Sebelumnya">
                                    <svg class="h-4 w-4 md:h-5 md:w-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                </span>
                            @else
                                <a href="{{ $vehicles->appends(request()->query())->previousPageUrl() }}"
                                   class="relative inline-flex items-center px-1.5 md:px-2 py-1.5 md:py-2 border border-gray-300 bg-white text-xs md:text-sm font-medium text-gray-500 hover:bg-gray-50 transition-colors"
                                   title="Halaman Sebelumnya">
                                    <svg class="h-4 w-4 md:h-5 md:w-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                </a>
                            @endif

                            <!-- Page Numbers -->
                            @php
                                $currentPage = $vehicles->currentPage();
                                $lastPage = $vehicles->lastPage();
                                $start = max(1, $currentPage - 2);
                                $end = min($lastPage, $currentPage + 2);

                                // Adjust range if we're near the beginning or end
                                if ($currentPage <= 3) {
                                    $end = min($lastPage, 5);
                                }
                                if ($currentPage >= $lastPage - 2) {
                                    $start = max(1, $lastPage - 4);
                                }
                            @endphp

                            <!-- Show first page if not in range -->
                            @if($start > 1)
                                <a href="{{ $vehicles->appends(request()->query())->url(1) }}"
                                   class="relative inline-flex items-center px-2 md:px-3 py-1.5 md:py-2 border border-gray-300 bg-white text-xs md:text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                                    1
                                </a>
                                @if($start > 2)
                                    <span class="relative inline-flex items-center px-2 md:px-3 py-1.5 md:py-2 border border-gray-300 bg-white text-xs md:text-sm font-medium text-gray-700">
                                        ...
                                    </span>
                                @endif
                            @endif

                            <!-- Page numbers in range -->
                            @for($page = $start; $page <= $end; $page++)
                                @if($page == $currentPage)
                                    <span class="relative inline-flex items-center px-2 md:px-3 py-1.5 md:py-2 border border-indigo-500 bg-indigo-50 text-xs md:text-sm font-medium text-indigo-600 z-10">
                                        {{ $page }}
                                    </span>
                                @else
                                    <a href="{{ $vehicles->appends(request()->query())->url($page) }}"
                                       class="relative inline-flex items-center px-2 md:px-3 py-1.5 md:py-2 border border-gray-300 bg-white text-xs md:text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endfor

                            <!-- Show last page if not in range -->
                            @if($end < $lastPage)
                                @if($end < $lastPage - 1)
                                    <span class="relative inline-flex items-center px-2 md:px-3 py-1.5 md:py-2 border border-gray-300 bg-white text-xs md:text-sm font-medium text-gray-700">
                                        ...
                                    </span>
                                @endif
                                <a href="{{ $vehicles->appends(request()->query())->url($lastPage) }}"
                                   class="relative inline-flex items-center px-2 md:px-3 py-1.5 md:py-2 border border-gray-300 bg-white text-xs md:text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                                    {{ $lastPage }}
                                </a>
                            @endif

                            <!-- Next Page Button -->
                            @if($vehicles->hasMorePages())
                                <a href="{{ $vehicles->appends(request()->query())->nextPageUrl() }}"
                                   class="relative inline-flex items-center px-1.5 md:px-2 py-1.5 md:py-2 border border-gray-300 bg-white text-xs md:text-sm font-medium text-gray-500 hover:bg-gray-50 transition-colors"
                                   title="Halaman Selanjutnya">
                                    <svg class="h-4 w-4 md:h-5 md:w-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                </a>
                            @else
                                <span class="relative inline-flex items-center px-1.5 md:px-2 py-1.5 md:py-2 border border-gray-300 bg-gray-100 text-xs md:text-sm font-medium text-gray-300 cursor-not-allowed"
                                      title="Halaman Selanjutnya">
                                    <svg class="h-4 w-4 md:h-5 md:w-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                </span>
                            @endif

                            <!-- Last Page Button -->
                            @if($vehicles->currentPage() < $vehicles->lastPage())
                                <a href="{{ $vehicles->appends(request()->query())->url($vehicles->lastPage()) }}"
                                   class="relative inline-flex items-center px-1.5 md:px-2 py-1.5 md:py-2 rounded-r-md border border-gray-300 bg-white text-xs md:text-sm font-medium text-gray-500 hover:bg-gray-50 transition-colors"
                                   title="Halaman Terakhir">
                                    <svg class="h-4 w-4 md:h-5 md:w-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0l5 5a1 1 0 010 1.414l-5 5a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414zM11 16a1 1 0 01-1-1h5a1 1 0 110 2h-5a1 1 0 01-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                </a>
                            @else
                                <span class="relative inline-flex items-center px-1.5 md:px-2 py-1.5 md:py-2 rounded-r-md border border-gray-300 bg-gray-100 text-xs md:text-sm font-medium text-gray-300 cursor-not-allowed">
                                    <svg class="h-4 w-4 md:h-5 md:w-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0l5 5a1 1 0 010 1.414l-5 5a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414zM11 16a1 1 0 01-1-1h5a1 1 0 110 2h-5a1 1 0 01-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                </span>
                            @endif
                        </nav>

                    </div>

                    <!-- Mobile-Only Simple Pagination - Visible only on mobile/tablet -->
                    <div class="flex lg:hidden justify-between items-center w-full order-3 mt-3 pt-3 border-t border-gray-200">
                        @if($vehicles->onFirstPage())
                            <span class="px-3 py-2 text-xs font-medium text-gray-300 bg-gray-100 rounded cursor-not-allowed">
                                « Sebelumnya
                            </span>
                        @else
                            <a href="{{ $vehicles->appends(request()->query())->previousPageUrl() }}"
                               class="px-3 py-2 text-xs font-medium text-indigo-600 bg-white border border-indigo-600 rounded hover:bg-indigo-50 transition-colors">
                                « Sebelumnya
                            </a>
                        @endif

                        <span class="text-xs text-gray-700 mx-2">
                            {{ $vehicles->currentPage() }}/{{ $vehicles->lastPage() }}
                        </span>

                        @if($vehicles->hasMorePages())
                            <a href="{{ $vehicles->appends(request()->query())->nextPageUrl() }}"
                               class="px-3 py-2 text-xs font-medium text-indigo-600 bg-white border border-indigo-600 rounded hover:bg-indigo-50 transition-colors">
                                Selanjutnya »
                            </a>
                        @else
                            <span class="px-3 py-2 text-xs font-medium text-gray-300 bg-gray-100 rounded cursor-not-allowed">
                                Selanjutnya »
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 items-center justify-center p-4 hidden z-50">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full transform transition-all">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>
                <h3 class="ml-3 text-lg font-medium text-gray-900">Konfirmasi Hapus Kendaraan</h3>
            </div>
        </div>
        <div class="px-6 py-4">
            <p class="text-sm text-gray-600 mb-4">Apakah Anda yakin ingin menghapus kendaraan berikut?</p>
            <div class="bg-red-50 border border-red-200 rounded-lg p-4 space-y-2">
                <div class="flex justify-between">
                    <span class="font-medium text-gray-700">Merek:</span>
                    <span id="delete-modal-brand" class="text-gray-900">-</span>
                </div>
                <div class="flex justify-between">
                    <span class="font-medium text-gray-700">Model:</span>
                    <span id="delete-modal-model" class="text-gray-900">-</span>
                </div>
                <div class="flex justify-between">
                    <span class="font-medium text-gray-700">Plat Nomor:</span>
                    <span id="delete-modal-license" class="text-gray-900">-</span>
                </div>
            </div>
            <div class="mt-4 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                <p class="text-sm text-yellow-800">
                    <span class="font-medium">Peringatan:</span> Data yang dihapus tidak dapat dikembalikan!
                </p>
            </div>
        </div>
        <div class="px-6 py-4 bg-gray-50 flex flex-col sm:flex-row sm:justify-end space-y-2 sm:space-y-0 sm:space-x-3">
            <button type="button" onclick="closeDeleteModal()"
                    class="w-full sm:w-auto px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                Batal
            </button>
            <button type="button" onclick="submitDeleteForm()"
                    class="w-full sm:w-auto px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
                Ya, Hapus
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let deleteFormToSubmit = null;

    // Pagination functions
    function changePerPage(perPage) {
        const url = new URL(window.location);
        url.searchParams.set('per_page', perPage);
        url.searchParams.delete('page'); // Reset to first page when changing per_page
        window.location.href = url.toString();
    }

    function jumpToPage(page) {
        const pageNum = parseInt(page);
        const maxPage = {{ $vehicles->lastPage() }};

        if (isNaN(pageNum) || pageNum < 1 || pageNum > maxPage) {
            alert(`Silakan masukkan nomor halaman antara 1 dan ${maxPage}`);
            return;
        }

        const url = new URL(window.location);
        url.searchParams.set('page', pageNum);
        window.location.href = url.toString();
    }

    // Confirm and delete vehicle
    function confirmAndDelete(form, brand, model, licensePlate) {
        deleteFormToSubmit = form;

        // Update modal content
        document.getElementById('delete-modal-brand').textContent = brand;
        document.getElementById('delete-modal-model').textContent = model;
        document.getElementById('delete-modal-license').textContent = licensePlate;

        // Show modal
        const modal = document.getElementById('deleteModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function closeDeleteModal() {
        const modal = document.getElementById('deleteModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = 'auto';
        deleteFormToSubmit = null;
    }

    function submitDeleteForm() {
        if (deleteFormToSubmit) {
            deleteFormToSubmit.submit();
        }
    }

    // Close modal when clicking outside
    document.getElementById('deleteModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeDeleteModal();
        }
    });

    // Close modal with ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeDeleteModal();
        }
    });

    // Handle Enter key in jump page input
    document.addEventListener('DOMContentLoaded', function() {
        const jumpPageInput = document.getElementById('jump_page');
        if (jumpPageInput) {
            jumpPageInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    jumpToPage(this.value);
                }
            });
        }
    });
</script>
@endpush

@endsection
