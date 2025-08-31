@extends('layouts.app')

@section('title', 'Tambah Service Kendaraan')

@section('content')
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
                    <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Tambah Service Kendaraan</h1>
                    <p class="mt-1 text-sm text-gray-600">Tambahkan data service baru untuk kendaraan</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <form method="POST" action="{{ route('operator.services.store') }}" enctype="multipart/form-data" class="p-4 sm:p-6 space-y-6">
            @csrf

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
                                    <option value="{{ $vehicle->id }}" {{ old('vehicle_id') == $vehicle->id ? 'selected' : '' }}>
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
                        <input type="date" name="service_date" id="service_date" value="{{ old('service_date', date('Y-m-d')) }}" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('service_date') border-red-500 @enderror">
                        @error('service_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Service Type -->
                    <div>
                        <label for="service_type" class="block text-sm font-medium text-gray-700 mb-2">Jenis Service <span class="text-red-500">*</span></label>
                        <select name="service_type" id="service_type" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('service_type') border-red-500 @enderror">
                            <option value="">Pilih Jenis Service</option>
                            <option value="service_rutin" {{ old('service_type') == 'service_rutin' ? 'selected' : '' }}>Service Rutin</option>
                            <option value="kerusakan" {{ old('service_type') == 'kerusakan' ? 'selected' : '' }}>Kerusakan</option>
                            <option value="perbaikan" {{ old('service_type') == 'perbaikan' ? 'selected' : '' }}>Perbaikan</option>
                            <option value="penggantian_part" {{ old('service_type') == 'penggantian_part' ? 'selected' : '' }}>Penggantian Part</option>
                        </select>
                        @error('service_type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Damage Description -->
                    <div>
                        <label for="damage_description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Kerusakan</label>
                        <textarea name="damage_description" id="damage_description" rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('damage_description') border-red-500 @enderror"
                                  placeholder="Jelaskan kerusakan atau masalah yang ditemukan...">{{ old('damage_description') }}</textarea>
                        @error('damage_description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Repair Description -->
                    <div>
                        <label for="repair_description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Perbaikan</label>
                        <textarea name="repair_description" id="repair_description" rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('repair_description') border-red-500 @enderror"
                                  placeholder="Jelaskan perbaikan yang dilakukan...">{{ old('repair_description') }}</textarea>
                        @error('repair_description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Parts Replaced -->
                    <div>
                        <label for="parts_replaced" class="block text-sm font-medium text-gray-700 mb-2">Penggantian Part</label>
                        <textarea name="parts_replaced" id="parts_replaced" rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('parts_replaced') border-red-500 @enderror"
                                  placeholder="Daftar part yang diganti (misal: Filter oli, Brake pad, dll)...">{{ old('parts_replaced') }}</textarea>
                        @error('parts_replaced')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Upload Documents -->
                    <div class="sm:col-span-2">
                        <label for="documents" class="block text-sm font-medium text-gray-700 mb-2">Dokumen Nota Dinas Permohonan Perbaikan <span class="text-gray-500">(Opsional)</span></label>
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

                                <!-- Payment Type -->
                                <div>
                                    <label for="payment_type" class="block text-sm font-medium text-gray-700 mb-2">Pembayaran <span class="text-red-500">*</span></label>
                                    <select name="payment_type" id="payment_type" required
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('payment_type') border-red-500 @enderror">
                                        <option value="">Pilih Jenis Pembayaran</option>
                                        <option value="asuransi" {{ old('payment_type') == 'asuransi' ? 'selected' : '' }}>Asuransi</option>
                                        <option value="kantor" {{ old('payment_type') == 'kantor' ? 'selected' : '' }}>Pembayaran Kantor</option>
                                    </select>
                                    @error('payment_type')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                        </div>
                        @error('documents')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror

                        <!-- Documents Preview -->
                        <div id="documents-preview" class="mt-4 hidden">
                            <h4 class="text-sm font-medium text-gray-700 mb-3">File yang dipilih:</h4>
                            <div id="documents-list" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3"></div>
                        </div>
                    </div>

                    <!-- Upload Photos -->
                    <div class="sm:col-span-2">
                        <label for="photos" class="block text-sm font-medium text-gray-700 mb-2">Foto Perbaikan</label>

                        <!-- Photo upload options -->
                        <div class="space-y-4">
                            <!-- File upload area -->
                            <div class="flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-gray-400 transition-colors">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20v6a2 2 0 002 2h6m0 0v6a2 2 0 002 2h6m0 0h6a2 2 0 002-2v-6m0 0V8a2 2 0 00-2-2h-6m0 0H8a2 2 0 00-2 2v6m0 0v6m0-6h6m6 0h6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="photos" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                            <span>Upload foto</span>
                                            <input id="photos" name="photos[]" type="file" class="sr-only" multiple accept="image/*">
                                        </label>
                                        <p class="pl-1">atau drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500">JPG, PNG, GIF up to 10MB</p>
                                </div>
                            </div>

                            <!-- Camera button -->
                            <div class="flex justify-center">
                                <button type="button" id="openCamera" class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    Ambil Foto dengan Kamera
                                </button>
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
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('description') border-red-500 @enderror"
                                  placeholder="Tambahkan deskripsi detail tentang perbaikan, catatan khusus, atau informasi penting lainnya...">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row items-center justify-end space-y-3 sm:space-y-0 sm:space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('operator.services.index') }}"
                   class="w-full sm:w-auto px-6 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors text-center">
                    Batal
                </a>
                <button type="submit"
                        class="w-full sm:w-auto px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors inline-flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Simpan Service
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
<div id="cameraModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-lg max-w-lg w-full max-h-full overflow-y-auto">
        <div class="flex items-center justify-between p-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Ambil Foto</h3>
            <button type="button" id="closeCameraModal" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div class="p-4">
            <div class="space-y-4">
                <!-- Camera preview -->
                <div class="relative">
                    <video id="cameraPreview" class="w-full rounded-lg bg-gray-100" style="max-height: 300px;" autoplay muted playsinline></video>
                    <canvas id="cameraCanvas" class="hidden"></canvas>
                </div>

                <!-- Camera controls -->
                <div class="flex justify-center space-x-4">
                    <button type="button" id="capturePhoto" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Ambil Foto
                    </button>
                    <button type="button" id="switchCamera" class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Flip
                    </button>
                </div>

                <!-- Captured photo preview -->
                <div id="capturedPhotoPreview" class="hidden">
                    <h4 class="text-sm font-medium text-gray-700 mb-2">Foto yang diambil:</h4>
                    <img id="capturedPhoto" class="w-full rounded-lg" alt="Captured photo">
                    <div class="flex justify-center space-x-4 mt-4">
                        <button type="button" id="retakePhoto" class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-md">
                            Ambil Ulang
                        </button>
                        <button type="button" id="usePhoto" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-md">
                            Gunakan Foto
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

    // Setup file upload previews
    setupFilePreview();

    // Setup camera functionality
    setupCamera();

    // Setup document preview
    setupDocumentPreview();

    // Form validation and submission
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

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

                if (selectedDate < today) {
                    errors.push('Tanggal service tidak boleh kurang dari hari ini');
                } else {
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

            // If validation passes, submit form normally
            this.submit();
        });
    }
});

