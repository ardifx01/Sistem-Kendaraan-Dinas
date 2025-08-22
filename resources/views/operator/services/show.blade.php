@extends('layouts.app')

@section('title', 'Detail Service Kendaraan')

@section('content')
<div class="min-h-screen bg-gray-50 py-4 sm:py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="mb-6 sm:mb-8">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 px-4 py-5 sm:p-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('operator.services.index') }}"
                           class="inline-flex items-center p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-all duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </a>
                        <div>
                            <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-900">Detail Service Kendaraan</h1>
                            <p class="mt-1 text-sm text-gray-600">Informasi lengkap service kendaraan dinas</p>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-2 sm:gap-3">
                        <a href="{{ route('operator.services.edit', $service) }}"
                           class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg shadow-sm transition-all duration-200 hover:shadow-md">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Edit Service
                        </a>
                        <form method="POST" action="{{ route('operator.services.destroy', $service) }}" class="inline"
                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus data service ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg shadow-sm transition-all duration-200 hover:shadow-md">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                Hapus Service
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column - Service Information -->
            <div class="lg:col-span-2 space-y-6">

                <!-- Service Information Card -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex items-center mb-6">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-gray-900">Informasi Service</h3>
                                <p class="text-sm text-gray-500">Detail lengkap service yang dilakukan</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Service Date -->
                            <div class="space-y-1">
                                <dt class="text-sm font-medium text-gray-500 flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    Tanggal Service
                                </dt>
                                <dd class="text-sm font-medium text-gray-900">
                                    {{ $service->service_date ? \Carbon\Carbon::parse($service->service_date)->format('d F Y') : '-' }}
                                </dd>
                            </div>

                            <!-- Service Type -->
                            <div class="space-y-1">
                                <dt class="text-sm font-medium text-gray-500 flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                    </svg>
                                    Jenis Service
                                </dt>
                                <dd class="text-sm font-medium text-gray-900">
                                    @php
                                        $serviceTypeLabels = [
                                            'service_rutin' => 'Service Rutin',
                                            'kerusakan' => 'Kerusakan',
                                            'perbaikan' => 'Perbaikan',
                                            'penggantian_part' => 'Penggantian Part'
                                        ];
                                        $serviceTypeColors = [
                                            'service_rutin' => 'bg-green-100 text-green-800',
                                            'kerusakan' => 'bg-red-100 text-red-800',
                                            'perbaikan' => 'bg-yellow-100 text-yellow-800',
                                            'penggantian_part' => 'bg-blue-100 text-blue-800'
                                        ];
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $serviceTypeColors[$service->service_type] ?? 'bg-gray-100 text-gray-800' }}">
                                        {{ $serviceTypeLabels[$service->service_type] ?? $service->service_type }}
                                    </span>
                                </dd>
                            </div>
                        </div>

                        <!-- Detailed Descriptions -->
                        <div class="mt-8 space-y-6">
                            @if($service->damage_description)
                            <div class="border-l-4 border-red-400 bg-red-50 p-4 rounded-r-lg">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 15.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h4 class="text-sm font-medium text-red-800">Deskripsi Kerusakan</h4>
                                        <p class="mt-1 text-sm text-red-700">{{ $service->damage_description }}</p>
                                    </div>
                                </div>
                            </div>
                            @endif

                            @if($service->repair_description)
                            <div class="border-l-4 border-blue-400 bg-blue-50 p-4 rounded-r-lg">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h4 class="text-sm font-medium text-blue-800">Deskripsi Perbaikan</h4>
                                        <p class="mt-1 text-sm text-blue-700">{{ $service->repair_description }}</p>
                                    </div>
                                </div>
                            </div>
                            @endif

                            @if($service->parts_replaced)
                            <div class="border-l-4 border-green-400 bg-green-50 p-4 rounded-r-lg">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h4 class="text-sm font-medium text-green-800">Part yang Diganti</h4>
                                        <p class="mt-1 text-sm text-green-700">{{ $service->parts_replaced }}</p>
                                    </div>
                                </div>
                            </div>
                            @endif

                            @if($service->description)
                            <div class="border-l-4 border-gray-400 bg-gray-50 p-4 rounded-r-lg">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h4 class="text-sm font-medium text-gray-800">Catatan Tambahan</h4>
                                        <p class="mt-1 text-sm text-gray-700">{{ $service->description }}</p>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Documents and Photos Section -->
                @if(($service->documents && count($service->documents)) ||
                    ($service->photos && count($service->photos)))
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex items-center mb-6">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-gray-900">Dokumen & Foto</h3>
                                <p class="text-sm text-gray-500">File dan gambar yang terkait dengan service</p>
                            </div>
                        </div>

                        <!-- Documents Section -->
                        @if($service->documents && count($service->documents))
                        <div class="mb-8">
                            <h4 class="text-base font-medium text-gray-900 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Dokumen ({{ count($service->documents) }})
                            </h4>
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-1 xl:grid-cols-2 gap-4">
                                @foreach($service->documents as $document)
                                <div class="group relative bg-gray-50 border border-gray-200 rounded-lg p-4 hover:bg-gray-100 hover:border-gray-300 transition-all duration-200">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                                @php
                                                    $extension = strtolower(pathinfo($document, PATHINFO_EXTENSION));
                                                @endphp
                                                @if(in_array($extension, ['pdf']))
                                                    <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                                    </svg>
                                                @elseif(in_array($extension, ['doc', 'docx']))
                                                    <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                    </svg>
                                                @else
                                                    <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                    </svg>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="ml-4 flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-900 truncate">
                                                {{ basename($document) }}
                                            </p>
                                            <p class="text-xs text-gray-500 mt-1">
                                                {{ strtoupper(pathinfo($document, PATHINFO_EXTENSION)) }} File
                                            </p>
                                        </div>
                                        <div class="ml-4 flex-shrink-0">
                                            <a href="{{ Storage::url($document) }}" target="_blank"
                                               class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-blue-700 bg-blue-100 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                                Lihat
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <!-- Photos Section -->
                        @if($service->photos && count($service->photos))
                        <div>
                            <h4 class="text-base font-medium text-gray-900 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                Foto ({{ count($service->photos) }})
                            </h4>
                            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-2 xl:grid-cols-4 gap-4">
                                @foreach($service->photos as $photo)
                                <div class="group relative cursor-pointer" onclick="openImageModal('{{ Storage::url($photo) }}')">
                                    <div class="aspect-w-1 aspect-h-1 w-full overflow-hidden rounded-lg bg-gray-200 group-hover:opacity-90 transition-all duration-200">
                                        <img src="{{ Storage::url($photo) }}"
                                             alt="Foto Service"
                                             class="w-full h-32 sm:h-36 object-cover group-hover:scale-105 transition-transform duration-200">
                                    </div>
                                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition-all duration-200 rounded-lg flex items-center justify-center">
                                        <div class="opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                            <div class="bg-white rounded-full p-2 shadow-lg">
                                                <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                @endif
            </div>
            <!-- Right Column - Vehicle Information -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex items-center mb-6">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                         <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12a7.5 7.5 0 0 0 15 0m-15 0a7.5 7.5 0 1 1 15 0m-15 0H3m16.5 0H21m-1.5 0H12m-8.457 3.077 1.41-.513m14.095-5.13 1.41-.513M5.106 17.785l1.15-.964m11.49-9.642 1.149-.964M7.501 19.795l.75-1.3m7.5-12.99.75-1.3m-6.063 16.658.26-1.477m2.605-14.772.26-1.477m0 17.726-.26-1.477M10.698 4.614l-.26-1.477M16.5 19.794l-.75-1.299M7.5 4.205 12 12m6.894 5.785-1.149-.964M6.256 7.178l-1.15-.964m15.352 8.864-1.41-.513M4.954 9.435l-1.41-.514M12.002 12l-3.75 6.495" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-gray-900">Informasi Kendaraan</h3>
                                <p class="text-sm text-gray-500">Detail kendaraan yang di-service</p>
                            </div>
                        </div>

                        @if($service->vehicle)
                        <div class="space-y-6">
                            <!-- Vehicle Identity Card -->
                            <div class="bg-gradient-to-r from-indigo-50 to-blue-50 rounded-lg p-4 border border-indigo-200">
                                <div class="text-center">
                                    <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                        <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                             <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12a7.5 7.5 0 0 0 15 0m-15 0a7.5 7.5 0 1 1 15 0m-15 0H3m16.5 0H21m-1.5 0H12m-8.457 3.077 1.41-.513m14.095-5.13 1.41-.513M5.106 17.785l1.15-.964m11.49-9.642 1.149-.964M7.501 19.795l.75-1.3m7.5-12.99.75-1.3m-6.063 16.658.26-1.477m2.605-14.772.26-1.477m0 17.726-.26-1.477M10.698 4.614l-.26-1.477M16.5 19.794l-.75-1.299M7.5 4.205 12 12m6.894 5.785-1.149-.964M6.256 7.178l-1.15-.964m15.352 8.864-1.41-.513M4.954 9.435l-1.41-.514M12.002 12l-3.75 6.495" />
                                        </svg>
                                    </div>
                                    <h4 class="text-lg font-bold text-gray-900">{{ $service->vehicle->brand }} {{ $service->vehicle->model }}</h4>
                                    <div class="mt-2 inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800">
                                        {{ $service->vehicle->license_plate }}
                                    </div>
                                </div>
                            </div>

                            <!-- Vehicle Details -->
                            <div class="space-y-4">
                                <div class="flex items-center justify-between py-3 border-b border-gray-200">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <span class="text-sm font-medium text-gray-500">Tahun Produksi</span>
                                    </div>
                                    <span class="text-sm font-semibold text-gray-900">{{ $service->vehicle->year }}</span>
                                </div>

                                <div class="flex items-center justify-between py-3 border-b border-gray-200">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zM21 5a2 2 0 00-2-2h-4a2 2 0 00-2 2v12a4 4 0 004 4h4a2 2 0 002-2V5z"></path>
                                        </svg>
                                        <span class="text-sm font-medium text-gray-500">Warna</span>
                                    </div>
                                    <span class="text-sm font-semibold text-gray-900">{{ $service->vehicle->color }}</span>
                                </div>

                                @if($service->vehicle->fuel_type)
                                <div class="flex items-center justify-between py-3 border-b border-gray-200">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.879 16.121A3 3 0 1012.015 11L11 14l4 4-6.121-1.879z"></path>
                                        </svg>
                                        <span class="text-sm font-medium text-gray-500">Bahan Bakar</span>
                                    </div>
                                    <span class="text-sm font-semibold text-gray-900">{{ ucfirst($service->vehicle->fuel_type) }}</span>
                                </div>
                                @endif

                                <div class="flex items-center justify-between py-3">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span class="text-sm font-medium text-gray-500">Status</span>
                                    </div>
                                    <div>
                                        @php
                                            $availabilityColors = [
                                                'available' => 'bg-green-100 text-green-800 ring-green-600/20',
                                                'borrowed' => 'bg-blue-100 text-blue-800 ring-blue-600/20',
                                                'service' => 'bg-yellow-100 text-yellow-800 ring-yellow-600/20',
                                                'maintenance' => 'bg-red-100 text-red-800 ring-red-600/20'
                                            ];
                                            $availabilityLabels = [
                                                'available' => 'Tersedia',
                                                'borrowed' => 'Dipinjam',
                                                'service' => 'Service',
                                                'maintenance' => 'Maintenance'
                                            ];
                                        @endphp
                                        <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium ring-1 ring-inset {{ $availabilityColors[$service->vehicle->availability_status] ?? 'bg-gray-100 text-gray-800 ring-gray-500/20' }}">
                                            {{ $availabilityLabels[$service->vehicle->availability_status] ?? $service->vehicle->availability_status }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @else
                        <div class="text-center py-12">
                            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 15.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Data Tidak Ditemukan</h3>
                            <p class="text-sm text-gray-500">Informasi kendaraan tidak tersedia atau telah dihapus dari sistem</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Enhanced Image Modal -->
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-90 hidden z-50 items-center justify-center p-4">
    <div class="relative max-w-6xl max-h-full w-full">
        <!-- Close Button -->
        <button onclick="closeImageModal()"
                class="absolute top-4 right-4 z-20 bg-white bg-opacity-10 hover:bg-opacity-20 text-white rounded-full p-2 transition-all duration-200 backdrop-blur-sm">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>

        <!-- Image Container -->
        <div class="flex items-center justify-center h-full">
            <img id="modalImage"
                 src=""
                 alt="Foto Service"
                 class="max-w-full max-h-full object-contain rounded-lg shadow-2xl">
        </div>

        <!-- Image Info -->
        <div class="absolute bottom-4 left-4 right-4 text-center">
            <div class="bg-black bg-opacity-50 text-white px-4 py-2 rounded-lg backdrop-blur-sm">
                <p class="text-sm">Klik di luar gambar atau tekan ESC untuk menutup</p>
            </div>
        </div>
    </div>
</div>

<script>
function openImageModal(imageSrc) {
    const modal = document.getElementById('imageModal');
    const modalImage = document.getElementById('modalImage');

    modalImage.src = imageSrc;
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.style.overflow = 'hidden';

    // Add smooth fade-in animation
    modal.style.opacity = '0';
    setTimeout(() => {
        modal.style.opacity = '1';
        modal.style.transition = 'opacity 0.3s ease-in-out';
    }, 10);
}

function closeImageModal() {
    const modal = document.getElementById('imageModal');

    // Add smooth fade-out animation
    modal.style.opacity = '0';
    setTimeout(() => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = 'auto';
        modal.style.transition = '';
    }, 300);
}

// Close modal when clicking outside the image
document.getElementById('imageModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeImageModal();
    }
});

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeImageModal();
    }
});

// Prevent image dragging
document.getElementById('modalImage').addEventListener('dragstart', function(e) {
    e.preventDefault();
});

// Add loading state for images
document.querySelectorAll('img[data-lazy]').forEach(img => {
    img.addEventListener('load', function() {
        this.style.opacity = '1';
    });
});
</script>
@endsection
