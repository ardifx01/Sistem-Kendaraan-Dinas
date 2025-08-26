@extends('layouts.app')

@section('title', 'Daftar Service Kendaraan')

@section('content')
<div class="max-w-full mx-auto px-2 sm:px-4 lg:px-6 py-2 sm:py-4">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-3 space-y-2 sm:space-y-0">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Daftar Service Kendaraan</h1>
            <p class="mt-1 text-xs text-gray-600">Kelola dan monitor semua data service kendaraan dinas</p>
        </div>
        <a href="{{ route('operator.services.create') }}"
           class="inline-flex items-center justify-center px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium rounded-md shadow-sm transition-colors duration-200 w-full sm:w-auto create-btn"
           data-action="create">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Tambah Service
        </a>
    </div>

    <!-- Info Alert -->
    <div class="bg-blue-50 border border-blue-200 rounded-md p-2 mb-3">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <svg class="w-4 h-4 text-blue-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="ml-2">
                <h3 class="text-xs font-medium text-blue-800">Informasi</h3>
                <p class="text-xs text-blue-700 mt-0.5">
                    Halaman ini menampilkan semua data service kendaraan dinas.
                    Anda dapat menambah, melihat, mengedit, dan menghapus data service kendaraan.
                </p>
            </div>
        </div>
    </div>

    <!-- Summary Card -->
    <div class="bg-white rounded-md shadow-sm border border-gray-200 p-3 mb-3">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-sm font-semibold text-gray-900">Total Service Records</h3>
                <p class="text-xl font-bold text-blue-600 mt-1">{{ $totalServices ?? 0 }}</p>
                <p class="text-xs text-gray-600 mt-0.5">Total semua data service kendaraan</p>
            </div>
            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path fill-rule="evenodd" d="M12 6.75a5.25 5.25 0 0 1 6.775-5.025.75.75 0 0 1 .313 1.248l-3.32 3.319c.063.475.276.934.641 1.299.365.365.824.578 1.3.64l3.318-3.319a.75.75 0 0 1 1.248.313 5.25 5.25 0 0 1-5.472 6.756c-1.018-.086-1.87.1-2.309.634L7.344 21.3A3.298 3.298 0 1 1 2.7 16.657l8.684-7.151c.533-.44.72-1.291.634-2.309A5.342 5.342 0 0 1 12 6.75ZM4.117 19.125a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75h-.008a.75.75 0 0 1-.75-.75v-.008Z" clip-rule="evenodd" />
                    <path d="m10.076 8.64-2.201-2.2V4.874a.75.75 0 0 0-.364-.643l-3.75-2.25a.75.75 0 0 0-.916.113l-.75.75a.75.75 0 0 0-.113.916l2.25 3.75a.75.75 0 0 0 .643.364h1.564l2.062 2.062 1.575-1.297Z" />
                    <path fill-rule="evenodd" d="m12.556 17.329 4.183 4.182a3.375 3.375 0 0 0 4.773-4.773l-3.306-3.305a6.803 6.803 0 0 1-1.53.043c-.394-.034-.682-.006-.867.042a.589.589 0 0 0-.167.063l-3.086 3.748Zm3.414-1.36a.75.75 0 0 1 1.06 0l1.875 1.876a.75.75 0 1 1-1.06 1.06L15.97 17.03a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Search Section -->
    <div class="bg-white rounded-md shadow-sm border border-gray-200 mb-3 p-2">
        <form method="GET" action="{{ route('operator.services.index') }}" class="flex flex-col sm:flex-row gap-2">
            <div class="flex-1">
                <label for="search" class="block text-xs font-medium text-gray-700 mb-1">Cari Service</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}"
                       placeholder="Plat nomor, merk, model, jenis service, bengkel..."
                       class="w-full px-2 py-1.5 border border-gray-300 rounded text-xs focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-transparent">
            </div>
            <div class="flex items-end space-x-1">
                <button type="submit" class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium rounded transition-colors duration-200">
                    Cari
                </button>
                <a href="{{ route('operator.services.index') }}" class="px-3 py-1.5 bg-gray-300 hover:bg-gray-400 text-gray-700 text-xs font-medium rounded transition-colors duration-200">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Table Section -->
    <div class="bg-white rounded-md shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto table-container">
            <table class="min-w-full divide-y divide-gray-200 table-mobile-card table-compact">
                <thead class="bg-gray-50 hidden sm:table-header-group">
                    <tr>
                        <th class="px-2 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-12">No</th>
                        <th class="px-2 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-32">Kendaraan</th>
                        <th class="px-2 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden sm:table-cell w-20">Tanggal</th>
                        <th class="px-2 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24">Jenis</th>
                        <th class="px-2 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden lg:table-cell w-40">Kerusakan & Perbaikan</th>
                        <th class="px-2 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden xl:table-cell w-32">Part Diganti</th>
                        <th class="px-2 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden lg:table-cell w-24">Dokumen</th>
                        <th class="px-2 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($services as $service)
                    <tr class="hover:bg-gray-50 transition-colors duration-200 service-row">
                        <td class="px-2 py-2 whitespace-nowrap text-xs text-gray-900" data-label="No">
                            {{ ($services->currentPage() - 1) * $services->perPage() + $loop->iteration }}
                        </td>
                        <td class="px-2 py-2 whitespace-nowrap" data-label="Kendaraan">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-6 w-6">
                                    <div class="h-6 w-6 rounded-full bg-indigo-100 flex items-center justify-center">
                                        <svg class="h-3 w-3 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12a7.5 7.5 0 0 0 15 0m-15 0a7.5 7.5 0 1 1 15 0m-15 0H3m16.5 0H21m-1.5 0H12m-8.457 3.077 1.41-.513m14.095-5.13 1.41-.513M5.106 17.785l1.15-.964m11.49-9.642 1.149-.964M7.501 19.795l.75-1.3m7.5-12.99.75-1.3m-6.063 16.658.26-1.477m2.605-14.772.26-1.477m0 17.726-.26-1.477M10.698 4.614l-.26-1.477M16.5 19.794l-.75-1.299M7.5 4.205 12 12m6.894 5.785-1.149-.964M6.256 7.178l-1.15-.964m15.352 8.864-1.41-.513M4.954 9.435l-1.41-.514M12.002 12l-3.75 6.495" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-2">
                                    <div class="text-xs font-medium text-gray-900 truncate max-w-24" title="{{ $service->vehicle ? $service->vehicle->brand . ' ' . $service->vehicle->model : 'Kendaraan tidak ditemukan' }}">
                                        {{ $service->vehicle ? Str::limit($service->vehicle->brand . ' ' . $service->vehicle->model, 20) : 'N/A' }}
                                    </div>
                                    <div class="text-xs text-gray-500 truncate max-w-24" title="{{ $service->vehicle ? $service->vehicle->license_plate : '-' }}">
                                        {{ $service->vehicle ? $service->vehicle->license_plate : '-' }}
                                    </div>
                                    <!-- Mobile-only additional info -->
                                    <div class="sm:hidden mt-1 space-y-0.5">
                                        <div class="text-xs text-gray-600">
                                            📅 {{ $service->service_date ? \Carbon\Carbon::parse($service->service_date)->format('d/m/Y') : '-' }}
                                        </div>
                                        @if($service->garage_name)
                                            <div class="text-xs text-gray-600 truncate">
                                                🔧 {{ Str::limit($service->garage_name, 20) }}
                                            </div>
                                        @endif
                                        @if($service->cost)
                                            <div class="text-xs text-green-600 font-medium">
                                                💰 Rp {{ number_format($service->cost, 0, ',', '.') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-2 py-2 whitespace-nowrap text-xs text-gray-900 hidden sm:table-cell" data-label="Tanggal">
                            {{ $service->service_date ? \Carbon\Carbon::parse($service->service_date)->format('d/m/y') : '-' }}
                        </td>
                        <td class="px-2 py-2 whitespace-nowrap" data-label="Jenis">
                            @php
                                $serviceTypeLabels = [
                                    'service_rutin' => 'Rutin',
                                    'kerusakan' => 'Rusak',
                                    'perbaikan' => 'Perbaikan',
                                    'penggantian_part' => 'Ganti Part'
                                ];
                                $serviceTypeColors = [
                                    'service_rutin' => 'bg-green-100 text-green-800',
                                    'kerusakan' => 'bg-red-100 text-red-800',
                                    'perbaikan' => 'bg-yellow-100 text-yellow-800',
                                    'penggantian_part' => 'bg-blue-100 text-blue-800'
                                ];
                            @endphp
                            <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-xs font-medium badge-status {{ $serviceTypeColors[$service->service_type] ?? 'bg-gray-100 text-gray-800' }}">
                                {{ $serviceTypeLabels[$service->service_type] ?? Str::limit($service->service_type, 8) }}
                            </span>
                            <!-- Mobile-only descriptions -->
                            <div class="sm:hidden mt-1 space-y-1">
                                @if($service->damage_description)
                                    <div class="text-xs">
                                        <span class="font-medium text-red-600">Kerusakan:</span>
                                        <p class="text-gray-600 mt-0.5">{{ Str::limit($service->damage_description ?? '', 50) }}</p>
                                    </div>
                                @endif
                                @if($service->repair_description)
                                    <div class="text-xs">
                                        <span class="font-medium text-green-600">Perbaikan:</span>
                                        <p class="text-gray-600 mt-0.5">{{ Str::limit($service->repair_description ?? '', 50) }}</p>
                                    </div>
                                @endif
                                @if($service->parts_replaced)
                                    <div class="text-xs">
                                        <span class="font-medium text-blue-600">Part:</span>
                                        <p class="text-gray-600 mt-0.5">{{ Str::limit($service->parts_replaced ?? '', 50) }}</p>
                                    </div>
                                @endif
                                <!-- Mobile documents & photos info -->
                                @php
                                    $documents = $service->documents ?? [];
                                    if (is_string($documents)) {
                                        $documents = json_decode($documents, true) ?: [];
                                    } elseif (!is_array($documents)) {
                                        $documents = [];
                                    }

                                    $photos = $service->photos ?? [];
                                    if (is_string($photos)) {
                                        $photos = json_decode($photos, true) ?: [];
                                    } elseif (!is_array($photos)) {
                                        $photos = [];
                                    }

                                    $documentCount = count($documents);
                                    $photoCount = count($photos);
                                @endphp
                                @if($documentCount > 0 || $photoCount > 0)
                                    <div class="text-xs flex items-center space-x-1">
                                        @if($documentCount > 0)
                                            <span class="inline-flex items-center px-1 py-0.5 rounded-full bg-blue-100 text-blue-800">
                                                📄 {{ $documentCount }}
                                            </span>
                                        @endif
                                        @if($photoCount > 0)
                                            <span class="inline-flex items-center px-1 py-0.5 rounded-full bg-green-100 text-green-800">
                                                📸 {{ $photoCount }}
                                            </span>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </td>

                        <!-- Damage & Repair Description -->
                        <td class="px-2 py-2 text-xs text-gray-900 hidden lg:table-cell max-w-xs" data-label="Kerusakan & Perbaikan">
                            <div class="space-y-1">
                                @if($service->damage_description)
                                    <div>
                                        <span class="text-xs font-medium text-red-600 bg-red-50 px-1 py-0.5 rounded">Rusak:</span>
                                        <p class="text-xs text-gray-700 mt-0.5 truncate" title="{{ $service->damage_description ?? '' }}">
                                            {{ Str::limit($service->damage_description ?? '', 30) }}
                                        </p>
                                    </div>
                                @endif
                                @if($service->repair_description)
                                    <div>
                                        <span class="text-xs font-medium text-green-600 bg-green-50 px-1 py-0.5 rounded">Perbaikan:</span>
                                        <p class="text-xs text-gray-700 mt-0.5 truncate" title="{{ $service->repair_description ?? '' }}">
                                            {{ Str::limit($service->repair_description ?? '', 30) }}
                                        </p>
                                    </div>
                                @endif
                                @if(!$service->damage_description && !$service->repair_description)
                                    <span class="text-gray-400 italic text-xs">-</span>
                                @endif
                            </div>
                        </td>

                        <!-- Parts Replaced -->
                        <td class="px-2 py-2 text-xs text-gray-900 hidden xl:table-cell max-w-xs" data-label="Part Diganti">
                            @if($service->parts_replaced)
                                <div class="text-xs text-gray-700 truncate" title="{{ $service->parts_replaced ?? '' }}">
                                    {{ Str::limit($service->parts_replaced ?? '', 30) }}
                                </div>
                            @else
                                <span class="text-gray-400 italic text-xs">-</span>
                            @endif
                        </td>

                        <!-- Documents & Photos -->
                        <td class="px-2 py-2 whitespace-nowrap text-xs text-gray-900 hidden lg:table-cell" data-label="Dokumen">
                            <div class="flex items-center space-x-1">
                                @php
                                    $documents = $service->documents ?? [];
                                    if (is_string($documents)) {
                                        $documents = json_decode($documents, true) ?: [];
                                    } elseif (!is_array($documents)) {
                                        $documents = [];
                                    }

                                    $photos = $service->photos ?? [];
                                    if (is_string($photos)) {
                                        $photos = json_decode($photos, true) ?: [];
                                    } elseif (!is_array($photos)) {
                                        $photos = [];
                                    }

                                    $documentCount = count($documents);
                                    $photoCount = count($photos);
                                @endphp

                                @if($documentCount > 0)
                                    <span class="inline-flex items-center px-1 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        📄 {{ $documentCount }}
                                    </span>
                                @endif

                                @if($photoCount > 0)
                                    <span class="inline-flex items-center px-1 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        📸 {{ $photoCount }}
                                    </span>
                                @endif

                                @if($documentCount == 0 && $photoCount == 0)
                                    <span class="text-gray-400 italic text-xs">-</span>
                                @endif
                            </div>
                        </td>

                        <!-- Actions -->
                        <td class="px-2 py-2 whitespace-nowrap text-xs font-medium" data-label="Aksi">
                            <div class="flex flex-col sm:flex-row sm:items-center space-y-0.5 sm:space-y-0 sm:space-x-1 action-buttons">
                                <a href="{{ route('operator.services.show', $service) }}"
                                   class="text-blue-600 hover:text-blue-800 transition-colors duration-200 text-center sm:text-left btn-detail text-xs">Detail</a>
                                <a href="{{ route('operator.services.edit', $service) }}"
                                   class="text-green-600 hover:text-green-800 transition-colors duration-200 text-center sm:text-left btn-edit edit-btn text-xs"
                                   data-service-id="{{ $service->id }}"
                                   data-service-name="{{ $service->vehicle ? $service->vehicle->brand . ' ' . $service->vehicle->model . ' (' . $service->vehicle->license_plate . ')' : 'Service' }}"
                                   data-service-date="{{ $service->service_date ? \Carbon\Carbon::parse($service->service_date)->format('d/m/Y') : '-' }}"
                                   data-service-type="{{ $serviceTypeLabels[$service->service_type] ?? $service->service_type }}">Edit</a>
                                <button type="button"
                                        class="text-red-600 hover:text-red-800 transition-colors duration-200 btn-delete delete-btn text-xs"
                                        data-service-id="{{ $service->id }}"
                                        data-service-name="{{ $service->vehicle ? $service->vehicle->brand . ' ' . $service->vehicle->model . ' (' . $service->vehicle->license_plate . ')' : 'Service' }}"
                                        data-service-date="{{ $service->service_date ? \Carbon\Carbon::parse($service->service_date)->format('d/m/Y') : '-' }}"
                                        data-service-type="{{ $serviceTypeLabels[$service->service_type] ?? $service->service_type }}"
                                        data-delete-url="{{ route('operator.services.destroy', $service) }}">
                                    Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-8 text-center">
                            <div class="flex flex-col items-center">
                                <svg class="w-8 h-8 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <p class="text-gray-500 text-sm font-medium">Tidak ada data service</p>
                                <p class="text-gray-400 text-xs mt-0.5">Belum ada data service kendaraan yang tercatat</p>
                                <a href="{{ route('operator.services.create') }}"
                                   class="mt-2 inline-flex items-center px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium rounded transition-colors duration-200 create-btn"
                                   data-action="create">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Tambah Service
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($services->hasPages())
        <div class="px-3 py-2 border-t border-gray-200">
            {{ $services->appends(request()->query())->links() }}
        </div>
        @endif
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
                <p class="text-sm text-gray-500 mb-3">Apakah Anda yakin ingin menghapus data service berikut?</p>
                <div class="bg-gray-50 p-3 rounded-md text-left">
                    <div class="text-sm">
                        <div class="font-medium text-gray-900" id="deleteServiceName"></div>
                        <div class="text-gray-600 mt-1" id="deleteServiceDetails"></div>
                    </div>
                </div>
                <p class="text-xs text-red-600 mt-3 font-medium">⚠️ Tindakan ini tidak dapat dibatalkan!</p>
            </div>
            <div class="items-center px-4 py-3 space-x-3 flex justify-center">
                <button id="cancelDelete" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 text-base font-medium rounded-md w-auto shadow-sm transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-gray-300">
                    Batal
                </button>
                <button id="confirmDelete" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-base font-medium rounded-md w-auto shadow-sm transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-red-300">
                    Ya, Hapus
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Confirmation Modal -->
<div id="editModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-yellow-100">
                <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
            </div>
            <h3 class="text-lg leading-6 font-medium text-gray-900 mt-4">Konfirmasi Edit Data</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500 mb-3">Anda akan mengedit data service berikut:</p>
                <div class="bg-gray-50 p-3 rounded-md text-left">
                    <div class="text-sm">
                        <div class="font-medium text-gray-900" id="editServiceName"></div>
                        <div class="text-gray-600 mt-1" id="editServiceDetails"></div>
                    </div>
                </div>
                <p class="text-xs text-blue-600 mt-3">💡 Pastikan data yang akan diubah sudah benar</p>
            </div>
            <div class="items-center px-4 py-3 space-x-3 flex justify-center">
                <button id="cancelEdit" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 text-base font-medium rounded-md w-auto shadow-sm transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-gray-300">
                    Batal
                </button>
                <button id="confirmEdit" class="px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white text-base font-medium rounded-md w-auto shadow-sm transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-yellow-300">
                    Lanjut Edit
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Create Confirmation Modal -->
<div id="createModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100">
                <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
            </div>
            <h3 class="text-lg leading-6 font-medium text-gray-900 mt-4">Konfirmasi Tambah Data</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500 mb-3">Anda akan menambah data service baru ke sistem.</p>
                <div class="bg-blue-50 p-3 rounded-md text-left">
                    <div class="text-sm text-blue-700">
                        <p class="font-medium">📝 Pastikan data yang akan diinput:</p>
                        <ul class="mt-2 space-y-1 text-xs">
                            <li>• Kendaraan yang akan diservice</li>
                            <li>• Tanggal service yang tepat</li>
                            <li>• Jenis service yang sesuai</li>
                            <li>• Deskripsi yang lengkap</li>
                        </ul>
                    </div>
                </div>
                <p class="text-xs text-green-600 mt-3">✨ Data baru akan tersimpan dalam sistem</p>
            </div>
            <div class="items-center px-4 py-3 space-x-3 flex justify-center">
                <button id="cancelCreate" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 text-base font-medium rounded-md w-auto shadow-sm transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-gray-300">
                    Batal
                </button>
                <button id="confirmCreate" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-base font-medium rounded-md w-auto shadow-sm transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-green-300">
                    Lanjut Tambah
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Success Modal -->
<div id="successModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100">
                <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h3 class="text-lg leading-6 font-medium text-gray-900 mt-4">Berhasil</h3>
            <div class="mt-2 px-7 py-3">
                <p id="successMessage" class="text-sm text-gray-500"></p>
            </div>
            <div class="items-center px-4 py-3">
                <button id="closeSuccess" class="px-4 py-2 bg-green-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-300">
                    OK
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Error Modal -->
<div id="errorModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </div>
            <h3 class="text-lg leading-6 font-medium text-gray-900 mt-4">Error</h3>
            <div class="mt-2 px-7 py-3">
                <p id="errorMessage" class="text-sm text-gray-500"></p>
            </div>
            <div class="items-center px-4 py-3">
                <button id="closeError" class="px-4 py-2 bg-red-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-300">
                    OK
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Loading Modal -->
<div id="loadingModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-blue-100">
                <svg class="animate-spin h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>
            <h3 class="text-lg leading-6 font-medium text-gray-900 mt-4">Memproses</h3>
            <div class="mt-2 px-7 py-3">
                <p id="loadingMessage" class="text-sm text-gray-500">Mohon tunggu...</p>
            </div>
        </div>
    </div>
</div>

@if(session('success'))
<div id="success-alert" class="fixed top-4 right-4 z-50 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-md shadow-lg">
    <div class="flex items-center">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
        </svg>
        {{ session('success') }}
        <button onclick="document.getElementById('success-alert').remove()" class="ml-4 text-green-600 hover:text-green-800">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>
</div>
<script>
    setTimeout(() => {
        const alert = document.getElementById('success-alert');
        if (alert) alert.remove();
    }, 5000);
</script>
@endif

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle delete buttons
    const deleteButtons = document.querySelectorAll('.delete-btn');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const serviceId = this.dataset.serviceId;
            const serviceName = this.dataset.serviceName;
            const serviceDate = this.dataset.serviceDate;
            const serviceType = this.dataset.serviceType;
            const deleteUrl = this.dataset.deleteUrl;

            showDeleteConfirm(serviceId, serviceName, serviceDate, serviceType, deleteUrl);
        });
    });

    // Handle edit buttons
    const editButtons = document.querySelectorAll('.edit-btn');
    editButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const serviceId = this.dataset.serviceId;
            const serviceName = this.dataset.serviceName;
            const serviceDate = this.dataset.serviceDate;
            const serviceType = this.dataset.serviceType;
            const editUrl = this.href;

            showEditConfirm(serviceId, serviceName, serviceDate, serviceType, editUrl);
        });
    });

    // Handle create button
    const createButtons = document.querySelectorAll('.create-btn');
    createButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const createUrl = this.href;
            showCreateConfirm(createUrl);
        });
    });
});