// Global variables
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

// File upload preview functions
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
                    fileItem.className = 'bg-white border border-gray-200 rounded-lg p-3 hover:shadow-md transition-shadow';

                    const fileIcon = getFileIcon(file.type, file.name);
                    const isImage = file.type.startsWith('image/');

                    fileItem.innerHTML = `
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0">
                                ${fileIcon}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">${file.name}</p>
                                <p class="text-xs text-gray-500">${formatFileSize(file.size)}</p>
                                <div class="mt-2 flex space-x-2">
                                    <button type="button" onclick="previewDocument(${index})"
                                            class="text-xs text-blue-600 hover:text-blue-800 font-medium">
                                        Preview
                                    </button>
                                    <button type="button" onclick="removeFile('documents', ${index})"
                                            class="text-xs text-red-600 hover:text-red-800 font-medium">
                                        Hapus
                                    </button>
                                </div>
                            </div>
                        </div>
                        ${isImage ? `<div class="mt-3">
                            <img src="" alt="Preview" class="w-full h-20 object-cover rounded-md document-preview-img" data-index="${index}">
                        </div>` : ''}
                    `;
                    documentsList.appendChild(fileItem);

                    // Load image preview if it's an image file
                    if (isImage) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const img = fileItem.querySelector('.document-preview-img');
                            if (img) {
                                img.src = e.target.result;
                            }
                        };
                        reader.readAsDataURL(file);
                    }
                });
            } else {
                documentsPreview.classList.add('hidden');
            }
        });
    }

    // Photos upload preview
    const photosInput = document.getElementById('photos');
    const photosPreview = document.getElementById('photos-preview');
    const photosGrid = document.getElementById('photos-grid');

    if (photosInput) {
        photosInput.addEventListener('change', function(e) {
            const files = Array.from(e.target.files);
            if (files.length > 0) {
                photosPreview.classList.remove('hidden');
                photosGrid.innerHTML = '';

                files.forEach((file, index) => {
                    if (file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const photoItem = document.createElement('div');
                            photoItem.className = 'relative group';
                            photoItem.innerHTML = `
                                <img src="${e.target.result}" alt="Preview" class="w-full h-24 object-cover rounded-md cursor-pointer hover:opacity-75 transition-opacity"
                                     onclick="previewImage('${e.target.result}', '${file.name}')">
                                <button type="button" onclick="removeFile('photos', ${index})"
                                        class="absolute top-1 right-1 bg-red-500 hover:bg-red-600 text-white rounded-full p-1 opacity-75 hover:opacity-100 transition-opacity">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                                <div class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-50 text-white text-xs p-1 rounded-b-md truncate">
                                    ${file.name}
                                </div>
                            `;
                            photosGrid.appendChild(photoItem);
                        };
                        reader.readAsDataURL(file);
                    }
                });
            } else {
                photosPreview.classList.add('hidden');
            }
        });
    }
}

