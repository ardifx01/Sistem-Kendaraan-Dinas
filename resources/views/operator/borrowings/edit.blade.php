@extends('layouts.app')

@section('title', 'Edit Peminjaman Kendaraan')

@section('content')
<div class="max-w-6xl mx-auto px-2 sm:px-4 lg:px-6 py-2 sm:py-4">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-3">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Edit Peminjaman Kendaraan</h1>
            <p class="mt-1 text-xs text-gray-600">Perbarui data pengajuan peminjaman kendaraan dinas</p>
        </div>
        <div class="flex items-center space-x-2 mt-2 sm:mt-0">
            <a href="{{ route('operator.borrowings.show', $borrowing) }}"
               class="inline-flex items-center px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium rounded-md shadow-sm transition-colors duration-200">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
                Lihat Detail
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

    <!-- Info Alert -->
    <div class="bg-orange-50 border border-orange-200 rounded-md p-2 mb-3">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <svg class="w-4 h-4 text-orange-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
            </div>
            <div class="ml-2">
                <h3 class="text-xs font-medium text-orange-800">Perhatian</h3>
                <p class="text-xs text-orange-700 mt-0.5">
                    Anda sedang mengedit pengajuan peminjaman. Pastikan semua perubahan sudah benar sebelum menyimpan.
                    Status peminjaman saat ini: <strong>{{ ucfirst($borrowing->status) }}</strong>
                </p>
            </div>
        </div>
    </div>

    <!-- Form Section -->
    <form action="{{ route('operator.borrowings.update', $borrowing) }}" method="POST" enctype="multipart/form-data" id="borrowingForm" class="space-y-4">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            <!-- Left Column -->
            <div class="space-y-4">
                <!-- Borrower Information Card -->
                <div class="bg-white rounded-md shadow-sm border border-gray-200 p-3 sm:p-4">
                    <h3 class="text-sm font-semibold text-gray-900 mb-3 flex items-center">
                        <svg class="w-4 h-4 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Informasi Peminjam
                    </h3>

                    <!-- Borrower Type -->
                    <div class="space-y-2">
                        <label class="block text-xs font-medium text-gray-700">
                            Tipe Peminjam <span class="text-red-500">*</span>
                        </label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                            <label class="relative flex items-center">
                                <input type="radio" name="borrower_type" value="internal"
                                       class="sr-only peer"
                                       {{ old('borrower_type', $borrowing->borrower_type) == 'internal' ? 'checked' : '' }} required>
                                <div class="w-full px-3 py-2 text-xs border border-gray-300 rounded-md cursor-pointer transition-all duration-200
                                            peer-checked:bg-blue-50 peer-checked:border-blue-500 peer-checked:text-blue-700
                                            hover:border-blue-400 flex items-center justify-center">
                                    <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    Internal (Pegawai)
                                </div>
                            </label>
                            <label class="relative flex items-center">
                                <input type="radio" name="borrower_type" value="eksternal"
                                       class="sr-only peer"
                                       {{ old('borrower_type', $borrowing->borrower_type) == 'eksternal' ? 'checked' : '' }} required>
                                <div class="w-full px-3 py-2 text-xs border border-gray-300 rounded-md cursor-pointer transition-all duration-200
                                            peer-checked:bg-orange-50 peer-checked:border-orange-500 peer-checked:text-orange-700
                                            hover:border-orange-400 flex items-center justify-center">
                                    <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                    Eksternal (Tamu)
                                </div>
                            </label>
                        </div>
                        @error('borrower_type')
                            <p class="text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Borrower Name -->
                    <div class="space-y-1 mt-3">
                        <label for="borrower_name" class="block text-xs font-medium text-gray-700">
                            Nama Peminjam <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="borrower_name" id="borrower_name"
                               value="{{ old('borrower_name', $borrowing->borrower_name) }}" required
                               placeholder="Masukkan nama lengkap peminjam"
                               class="w-full px-2 py-1.5 border border-gray-300 rounded-md text-xs
                                      focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-transparent
                                      @error('borrower_name') border-red-300 @enderror">
                        @error('borrower_name')
                            <p class="text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Borrower Institution (conditional for external) -->
                    <div class="space-y-1 mt-3" id="institutionField" style="display: {{ old('borrower_type', $borrowing->borrower_type) == 'eksternal' ? 'block' : 'none' }};">
                        <label for="borrower_institution" class="block text-xs font-medium text-gray-700">
                            Asal Instansi <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="borrower_institution" id="borrower_institution"
                               value="{{ old('borrower_institution', $borrowing->borrower_institution ?? '') }}"
                               placeholder="Masukkan nama instansi/perusahaan"
                               class="w-full px-2 py-1.5 border border-gray-300 rounded-md text-xs
                                      focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-transparent
                                      @error('borrower_institution') border-red-300 @enderror">
                        @error('borrower_institution')
                            <p class="text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Contact -->
                    <div class="space-y-1 mt-3">
                        <label for="borrower_contact" class="block text-xs font-medium text-gray-700">
                            Nomor Kontak <span class="text-red-500">*</span>
                        </label>
                        <input type="tel" name="borrower_contact" id="borrower_contact"
                               value="{{ old('borrower_contact', $borrowing->borrower_contact ?? '') }}" required
                               placeholder="Masukkan nomor telepon/WhatsApp"
                               class="w-full px-2 py-1.5 border border-gray-300 rounded-md text-xs
                                      focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-transparent
                                      @error('borrower_contact') border-red-300 @enderror">
                        @error('borrower_contact')
                            <p class="text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Period & Location Card -->
                <div class="bg-white rounded-md shadow-sm border border-gray-200 p-3 sm:p-4">
                    <h3 class="text-sm font-semibold text-gray-900 mb-3 flex items-center">
                        <svg class="w-4 h-4 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Periode & Lokasi Penggunaan
                    </h3>

                    <!-- Date Range -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-2 sm:gap-3">
                        <div class="space-y-1">
                            <label for="start_date" class="block text-xs sm:text-sm font-medium text-gray-700">
                                Tanggal Mulai <span class="text-red-500">*</span>
                                <span class="text-xs text-blue-500 font-normal sm:hidden">(Pilih tanggal)</span>
                            </label>
                            <div class="relative">
                                <input type="date" name="start_date" id="start_date"
                                       value="{{ old('start_date', $borrowing->start_date ? $borrowing->start_date->format('Y-m-d') : '') }}" required
                                       min="{{ date('Y-m-d') }}"
                                       aria-label="Pilih tanggal mulai peminjaman"
                                       aria-describedby="start_date_help"
                                       class="w-full px-2 sm:px-3 py-2 sm:py-2.5 border border-gray-300 rounded-md text-xs sm:text-sm
                                              focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-transparent
                                              @error('start_date') border-red-300 @enderror
                                              date-input-responsive">
                                <svg class="absolute right-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div id="start_date_help" class="text-xs text-gray-500 hidden sm:block">
                                Tanggal mulai tidak boleh kurang dari hari ini
                            </div>
                            @error('start_date')
                                <p class="text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-1">
                            <label for="end_date" class="block text-xs sm:text-sm font-medium text-gray-700">
                                Tanggal Selesai <span class="text-red-500">*</span>
                                <span class="text-xs text-gray-500 font-normal sm:hidden">(Pilih tanggal)</span>
                            </label>
                            <div class="relative">
                                <input type="date" name="end_date" id="end_date"
                                       value="{{ old('end_date', $borrowing->end_date ? $borrowing->end_date->format('Y-m-d') : '') }}" required
                                       min="{{ date('Y-m-d') }}"
                                       aria-label="Pilih tanggal selesai peminjaman"
                                       aria-describedby="end_date_help"
                                       class="w-full px-2 sm:px-3 py-2 sm:py-2.5 border border-gray-300 rounded-md text-xs sm:text-sm
                                              focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-transparent
                                              @error('end_date') border-red-300 @enderror
                                              date-input-responsive">
                                <svg class="absolute right-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div id="end_date_help" class="text-xs text-gray-500 hidden sm:block">
                                Tanggal selesai tidak boleh kurang dari tanggal mulai
                            </div>
                            @error('end_date')
                                <p class="text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Location Type -->
                    <div class="space-y-2 mt-3">
                        <label class="block text-xs font-medium text-gray-700">
                            Tipe Lokasi <span class="text-red-500">*</span>
                        </label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                            <label class="relative flex items-center">
                                <input type="radio" name="location_type" value="dalam_kota"
                                       class="sr-only peer"
                                       {{ old('location_type', $borrowing->location_type) == 'dalam_kota' ? 'checked' : '' }} required>
                                <div class="w-full px-3 py-2 text-xs border border-gray-300 rounded-md cursor-pointer transition-all duration-200
                                            peer-checked:bg-green-50 peer-checked:border-green-500 peer-checked:text-green-700
                                            hover:border-green-400 flex items-center justify-center">
                                    <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                    Dalam Kota
                                </div>
                            </label>
                            <label class="relative flex items-center">
                                <input type="radio" name="location_type" value="luar_kota"
                                       class="sr-only peer"
                                       {{ old('location_type', $borrowing->location_type) == 'luar_kota' ? 'checked' : '' }} required>
                                <div class="w-full px-3 py-2 text-xs border border-gray-300 rounded-md cursor-pointer transition-all duration-200
                                            peer-checked:bg-purple-50 peer-checked:border-purple-500 peer-checked:text-purple-700
                                            hover:border-purple-400 flex items-center justify-center">
                                    <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    Luar Kota
                                </div>
                            </label>
                        </div>
                        @error('location_type')
                            <p class="text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Destination (conditional for luar_kota) -->
                    <div class="space-y-3 mt-3" id="destinationField" style="display: {{ old('location_type', $borrowing->location_type) == 'luar_kota' ? 'block' : 'none' }};">
                        <!-- Province Selection -->
                        <div class="space-y-1">
                            <label for="province" class="block text-xs font-medium text-gray-700">
                                Provinsi Tujuan <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <select name="province" id="province"
                                        class="w-full px-2 py-1.5 border border-gray-300 rounded-md text-xs
                                               focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-transparent
                                               @error('province') border-red-300 @enderror searchable-select">
                                    <option value="">-- Pilih Provinsi --</option>
                                    <option value="Aceh" {{ old('province', $destinationData['province'] ?? '') == 'Aceh' ? 'selected' : '' }}>Aceh</option>
                                    <option value="Sumatera Utara" {{ old('province', $destinationData['province'] ?? '') == 'Sumatera Utara' ? 'selected' : '' }}>Sumatera Utara</option>
                                    <option value="Sumatera Barat" {{ old('province', $destinationData['province'] ?? '') == 'Sumatera Barat' ? 'selected' : '' }}>Sumatera Barat</option>
                                    <option value="Riau" {{ old('province', $destinationData['province'] ?? '') == 'Riau' ? 'selected' : '' }}>Riau</option>
                                    <option value="Kepulauan Riau" {{ old('province', $destinationData['province'] ?? '') == 'Kepulauan Riau' ? 'selected' : '' }}>Kepulauan Riau</option>
                                    <option value="Jambi" {{ old('province', $destinationData['province'] ?? '') == 'Jambi' ? 'selected' : '' }}>Jambi</option>
                                    <option value="Sumatera Selatan" {{ old('province', $destinationData['province'] ?? '') == 'Sumatera Selatan' ? 'selected' : '' }}>Sumatera Selatan</option>
                                    <option value="Bangka Belitung" {{ old('province', $destinationData['province'] ?? '') == 'Bangka Belitung' ? 'selected' : '' }}>Bangka Belitung</option>
                                    <option value="Bengkulu" {{ old('province', $destinationData['province'] ?? '') == 'Bengkulu' ? 'selected' : '' }}>Bengkulu</option>
                                    <option value="Lampung" {{ old('province', $destinationData['province'] ?? '') == 'Lampung' ? 'selected' : '' }}>Lampung</option>
                                    <option value="DKI Jakarta" {{ old('province', $destinationData['province'] ?? '') == 'DKI Jakarta' ? 'selected' : '' }}>DKI Jakarta</option>
                                    <option value="Jawa Barat" {{ old('province', $destinationData['province'] ?? '') == 'Jawa Barat' ? 'selected' : '' }}>Jawa Barat</option>
                                    <option value="Jawa Tengah" {{ old('province', $destinationData['province'] ?? '') == 'Jawa Tengah' ? 'selected' : '' }}>Jawa Tengah</option>
                                    <option value="DI Yogyakarta" {{ old('province', $destinationData['province'] ?? '') == 'DI Yogyakarta' ? 'selected' : '' }}>DI Yogyakarta</option>
                                    <option value="Jawa Timur" {{ old('province', $destinationData['province'] ?? '') == 'Jawa Timur' ? 'selected' : '' }}>Jawa Timur</option>
                                    <option value="Banten" {{ old('province', $destinationData['province'] ?? '') == 'Banten' ? 'selected' : '' }}>Banten</option>
                                    <option value="Bali" {{ old('province', $destinationData['province'] ?? '') == 'Bali' ? 'selected' : '' }}>Bali</option>
                                    <option value="Nusa Tenggara Barat" {{ old('province', $destinationData['province'] ?? '') == 'Nusa Tenggara Barat' ? 'selected' : '' }}>Nusa Tenggara Barat</option>
                                    <option value="Nusa Tenggara Timur" {{ old('province', $destinationData['province'] ?? '') == 'Nusa Tenggara Timur' ? 'selected' : '' }}>Nusa Tenggara Timur</option>
                                    <option value="Kalimantan Barat" {{ old('province', $destinationData['province'] ?? '') == 'Kalimantan Barat' ? 'selected' : '' }}>Kalimantan Barat</option>
                                    <option value="Kalimantan Tengah" {{ old('province', $destinationData['province'] ?? '') == 'Kalimantan Tengah' ? 'selected' : '' }}>Kalimantan Tengah</option>
                                    <option value="Kalimantan Selatan" {{ old('province', $destinationData['province'] ?? '') == 'Kalimantan Selatan' ? 'selected' : '' }}>Kalimantan Selatan</option>
                                    <option value="Kalimantan Timur" {{ old('province', $destinationData['province'] ?? '') == 'Kalimantan Timur' ? 'selected' : '' }}>Kalimantan Timur</option>
                                    <option value="Kalimantan Utara" {{ old('province', $destinationData['province'] ?? '') == 'Kalimantan Utara' ? 'selected' : '' }}>Kalimantan Utara</option>
                                    <option value="Sulawesi Utara" {{ old('province', $destinationData['province'] ?? '') == 'Sulawesi Utara' ? 'selected' : '' }}>Sulawesi Utara</option>
                                    <option value="Sulawesi Tengah" {{ old('province', $destinationData['province'] ?? '') == 'Sulawesi Tengah' ? 'selected' : '' }}>Sulawesi Tengah</option>
                                    <option value="Sulawesi Selatan" {{ old('province', $destinationData['province'] ?? '') == 'Sulawesi Selatan' ? 'selected' : '' }}>Sulawesi Selatan</option>
                                    <option value="Sulawesi Tenggara" {{ old('province', $destinationData['province'] ?? '') == 'Sulawesi Tenggara' ? 'selected' : '' }}>Sulawesi Tenggara</option>
                                    <option value="Gorontalo" {{ old('province', $destinationData['province'] ?? '') == 'Gorontalo' ? 'selected' : '' }}>Gorontalo</option>
                                    <option value="Sulawesi Barat" {{ old('province', $destinationData['province'] ?? '') == 'Sulawesi Barat' ? 'selected' : '' }}>Sulawesi Barat</option>
                                    <option value="Maluku" {{ old('province', $destinationData['province'] ?? '') == 'Maluku' ? 'selected' : '' }}>Maluku</option>
                                    <option value="Maluku Utara" {{ old('province', $destinationData['province'] ?? '') == 'Maluku Utara' ? 'selected' : '' }}>Maluku Utara</option>
                                    <option value="Papua" {{ old('province', $destinationData['province'] ?? '') == 'Papua' ? 'selected' : '' }}>Papua</option>
                                    <option value="Papua Barat" {{ old('province', $destinationData['province'] ?? '') == 'Papua Barat' ? 'selected' : '' }}>Papua Barat</option>
                                    <option value="Papua Selatan" {{ old('province', $destinationData['province'] ?? '') == 'Papua Selatan' ? 'selected' : '' }}>Papua Selatan</option>
                                    <option value="Papua Tengah" {{ old('province', $destinationData['province'] ?? '') == 'Papua Tengah' ? 'selected' : '' }}>Papua Tengah</option>
                                    <option value="Papua Pegunungan" {{ old('province', $destinationData['province'] ?? '') == 'Papua Pegunungan' ? 'selected' : '' }}>Papua Pegunungan</option>
                                    <option value="Papua Barat Daya" {{ old('province', $destinationData['province'] ?? '') == 'Papua Barat Daya' ? 'selected' : '' }}>Papua Barat Daya</option>
                                </select>
                            </div>
                            @error('province')
                                <p class="text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- City/Regency Selection -->
                        <div class="space-y-1">
                            <label for="city" class="block text-xs font-medium text-gray-700">
                                Kota/Kabupaten Tujuan <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <select name="city" id="city"
                                        class="w-full px-2 py-1.5 border border-gray-300 rounded-md text-xs
                                               focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-transparent
                                               @error('city') border-red-300 @enderror searchable-select"
                                        {{ old('province', $borrowing->province) ? '' : 'disabled' }}>
                                    <option value="">{{ old('province', $borrowing->province) ? '-- Pilih Kota/Kabupaten --' : '-- Pilih Provinsi Terlebih Dahulu --' }}</option>
                                    <!-- City options will be populated by JavaScript -->
                                </select>
                            </div>
                            @error('city')
                                <p class="text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="space-y-4">
                <!-- Vehicle & Purpose Card -->
                <div class="bg-white rounded-md shadow-sm border border-gray-200 p-3 sm:p-4">
                    <h3 class="text-sm font-semibold text-gray-900 mb-3 flex items-center">
                        <svg class="w-4 h-4 text-purple-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Kendaraan & Keperluan
                    </h3>

                    <!-- Vehicle Selection -->
                    <div id="singleVehicleSection" class="space-y-1">
                        <label for="vehicle_id" class="block text-xs font-medium text-gray-700">
                            Pilih Kendaraan <span class="text-red-500">*</span>
                        </label>
                        <select name="vehicle_id" id="vehicle_id" required
                                class="w-full px-2 py-1.5 border border-gray-300 rounded-md text-xs
                                       focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-transparent
                                       @error('vehicle_id') border-red-300 @enderror">
                            <option value="">-- Pilih Kendaraan --</option>
                            @foreach($availableVehicles as $vehicle)
                                <option value="{{ $vehicle->id }}"
                                        {{ old('vehicle_id', $borrowing->vehicle_id) == $vehicle->id ? 'selected' : '' }}
                                        data-brand="{{ $vehicle->brand }}"
                                        data-model="{{ $vehicle->model }}"
                                        data-plate="{{ $vehicle->license_plate }}"
                                        data-year="{{ $vehicle->year }}">
                                    {{ $vehicle->brand }} {{ $vehicle->model }} - {{ $vehicle->license_plate }} ({{ $vehicle->year }})
                                </option>
                            @endforeach
                        </select>
                        @error('vehicle_id')
                            <p class="text-xs text-red-600">{{ $message }}</p>
                        @enderror

                        <!-- Vehicle Info Display -->
                        <div id="vehicleInfo" class="hidden mt-2 p-2 bg-gray-50 rounded-md">
                            <div class="text-xs text-gray-600 space-y-1">
                                <div><span class="font-medium">Brand:</span> <span id="vehicleBrand">-</span></div>
                                <div><span class="font-medium">Model:</span> <span id="vehicleModel">-</span></div>
                                <div><span class="font-medium">Plat Nomor:</span> <span id="vehiclePlate">-</span></div>
                                <div><span class="font-medium">Tahun:</span> <span id="vehicleYear">-</span></div>
                            </div>
                        </div>
                    </div>

                    <!-- Unit Count -->
                    <div class="space-y-1 mt-3">
                        <label for="unit_count" class="block text-xs font-medium text-gray-700">
                            Jumlah Unit <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="unit_count" id="unit_count"
                               value="{{ old('unit_count', $borrowing->unit_count) }}" min="1" max="10" required
                               class="w-full px-2 py-1.5 border border-gray-300 rounded-md text-xs
                                      focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-transparent
                                      @error('unit_count') border-red-300 @enderror">
                        @error('unit_count')
                            <p class="text-xs text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-gray-500">Maksimal 10 unit kendaraan</p>
                    </div>

                    <!-- Multiple Vehicle Selection (untuk unit > 1) -->
                    <div id="multipleVehiclesSection" class="space-y-1 mt-3" style="display: none;">
                        <label class="block text-xs font-medium text-gray-700">
                            Pilih Kendaraan per Unit <span class="text-red-500">*</span>
                        </label>
                        <div class="bg-blue-50 border border-blue-200 rounded-md p-2 mb-2">
                            <div class="flex items-start">
                                <svg class="w-3 h-3 text-blue-600 mt-0.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <p class="text-xs text-blue-700">Silakan pilih kendaraan untuk setiap unit yang akan dipinjam</p>
                            </div>
                        </div>
                        <div id="vehicleSelections" class="space-y-2">
                            <!-- Dynamic vehicle dropdowns will be inserted here -->
                        </div>
                    </div>

                    <!-- Purpose -->
                    <div class="space-y-1 mt-3">
                        <label for="purpose" class="block text-xs font-medium text-gray-700">
                            Keperluan/Tujuan Penggunaan <span class="text-red-500">*</span>
                        </label>
                        <textarea name="purpose" id="purpose" rows="3" required
                                  placeholder="Jelaskan keperluan penggunaan kendaraan secara detail..."
                                  class="w-full px-2 py-1.5 border border-gray-300 rounded-md text-xs
                                         focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-transparent
                                         @error('purpose') border-red-300 @enderror resize-none">{{ old('purpose', $borrowing->purpose) }}</textarea>
                        @error('purpose')
                            <p class="text-xs text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-gray-500">Minimal 10 karakter, maksimal 500 karakter</p>
                    </div>
                </div>

                <!-- Documents Card -->
                <div class="bg-white rounded-md shadow-sm border border-gray-200 p-3 sm:p-4">
                    <h3 class="text-sm font-semibold text-gray-900 mb-3 flex items-center">
                        <svg class="w-4 h-4 text-orange-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Dokumen Pendukung
                    </h3>

                    <!-- Current Surat Permohonan -->
                    @if($borrowing->surat_permohonan)
                    <div class="mb-3 p-2 bg-blue-50 border border-blue-200 rounded-md">
                        <p class="text-xs font-medium text-blue-800 mb-1">Surat Permohonan Saat Ini:</p>
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-blue-700">{{ basename($borrowing->surat_permohonan) }}</span>
                            <a href="{{ Storage::url($borrowing->surat_permohonan) }}" target="_blank"
                               class="text-xs text-blue-600 hover:text-blue-800">Lihat</a>
                        </div>
                    </div>
                    @endif

                    <!-- Surat Permohonan -->
                    <div class="space-y-1">
                        <label for="surat_permohonan" class="block text-xs font-medium text-gray-700">
                            Surat Permohonan {{ $borrowing->surat_permohonan ? '(Opsional - kosongkan jika tidak ingin mengganti)' : '' }} <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="file" name="surat_permohonan" id="surat_permohonan"
                                   accept=".pdf,.jpg,.jpeg,.png" {{ !$borrowing->surat_permohonan ? 'required' : '' }}
                                   class="w-full px-2 py-1.5 border border-gray-300 rounded-md text-xs
                                          focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-transparent
                                          @error('surat_permohonan') border-red-300 @enderror file:mr-2 file:py-1 file:px-2
                                          file:rounded file:border-0 file:text-xs file:font-medium
                                          file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        </div>

                        <!-- File Preview Area -->
                        <div id="surat_permohonan_preview" class="hidden mt-2 p-3 bg-blue-50 rounded-md border border-blue-200">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <div>
                                        <p class="text-xs font-medium text-blue-700" id="surat_permohonan_filename">File terpilih</p>
                                        <p class="text-xs text-blue-600" id="surat_permohonan_size">Ukuran file</p>
                                    </div>
                                </div>
                                <button type="button" onclick="removeFile('surat_permohonan')"
                                        class="inline-flex items-center px-2 py-1 text-xs font-medium text-red-700 bg-red-100 hover:bg-red-200 rounded-md transition-colors duration-150">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    Hapus
                                </button>
                            </div>
                        </div>

                        @error('surat_permohonan')
                            <p class="text-xs text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-gray-500">Format: PDF, JPG, JPEG, PNG (Max: 2MB)</p>
                    </div>

                    <!-- Current Surat Tugas -->
                    @if($borrowing->surat_tugas)
                    <div class="mb-3 mt-3 p-2 bg-green-50 border border-green-200 rounded-md">
                        <p class="text-xs font-medium text-green-800 mb-1">Surat Tugas Saat Ini:</p>
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-green-700">{{ basename($borrowing->surat_tugas) }}</span>
                            <a href="{{ Storage::url($borrowing->surat_tugas) }}" target="_blank"
                               class="text-xs text-green-600 hover:text-green-800">Lihat</a>
                        </div>
                    </div>
                    @endif

                    <!-- Surat Tugas (Optional) -->
                    <div class="space-y-1 mt-3">
                        <label for="surat_tugas" class="block text-xs font-medium text-gray-700">
                            Surat Tugas <span class="text-gray-400">(Opsional)</span>
                        </label>
                        <div class="relative">
                            <input type="file" name="surat_tugas" id="surat_tugas"
                                   accept=".pdf,.jpg,.jpeg,.png"
                                   class="w-full px-2 py-1.5 border border-gray-300 rounded-md text-xs
                                          focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-transparent
                                          @error('surat_tugas') border-red-300 @enderror file:mr-2 file:py-1 file:px-2
                                          file:rounded file:border-0 file:text-xs file:font-medium
                                          file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                        </div>

                        <!-- File Preview Area -->
                        <div id="surat_tugas_preview" class="hidden mt-2 p-3 bg-green-50 rounded-md border border-green-200">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <div>
                                        <p class="text-xs font-medium text-green-700" id="surat_tugas_filename">File terpilih</p>
                                        <p class="text-xs text-green-600" id="surat_tugas_size">Ukuran file</p>
                                    </div>
                                </div>
                                <button type="button" onclick="removeFile('surat_tugas')"
                                        class="inline-flex items-center px-2 py-1 text-xs font-medium text-red-700 bg-red-100 hover:bg-red-200 rounded-md transition-colors duration-150">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    Hapus
                                </button>
                            </div>
                        </div>

                        @error('surat_tugas')
                            <p class="text-xs text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-gray-500">Format: PDF, JPG, JPEG, PNG (Max: 2MB)</p>
                    </div>

                    <!-- Notes -->
                    <div class="space-y-1 mt-3">
                        <label for="notes" class="block text-xs font-medium text-gray-700">
                            Catatan Tambahan <span class="text-gray-400">(Opsional)</span>
                        </label>
                        <textarea name="notes" id="notes" rows="2"
                                  placeholder="Catatan atau informasi tambahan..."
                                  class="w-full px-2 py-1.5 border border-gray-300 rounded-md text-xs
                                         focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-transparent
                                         @error('notes') border-red-300 @enderror resize-none">{{ old('notes', $borrowing->notes) }}</textarea>
                        @error('notes')
                            <p class="text-xs text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-gray-500">Maksimal 300 karakter</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Submit Buttons -->
        <div class="flex flex-col sm:flex-row gap-2 pt-4">
            <button type="submit"
                    class="flex-1 sm:flex-none inline-flex items-center justify-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md shadow-sm transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Simpan Perubahan
            </button>

            <button type="button" onclick="resetForm()"
                    class="inline-flex items-center justify-center px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 text-sm font-medium rounded-md shadow-sm transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-offset-2">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                Reset Form
            </button>

            <a href="{{ route('operator.borrowings.show', $borrowing) }}"
               class="inline-flex items-center justify-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-md shadow-sm transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Batal
            </a>
        </div>
    </form>
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
            <h3 class="text-lg leading-6 font-medium text-gray-900 mt-4">Menyimpan Perubahan</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">Mohon tunggu, sedang menyimpan perubahan data peminjaman...</p>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle borrower type change
    const borrowerTypeInputs = document.querySelectorAll('input[name="borrower_type"]');
    const institutionField = document.getElementById('institutionField');
    const institutionInput = document.getElementById('borrower_institution');

    borrowerTypeInputs.forEach(input => {
        input.addEventListener('change', function() {
            if (this.value === 'internal') {
                institutionField.style.display = 'none';
                institutionInput.required = false;
                institutionInput.value = '';
            } else if (this.value === 'eksternal') {
                institutionField.style.display = 'block';
                institutionInput.required = true;
            }
        });
    });

    // Trigger change event on page load if value exists
    const checkedBorrowerType = document.querySelector('input[name="borrower_type"]:checked');
    if (checkedBorrowerType) {
        checkedBorrowerType.dispatchEvent(new Event('change'));
    }

    // Handle location type change
    const locationTypeInputs = document.querySelectorAll('input[name="location_type"]');
    const destinationField = document.getElementById('destinationField');
    const provinceSelect = document.getElementById('province');
    const citySelect = document.getElementById('city');

    locationTypeInputs.forEach(input => {
        input.addEventListener('change', function() {
            if (this.value === 'luar_kota') {
                destinationField.style.display = 'block';
                provinceSelect.required = true;
                citySelect.required = true;
            } else {
                destinationField.style.display = 'none';
                provinceSelect.required = false;
                citySelect.required = false;
                provinceSelect.value = '';
                citySelect.value = '';
                citySelect.disabled = true;
            }
        });
    });

    // Trigger change event on page load if value exists
    const checkedLocationType = document.querySelector('input[name="location_type"]:checked');
    if (checkedLocationType) {
        checkedLocationType.dispatchEvent(new Event('change'));
    }

    // City data for each province
    const cityData = {
        'Aceh': ['Banda Aceh', 'Langsa', 'Lhokseumawe', 'Meulaboh', 'Sabang', 'Subulussalam', 'Aceh Barat', 'Aceh Barat Daya', 'Aceh Besar', 'Aceh Jaya', 'Aceh Selatan', 'Aceh Singkil', 'Aceh Tamiang', 'Aceh Tengah', 'Aceh Tenggara', 'Aceh Timur', 'Aceh Utara', 'Bener Meriah', 'Bireuen', 'Gayo Lues', 'Nagan Raya', 'Pidie', 'Pidie Jaya', 'Simeulue'],
        'Sumatera Utara': ['Medan', 'Binjai', 'Gunungsitoli', 'Padang Sidempuan', 'Pematangsiantar', 'Sibolga', 'Tanjungbalai', 'Tebing Tinggi', 'Asahan', 'Batubara', 'Dairi', 'Deli Serdang', 'Humbang Hasundutan', 'Karo', 'Labuhanbatu', 'Labuhanbatu Selatan', 'Labuhanbatu Utara', 'Langkat', 'Mandailing Natal', 'Nias', 'Nias Barat', 'Nias Selatan', 'Nias Utara', 'Padang Lawas', 'Padang Lawas Utara', 'Pakpak Bharat', 'Samosir', 'Serdang Bedagai', 'Tapanuli Selatan', 'Tapanuli Tengah', 'Tapanuli Utara', 'Toba Samosir'],
        'Sumatera Barat': ['Padang', 'Bukittinggi', 'Padang Panjang', 'Pariaman', 'Payakumbuh', 'Sawahlunto', 'Solok', 'Agam', 'Dharmasraya', 'Kepulauan Mentawai', 'Lima Puluh Kota', 'Padang Pariaman', 'Pasaman', 'Pasaman Barat', 'Pesisir Selatan', 'Sijunjung', 'Solok Selatan', 'Tanah Datar'],
        'Riau': ['Pekanbaru', 'Dumai', 'Bengkalis', 'Indragiri Hilir', 'Indragiri Hulu', 'Kampar', 'Kepulauan Meranti', 'Kuantan Singingi', 'Pelalawan', 'Rokan Hilir', 'Rokan Hulu', 'Siak'],
        'Kepulauan Riau': ['Batam', 'Tanjung Pinang', 'Bintan', 'Karimun', 'Kepulauan Anambas', 'Lingga', 'Natuna'],
        'Jambi': ['Jambi', 'Sungai Penuh', 'Batang Hari', 'Bungo', 'Kerinci', 'Merangin', 'Muaro Jambi', 'Sarolangun', 'Tanjung Jabung Barat', 'Tanjung Jabung Timur', 'Tebo'],
        'Sumatera Selatan': ['Palembang', 'Lubuklinggau', 'Pagar Alam', 'Prabumulih', 'Banyuasin', 'Empat Lawang', 'Lahat', 'Muara Enim', 'Musi Banyuasin', 'Musi Rawas', 'Musi Rawas Utara', 'Ogan Ilir', 'Ogan Komering Ilir', 'Ogan Komering Ulu', 'Ogan Komering Ulu Selatan', 'Ogan Komering Ulu Timur', 'Penukal Abab Lematang Ilir'],
        'Bangka Belitung': ['Pangkalpinang', 'Bangka', 'Bangka Barat', 'Bangka Selatan', 'Bangka Tengah', 'Belitung', 'Belitung Timur'],
        'Bengkulu': ['Bengkulu', 'Bengkulu Selatan', 'Bengkulu Tengah', 'Bengkulu Utara', 'Kaur', 'Kepahiang', 'Lebong', 'Mukomuko', 'Rejang Lebong', 'Seluma'],
        'Lampung': ['Bandar Lampung', 'Metro', 'Lampung Barat', 'Lampung Selatan', 'Lampung Tengah', 'Lampung Timur', 'Lampung Utara', 'Mesuji', 'Pesawaran', 'Pesisir Barat', 'Pringsewu', 'Tanggamus', 'Tulang Bawang', 'Tulang Bawang Barat', 'Way Kanan'],
        'DKI Jakarta': ['Jakarta Barat', 'Jakarta Pusat', 'Jakarta Selatan', 'Jakarta Timur', 'Jakarta Utara', 'Kepulauan Seribu'],
        'Jawa Barat': ['Bandung', 'Bekasi', 'Bogor', 'Cimahi', 'Cirebon', 'Depok', 'Sukabumi', 'Tasikmalaya', 'Banjar', 'Bandung Barat', 'Bandung', 'Bekasi', 'Bogor', 'Ciamis', 'Cianjur', 'Cirebon', 'Garut', 'Indramayu', 'Karawang', 'Kuningan', 'Majalengka', 'Pangandaran', 'Purwakarta', 'Subang', 'Sukabumi', 'Sumedang', 'Tasikmalaya'],
        'Jawa Tengah': ['Magelang', 'Pekalongan', 'Salatiga', 'Semarang', 'Surakarta', 'Tegal', 'Banjarnegara', 'Banyumas', 'Batang', 'Blora', 'Boyolali', 'Brebes', 'Cilacap', 'Demak', 'Grobogan', 'Jepara', 'Karanganyar', 'Kebumen', 'Kendal', 'Klaten', 'Kudus', 'Magelang', 'Pati', 'Pekalongan', 'Pemalang', 'Purbalingga', 'Purworejo', 'Rembang', 'Semarang', 'Sragen', 'Sukoharjo', 'Tegal', 'Temanggung', 'Wonogiri', 'Wonosobo'],
        'DI Yogyakarta': ['Yogyakarta', 'Bantul', 'Gunungkidul', 'Kulon Progo', 'Sleman'],
        'Jawa Timur': ['Batu', 'Blitar', 'Kediri', 'Madiun', 'Malang', 'Mojokerto', 'Pasuruan', 'Probolinggo', 'Surabaya', 'Bangkalan', 'Banyuwangi', 'Blitar', 'Bojonegoro', 'Bondowoso', 'Gresik', 'Jember', 'Jombang', 'Kediri', 'Lamongan', 'Lumajang', 'Madiun', 'Magetan', 'Malang', 'Mojokerto', 'Nganjuk', 'Ngawi', 'Pacitan', 'Pamekasan', 'Pasuruan', 'Ponorogo', 'Probolinggo', 'Sampang', 'Sidoarjo', 'Situbondo', 'Sumenep', 'Trenggalek', 'Tuban', 'Tulungagung'],
        'Banten': ['Cilegon', 'Serang', 'Tangerang', 'Tangerang Selatan', 'Lebak', 'Pandeglang', 'Serang', 'Tangerang'],
        'Bali': ['Denpasar', 'Badung', 'Bangli', 'Buleleng', 'Gianyar', 'Jembrana', 'Karangasem', 'Klungkung', 'Tabanan'],
        'Nusa Tenggara Barat': ['Mataram', 'Bima', 'Bima', 'Dompu', 'Lombok Barat', 'Lombok Tengah', 'Lombok Timur', 'Lombok Utara', 'Sumbawa', 'Sumbawa Barat'],
        'Nusa Tenggara Timur': ['Kupang', 'Alor', 'Belu', 'Ende', 'Flores Timur', 'Kupang', 'Lembata', 'Malaka', 'Manggarai', 'Manggarai Barat', 'Manggarai Timur', 'Nagekeo', 'Ngada', 'Rote Ndao', 'Sabu Raijua', 'Sikka', 'Sumba Barat', 'Sumba Barat Daya', 'Sumba Tengah', 'Sumba Timur', 'Timor Tengah Selatan', 'Timor Tengah Utara'],
        'Kalimantan Barat': ['Pontianak', 'Singkawang', 'Bengkayang', 'Kapuas Hulu', 'Kayong Utara', 'Ketapang', 'Kubu Raya', 'Landak', 'Melawi', 'Mempawah', 'Sambas', 'Sanggau', 'Sekadau', 'Sintang'],
        'Kalimantan Tengah': ['Palangka Raya', 'Barito Selatan', 'Barito Timur', 'Barito Utara', 'Gunung Mas', 'Kapuas', 'Katingan', 'Kotawaringin Barat', 'Kotawaringin Timur', 'Lamandau', 'Murung Raya', 'Pulang Pisau', 'Sukamara', 'Seruyan'],
        'Kalimantan Selatan': ['Banjarmasin', 'Banjarbaru', 'Balangan', 'Banjar', 'Barito Kuala', 'Hulu Sungai Selatan', 'Hulu Sungai Tengah', 'Hulu Sungai Utara', 'Kotabaru', 'Tabalong', 'Tanah Bumbu', 'Tanah Laut', 'Tapin'],
        'Kalimantan Timur': ['Balikpapan', 'Bontang', 'Samarinda', 'Berau', 'Kutai Barat', 'Kutai Kartanegara', 'Kutai Timur', 'Mahakam Ulu', 'Paser', 'Penajam Paser Utara'],
        'Kalimantan Utara': ['Tarakan', 'Bulungan', 'Malinau', 'Nunukan', 'Tana Tidung'],
        'Sulawesi Utara': ['Bitung', 'Kotamobagu', 'Manado', 'Tomohon', 'Bolaang Mongondow', 'Bolaang Mongondow Selatan', 'Bolaang Mongondow Timur', 'Bolaang Mongondow Utara', 'Kepulauan Sangihe', 'Kepulauan Siau Tagulandang Biaro', 'Kepulauan Talaud', 'Minahasa', 'Minahasa Selatan', 'Minahasa Tenggara', 'Minahasa Utara'],
        'Sulawesi Tengah': ['Palu', 'Banggai', 'Banggai Kepulauan', 'Banggai Laut', 'Buol', 'Donggala', 'Morowali', 'Morowali Utara', 'Parigi Moutong', 'Poso', 'Sigi', 'Tojo Una-Una', 'Tolitoli'],
        'Sulawesi Selatan': ['Makassar', 'Palopo', 'Parepare', 'Bantaeng', 'Barru', 'Bone', 'Bulukumba', 'Enrekang', 'Gowa', 'Jeneponto', 'Kepulauan Selayar', 'Luwu', 'Luwu Timur', 'Luwu Utara', 'Maros', 'Pangkajene dan Kepulauan', 'Pinrang', 'Sidenreng Rappang', 'Sinjai', 'Soppeng', 'Takalar', 'Tana Toraja', 'Toraja Utara', 'Wajo'],
        'Sulawesi Tenggara': ['Bau-Bau', 'Kendari', 'Bombana', 'Buton', 'Buton Selatan', 'Buton Tengah', 'Buton Utara', 'Kolaka', 'Kolaka Timur', 'Kolaka Utara', 'Konawe', 'Konawe Kepulauan', 'Konawe Selatan', 'Konawe Utara', 'Muna', 'Muna Barat', 'Wakatobi'],
        'Gorontalo': ['Gorontalo', 'Boalemo', 'Bone Bolango', 'Gorontalo', 'Gorontalo Utara', 'Pohuwato'],
        'Sulawesi Barat': ['Majene', 'Mamasa', 'Mamuju', 'Mamuju Tengah', 'Mamuju Utara', 'Polewali Mandar'],
        'Maluku': ['Ambon', 'Tual', 'Buru', 'Buru Selatan', 'Kepulauan Aru', 'Maluku Barat Daya', 'Maluku Tengah', 'Maluku Tenggara', 'Maluku Tenggara Barat', 'Seram Bagian Barat', 'Seram Bagian Timur'],
        'Maluku Utara': ['Ternate', 'Tidore Kepulauan', 'Halmahera Barat', 'Halmahera Selatan', 'Halmahera Tengah', 'Halmahera Timur', 'Halmahera Utara', 'Kepulauan Sula', 'Pulau Morotai', 'Pulau Taliabu'],
        'Papua': ['Jayapura', 'Asmat', 'Biak Numfor', 'Boven Digoel', 'Deiyai', 'Dogiyai', 'Intan Jaya', 'Jayapura', 'Jayawijaya', 'Keerom', 'Kepulauan Yapen', 'Lanny Jaya', 'Mamberamo Raya', 'Mamberamo Tengah', 'Mappi', 'Merauke', 'Mimika', 'Nabire', 'Nduga', 'Paniai', 'Pegunungan Bintang', 'Puncak', 'Puncak Jaya', 'Sarmi', 'Supiori', 'Tolikara', 'Waropen', 'Yahukimo', 'Yalimo'],
        'Papua Barat': ['Manokwari', 'Sorong', 'Arfak', 'Fakfak', 'Kaimana', 'Manokwari', 'Manokwari Selatan', 'Maybrat', 'Pegunungan Arfak', 'Raja Ampat', 'Sorong', 'Sorong Selatan', 'Tambrauw', 'Teluk Bintuni', 'Teluk Wondama'],
        'Papua Selatan': ['Merauke', 'Asmat', 'Boven Digoel', 'Mappi'],
        'Papua Tengah': ['Nabire', 'Deiyai', 'Dogiyai', 'Intan Jaya', 'Mimika', 'Paniai', 'Puncak', 'Puncak Jaya'],
        'Papua Pegunungan': ['Jayawijaya', 'Lanny Jaya', 'Mamberamo Tengah', 'Nduga', 'Pegunungan Bintang', 'Tolikara', 'Yahukimo', 'Yalimo'],
        'Papua Barat Daya': ['Sorong', 'Fakfak', 'Kaimana', 'Maybrat', 'Raja Ampat', 'Sorong Selatan', 'Tambrauw']
    };

    // Handle province change
    if (provinceSelect) {
        provinceSelect.addEventListener('change', function() {
            const selectedProvince = this.value;
            citySelect.innerHTML = '<option value="">-- Pilih Kota/Kabupaten --</option>';

            if (selectedProvince && cityData[selectedProvince]) {
                citySelect.disabled = false;
                cityData[selectedProvince].forEach(city => {
                    const option = document.createElement('option');
                    option.value = city;
                    option.textContent = city;

                    // Check if this city should be selected (for edit form)
                    if (citySelect.dataset.selectedCity && citySelect.dataset.selectedCity === city) {
                        option.selected = true;
                    }

                    citySelect.appendChild(option);
                });
            } else {
                citySelect.disabled = true;
            }
        });

        // Set selected city data attribute if exists
        @if(old('city', $destinationData['city'] ?? ''))
            citySelect.dataset.selectedCity = '{{ old('city', $destinationData['city'] ?? '') }}';
        @endif

        // Trigger province change on page load if value exists
        if (provinceSelect.value) {
            provinceSelect.dispatchEvent(new Event('change'));
        }
    }

    // Handle vehicle selection
    const vehicleSelect = document.getElementById('vehicle_id');
    const vehicleInfo = document.getElementById('vehicleInfo');
    const vehicleBrand = document.getElementById('vehicleBrand');
    const vehicleModel = document.getElementById('vehicleModel');
    const vehiclePlate = document.getElementById('vehiclePlate');
    const vehicleYear = document.getElementById('vehicleYear');

    vehicleSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        if (selectedOption.value) {
            vehicleBrand.textContent = selectedOption.dataset.brand || '-';
            vehicleModel.textContent = selectedOption.dataset.model || '-';
            vehiclePlate.textContent = selectedOption.dataset.plate || '-';
            vehicleYear.textContent = selectedOption.dataset.year || '-';
            vehicleInfo.classList.remove('hidden');
        } else {
            vehicleInfo.classList.add('hidden');
        }
    });

    // Trigger vehicle change on page load if value exists
    if (vehicleSelect.value) {
        vehicleSelect.dispatchEvent(new Event('change'));
    }

    // Handle unit count and multiple vehicle selection
    const unitCountInput = document.getElementById('unit_count');
    const singleVehicleSection = document.getElementById('singleVehicleSection');
    const multipleVehiclesSection = document.getElementById('multipleVehiclesSection');
    const vehicleSelectionsContainer = document.getElementById('vehicleSelections');

    // Get all vehicles data from the original select
    const originalVehicleSelect = document.getElementById('vehicle_id');
    const vehiclesData = Array.from(originalVehicleSelect.options).map(option => ({
        value: option.value,
        text: option.textContent,
        brand: option.dataset.brand,
        model: option.dataset.model,
        plate: option.dataset.plate,
        year: option.dataset.year
    }));

    unitCountInput.addEventListener('input', function() {
        const unitCount = parseInt(this.value) || 0;
        console.log('Unit count changed to:', unitCount);

        if (unitCount > 1) {
            // Show multiple vehicle section
            if (singleVehicleSection) {
                singleVehicleSection.style.display = 'none';
            }
            multipleVehiclesSection.style.display = 'block';

            // Clear original vehicle selection
            originalVehicleSelect.value = '';
            originalVehicleSelect.removeAttribute('required');
            if (vehicleInfo) {
                vehicleInfo.classList.add('hidden');
            }

            // Generate vehicle dropdowns
            generateVehicleDropdowns(unitCount);
        } else {
            // Show single vehicle section
            if (singleVehicleSection) {
                singleVehicleSection.style.display = 'block';
            }
            multipleVehiclesSection.style.display = 'none';

            // Restore original vehicle selection requirement
            originalVehicleSelect.setAttribute('required', 'required');

            // Clear multiple vehicle selections
            vehicleSelectionsContainer.innerHTML = '';
        }
    });

    // Trigger initial check on page load for existing data
    const initialUnitCount = parseInt(unitCountInput.value) || 1;
    if (initialUnitCount > 1) {
        unitCountInput.dispatchEvent(new Event('input'));

        // Load existing vehicles data if available
        let existingVehiclesData = [];
        try {
            const vehiclesDataRaw = @json($borrowing->vehicles_data ?? '[]');
            if (typeof vehiclesDataRaw === 'string') {
                existingVehiclesData = JSON.parse(vehiclesDataRaw);
            } else if (Array.isArray(vehiclesDataRaw)) {
                existingVehiclesData = vehiclesDataRaw;
            }
        } catch (e) {
            console.log('Error parsing vehicles data:', e);
            existingVehiclesData = [];
        }

        if (existingVehiclesData && existingVehiclesData.length > 0) {
            // Delay to ensure dropdowns are created first
            setTimeout(function() {
                loadExistingVehiclesData(existingVehiclesData);
            }, 100);
        }
    } else {
        // For single unit, ensure single vehicle section is shown
        if (singleVehicleSection) {
            singleVehicleSection.style.display = 'block';
        }
        if (multipleVehiclesSection) {
            multipleVehiclesSection.style.display = 'none';
        }

        // Ensure original vehicle select is required
        originalVehicleSelect.setAttribute('required', 'required');
    }

    // Handle date validation
    const startDateInput = document.getElementById('start_date');
    const endDateInput = document.getElementById('end_date');

    startDateInput.addEventListener('change', function() {
        endDateInput.min = this.value;
        if (endDateInput.value && endDateInput.value < this.value) {
            endDateInput.value = this.value;
        }
    });

    endDateInput.addEventListener('change', function() {
        if (startDateInput.value && this.value < startDateInput.value) {
            this.value = startDateInput.value;
        }
    });

    // Handle form submission
    const form = document.getElementById('borrowingForm');
    form.addEventListener('submit', function(e) {
        // Show loading
        showLoading();

        // Validate multiple vehicles if unit count > 1
        const unitCount = parseInt(document.getElementById('unit_count').value) || 1;
        if (unitCount > 1) {
            const vehicleSelects = document.querySelectorAll('select[name^="vehicles["]');
            let hasEmptySelection = false;

            vehicleSelects.forEach(select => {
                if (!select.value) {
                    hasEmptySelection = true;
                }
            });

            if (hasEmptySelection) {
                e.preventDefault();
                hideLoading();
                alert('Mohon pilih kendaraan untuk semua unit');
                return false;
            }
        }

        // Let form submit normally
        return true;
    });

    // Handle window beforeunload to hide loading if user navigates away
    window.addEventListener('beforeunload', function() {
        hideLoading();
    });

    // Hide loading on page errors
    window.addEventListener('error', function() {
        hideLoading();
    });

    // Character count for purpose textarea
    const purposeTextarea = document.getElementById('purpose');
    purposeTextarea.addEventListener('input', function() {
        const maxLength = 500;
        const currentLength = this.value.length;

        if (currentLength >= maxLength) {
            this.value = this.value.substring(0, maxLength);
        }
    });

    // Character count for notes textarea
    const notesTextarea = document.getElementById('notes');
    notesTextarea.addEventListener('input', function() {
        const maxLength = 300;
        const currentLength = this.value.length;

        if (currentLength >= maxLength) {
            this.value = this.value.substring(0, maxLength);
        }
    });

    // File upload handling with preview
    const fileInputs = document.querySelectorAll('input[type="file"]');
    fileInputs.forEach(input => {
        input.addEventListener('change', function() {
            const maxSize = 2 * 1024 * 1024; // 2MB in bytes
            const file = this.files[0];

            if (file) {
                if (file.size > maxSize) {
                    alert('Ukuran file terlalu besar. Maksimal 2MB.');
                    this.value = '';
                    hideFilePreview(this.id);
                    return;
                }

                // Show file preview
                showFilePreview(this.id, file);
            } else {
                hideFilePreview(this.id);
            }
        });
    });
});