// Modal Manager Functions
function showDeleteConfirm(serviceId, serviceName, serviceDate, serviceType, deleteUrl) {
    const modal = document.getElementById('deleteModal');
    const serviceNameEl = document.getElementById('deleteServiceName');
    const serviceDetailsEl = document.getElementById('deleteServiceDetails');
    const confirmBtn = document.getElementById('confirmDelete');
    const cancelBtn = document.getElementById('cancelDelete');

    if (serviceNameEl) {
        serviceNameEl.textContent = serviceName;
    }

    if (serviceDetailsEl) {
        serviceDetailsEl.innerHTML = `
            <div class="space-y-1">
                <div><span class="font-medium">Tanggal:</span> ${serviceDate}</div>
                <div><span class="font-medium">Jenis:</span> ${serviceType}</div>
            </div>
        `;
    }

    // Remove previous event listeners
    const newConfirmBtn = confirmBtn.cloneNode(true);
    confirmBtn.parentNode.replaceChild(newConfirmBtn, confirmBtn);

    // Add new event listeners
    newConfirmBtn.addEventListener('click', () => {
        hideModal('deleteModal');
        performDelete(deleteUrl);
    });

    cancelBtn.addEventListener('click', () => {
        hideModal('deleteModal');
    });

    showModal('deleteModal');
}

