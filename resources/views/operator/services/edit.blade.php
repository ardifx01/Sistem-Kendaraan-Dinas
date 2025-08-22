@extends('layouts.app')

@section('title', 'Edit Service Kendaraan')

@section('content')
<style>
/* Responsive vehicle select styles */
@media (max-width: 640px) {
    select#vehicle_id {
        font-size: 14px;
        line-height: 1.2;
        padding: 8px 32px 8px 12px;
    }

    select#vehicle_id option {
        padding: 8px 12px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 100%;
    }
}

/* Ensure dropdown doesn't overflow viewport */
select {
    max-width: 100%;
    word-wrap: break-word;
}

/* Custom dropdown arrow positioning */
.select-wrapper {
    position: relative;
}

.select-wrapper select {
    appearance: none;
    background-image: none;
}

/* Improve mobile dropdown visibility */
@media (max-width: 768px) {
    select option {
        font-size: 14px;
        padding: 10px 8px;
    }
}
</style>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-8">
    <!-- Header -->
    <div class="mb-6 sm:mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
            <div class="flex items-center space-x-4">
                <a href="{{ route('operator.services.index') }}"
                   class="text-gray-500 hover:text-gray-700 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <div>
                    <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Edit Service Kendaraan</h1>
                    <p class="mt-1 text-sm text-gray-600">Perbarui data service untuk kendaraan</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <form method="POST" action="{{ route('operator.services.update', $service) }}" enctype="multipart/form-data" class="p-4 sm:p-6 space-y-6">
            @csrf
            @method('PUT')

            <!-- Basic Information -->
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Dasar</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                    <!-- Vehicle -->
                    <div class="sm:col-span-2 relative">
                        <label for="vehicle_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Kendaraan <span class="text-red-500">*</span>
                        </label>

                        <!-- Custom Dropdown -->
                        <div class="relative">
                            <button type="button" id="vehicleDropdownButton"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white text-left cursor-pointer hover:border-gray-400 transition-colors @error('vehicle_id') border-red-500 @enderror">
                                <span id="vehicleSelectedText" class="block truncate text-gray-500">Pilih Kendaraan</span>
                                <span class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <svg id="vehicleDropdownIcon" class="w-5 h-5 text-gray-400 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </span>
                            </button>

                            <!-- Hidden Select -->
                            <select name="vehicle_id" id="vehicle_id" class="sr-only" required>
                                <option value="">Pilih Kendaraan</option>
                                @foreach($vehicles as $vehicle)
                                    <option value="{{ $vehicle->id }}" {{ old('vehicle_id', $service->vehicle_id) == $vehicle->id ? 'selected' : '' }}>
                                        {{ $vehicle->brand }} {{ $vehicle->model }} - {{ $vehicle->license_plate }}
                                        ({{ ucfirst($vehicle->availability_status) }})
                                    </option>
                                @endforeach
                            </select>

                            <!-- Dropdown Menu -->
                            <div id="vehicleDropdownMenu"
                                 class="absolute z-20 w-full mt-1 bg-white border border-gray-300 rounded-md shadow-lg hidden max-h-60 overflow-y-auto">
                                <div class="p-2">
                                    <input type="text" id="vehicleSearch"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                                           placeholder="Cari kendaraan...">
                                </div>
                                <ul id="vehicleOptions" class="py-1">
                                    @foreach($vehicles as $vehicle)
                                        <li class="vehicle-option cursor-pointer px-3 py-2 text-sm hover:bg-gray-100 transition-colors"
                                            data-value="{{ $vehicle->id }}"
                                            data-text="{{ $vehicle->brand }} {{ $vehicle->model }} - {{ $vehicle->license_plate }} ({{ ucfirst($vehicle->availability_status) }})">
                                            <div class="flex items-center justify-between">
                                                <div>
                                                    <div class="font-medium text-gray-900">{{ $vehicle->brand }} {{ $vehicle->model }}</div>
                                                    <div class="text-gray-500 text-xs">{{ $vehicle->license_plate }}</div>
                                                </div>
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                                    @if($vehicle->availability_status === 'available') bg-green-100 text-green-800
                                                    @elseif($vehicle->availability_status === 'in_use') bg-yellow-100 text-yellow-800
                                                    @elseif($vehicle->availability_status === 'maintenance') bg-red-100 text-red-800
                                                    @else bg-gray-100 text-gray-800 @endif">
                                                    {{ ucfirst($vehicle->availability_status) }}
                                                </span>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        @error('vehicle_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Service Date -->
                    <div>
                        <label for="service_date" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Service <span class="text-red-500">*</span></label>
                        <input type="date" name="service_date" id="service_date" value="{{ old('service_date', $service->service_date) }}" required
                               class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('service_date') border-red-500 @else border-gray-300 @enderror">
                        @error('service_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Service Type -->
                    <div>
                        <label for="service_type" class="block text-sm font-medium text-gray-700 mb-2">Jenis Service <span class="text-red-500">*</span></label>
                        <select name="service_type" id="service_type" required
                                class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('service_type') border-red-500 @else border-gray-300 @enderror">
                            <option value="">Pilih Jenis Service</option>
                            <option value="service_rutin" {{ old('service_type', $service->service_type) == 'service_rutin' ? 'selected' : '' }}>Service Rutin</option>
                            <option value="kerusakan" {{ old('service_type', $service->service_type) == 'kerusakan' ? 'selected' : '' }}>Kerusakan</option>
                            <option value="perbaikan" {{ old('service_type', $service->service_type) == 'perbaikan' ? 'selected' : '' }}>Perbaikan</option>
                            <option value="penggantian_part" {{ old('service_type', $service->service_type) == 'penggantian_part' ? 'selected' : '' }}>Penggantian Part</option>
                        </select>
                        @error('service_type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Damage Description -->
                    <div>
                        <label for="damage_description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Kerusakan</label>
                        <textarea name="damage_description" id="damage_description" rows="3"
                                  class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('damage_description') border-red-500 @else border-gray-300 @enderror"
                                  placeholder="Jelaskan kerusakan atau masalah yang ditemukan...">{{ old('damage_description', $service->damage_description) }}</textarea>
                        @error('damage_description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Repair Description -->
                    <div>
                        <label for="repair_description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Perbaikan</label>
                        <textarea name="repair_description" id="repair_description" rows="3"
                                  class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('repair_description') border-red-500 @else border-gray-300 @enderror"
                                  placeholder="Jelaskan perbaikan yang dilakukan...">{{ old('repair_description', $service->repair_description) }}</textarea>
                        @error('repair_description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Parts Replaced -->
                    <div>
                        <label for="parts_replaced" class="block text-sm font-medium text-gray-700 mb-2">Penggantian Part</label>
                        <textarea name="parts_replaced" id="parts_replaced" rows="3"
                                  class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('parts_replaced') border-red-500 @else border-gray-300 @enderror"
                                  placeholder="Daftar part yang diganti (misal: Filter oli, Brake pad, dll)...">{{ old('parts_replaced', $service->parts_replaced) }}</textarea>
                        @error('parts_replaced')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Existing Documents -->
                    @if($service->documents && count($service->documents) > 0)
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Dokumen Saat Ini</label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            @foreach($service->documents as $index => $document)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-md">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <a href="{{ asset('storage/' . $document) }}" target="_blank" class="text-sm text-blue-600 hover:text-blue-800">
                                        {{ basename($document) }}
                                    </a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Upload New Documents -->
                    <div class="sm:col-span-2">
                        <label for="documents" class="block text-sm font-medium text-gray-700 mb-2">Tambah Dokumen Nota Dinas <span class="text-gray-500">(Opsional)</span></label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-gray-400 transition-colors">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="documents" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                        <span>Upload dokumen</span>
                                        <input id="documents" name="documents[]" type="file" class="sr-only" multiple accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                                    </label>
                                    <p class="pl-1">atau drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">PDF, DOC, DOCX, JPG, PNG up to 10MB</p>
                            </div>
                        </div>
                        @error('documents')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <div id="documents-preview" class="mt-2 hidden">
                            <h4 class="text-sm font-medium text-gray-700 mb-2">File yang dipilih:</h4>
                            <div id="documents-list" class="space-y-1"></div>
                        </div>
                    </div>

                    <!-- Existing Photos -->
                    @if($service->photos && count($service->photos) > 0)
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Foto Perbaikan Saat Ini</label>
                        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
                            @foreach($service->photos as $index => $photo)
                            <div class="relative group">
                                <img src="{{ asset('storage/' . $photo) }}" alt="Foto Perbaikan" class="w-full h-24 object-cover rounded-md">
                                <div class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-50 text-white text-xs p-1 rounded-b-md truncate">
                                    {{ basename($photo) }}
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Upload New Photos -->
                    <div class="sm:col-span-2">
                        <label for="photos" class="block text-sm font-medium text-gray-700 mb-2">Tambah Foto Perbaikan</label>
                        <div class="space-y-4">
                            <!-- Camera Option -->
                            <div class="flex items-center justify-center px-6 pt-5 pb-6 border-2 border-blue-300 border-dashed rounded-md hover:border-blue-400 transition-colors bg-blue-50">
                                <div class="text-center">
                                    <svg class="mx-auto h-12 w-12 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 48 48">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h4.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9zM15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <button type="button" id="openCamera" class="mt-2 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h4.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9zM15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        Ambil Foto dengan Kamera
                                    </button>
                                    <p class="text-xs text-blue-600 mt-1">Langsung dari kamera HP/laptop</p>
                                </div>
                            </div>

                            <!-- File Upload Option -->
                            <div class="flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-gray-400 transition-colors">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20v6a2 2 0 002 2h6m0 0v6a2 2 0 002 2h6m0 0h6a2 2 0 002-2v-6m0 0V8a2 2 0 00-2-2h-6m0 0H8a2 2 0 00-2 2v6m0 0v6m0-6h6m6 0h6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="photos" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                            <span>Upload dari galeri</span>
                                            <input id="photos" name="photos[]" type="file" class="sr-only" multiple accept="image/*" capture="environment">
                                        </label>
                                        <p class="pl-1">atau drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500">JPG, PNG, GIF up to 10MB</p>
                                </div>
                            </div>
                        </div>
                        @error('photos')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <div id="photos-preview" class="mt-4 hidden">
                            <h4 class="text-sm font-medium text-gray-700 mb-2">Preview foto:</h4>
                            <div id="photos-grid" class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4"></div>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="sm:col-span-2">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Tambahan</label>
                        <textarea name="description" id="description" rows="4"
                                  class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('description') border-red-500 @else border-gray-300 @enderror"
                                  placeholder="Tambahkan deskripsi detail tentang perbaikan, catatan khusus, atau informasi penting lainnya...">{{ old('description', $service->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Current Status Info -->
            @if($service->status)
            <div class="bg-blue-50 border border-blue-200 rounded-md p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-blue-800">Status Saat Ini</h3>
                        <div class="mt-2 text-sm text-blue-700">
                            <p>Service ini sedang dalam status <strong>{{ ucfirst($service->status) }}</strong>.
                            Mengubah status akan mempengaruhi ketersediaan kendaraan untuk peminjaman.</p>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row items-center justify-end space-y-3 sm:space-y-0 sm:space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('operator.services.show', $service) }}"
                   class="w-full sm:w-auto px-6 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors text-center">
                    Batal
                </a>
                <button type="submit"
                        class="w-full sm:w-auto px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors inline-flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Perbarui Service
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Document Preview Modal -->
<div id="document-preview-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-2 sm:p-4">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-xs sm:max-w-md md:max-w-2xl lg:max-w-4xl xl:max-w-5xl max-h-[95vh] sm:max-h-[90vh] overflow-hidden">
            <div class="flex items-center justify-between p-3 sm:p-4 border-b">
                <h3 class="text-base sm:text-lg font-medium text-gray-900 truncate pr-2" id="document-title">Preview Dokumen</h3>
                <button type="button" id="close-document-preview" class="text-gray-400 hover:text-gray-600 flex-shrink-0">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="p-2 sm:p-4 max-h-[calc(95vh-140px)] sm:max-h-[calc(90vh-120px)] overflow-auto">
                <div id="document-content" class="w-full h-full min-h-[250px] sm:min-h-[400px] flex items-center justify-center">
                    <div class="text-gray-500 text-sm sm:text-base">Memuat dokumen...</div>
                </div>
            </div>
            <div class="flex items-center justify-end p-3 sm:p-4 border-t space-x-2 sm:space-x-3">
                <button type="button" id="download-document" class="px-3 py-2 sm:px-4 sm:py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md text-sm sm:text-base">
                    <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1 sm:mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-4-4m4 4l4-4m6-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="hidden xs:inline">Download</span>
                    <span class="xs:hidden">⬇</span>
                </button>
                <button type="button" id="close-document-modal" class="px-3 py-2 sm:px-4 sm:py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 text-sm sm:text-base">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Camera Modal -->
<div id="camera-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-lg max-w-md w-full">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Ambil Foto</h3>
                    <button type="button" id="close-camera" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <div class="space-y-4">
                    <video id="camera-video" class="w-full h-48 bg-gray-900 rounded-md" autoplay playsinline></video>
                    <canvas id="camera-canvas" class="hidden"></canvas>
                    <div class="flex justify-center space-x-4">
                        <button type="button" id="capture-photo" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md">
                            <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Ambil Foto
                        </button>
                        <button type="button" id="cancel-camera" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50">
                            Batal
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Setup custom vehicle dropdown
    setupVehicleDropdown();

    // Initialize all components
    setupFilePreview();
    setupCamera();
    setupDocumentPreviewModal();
    setupFormValidation();
    setupModalHandlers();

    // Format currency input if exists
    const costInput = document.getElementById('cost');
    if (costInput) {
        costInput.addEventListener('input', function() {
            let value = this.value.replace(/[^\d]/g, '');
            if (value) {
                value = parseInt(value).toLocaleString('id-ID');
                this.setAttribute('data-value', this.value.replace(/[^\d]/g, ''));
            }
        });

        costInput.closest('form').addEventListener('submit', function(e) {
            const rawValue = costInput.value.replace(/[^\d]/g, '');
            costInput.value = rawValue;
        });
    }
});

// Global variables
let mediaStream = null;
let capturedFiles = [];
let documentsFiles = [];

// Custom Vehicle Dropdown Functions
function setupVehicleDropdown() {
    const button = document.getElementById('vehicleDropdownButton');
    const menu = document.getElementById('vehicleDropdownMenu');
    const icon = document.getElementById('vehicleDropdownIcon');
    const selectedText = document.getElementById('vehicleSelectedText');
    const hiddenSelect = document.getElementById('vehicle_id');
    const searchInput = document.getElementById('vehicleSearch');
    const options = document.querySelectorAll('.vehicle-option');

    let isOpen = false;

    // Toggle dropdown
    button.addEventListener('click', function(e) {
        e.preventDefault();
        toggleDropdown();
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        if (!button.contains(e.target) && !menu.contains(e.target)) {
            closeDropdown();
        }
    });

    // Handle option selection
    options.forEach(option => {
        option.addEventListener('click', function() {
            const value = this.dataset.value;
            const text = this.dataset.text;

            hiddenSelect.value = value;
            selectedText.textContent = text;
            selectedText.classList.remove('text-gray-500');
            selectedText.classList.add('text-gray-900');

            closeDropdown();

            // Remove error styling if exists
            button.classList.remove('border-red-500');
        });
    });

    // Search functionality
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();

        options.forEach(option => {
            const text = option.dataset.text.toLowerCase();
            if (text.includes(searchTerm)) {
                option.style.display = 'block';
            } else {
                option.style.display = 'none';
            }
        });
    });

    // Keyboard navigation
    button.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' || e.key === ' ') {
            e.preventDefault();
            toggleDropdown();
        } else if (e.key === 'Escape') {
            closeDropdown();
        }
    });

    function toggleDropdown() {
        if (isOpen) {
            closeDropdown();
        } else {
            openDropdown();
        }
    }

    function openDropdown() {
        menu.classList.remove('hidden');
        icon.style.transform = 'rotate(180deg)';
        searchInput.focus();
        searchInput.value = '';

        // Show all options
        options.forEach(option => {
            option.style.display = 'block';
        });

        isOpen = true;
    }

    function closeDropdown() {
        menu.classList.add('hidden');
        icon.style.transform = 'rotate(0deg)';
        isOpen = false;
    }

    // Set initial value if old value exists
    const oldValue = hiddenSelect.value;
    if (oldValue) {
        const selectedOption = document.querySelector(`[data-value="${oldValue}"]`);
        if (selectedOption) {
            selectedText.textContent = selectedOption.dataset.text;
            selectedText.classList.remove('text-gray-500');
            selectedText.classList.add('text-gray-900');
        }
    }
}