function resetForm() {
    if (confirm('Apakah Anda yakin ingin mereset form? Semua perubahan yang belum disimpan akan hilang.')) {
        document.getElementById('borrowingForm').reset();
        document.getElementById('vehicleInfo').classList.add('hidden');
        document.getElementById('institutionField').style.display = 'none';

        // Reset vehicle selection sections
        const singleVehicleSection = document.getElementById('singleVehicleSection');
        const multipleVehiclesSection = document.getElementById('multipleVehiclesSection');
        const vehicleSelectionsContainer = document.getElementById('vehicleSelections');

        if (singleVehicleSection) {
            singleVehicleSection.style.display = 'block';
        }
        if (multipleVehiclesSection) {
            multipleVehiclesSection.style.display = 'none';
        }
        if (vehicleSelectionsContainer) {
            vehicleSelectionsContainer.innerHTML = '';
        }

        // Restore original vehicle selection requirement
        const originalVehicleSelect = document.getElementById('vehicle_id');
        if (originalVehicleSelect) {
            originalVehicleSelect.setAttribute('required', 'required');
        }

        // Hide file previews
        hideFilePreview('surat_permohonan');
        hideFilePreview('surat_tugas');
    }
}

function showLoading() {
    const modal = document.getElementById('loadingModal');
    if (modal) {
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
}

function hideLoading() {
    const modal = document.getElementById('loadingModal');
    if (modal) {
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
}

// File preview functions
function showFilePreview(inputId, file) {
    const previewArea = document.getElementById(inputId + '_preview');
    const filenameElement = document.getElementById(inputId + '_filename');
    const sizeElement = document.getElementById(inputId + '_size');

    if (previewArea && filenameElement && sizeElement) {
        filenameElement.textContent = file.name;
        sizeElement.textContent = formatFileSize(file.size);
        previewArea.classList.remove('hidden');
    }
}

function hideFilePreview(inputId) {
    const previewArea = document.getElementById(inputId + '_preview');
    if (previewArea) {
        previewArea.classList.add('hidden');
    }
}

function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}

function removeFile(inputId) {
    if (confirm('Apakah Anda yakin ingin menghapus file ini?')) {
        const input = document.getElementById(inputId);
        input.value = '';
        hideFilePreview(inputId);
    }
}

function generateVehicleDropdowns(count) {
    const vehicleSelectionsContainer = document.getElementById('vehicleSelections');
    const vehiclesData = Array.from(document.getElementById('vehicle_id').options).map(option => ({
        value: option.value,
        text: option.textContent,
        brand: option.dataset.brand,
        model: option.dataset.model,
        plate: option.dataset.plate,
        year: option.dataset.year
    }));

    vehicleSelectionsContainer.innerHTML = '';

    for (let i = 1; i <= count; i++) {
        const vehicleDropdownHtml = `
            <div class="bg-white rounded-lg border border-gray-200 p-4 mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Kendaraan Unit ${i} <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <select name="vehicles[${i-1}][vehicle_id]" id="vehicle_${i}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                        <option value="">Pilih Kendaraan</option>
                        ${vehiclesData.filter(v => v.value).map(vehicle =>
                            `<option value="${vehicle.value}"
                                data-brand="${vehicle.brand || ''}"
                                data-model="${vehicle.model || ''}"
                                data-plate="${vehicle.plate || ''}"
                                data-year="${vehicle.year || ''}">
                                ${vehicle.text}
                            </option>`
                        ).join('')}
                    </select>
                </div>

                <!-- Vehicle Info Display -->
                <div id="vehicleInfo_${i}" class="mt-3 p-3 bg-gray-50 rounded-lg hidden">
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="font-medium text-gray-600">Merek:</span>
                            <span id="vehicleBrand_${i}" class="ml-1 text-gray-800">-</span>
                        </div>
                        <div>
                            <span class="font-medium text-gray-600">Model:</span>
                            <span id="vehicleModel_${i}" class="ml-1 text-gray-800">-</span>
                        </div>
                        <div>
                            <span class="font-medium text-gray-600">Plat Nomor:</span>
                            <span id="vehiclePlate_${i}" class="ml-1 text-gray-800">-</span>
                        </div>
                        <div>
                            <span class="font-medium text-gray-600">Tahun:</span>
                            <span id="vehicleYear_${i}" class="ml-1 text-gray-800">-</span>
                        </div>
                    </div>
                </div>
            </div>
        `;

        vehicleSelectionsContainer.insertAdjacentHTML('beforeend', vehicleDropdownHtml);

        // Get the newly created select element
        const vehicleSelect = document.getElementById(`vehicle_${i}`);
        const vehicleInfoDiv = document.getElementById(`vehicleInfo_${i}`);

        // Add event listener for vehicle selection
        vehicleSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            if (selectedOption.value) {
                document.getElementById(`vehicleBrand_${i}`).textContent = selectedOption.dataset.brand || '-';
                document.getElementById(`vehicleModel_${i}`).textContent = selectedOption.dataset.model || '-';
                document.getElementById(`vehiclePlate_${i}`).textContent = selectedOption.dataset.plate || '-';
                document.getElementById(`vehicleYear_${i}`).textContent = selectedOption.dataset.year || '-';
                vehicleInfoDiv.classList.remove('hidden');
            } else {
                vehicleInfoDiv.classList.add('hidden');
            }

            // Update availability of other dropdowns
            updateVehicleAvailability();
        });
    }
}