function showEditConfirm(serviceId, serviceName, serviceDate, serviceType, editUrl) {
    const modal = document.getElementById('editModal');
    const serviceNameEl = document.getElementById('editServiceName');
    const serviceDetailsEl = document.getElementById('editServiceDetails');
    const confirmBtn = document.getElementById('confirmEdit');
    const cancelBtn = document.getElementById('cancelEdit');

    if (serviceNameEl) {
        serviceNameEl.textContent = serviceName;
    }

    if (serviceDetailsEl) {
        serviceDetailsEl.innerHTML = `
            <div class="space-y-1">
                <div><span class="font-medium">Tanggal:</span> ${serviceDate}</div>
                <div><span class="font-medium">Jenis:</span> ${serviceType}</div>
            </div>
        `;
    }

    // Remove previous event listeners
    const newConfirmBtn = confirmBtn.cloneNode(true);
    confirmBtn.parentNode.replaceChild(newConfirmBtn, confirmBtn);

    // Add new event listeners
    newConfirmBtn.addEventListener('click', () => {
        hideModal('editModal');
        showLoading('Memuat halaman edit...');
        window.location.href = editUrl;
    });

    cancelBtn.addEventListener('click', () => {
        hideModal('editModal');
    });

    showModal('editModal');
}

function showCreateConfirm(createUrl) {
    const modal = document.getElementById('createModal');
    const confirmBtn = document.getElementById('confirmCreate');
    const cancelBtn = document.getElementById('cancelCreate');

    // Remove previous event listeners
    const newConfirmBtn = confirmBtn.cloneNode(true);
    confirmBtn.parentNode.replaceChild(newConfirmBtn, confirmBtn);

    // Add new event listeners
    newConfirmBtn.addEventListener('click', () => {
        hideModal('createModal');
        showLoading('Memuat halaman tambah data...');
        window.location.href = createUrl;
    });

    cancelBtn.addEventListener('click', () => {
        hideModal('createModal');
    });

    showModal('createModal');
}