// Setup file upload previews
function setupFilePreview() {
    // Documents upload preview
    const documentsInput = document.getElementById('documents');
    const documentsPreview = document.getElementById('documents-preview');
    const documentsList = document.getElementById('documents-list');

    if (documentsInput) {
        documentsInput.addEventListener('change', function(e) {
            const files = Array.from(e.target.files);
            documentsFiles = files; // Store files for preview
            if (files.length > 0) {
                documentsPreview.classList.remove('hidden');
                documentsList.innerHTML = '';

                files.forEach((file, index) => {
                    const fileItem = document.createElement('div');
                    fileItem.className = 'flex items-center justify-between p-2 bg-gray-50 rounded-md';
                    fileItem.innerHTML = `
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <span class="text-sm text-gray-700">${file.name}</span>
                            <span class="text-xs text-gray-500 ml-2">(${formatFileSize(file.size)})</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <button type="button" onclick="previewDocument(${index})" class="text-blue-500 hover:text-blue-700 text-sm">
                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                Lihat
                            </button>
                            <button type="button" onclick="removeFile('documents', ${index})" class="text-red-500 hover:text-red-700">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    `;
                    documentsList.appendChild(fileItem);
                });
            } else {
                documentsPreview.classList.add('hidden');
            }
        });
    }

    // Photos upload preview
    const photosInput = document.getElementById('photos');
    if (photosInput) {
        photosInput.addEventListener('change', function(e) {
            const files = Array.from(e.target.files);
            if (files.length > 0) {
                // Clear captured files when user uploads from gallery
                capturedFiles = [];

                // Keep only the first file if multiple files selected
                if (files.length > 1) {
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(files[0]); // Only first file
                    this.files = dataTransfer.files;
                }
            }
            updatePhotosPreview();
        });
    }
}