function updateVehicleAvailability() {
    const vehicleSelectionsContainer = document.getElementById('vehicleSelections');
    const allVehicleSelects = vehicleSelectionsContainer.querySelectorAll('select[name^="vehicles["]');
    const selectedValues = Array.from(allVehicleSelects).map(select => select.value).filter(value => value);

    allVehicleSelects.forEach(select => {
        const currentValue = select.value;

        // Update options availability
        Array.from(select.options).forEach(option => {
            if (option.value && option.value !== currentValue) {
                option.disabled = selectedValues.includes(option.value);
                if (option.disabled) {
                    option.style.color = '#9ca3af';
                    option.style.backgroundColor = '#f3f4f6';
                } else {
                    option.style.color = '';
                    option.style.backgroundColor = '';
                }
            }
        });
    });
}

function loadExistingVehiclesData(vehiclesData) {
    console.log('Loading existing vehicles data:', vehiclesData);

    vehiclesData.forEach((vehicleData, index) => {
        const unitNumber = vehicleData.unit_number || (index + 1);
        const vehicleSelect = document.getElementById(`vehicle_${unitNumber}`);

        if (vehicleSelect && vehicleData.vehicle_id) {
            vehicleSelect.value = vehicleData.vehicle_id;

            // Trigger change event to show vehicle info
            vehicleSelect.dispatchEvent(new Event('change'));

            console.log(`Set vehicle ${vehicleData.vehicle_id} for unit ${unitNumber}`);
        } else {
            console.log(`Vehicle select not found for unit ${unitNumber} or no vehicle_id provided`);
        }
    });

    // Update availability after loading data
    setTimeout(function() {
        updateVehicleAvailability();
    }, 50);
}
</script>

