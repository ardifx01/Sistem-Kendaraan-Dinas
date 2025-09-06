@extends('layouts.app')

@section('title', 'Edit Kendaraan')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center space-x-4">
            <a href="{{ route('operator.vehicles.index') }}" class="text-gray-500 hover:text-gray-700 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Edit Kendaraan</h1>
                <p class="mt-2 text-sm text-gray-700">Perbarui data kendaraan</p>
            </div>
        </div>
    </div>

    <div class="card">
        <form method="POST" action="{{ route('operator.vehicles.update', $vehicle) }}" enctype="multipart/form-data" class="p-6 space-y-6" onsubmit="return confirmAndSubmit(event)">
            @csrf
            @method('PUT')

            <!-- Basic Information -->
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Dasar</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700 mb-2">Jenis Kendaraan</label>
                        <select name="type" id="type" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('type') border-red-500 @enderror">
                            <option value="">Pilih Jenis</option>
                            <option value="motor" {{ old('type', $vehicle->type) == 'motor' ? 'selected' : '' }}>Motor</option>
                            <option value="mobil" {{ old('type', $vehicle->type) == 'mobil' ? 'selected' : '' }}>Mobil</option>
                        </select>
                        @error('type')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="brand" class="block text-sm font-medium text-gray-700 mb-2">Merk</label>
                        <input type="text" name="brand" id="brand" value="{{ old('brand', $vehicle->brand) }}" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('brand') border-red-500 @enderror" placeholder="Toyota, Honda, dll">
                        @error('brand')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="model" class="block text-sm font-medium text-gray-700 mb-2">Model</label>
                        <input type="text" name="model" id="model" value="{{ old('model', $vehicle->model) }}" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('model') border-red-500 @enderror" placeholder="Avanza, Beat, dll">
                        @error('model')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="year" class="block text-sm font-medium text-gray-700 mb-2">Tahun</label>
                        <input type="number" name="year" id="year" value="{{ old('year', $vehicle->year) }}" required min="1990" max="{{ date('Y') + 1 }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('year') border-red-500 @enderror">
                        @error('year')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="license_plate" class="block text-sm font-medium text-gray-700 mb-2">Plat Nomor</label>
                        <input type="text" name="license_plate" id="license_plate" value="{{ old('license_plate', $vehicle->license_plate) }}" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('license_plate') border-red-500 @enderror" placeholder="B 1234 ABC" style="text-transform: uppercase;">
                        @error('license_plate')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="color" class="block text-sm font-medium text-gray-700 mb-2">Warna</label>
                        <input type="text" name="color" id="color" value="{{ old('color', $vehicle->color) }}" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('color') border-red-500 @enderror" placeholder="Hitam, Putih, dll">
                        @error('color')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            <!-- Document Information -->
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Dokumen</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="tax_expiry_date" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Berakhir Pajak</label>
                        <input type="date" name="tax_expiry_date" id="tax_expiry_date" value="{{ old('tax_expiry_date', optional($vehicle->tax_expiry_date)->format('Y-m-d')) }}" required min="{{ date('Y-m-d', strtotime('+1 day')) }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('tax_expiry_date') border-red-500 @enderror">
                        @error('tax_expiry_date')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="document_status" class="block text-sm font-medium text-gray-700 mb-2">Status Dokumen</label>
                        <select name="document_status" id="document_status" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('document_status') border-red-500 @enderror">
                            <option value="">Pilih Status</option>
                            <option value="lengkap" {{ old('document_status', $vehicle->document_status) == 'lengkap' ? 'selected' : '' }}>Lengkap</option>
                            <option value="tidak_lengkap" {{ old('document_status', $vehicle->document_status) == 'tidak_lengkap' ? 'selected' : '' }}>Tidak Lengkap</option>
                        </select>
                        @error('document_status')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div class="md:col-span-2" id="document_notes_container" style="display: {{ old('document_status', $vehicle->document_status) == 'tidak_lengkap' ? 'block' : 'none' }};">
                        <label for="document_notes" class="block text-sm font-medium text-gray-700 mb-2">Catatan Dokumen</label>
                        <textarea name="document_notes" id="document_notes" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('document_notes') border-red-500 @enderror" placeholder="Jelaskan dokumen apa yang kurang...">{{ old('document_notes', $vehicle->document_notes) }}</textarea>
                        @error('document_notes')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            <!-- Additional Information -->
            <div>
                <label for="availability_status" class="block text-sm font-medium text-gray-700 mb-2">Status Kendaraan</label>
                <select name="availability_status" id="availability_status" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('availability_status') border-red-500 @enderror">
                    <option value="">Pilih Status</option>
                    <option value="tersedia" {{ old('availability_status', $vehicle->availability_status) == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                    <option value="dipinjam" {{ old('availability_status', $vehicle->availability_status) == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                    <option value="service" {{ old('availability_status', $vehicle->availability_status) == 'service' ? 'selected' : '' }}>Service</option>
                    <option value="digunakan_pejabat" {{ old('availability_status', $vehicle->availability_status) == 'digunakan_pejabat' ? 'selected' : '' }}>Digunakan Pejabat/Operasional</option>
                </select>
                <p class="text-sm text-gray-500">Bila Kendaraan Tidak Memiliki Pengemudi Pilih Status Tersedia</p>
                @error('availability_status')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Tambahan</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="driver_name" class="block text-sm font-medium text-gray-700 mb-2">Nama Driver</label>
                        <input type="text" name="driver_name" id="driver_name" value="{{ old('driver_name', $vehicle->driver_name) }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('driver_name') border-red-500 @enderror" placeholder="Nama driver kendaraan">
                        @error('driver_name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="user_name" class="block text-sm font-medium text-gray-700 mb-2">Nama Pengguna</label>
                        <input type="text" name="user_name" id="user_name" value="{{ old('user_name', $vehicle->user_name) }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('user_name') border-red-500 @enderror" placeholder="Nama pengguna kendaraan">
                        @error('user_name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <!-- Kedudukan Kendaraan -->
                    <div>
                        <label for="kedudukan" class="block text-sm font-medium text-gray-700 mb-2">Kedudukan Kendaraan</label>
                        <select name="kedudukan" id="kedudukan" class="w-full px-3 py-2 border border-gray-300 rounded-md" onchange="toggleKedudukan(this.value)">
                            <option value="">Pilih Kedudukan</option>
                            <option value="BMN" {{ old('kedudukan', $vehicle->kedudukan) == 'BMN' ? 'selected' : '' }}>BMN</option>
                            <option value="Sewa" {{ old('kedudukan', $vehicle->kedudukan) == 'Sewa' ? 'selected' : '' }}>Sewa</option>
                            <option value="Lainnya" {{ old('kedudukan', $vehicle->kedudukan) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                        @error('kedudukan')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div id="kedudukan_detail_container" style="display: {{ old('kedudukan', $vehicle->kedudukan) ? 'block' : 'none' }};" class="md:col-span-2">
                        <label for="kedudukan_detail" class="block text-sm font-medium text-gray-700 mb-2">Rincian Kedudukan (Nomor BMN / Nama Penyewa / Keterangan lain)</label>
                        <input type="text" name="kedudukan_detail" id="kedudukan_detail" value="{{ old('kedudukan_detail', $vehicle->kedudukan_detail) }}" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                        @error('kedudukan_detail')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <script>
                    (function(){
                        var sel = document.getElementById('kedudukan');
                        var cont = document.getElementById('kedudukan_detail_container');
                        var inp = document.getElementById('kedudukan_detail');
                        function update(v){
                            console.log('[kedudukan-edit] update called, value=', v);
                            if(v){
                                if(cont) cont.style.display = '';
                                if(inp){ inp.setAttribute('required','required');
                                    if(v === 'BMN') inp.placeholder = 'Nomor BMN atau Tahun BMN';
                                    else if(v === 'Sewa') inp.placeholder = 'Nama perusahaan penyewa';
                                    else inp.placeholder = 'Keterangan lain';
                                }
                            } else {
                                if(cont) cont.style.display = 'none';
                                if(inp){ inp.removeAttribute('required'); inp.value = ''; }
                            }
                        }
                        if(sel){ sel.addEventListener('change', function(){ update(this.value); }); update(sel.value || ''); }
                    })();
                    </script>

                    <script>
                    // global helper so edit page can call toggleKedudukan directly
                    window.toggleKedudukan = function(v){
                        var cont = document.getElementById('kedudukan_detail_container');
                        var inp = document.getElementById('kedudukan_detail');
                        if(v){ if(cont) cont.style.display = ''; if(inp){ inp.setAttribute('required','required'); if(v==='BMN') inp.placeholder='Nomor BMN atau Tahun BMN'; else if(v==='Sewa') inp.placeholder='Nama perusahaan penyewa'; else inp.placeholder='Keterangan lain'; } }
                        else { if(cont) cont.style.display = 'none'; if(inp){ inp.removeAttribute('required'); inp.value=''; } }
                    };
                    </script>

                    <div>
                        <label for="bpkb_number" class="block text-sm font-medium text-gray-700 mb-2">Nomor BPKB</label>
                        <input type="text" name="bpkb_number" id="bpkb_number" value="{{ old('bpkb_number', $vehicle->bpkb_number) }}" required maxlength="100" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('bpkb_number') border-red-500 @enderror" placeholder="Nomor BPKB">
                        @error('bpkb_number')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="chassis_number" class="block text-sm font-medium text-gray-700 mb-2">Nomor Rangka</label>
                        <input type="text" name="chassis_number" id="chassis_number" value="{{ old('chassis_number', $vehicle->chassis_number) }}" required maxlength="100" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('chassis_number') border-red-500 @enderror" placeholder="Nomor rangka kendaraan">
                        @error('chassis_number')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="engine_number" class="block text-sm font-medium text-gray-700 mb-2">Nomor Mesin</label>
                        <input type="text" name="engine_number" id="engine_number" value="{{ old('engine_number', $vehicle->engine_number) }}" required maxlength="100" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('engine_number') border-red-500 @enderror" placeholder="Nomor mesin kendaraan">
                        @error('engine_number')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="cc_amount" class="block text-sm font-medium text-gray-700 mb-2">Isi Silinder (CC)</label>
                        <input type="number" name="cc_amount" id="cc_amount" value="{{ old('cc_amount', $vehicle->cc_amount) }}" required min="50" max="10000" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('cc_amount') border-red-500 @enderror" placeholder="Contoh: 1500">
                        @error('cc_amount')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <!-- Current Photo -->
                    @if($vehicle->photo)
                        <div class="md:col-span-2" id="current-photo-wrapper">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Foto Saat Ini</label>
                            <div class="flex items-center space-x-4">
                                <img src="{{ Storage::url($vehicle->photo) }}" alt="Foto {{ $vehicle->brand }} {{ $vehicle->model }}" class="h-20 w-20 rounded-lg object-cover border">
                                <div class="text-sm text-gray-600">
                                    <p>Foto saat ini</p>
                                    <p class="text-xs text-gray-500">Pilih foto baru untuk mengganti</p>
                                </div>
                                <div class="ml-4">
                                    <button type="button" id="remove-existing-photo" title="Hapus Foto" class="inline-flex items-center px-3 py-1 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                        <!-- trash icon -->
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                        Hapus Foto
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Photo upload area (same as admin) -->
                    <div class="md:col-span-2">
                        <label for="photo" class="block text-sm font-medium text-gray-700 mb-2">Foto Kendaraan</label>
                        <div id="upload-area" class="border-2 border-dashed border-gray-300 rounded-md p-6 flex flex-col items-center justify-center mb-4" style="min-height:160px;">
                            <svg class="mx-auto h-12 w-12 text-gray-400 mb-2" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <label for="photo" class="text-blue-600 font-medium cursor-pointer hover:underline">Upload foto</label>
                            <input id="photo" name="photo" type="file" accept="image/*" capture="environment" style="display:none;">
                            <span class="text-gray-500 text-sm mt-2">atau drag and drop</span>
                            <span class="text-xs text-gray-400 mt-1">PNG, JPG hingga 5MB</span>
                        </div>
                        @error('photo')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        <div class="flex justify-center">
                            <button type="button" id="openCamera" class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                Ambil Foto dengan Kamera
                            </button>
                        </div>
                        <div id="photo-preview-container" style="display:none;" class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Preview foto:</label>
                            <div style="position:relative;display:inline-block;">
                                <img id="photo-preview" src="" alt="Preview" style="height:80px;width:120px;object-fit:cover;border-radius:8px;border:2px solid #e5e7eb;">
                                <button type="button" id="remove-photo-preview" style="position:absolute;top:4px;right:4px;background:#ef4444;color:#fff;border:none;border-radius:50%;width:24px;height:24px;display:flex;align-items:center;justify-content:center;cursor:pointer;" title="Hapus Foto">&times;</button>
                            </div>
                            <div id="photo-preview-filename" class="text-xs text-gray-700 mt-1"></div>
                        </div>
                        <input type="hidden" name="photo_data" id="photo_data">
                        <input type="hidden" name="remove_existing_photo" id="remove_existing_photo" value="0">
                        <p class="text-xs text-gray-500 mt-1">PNG, JPG hingga 5MB. Bisa ambil langsung dari kamera (desktop & mobile) atau pilih file.</p>

                        <!-- Camera Modal (admin-style) - copied from create view -->
                        <div id="cameraModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 items-center justify-center p-4">
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
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-end space-y-3 sm:space-y-0 sm:space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('operator.vehicles.index') }}" class="w-full sm:w-auto px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors text-center">
                    Kembali
                </a>

                <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-3">
                    <button type="button" onclick="confirmDelete()" class="w-full sm:w-auto px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors justify-center flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Hapus Kendaraan
                    </button>

                    <button type="submit" class="w-full sm:w-auto btn btn-primary justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Perbarui Kendaraan
                    </button>
                </div>
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
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="ml-3 text-lg font-medium text-gray-900">Konfirmasi Perbarui Kendaraan</h3>
            </div>
        </div>
        <div class="px-6 py-4">
            <p class="text-sm text-gray-600 mb-4">Apakah Anda yakin ingin memperbarui kendaraan dengan data berikut?</p>
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
        <div class="px-6 py-4 border-t border-gray-200 flex justify-end space-x-3">
            <button type="button" onclick="hideConfirmModal()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md">Batal</button>
            <button type="button" onclick="submitForm()" class="px-4 py-2 btn btn-primary">Ya, Perbarui</button>
        </div>
    </div>
</div>

@push('scripts')
<script>
function confirmAndSubmit(e){ e.preventDefault(); document.getElementById('modal-brand').innerText = document.getElementById('brand').value || '-'; document.getElementById('modal-model').innerText = document.getElementById('model').value || '-'; document.getElementById('modal-license').innerText = document.getElementById('license_plate').value || '-'; document.getElementById('modal-year').innerText = document.getElementById('year').value || '-'; document.getElementById('confirmModal').classList.remove('hidden'); return false; }
function hideConfirmModal(){ document.getElementById('confirmModal').classList.add('hidden'); }
function submitForm(){ document.querySelector('form[onsubmit]').submit(); }

// Delete confirmation (submit delete form)
function confirmDelete(){ if(confirm('Hapus kendaraan ini? Tindakan tidak bisa dibatalkan')){ var f = document.createElement('form'); f.method='POST'; f.action='{{ route("operator.vehicles.destroy", $vehicle) }}'; var token=document.createElement('input'); token.type='hidden'; token.name='_token'; token.value='{{ csrf_token() }}'; var method=document.createElement('input'); method.type='hidden'; method.name='_method'; method.value='DELETE'; f.appendChild(token); f.appendChild(method); document.body.appendChild(f); f.submit(); } }

// show/hide document notes and set up camera + preview handlers
document.addEventListener('DOMContentLoaded', function(){
    var docStatus = document.getElementById('document_status');
    if(docStatus){
        docStatus.addEventListener('change', function(){ var c = document.getElementById('document_notes_container'); c.style.display = this.value === 'tidak_lengkap' ? 'block' : 'none'; });
    }

    // Elements
    const photoInput = document.getElementById('photo');
    const previewContainer = document.getElementById('photo-preview-container');
    const previewImg = document.getElementById('photo-preview');
    const previewFilename = document.getElementById('photo-preview-filename');
    const uploadArea = document.getElementById('upload-area');
    const removePreviewBtn = document.getElementById('remove-photo-preview');
    const currentPhotoWrapper = document.getElementById('current-photo-wrapper');
    const removeExistingBtn = document.getElementById('remove-existing-photo');
    const removeExistingHidden = document.getElementById('remove_existing_photo');

    function showPreview(file, dataUrl) {
        if (!previewImg || !previewContainer) return;
        previewImg.src = dataUrl;
        previewContainer.style.display = 'block';
        if (previewFilename) previewFilename.innerText = file.name || '';
        // When a new preview is shown, hide the existing stored photo (if any)
        if (currentPhotoWrapper) currentPhotoWrapper.style.display = 'none';
        if (removeExistingHidden) removeExistingHidden.value = '0';
    }

    if (photoInput) {
        photoInput.addEventListener('change', function(e) {
            const file = e.target.files && e.target.files[0];
            if (!file) return;
            if (!file.type.startsWith('image/')) { alert('File harus berupa gambar!'); photoInput.value = ''; return; }
            if (file.size > 5 * 1024 * 1024) { alert('Ukuran file maksimal 5MB!'); photoInput.value = ''; return; }
            const reader = new FileReader();
            reader.onload = function(evt) { showPreview(file, evt.target.result); };
            reader.readAsDataURL(file);
            // clear photo_data when user selects file
            const photoData = document.getElementById('photo_data'); if (photoData) photoData.value = '';
        });
    }

    if (removePreviewBtn) {
        removePreviewBtn.addEventListener('click', function() {
            if (photoInput) photoInput.value = '';
            if (previewContainer) previewContainer.style.display = 'none';
            if (uploadArea) uploadArea.classList.remove('hidden');
            if (previewImg) previewImg.src = '';
            if (previewFilename) previewFilename.innerText = '';
            const photoData = document.getElementById('photo_data'); if (photoData) photoData.value = '';
            // If there was an original photo, show it again
            if (currentPhotoWrapper) currentPhotoWrapper.style.display = '';
            if (removeExistingHidden) removeExistingHidden.value = '0';
        });
    }

    if (removeExistingBtn) {
        removeExistingBtn.addEventListener('click', function(){
            if (confirm('Hapus foto saat ini?')){
                if (currentPhotoWrapper) currentPhotoWrapper.style.display = 'none';
                if (removeExistingHidden) removeExistingHidden.value = '1';
                // ensure upload area is visible so user can add new photo
                if (uploadArea) uploadArea.classList.remove('hidden');
            }
        });
    }

    if (uploadArea) {
        uploadArea.addEventListener('dragover', function(e) { e.preventDefault(); e.stopPropagation(); this.classList.add('border-indigo-500', 'bg-indigo-50'); });
        uploadArea.addEventListener('dragleave', function(e) { e.preventDefault(); e.stopPropagation(); this.classList.remove('border-indigo-500', 'bg-indigo-50'); });
        uploadArea.addEventListener('drop', function(e) {
            e.preventDefault(); e.stopPropagation(); this.classList.remove('border-indigo-500', 'bg-indigo-50');
            const files = e.dataTransfer.files; if (!files || files.length === 0) return;
            if (photoInput) { photoInput.files = files; photoInput.dispatchEvent(new Event('change')); }
        });
    }

    // Camera modal (admin-style) setup
    (function(){
        let currentStream = null;
        let currentFacingMode = 'environment';

        const openCameraBtn = document.getElementById('openCamera');
        const cameraModal = document.getElementById('cameraModal');
        const closeCameraBtn = document.getElementById('closeCameraModal');
        const cameraPreview = document.getElementById('cameraPreview');
        const cameraCanvas = document.getElementById('cameraCanvas');
        const captureBtn = document.getElementById('capturePhoto');
        const switchCameraBtn = document.getElementById('switchCamera');
        const capturedPhotoPreview = document.getElementById('capturedPhotoPreview');
        const capturedPhoto = document.getElementById('capturedPhoto');
        const retakeBtn = document.getElementById('retakePhoto');
        const usePhotoBtn = document.getElementById('usePhoto');

        function startCamera(){
            const constraints = { video: { facingMode: currentFacingMode, width: { ideal: 1280 }, height: { ideal: 720 } } };
            return navigator.mediaDevices.getUserMedia(constraints).then(stream=>{ currentStream = stream; cameraPreview.srcObject = stream; });
        }

        function stopCamera(){ if(currentStream){ currentStream.getTracks().forEach(t=>t.stop()); currentStream = null; } }

        function showModal(){ if(cameraModal){ cameraModal.classList.remove('hidden'); cameraModal.classList.add('flex'); document.body.style.overflow = 'hidden'; } }
        function hideModal(){ if(cameraModal){ cameraModal.classList.add('hidden'); cameraModal.classList.remove('flex'); document.body.style.overflow = 'auto'; } }

        if(openCameraBtn){
            openCameraBtn.addEventListener('click', async function(){
                if(!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia){
                    return fallbackToFileInput();
                }

                try{ await startCamera(); showModal(); }catch(err){ console.error('Error accessing camera:', err); return fallbackToFileInput(); }
            });
        }

        if(closeCameraBtn) closeCameraBtn.addEventListener('click', function(){ stopCamera(); hideModal(); resetCameraModal(); });

        if(captureBtn) captureBtn.addEventListener('click', function(){ const ctx = cameraCanvas.getContext('2d'); cameraCanvas.width = cameraPreview.videoWidth; cameraCanvas.height = cameraPreview.videoHeight; ctx.drawImage(cameraPreview,0,0); const dataURL = cameraCanvas.toDataURL('image/jpeg',0.8); capturedPhoto.src = dataURL; cameraPreview.style.display = 'none'; captureBtn.style.display = 'none'; switchCameraBtn.style.display = 'none'; capturedPhotoPreview.classList.remove('hidden'); });

        if(switchCameraBtn) switchCameraBtn.addEventListener('click', async function(){ currentFacingMode = currentFacingMode === 'environment' ? 'user' : 'environment'; try{ stopCamera(); await startCamera(); }catch(e){ console.error(e); } });

        if(retakeBtn) retakeBtn.addEventListener('click', function(){ resetCameraModal(); startCamera(); });

        function resetCameraModal(){ if(cameraPreview){ cameraPreview.style.display = 'block'; } if(captureBtn){ captureBtn.style.display = 'inline-flex'; } if(switchCameraBtn){ switchCameraBtn.style.display = 'inline-flex'; } if(capturedPhotoPreview){ capturedPhotoPreview.classList.add('hidden'); } if(capturedPhoto){ capturedPhoto.src = ''; } }

    function addCapturedPhotoToInput(){ const dataURL = capturedPhoto.src; fetch(dataURL).then(res=>res.blob()).then(blob=>{ const file = new File([blob], `camera_photo_${Date.now()}.jpg`, { type: 'image/jpeg' }); if(photoInput){ const dataTransfer = new DataTransfer(); dataTransfer.items.add(file); photoInput.files = dataTransfer.files; photoInput.dispatchEvent(new Event('change')); } }); }

    function fallbackToFileInput(){ const input = document.createElement('input'); input.type='file'; input.accept='image/*'; input.capture='environment'; input.onchange=function(e){ const file=e.target.files[0]; if(file){ const dt=new DataTransfer(); dt.items.add(file); if(photoInput){ photoInput.files=dt.files; photoInput.dispatchEvent(new Event('change')); } } }; input.click(); }

        if(usePhotoBtn) usePhotoBtn.addEventListener('click', function(){ addCapturedPhotoToInput(); stopCamera(); hideModal(); resetCameraModal(); });
    })();

});
// show/hide kedudukan detail (mirror document_status behavior)
document.addEventListener('DOMContentLoaded', function(){
    var kedSelect = document.getElementById('kedudukan');
    var kedContainer = document.getElementById('kedudukan_detail_container');
    var kedInput = document.getElementById('kedudukan_detail');
    if(kedSelect){
        if(kedSelect.value){ if(kedContainer) kedContainer.style.display = 'block'; if(kedInput) kedInput.setAttribute('required','required'); }
        else { if(kedContainer) kedContainer.style.display = 'none'; if(kedInput) kedInput.removeAttribute('required'); }
        kedSelect.addEventListener('change', function(){ if(this.value){ if(kedContainer) kedContainer.style.display = 'block'; if(kedInput) kedInput.setAttribute('required','required'); } else { if(kedContainer) kedContainer.style.display = 'none'; if(kedInput){ kedInput.removeAttribute('required'); kedInput.value = ''; } } });
    }
});
// show/hide kedudukan detail
document.addEventListener('DOMContentLoaded', function(){
    var ked = document.getElementById('kedudukan');
    if(ked){
        ked.addEventListener('change', function(){
            var c = document.getElementById('kedudukan_detail_container');
            c.style.display = this.value ? 'block' : 'none';
        });
    }
});
</script>
@endpush

@endsection
