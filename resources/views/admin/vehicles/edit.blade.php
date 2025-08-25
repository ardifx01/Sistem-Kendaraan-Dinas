@extends('layouts.app')

@section('title', 'Edit Kendaraan')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.vehicles.index') }}"
                   class="text-gray-500 hover:text-gray-700 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <div>
                    <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Edit Kendaraan</h1>
                    <p class="mt-1 text-sm text-gray-700">{{ $vehicle->brand }} {{ $vehicle->model }} - {{ $vehicle->license_plate }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="card">
        <form method="POST" action="{{ route('admin.vehicles.update', $vehicle) }}" enctype="multipart/form-data" class="p-6 space-y-6" onsubmit="return confirmAndUpdate(event)">
            @csrf
            @method('PUT')

            <!-- Basic Information -->
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Dasar</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                    <!-- Type -->
                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700 mb-2">Jenis Kendaraan</label>
                        <select name="type" id="type" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('type') border-red-500 @enderror">
                            <option value="">Pilih Jenis</option>
                            <option value="motor" {{ old('type', $vehicle->type) == 'motor' ? 'selected' : '' }}>Motor</option>
                            <option value="mobil" {{ old('type', $vehicle->type) == 'mobil' ? 'selected' : '' }}>Mobil</option>
                        </select>
                        @error('type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Brand -->
                    <div>
                        <label for="brand" class="block text-sm font-medium text-gray-700 mb-2">Merk</label>
                        <input type="text" name="brand" id="brand" value="{{ old('brand', $vehicle->brand) }}" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('brand') border-red-500 @enderror"
                               placeholder="Toyota, Honda, dll">
                        @error('brand')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Model -->
                    <div>
                        <label for="model" class="block text-sm font-medium text-gray-700 mb-2">Model</label>
                        <input type="text" name="model" id="model" value="{{ old('model', $vehicle->model) }}" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('model') border-red-500 @enderror"
                               placeholder="Avanza, Beat, dll">
                        @error('model')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Year -->
                    <div>
                        <label for="year" class="block text-sm font-medium text-gray-700 mb-2">Tahun</label>
                        <input type="number" name="year" id="year" value="{{ old('year', $vehicle->year) }}" required
                               min="1990" max="{{ date('Y') + 1 }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('year') border-red-500 @enderror"
                               placeholder="{{ date('Y') }}">
                        @error('year')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- License Plate -->
                    <div>
                        <label for="license_plate" class="block text-sm font-medium text-gray-700 mb-2">Plat Nomor</label>
                        <input type="text" name="license_plate" id="license_plate" value="{{ old('license_plate', $vehicle->license_plate) }}" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('license_plate') border-red-500 @enderror"
                               placeholder="B 1234 ABC" style="text-transform: uppercase;">
                        @error('license_plate')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Color -->
                    <div>
                        <label for="color" class="block text-sm font-medium text-gray-700 mb-2">Warna</label>
                        <input type="text" name="color" id="color" value="{{ old('color', $vehicle->color) }}" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('color') border-red-500 @enderror"
                               placeholder="Hitam, Putih, dll">
                        @error('color')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Document Information -->
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Dokumen</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                    <!-- Tax Expiry Date -->
                    <div>
                        <label for="tax_expiry_date" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Berakhir Pajak</label>
                        <input type="date" name="tax_expiry_date" id="tax_expiry_date" value="{{ old('tax_expiry_date', $vehicle->tax_expiry_date?->format('Y-m-d')) }}" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('tax_expiry_date') border-red-500 @enderror">
                        @error('tax_expiry_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Document Status -->
                    <div>
                        <label for="document_status" class="block text-sm font-medium text-gray-700 mb-2">Status Dokumen</label>
                        <select name="document_status" id="document_status" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('document_status') border-red-500 @enderror">
                            <option value="">Pilih Status</option>
                            <option value="lengkap" {{ old('document_status', $vehicle->document_status) == 'lengkap' ? 'selected' : '' }}>Lengkap</option>
                            <option value="tidak_lengkap" {{ old('document_status', $vehicle->document_status) == 'tidak_lengkap' ? 'selected' : '' }}>Tidak Lengkap</option>
                        </select>
                        @error('document_status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Document Notes -->
                    <div class="md:col-span-2" id="document_notes_container" style="display: {{ old('document_status', $vehicle->document_status) == 'tidak_lengkap' ? 'block' : 'none' }};">
                        <label for="document_notes" class="block text-sm font-medium text-gray-700 mb-2">Catatan Dokumen</label>
                        <textarea name="document_notes" id="document_notes" rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('document_notes') border-red-500 @enderror"
                                  placeholder="Jelaskan dokumen apa yang kurang...">{{ old('document_notes', $vehicle->document_notes) }}</textarea>
                        @error('document_notes')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Additional Information -->
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Tambahan</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Availability Status -->
                    <div>
                        <label for="availability_status" class="block text-sm font-medium text-gray-700 mb-2">Status Ketersediaan</label>
                        <select name="availability_status" id="availability_status" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('availability_status') border-red-500 @enderror">
                            <option value="tersedia" {{ old('availability_status', $vehicle->availability_status) == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                            <option value="dipinjam" {{ old('availability_status', $vehicle->availability_status) == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                            <option value="service" {{ old('availability_status', $vehicle->availability_status) == 'service' ? 'selected' : '' }}>Service</option>
                            <option value="tidak_tersedia" {{ old('availability_status', $vehicle->availability_status) == 'tidak_tersedia' ? 'selected' : '' }}>Tidak Tersedia</option>
                        </select>
                        @error('availability_status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div></div>

                    <!-- Driver Name -->
                    <div>
                        <label for="driver_name" class="block text-sm font-medium text-gray-700 mb-2">Nama Driver</label>
                        <input type="text" name="driver_name" id="driver_name" value="{{ old('driver_name', $vehicle->driver_name) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('driver_name') border-red-500 @enderror"
                               placeholder="Nama driver kendaraan">
                        @error('driver_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- User Name -->
                    <div>
                        <label for="user_name" class="block text-sm font-medium text-gray-700 mb-2">Nama Pengguna</label>
                        <input type="text" name="user_name" id="user_name" value="{{ old('user_name', $vehicle->user_name) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('user_name') border-red-500 @enderror"
                               placeholder="Nama pengguna kendaraan">
                        @error('user_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                        <!-- BPKB Number -->
                        <div>
                            <label for="bpkb_number" class="block text-sm font-medium text-gray-700 mb-2">Nomor BPKB</label>
                            <input type="text" name="bpkb_number" id="bpkb_number" value="{{ old('bpkb_number', $vehicle->bpkb_number) }}" required
                                   maxlength="100"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('bpkb_number') border-red-500 @enderror"
                                   placeholder="Nomor BPKB">
                            @error('bpkb_number')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Chassis Number -->
                        <div>
                            <label for="chassis_number" class="block text-sm font-medium text-gray-700 mb-2">Nomor Rangka</label>
                            <input type="text" name="chassis_number" id="chassis_number" value="{{ old('chassis_number', $vehicle->chassis_number) }}" required
                                   maxlength="100"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('chassis_number') border-red-500 @enderror"
                                   placeholder="Nomor rangka kendaraan">
                            @error('chassis_number')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Engine Number -->
                        <div>
                            <label for="engine_number" class="block text-sm font-medium text-gray-700 mb-2">Nomor Mesin</label>
                            <input type="text" name="engine_number" id="engine_number" value="{{ old('engine_number', $vehicle->engine_number) }}" required
                                   maxlength="100"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('engine_number') border-red-500 @enderror"
                                   placeholder="Nomor mesin kendaraan">
                            @error('engine_number')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- CC Amount -->
                        <div>
                            <label for="cc_amount" class="block text-sm font-medium text-gray-700 mb-2">Isi Silinder (CC)</label>
                            <input type="number" name="cc_amount" id="cc_amount" value="{{ old('cc_amount', $vehicle->cc_amount) }}" required
                                   min="50" max="10000"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('cc_amount') border-red-500 @enderror"
                                   placeholder="Contoh: 1500">
                            @error('cc_amount')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                    <!-- Current Photo -->
                    @if($vehicle->photo)
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Foto Saat Ini</label>
                            <div class="flex items-center space-x-4">
                                <img src="{{ Storage::url($vehicle->photo) }}"
                                     alt="Foto {{ $vehicle->brand }} {{ $vehicle->model }}"
                                     class="h-20 w-20 rounded-lg object-cover border">
                                <div class="text-sm text-gray-600">
                                    <p>Foto saat ini</p>
                                    <p class="text-xs text-gray-500">Pilih foto baru untuk mengganti</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Photo -->
                    <div class="md:col-span-2">
                        <label for="photo" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ $vehicle->photo ? 'Ganti Foto Kendaraan' : 'Foto Kendaraan' }}
                        </label>

                        <!-- Photo Preview Container -->
                        <div id="photo-preview-container" class="hidden mb-4">
                            <div class="relative inline-block">
                                <img id="photo-preview" src="" alt="Preview" class="h-32 w-32 object-cover rounded-lg border-2 border-gray-300">
                                <button type="button" id="remove-photo"
                                        class="absolute -top-2 -right-2 bg-red-500 hover:bg-red-600 text-white rounded-full w-8 h-8 flex items-center justify-center text-sm transition-colors duration-200">
                                    ×
                                </button>
                            </div>
                            <p class="mt-2 text-sm text-gray-600">Preview foto baru yang akan diupload</p>
                        </div>

                        <!-- Upload Area -->
                        <div id="upload-area" class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-gray-400 transition-colors">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex flex-col sm:flex-row justify-center items-center space-y-2 sm:space-y-0 sm:space-x-4">
                                    <label for="photo" class="cursor-pointer bg-indigo-600 text-white px-4 py-2 rounded-md font-medium hover:bg-indigo-700 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500 transition-colors">
                                        <span>📁 {{ $vehicle->photo ? 'Pilih File Baru' : 'Pilih File' }}</span>
                                        <input id="photo" name="photo" type="file" class="sr-only" accept="image/*">
                                    </label>
                                    <button type="button" onclick="openCamera()"
                                            class="bg-green-600 text-white px-6 py-2 rounded-md font-medium hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
                                        <span>📷 Ambil Foto</span>
                                    </button>
                                </div>
                                <p class="text-sm text-gray-600">atau drag and drop file di sini</p>
                                <p class="text-xs text-gray-500">PNG, JPG hingga 5MB</p>
                            </div>
                        </div>
                        @error('photo')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row items-center justify-end space-y-3 sm:space-y-0 sm:space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.vehicles.index') }}"
                   class="w-full sm:w-auto px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors text-center">
                    Batal
                </a>
                <button type="submit"
                        class="w-full sm:w-auto px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200 inline-flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Perbarui Kendaraan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Confirmation Modal -->
<div id="confirmModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 items-center justify-center p-4 hidden z-50">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full transform transition-all">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                </div>
                <h3 class="ml-3 text-lg font-medium text-gray-900">Konfirmasi Perbarui Kendaraan</h3>
            </div>
        </div>
        <div class="px-6 py-4">
            <p class="text-sm text-gray-600 mb-4">Apakah Anda yakin ingin memperbarui data kendaraan berikut?</p>
            <div class="bg-gray-50 rounded-lg p-4 space-y-2">
                <div class="flex justify-between">
                    <span class="font-medium text-gray-700">Merek:</span>
                    <span id="modal-brand" class="text-gray-900">-</span>
                </div>
                <div class="flex justify-between">
                    <span class="font-medium text-gray-700">Model:</span>
                    <span id="modal-model" class="text-gray-900">-</span>
                </div>
                <div class="flex justify-between">
                    <span class="font-medium text-gray-700">Plat Nomor:</span>
                    <span id="modal-license" class="text-gray-900">-</span>
                </div>
                <div class="flex justify-between">
                    <span class="font-medium text-gray-700">Tahun:</span>
                    <span id="modal-year" class="text-gray-900">-</span>
                </div>
            </div>
        </div>
        <div class="px-6 py-4 bg-gray-50 flex flex-col sm:flex-row sm:justify-end space-y-2 sm:space-y-0 sm:space-x-3">
            <button type="button" onclick="closeModal()"
                    class="w-full sm:w-auto px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                Batal
            </button>
            <button type="button" onclick="submitForm()"
                    class="w-full sm:w-auto px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white text-sm font-medium rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition-colors">
                <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Ya, Perbarui
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let formToSubmit = null;

        // Confirm and submit form (Global function for onsubmit)
        window.confirmAndUpdate = function(event) {
            event.preventDefault();
            console.log('confirmAndUpdate called');
            formToSubmit = event.target;

            const brand = document.querySelector('[name="brand"]').value || '-';
            const model = document.querySelector('[name="model"]').value || '-';
            const licensePlate = document.querySelector('[name="license_plate"]').value || '-';
            const year = document.querySelector('[name="year"]').value || '-';

            console.log('Form data:', { brand, model, licensePlate, year });

            // Update modal content
            document.getElementById('modal-brand').textContent = brand;
            document.getElementById('modal-model').textContent = model;
            document.getElementById('modal-license').textContent = licensePlate;
            document.getElementById('modal-year').textContent = year;

            // Show modal
            const modal = document.getElementById('confirmModal');
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                document.body.style.overflow = 'hidden';
                console.log('Modal should be visible now');
            } else {
                console.error('Modal not found!');
            }

            return false;
        };

        // Close modal (Global function for onclick)
        window.closeModal = function() {
            console.log('closeModal called');
            const modal = document.getElementById('confirmModal');
            if (modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                document.body.style.overflow = 'auto';
                formToSubmit = null;
                console.log('Modal closed');
            }
        };

        // Submit form (Global function for onclick)
        window.submitForm = function() {
            console.log('submitForm called');
            if (formToSubmit) {
                console.log('Submitting form...');
                formToSubmit.submit();
            } else {
                console.error('No form to submit!');
            }
        };

        // Camera functionality (Global function for onclick)
        window.openCamera = function() {
            const input = document.createElement('input');
            input.type = 'file';
            input.accept = 'image/*';
            input.capture = 'environment';

            input.onchange = function(event) {
                const file = event.target.files[0];
                if (file) {
                    const photoInput = document.getElementById('photo');
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file);
                    photoInput.files = dataTransfer.files;

                    // Trigger change event
                    const changeEvent = new Event('change', { bubbles: true });
                    photoInput.dispatchEvent(changeEvent);
                }
            };

            input.click();
        };

        // Close modal when clicking outside
        const modal = document.getElementById('confirmModal');
        if (modal) {
            modal.addEventListener('click', function(e) {
                if (e.target === this) {
                    closeModal();
                }
            });
        }

        // Close modal with ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal();
            }
        });

        // Show/hide document notes based on document status
        const documentStatus = document.getElementById('document_status');
        if (documentStatus) {
            documentStatus.addEventListener('change', function() {
                const notesContainer = document.getElementById('document_notes_container');
                if (this.value === 'tidak_lengkap') {
                    notesContainer.style.display = 'block';
                    document.getElementById('document_notes').setAttribute('required', '');
                } else {
                    notesContainer.style.display = 'none';
                    document.getElementById('document_notes').removeAttribute('required');
                }
            });
        }

        // Photo preview functionality
        const photoInput = document.getElementById('photo');
        if (photoInput) {
            photoInput.addEventListener('change', function(event) {
                const file = event.target.files[0];
                const preview = document.getElementById('photo-preview');
                const previewContainer = document.getElementById('photo-preview-container');

                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        previewContainer.classList.remove('hidden');
                    };
                    reader.readAsDataURL(file);
                } else {
                    previewContainer.classList.add('hidden');
                }
            });
        }

        // Remove photo preview
        const removePhotoBtn = document.getElementById('remove-photo');
        if (removePhotoBtn) {
            removePhotoBtn.addEventListener('click', function() {
                const photoInput = document.getElementById('photo');
                const previewContainer = document.getElementById('photo-preview-container');

                photoInput.value = '';
                previewContainer.classList.add('hidden');
            });
        }

        // Auto uppercase license plate
        const licensePlateInput = document.getElementById('license_plate');
        if (licensePlateInput) {
            licensePlateInput.addEventListener('input', function() {
                this.value = this.value.toUpperCase();
            });
        }

        // Drag and drop functionality
        const uploadArea = document.getElementById('upload-area');
        if (uploadArea) {
            uploadArea.addEventListener('dragover', function(e) {
                e.preventDefault();
                e.stopPropagation();
                this.classList.add('border-indigo-500', 'bg-indigo-50');
            });

            uploadArea.addEventListener('dragleave', function(e) {
                e.preventDefault();
                e.stopPropagation();
                this.classList.remove('border-indigo-500', 'bg-indigo-50');
            });

            uploadArea.addEventListener('drop', function(e) {
                e.preventDefault();
                e.stopPropagation();
                this.classList.remove('border-indigo-500', 'bg-indigo-50');

                const files = e.dataTransfer.files;
                if (files.length > 0) {
                    const photoInput = document.getElementById('photo');
                    photoInput.files = files;

                    // Trigger change event
                    const event = new Event('change', { bubbles: true });
                    photoInput.dispatchEvent(event);
                }
            });
        }
    });
</script>
@endpush
@endsection