<style>
/* Form styling enhancements */
.form-card {
    transition: all 0.3s ease;
}

.form-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

/* Radio button custom styling */
input[type="radio"]:checked + div {
    border-width: 2px;
    font-weight: 600;
}

/* File input styling */
input[type="file"]:focus {
    outline: none;
    box-shadow: 0 0 0 2px #3b82f6;
}

/* Date input responsive styling */
.date-input-responsive {
    position: relative;
    min-height: 44px; /* Touch target size for mobile */
}

/* Date picker styling for all devices */
input[type="date"] {
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    background: #dbeafe; /* Light blue background */
    border: 1px solid #3b82f6;
    border-radius: 0.375rem;
    padding-right: 3rem !important; /* Space for icon */
    cursor: pointer;
    transition: all 0.2s ease;
}

input[type="date"]::-webkit-calendar-picker-indicator {
    position: absolute;
    right: 0.75rem;
    top: 50%;
    transform: translateY(-50%);
    width: 1rem;
    height: 1rem;
    cursor: pointer;
    opacity: 0;
    z-index: 2;
}

/* Date input focus states */
input[type="date"]:focus {
    background: #dbeafe; /* Keep light blue on focus */
    border-color: #1d4ed8;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

input[type="date"]::-webkit-inner-spin-button {
    display: none;
}

input[type="date"]::-webkit-clear-button {
    display: none;
}

/* Firefox date input */
input[type="date"]::-moz-focus-inner {
    border: 0;
    padding: 0;
}

/* Mobile styles (320px - 640px) */
@media (max-width: 640px) {
    .date-input-responsive {
        min-height: 48px; /* Larger touch target on mobile */
        font-size: 16px !important; /* Prevent zoom on iOS */
    }

    input[type="date"] {
        padding: 0.75rem 3rem 0.75rem 0.5rem !important;
        font-size: 16px !important; /* Prevent zoom on iOS */
        line-height: 1.25;
    }

    input[type="date"]::-webkit-calendar-picker-indicator {
        width: 1.25rem;
        height: 1.25rem;
        right: 0.75rem;
    }
}

/* Tablet styles (641px - 1024px) */
@media (min-width: 641px) and (max-width: 1024px) {
    .date-input-responsive {
        min-height: 44px;
    }

    input[type="date"] {
        padding: 0.625rem 3rem 0.625rem 0.75rem !important;
        font-size: 0.875rem !important;
    }

    input[type="date"]::-webkit-calendar-picker-indicator {
        width: 1.125rem;
        height: 1.125rem;
        right: 0.75rem;
    }
}

/* Desktop styles (1025px+) */
@media (min-width: 1025px) {
    .date-input-responsive {
        min-height: 42px;
    }

    input[type="date"] {
        padding: 0.5rem 3rem 0.5rem 0.75rem !important;
        font-size: 0.875rem !important;
    }

    input[type="date"]::-webkit-calendar-picker-indicator {
        width: 1rem;
        height: 1rem;
        right: 0.75rem;
    }
}

/* Focus states for date inputs */
input[type="date"]:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 1px #3b82f6;
    background-color: #fefefe;
}