function performDelete(deleteUrl) {
    showLoading('Menghapus data service...');

    // Create form for DELETE request
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = deleteUrl;
    form.style.display = 'none';

    // Add CSRF token
    const csrfField = document.createElement('input');
    csrfField.type = 'hidden';
    csrfField.name = '_token';
    csrfField.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    form.appendChild(csrfField);

    // Add method override for DELETE
    const methodField = document.createElement('input');
    methodField.type = 'hidden';
    methodField.name = '_method';
    methodField.value = 'DELETE';
    form.appendChild(methodField);

    document.body.appendChild(form);
    form.submit();
}

function showSuccess(message) {
    const messageEl = document.getElementById('successMessage');
    if (messageEl) messageEl.textContent = message;
    showModal('successModal');
}

function showError(message) {
    const messageEl = document.getElementById('errorMessage');
    if (messageEl) messageEl.textContent = message;
    showModal('errorModal');
}

function showLoading(message = 'Memproses...') {
    const messageEl = document.getElementById('loadingMessage');
    if (messageEl) messageEl.textContent = message;
    showModal('loadingModal');
}

function hideLoading() {
    hideModal('loadingModal');
}

function showModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
}

function hideModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
}

// Close modal event listeners
document.addEventListener('DOMContentLoaded', function() {
    // Close buttons
    const closeButtons = ['cancelDelete', 'closeSuccess', 'closeError', 'cancelEdit', 'cancelCreate'];
    closeButtons.forEach(buttonId => {
        const button = document.getElementById(buttonId);
        if (button) {
            button.addEventListener('click', function() {
                const modal = this.closest('.fixed');
                if (modal) {
                    modal.classList.add('hidden');
                    document.body.style.overflow = 'auto';
                }
            });
        }
    });

    // Close on backdrop click
    const modals = ['deleteModal', 'successModal', 'errorModal', 'loadingModal', 'editModal', 'createModal'];
    modals.forEach(modalId => {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.addEventListener('click', function(e) {
                if (e.target === this) {
                    hideModal(modalId);
                }
            });
        }
    });

    // Close on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            modals.forEach(modalId => hideModal(modalId));
        }
    });
});
</script>