// Setup camera functionality
function setupCamera() {
    const openCameraBtn = document.getElementById('openCamera');
    const closeCameraBtn = document.getElementById('close-camera');
    const cancelCameraBtn = document.getElementById('cancel-camera');
    const captureBtn = document.getElementById('capture-photo');
    const modal = document.getElementById('camera-modal');
    const video = document.getElementById('camera-video');
    const canvas = document.getElementById('camera-canvas');

    if (openCameraBtn) {
        openCameraBtn.addEventListener('click', async function() {
            try {
                mediaStream = await navigator.mediaDevices.getUserMedia({
                    video: {
                        facingMode: 'environment',
                        width: { ideal: 1280 },
                        height: { ideal: 720 }
                    }
                });
                video.srcObject = mediaStream;
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            } catch (error) {
                console.error('Error accessing camera:', error);
                alert('Tidak dapat mengakses kamera. Pastikan izin kamera telah diberikan.');
            }
        });
    }

    function stopCamera() {
        if (mediaStream) {
            mediaStream.getTracks().forEach(track => track.stop());
            mediaStream = null;
        }
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    if (closeCameraBtn) {
        closeCameraBtn.addEventListener('click', stopCamera);
    }

    if (cancelCameraBtn) {
        cancelCameraBtn.addEventListener('click', stopCamera);
    }

    if (captureBtn) {
        captureBtn.addEventListener('click', function() {
            const context = canvas.getContext('2d');
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            context.drawImage(video, 0, 0);

            canvas.toBlob(function(blob) {
                const timestamp = new Date().toISOString().replace(/[:.]/g, '-');
                const file = new File([blob], `camera-photo-${timestamp}.jpg`, { type: 'image/jpeg' });

                // Clear any existing gallery files when capturing from camera
                const photosInput = document.getElementById('photos');
                if (photosInput) {
                    const dataTransfer = new DataTransfer();
                    photosInput.files = dataTransfer.files;
                }

                // Clear any existing captured files and add new one
                capturedFiles = [file];

                // Update preview
                updatePhotosPreview();

                stopCamera();
            }, 'image/jpeg', 0.8);
        });
    }
}

// Update photos preview
function updatePhotosPreview() {
    const photosInput = document.getElementById('photos');
    const photosPreview = document.getElementById('photos-preview');
    const photosGrid = document.getElementById('photos-grid');

    // Get files with priority: gallery files first, then camera files
    const inputFiles = photosInput && photosInput.files ? Array.from(photosInput.files) : [];

    // Use only the first available file (gallery has priority)
    let selectedFile = null;
    let fileSource = '';

    if (inputFiles.length > 0) {
        selectedFile = inputFiles[0]; // First file from gallery
        fileSource = 'gallery';
    } else if (capturedFiles.length > 0) {
        selectedFile = capturedFiles[0]; // First file from camera
        fileSource = 'camera';
    }

    if (selectedFile && selectedFile.type && selectedFile.type.startsWith('image/')) {
        photosPreview.classList.remove('hidden');
        photosGrid.innerHTML = '';

        const reader = new FileReader();
        reader.onload = function(e) {
            const photoItem = document.createElement('div');
            photoItem.className = 'relative group';
            photoItem.innerHTML = `
                <img src="${e.target.result}" alt="Preview" class="w-full h-24 object-cover rounded-md">
                <button type="button" onclick="removeCurrentPhoto()"
                        class="absolute top-1 right-1 bg-red-500 hover:bg-red-600 text-white rounded-full p-1 opacity-75 hover:opacity-100 transition-opacity">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
                <div class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-50 text-white text-xs p-1 rounded-b-md truncate">
                    ${selectedFile.name || 'Camera Photo'} ${fileSource === 'gallery' ? '(Galeri)' : '(Kamera)'}
                </div>
            `;
            photosGrid.appendChild(photoItem);
        };
        reader.readAsDataURL(selectedFile);
    } else {
        photosPreview.classList.add('hidden');
    }
}

// Remove file
function removeFile(inputName, index) {
    const input = document.getElementById(inputName);
    if (input && input.files) {
        const files = Array.from(input.files);
        files.splice(index, 1);

        const dataTransfer = new DataTransfer();
        files.forEach(file => dataTransfer.items.add(file));
        input.files = dataTransfer.files;

        // Update documentsFiles array for preview
        if (inputName === 'documents') {
            documentsFiles = files;
        }

        if (inputName === 'photos') {
            updatePhotosPreview();
        } else {
            input.dispatchEvent(new Event('change'));
        }
    }
}

// Preview document function
function previewDocument(index) {
    if (index >= 0 && index < documentsFiles.length) {
        const file = documentsFiles[index];
        const modal = document.getElementById('document-preview-modal');
        const title = document.getElementById('document-title');
        const content = document.getElementById('document-content');
        const downloadBtn = document.getElementById('download-document');

        title.textContent = file.name;

        // Clear previous content
        content.innerHTML = '<div class="text-gray-500 flex items-center justify-center h-full">Memuat dokumen...</div>';

        // Show modal
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';

        const fileType = file.type.toLowerCase();
        const fileName = file.name.toLowerCase();

        if (fileType.includes('image/') || fileName.match(/\.(jpg|jpeg|png|gif|bmp|webp)$/)) {
            // Preview image
            const reader = new FileReader();
            reader.onload = function(e) {
                content.innerHTML = `
                    <div class="flex justify-center">
                        <img src="${e.target.result}" alt="${file.name}" class="max-w-full max-h-full object-contain">
                    </div>
                `;
            };
            reader.readAsDataURL(file);
        } else if (fileType.includes('pdf') || fileName.endsWith('.pdf')) {
            // Preview PDF with responsive handling
            const reader = new FileReader();
            reader.onload = function(e) {
                const isMobile = window.innerWidth < 768;
                const height = isMobile ? '400px' : '600px';

                content.innerHTML = `
                    <div class="w-full h-full">
                        <embed src="${e.target.result}" type="application/pdf" width="100%" height="${height}" class="rounded-md" />
                        <div class="mt-2 text-xs text-gray-500 text-center sm:hidden">
                            Scroll untuk melihat seluruh dokumen. Gunakan tombol Download untuk membuka di aplikasi PDF.
                        </div>
                    </div>
                `;
            };
            reader.readAsDataURL(file);
        } else if (fileType.includes('text/') || fileName.match(/\.(txt|csv)$/)) {
            // Preview text file
            const reader = new FileReader();
            reader.onload = function(e) {
                content.innerHTML = `
                    <div class="bg-gray-50 p-2 sm:p-4 rounded-md">
                        <pre class="whitespace-pre-wrap text-xs sm:text-sm overflow-auto max-h-96">${e.target.result}</pre>
                    </div>
                `;
            };
            reader.readAsText(file);
        } else {
            // Unsupported file type
            content.innerHTML = `
                <div class="text-center text-gray-500 p-4">
                    <svg class="mx-auto h-12 w-12 sm:h-16 sm:w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <p class="text-base sm:text-lg font-medium">Preview tidak tersedia</p>
                    <p class="text-xs sm:text-sm mt-2 break-words">File ${file.name} tidak dapat di-preview.</p>
                    <p class="text-xs sm:text-sm text-gray-400">Tipe file: ${file.type || 'Unknown'}</p>
                    <p class="text-xs sm:text-sm text-gray-400 mt-2">Gunakan tombol Download untuk mengunduh file.</p>
                </div>
            `;
        }

        // Setup download button
        downloadBtn.onclick = function() {
            const url = URL.createObjectURL(file);
            const a = document.createElement('a');
            a.href = url;
            a.download = file.name;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            URL.revokeObjectURL(url);
        };
    }
}

// Setup document preview modal handlers
function setupDocumentPreviewModal() {
    const modal = document.getElementById('document-preview-modal');
    const closeBtn = document.getElementById('close-document-preview');
    const closeModalBtn = document.getElementById('close-document-modal');

    function closeModal() {
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    if (closeBtn) {
        closeBtn.addEventListener('click', closeModal);
    }

    if (closeModalBtn) {
        closeModalBtn.addEventListener('click', closeModal);
    }

    // Close on backdrop click
    modal.addEventListener('click', function(e) {
        if (e.target === this) {
            closeModal();
        }
    });

    // Close on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
            closeModal();
        }
    });
}