/* Error state for date inputs */
input[type="date"].border-red-300 {
    border-color: #fca5a5 !important;
}

input[type="date"].border-red-300:focus {
    border-color: #ef4444 !important;
    box-shadow: 0 0 0 1px #ef4444 !important;
}

/* Better focus states */
input:focus,
select:focus,
textarea:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 1px #3b82f6;
}

/* Error state styling */
.border-red-300:focus {
    border-color: #ef4444;
    box-shadow: 0 0 0 1px #ef4444;
}

/* Success state styling */
.border-green-300:focus {
    border-color: #10b981;
    box-shadow: 0 0 0 1px #10b981;
}

/* Loading animation */
@keyframes pulse {
    0%, 100% {
        opacity: 1;
    }
    50% {
        opacity: .5;
    }
}

.animate-pulse {
    animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}

/* Responsive form adjustments */
/* Mobile styles (320px - 640px) */
@media (max-width: 640px) {
    .container {
        padding: 0.5rem !important;
    }

    .grid.grid-cols-1.lg\\:grid-cols-2 {
        gap: 16px;
    }

    .form-card {
        margin-bottom: 16px;
        padding: 1rem !important;
    }

    .radio-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 8px;
    }

    .text-xl {
        font-size: 1.125rem !important;
    }

    .text-lg {
        font-size: 1rem !important;
    }

    input, select, textarea {
        font-size: 16px !important; /* Prevent zoom on iOS */
    }
}