<style>
/* Compact table styles for desktop */
.table-compact {
    font-size: 0.75rem;
    line-height: 1;
}

.table-compact th,
.table-compact td {
    padding: 0.375rem 0.5rem;
    vertical-align: middle;
}

.table-compact th {
    font-weight: 600;
    font-size: 0.7rem;
    text-transform: uppercase;
    letter-spacing: 0.025em;
}

/* Compact badge */
.badge-status {
    font-size: 0.6875rem;
    padding: 0.125rem 0.375rem;
    transition: all 0.2s ease-in-out;
}

.badge-status:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

/* Compact row styling */
.service-row {
    transition: all 0.3s ease;
}

.service-row:hover {
    background-color: #f9fafb;
    transform: translateY(-1px);
    box-shadow: 0 2px 4px -1px rgba(0, 0, 0, 0.1);
}

/* Desktop table layout optimization */
@media (min-width: 1024px) {
    .table-compact {
        table-layout: fixed;
        width: 100%;
    }

    .table-compact th:nth-child(1) { width: 60px; }
    .table-compact th:nth-child(2) { width: 180px; }
    .table-compact th:nth-child(3) { width: 80px; }
    .table-compact th:nth-child(4) { width: 100px; }
    .table-compact th:nth-child(5) { width: 200px; }
    .table-compact th:nth-child(6) { width: 150px; }
    .table-compact th:nth-child(7) { width: 100px; }
    .table-compact th:nth-child(8) { width: 120px; }
}