function getFileIcon(fileType, fileName) {
    const extension = fileName.split('.').pop().toLowerCase();

    if (fileType.startsWith('image/')) {
        return `<div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M1.5 6a2.25 2.25 0 0 1 2.25-2.25h16.5A2.25 2.25 0 0 1 22.5 6v12a2.25 2.25 0 0 1-2.25 2.25H3.75A2.25 2.25 0 0 1 1.5 18V6ZM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0 0 21 18v-1.94l-2.69-2.689a1.5 1.5 0 0 0-2.12 0l-.88.879.97.97a.75.75 0 1 1-1.06 1.06l-5.16-5.159a1.5 1.5 0 0 0-2.12 0L3 16.061Zm10.125-7.81a1.125 1.125 0 1 1 2.25 0 1.125 1.125 0 0 1-2.25 0Z" clip-rule="evenodd" />
                    </svg>
                </div>`;
    } else if (fileType === 'application/pdf' || extension === 'pdf') {
        return `<div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                    </svg>
                </div>`;
    } else if (extension === 'doc' || extension === 'docx') {
        return `<div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>`;
    } else {
        return `<div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>`;
    }
}

function removeFile(inputName, index) {
    const input = document.getElementById(inputName);
    if (input && input.files) {
        const files = Array.from(input.files);
        files.splice(index, 1);

        // Create new FileList
        const dataTransfer = new DataTransfer();
        files.forEach(file => dataTransfer.items.add(file));
        input.files = dataTransfer.files;

        // Update documentsFiles array for preview
        if (inputName === 'documents') {
            documentsFiles = files;
        }

        // Trigger change event to update preview
        input.dispatchEvent(new Event('change'));
    }
}

function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}

// Document Preview Functions
function setupDocumentPreview() {
    const closeBtn = document.getElementById('close-document-preview');
    const closeModalBtn = document.getElementById('close-document-modal');
    const modal = document.getElementById('document-preview-modal');

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

function previewImage(src, name) {
    const modal = document.getElementById('document-preview-modal');
    const title = document.getElementById('document-title');
    const content = document.getElementById('document-content');

    title.textContent = name;
    content.innerHTML = `
        <div class="w-full h-full flex items-center justify-center">
            <img src="${src}" alt="${name}" class="max-w-full max-h-full object-contain rounded-lg shadow-lg">
        </div>
    `;

    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

// Camera functionality (use file-input capture for broader compatibility)
function setupCamera() {
    const openCameraBtn = document.getElementById('openCamera');
    const photosInput = document.getElementById('photos');

    if (!openCameraBtn || !photosInput) return;

    openCameraBtn.addEventListener('click', function() {
        // Create a temporary file input that requests the device camera
        const input = document.createElement('input');
        input.type = 'file';
        input.accept = 'image/*';
        input.capture = 'environment';

        input.addEventListener('change', function(e) {
            const file = e.target.files && e.target.files[0];
            if (!file) return;

            // Append captured file to existing photos[] input
            const dt = new DataTransfer();
            Array.from(photosInput.files || []).forEach(f => dt.items.add(f));
            dt.items.add(file);
            photosInput.files = dt.files;

            // Trigger change to update previews
            photosInput.dispatchEvent(new Event('change'));
        });

        input.click();
    });
}
</script>
@endsection