/* Tablet styles (641px - 1024px) */
@media (min-width: 641px) and (max-width: 1024px) {
    .container {
        padding: 1rem !important;
    }

    .form-card {
        padding: 1.5rem !important;
    }

    .grid.grid-cols-1.lg\\:grid-cols-2 {
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
    }
}

/* Desktop styles (1025px - 1440px) */
@media (min-width: 1025px) and (max-width: 1440px) {
    .container {
        max-width: 1200px;
        margin: 0 auto;
    }

    .form-card {
        padding: 2rem !important;
    }
}

/* Large desktop styles (1441px+) */
@media (min-width: 1441px) {
    .container {
        max-width: 1400px;
        margin: 0 auto;
    }

    .form-card {
        padding: 2.5rem !important;
    }

    .text-xl {
        font-size: 1.375rem !important;
    }
}

/* Multiple vehicles section styling */
#multipleVehiclesSection .dropdown-responsive {
    position: relative;
}

#multipleVehiclesSection .dropdown-responsive select {
    appearance: none;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
    background-position: right 0.5rem center;
    background-repeat: no-repeat;
    background-size: 1.5em 1.5em;
    padding-right: 2.5rem;
}

#multipleVehiclesSection .relative {
    display: flex;
    flex-direction: column;
}

/* Vehicle card styling in multiple selection */
#multipleVehiclesSection .bg-white {
    transition: all 0.2s ease;
}

#multipleVehiclesSection .bg-white:hover {
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    transform: translateY(-1px);
}

/* Vehicle info display styling */
#multipleVehiclesSection .bg-gray-50 {
    border: 1px solid #e5e7eb;
    transition: all 0.2s ease;
}

#multipleVehiclesSection .bg-gray-50:hover {
    background-color: #f9fafb;
}

/* Disabled option styling */
#multipleVehiclesSection select option:disabled {
    color: #9ca3af !important;
    background-color: #f3f4f6 !important;
    font-style: italic;
}

/* Focus states for multiple vehicle selects */
#multipleVehiclesSection select:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    outline: none;
}
</style>
@endsection