/* Custom responsive table styles */
@media (max-width: 640px) {
    .table-mobile-card {
        display: block !important;
        border: none !important;
    }

    .table-mobile-card tbody {
        display: block !important;
    }

    .table-mobile-card tr {
        display: block !important;
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        margin-bottom: 16px;
        padding: 16px;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
    }

    .table-mobile-card td {
        display: block !important;
        text-align: left !important;
        border: none !important;
        padding: 4px 0 !important;
    }

    .table-mobile-card td:before {
        content: attr(data-label) ": ";
        font-weight: 600;
        color: #374151;
        display: inline-block;
        width: 120px;
        flex-shrink: 0;
    }

    .table-mobile-card .mobile-flex {
        display: flex !important;
        align-items: flex-start;
        gap: 8px;
    }
}

/* Mobile friendly action buttons */
@media (max-width: 640px) {
    .action-buttons {
        display: flex;
        flex-direction: column;
        gap: 8px;
        margin-top: 12px;
    }

    .action-buttons a,
    .action-buttons button {
        text-align: center;
        padding: 8px 16px;
        border-radius: 6px;
        font-weight: 500;
        transition: all 0.2s;
    }

    .action-buttons .btn-detail {
        background-color: #dbeafe;
        color: #1d4ed8;
    }

    .action-buttons .btn-edit {
        background-color: #dcfce7;
        color: #166534;
    }

    .action-buttons .btn-delete {
        background-color: #fee2e2;
        color: #dc2626;
        border: none;
    }
}

/* Better scrollbar for horizontal scroll */
.table-container::-webkit-scrollbar {
    height: 8px;
}

.table-container::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 4px;
}

.table-container::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 4px;
}

.table-container::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}

/* Loading skeleton animation */
@keyframes shimmer {
    0% {
        background-position: -468px 0;
    }
    100% {
        background-position: 468px 0;
    }
}

.skeleton {
    animation: shimmer 1.2s ease-in-out infinite;
    background: linear-gradient(to right, #f6f7f8 8%, #edeef1 18%, #f6f7f8 33%);
    background-size: 800px 104px;
}

/* Text truncation utilities */
.truncate-sm {
    max-width: 80px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.truncate-md {
    max-width: 120px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.truncate-lg {
    max-width: 160px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
</style>
@endsection