// Remove current photo (single photo logic)
function removeCurrentPhoto() {
    const photosInput = document.getElementById('photos');

    // Clear gallery files
    if (photosInput && photosInput.files && photosInput.files.length > 0) {
        const dataTransfer = new DataTransfer();
        photosInput.files = dataTransfer.files;
    }

    // Clear captured files
    capturedFiles = [];

    // Update preview
    updatePhotosPreview();
}

// Setup form validation
function setupFormValidation() {
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            // Add captured photos to form data before submission
            if (capturedFiles.length > 0) {
                const photosInput = document.getElementById('photos');
                const dataTransfer = new DataTransfer();

                // Add existing files
                if (photosInput.files) {
                    Array.from(photosInput.files).forEach(file => dataTransfer.items.add(file));
                }

                // Add captured files
                capturedFiles.forEach(file => dataTransfer.items.add(file));

                photosInput.files = dataTransfer.files;
            }

            // Validate required fields
            const requiredFields = [
                { id: 'vehicle_id', label: 'Kendaraan' },
                { id: 'service_date', label: 'Tanggal Service' },
                { id: 'service_type', label: 'Jenis Service' }
            ];

            const errors = [];
            requiredFields.forEach(field => {
                const input = document.getElementById(field.id);
                if (!input || !input.value.trim()) {
                    errors.push(`${field.label} harus diisi`);
                    input?.classList.add('border-red-500');
                } else {
                    input?.classList.remove('border-red-500');
                    input?.classList.add('border-gray-300');
                }
            });

            // Validate service date
            const serviceDate = document.getElementById('service_date').value;
            if (serviceDate) {
                const selectedDate = new Date(serviceDate);
                const today = new Date();
                today.setHours(0, 0, 0, 0);

                if (selectedDate > today) {
                    const futureDate = new Date();
                    futureDate.setDate(futureDate.getDate() + 30);

                    if (selectedDate > futureDate) {
                        errors.push('Tanggal service tidak boleh lebih dari 30 hari ke depan');
                    }
                }
            }

            if (errors.length > 0) {
                alert('Error:\n' + errors.join('\n'));
                return;
            }

            // Submit form
            this.submit();
        });
    }
}

// Setup modal handlers
function setupModalHandlers() {
    // Close buttons
    const closeButtons = ['cancelStatus', 'closeValidation', 'closeSuccess', 'closeError'];
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
    const modals = ['statusModal', 'formValidationModal', 'successModal', 'errorModal', 'loadingModal'];
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
}

function hideModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
}

function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}
</script>
@endsection
