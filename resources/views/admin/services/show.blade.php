@extends('layouts.app')

@section('title', 'Detail Service Kendaraan (Admin)')

@section('content')
<div class="min-h-screen bg-gray-50 py-4 sm:py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header (admin back only) -->
        <div class="mb-6 sm:mb-8">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 px-4 py-5 sm:p-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('admin.vehicles.index') }}"
                           class="inline-flex items-center p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-all duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </a>
                        <div>
                            <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-900">Detail Service Kendaraan</h1>
                            <p class="mt-1 text-sm text-gray-600">Informasi lengkap service kendaraan (admin view)</p>
                        </div>
                    </div>
                    <!-- Admin does not have edit/delete here to avoid operator-only routes -->
                </div>
            </div>
        </div>

        <!-- Main Content: copied from operator.services.show but with admin-safe links/actions -->
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

                            <!-- Payment Type -->
                            <div class="space-y-1">
                                <dt class="text-sm font-medium text-gray-500 flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 10c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm0-18C5.48 0 0 5.48 0 12s5.48 12 12 12 12-5.48 12-12S18.52 0 12 0z" />
                                    </svg>
                                    Jenis Pembayaran
                                </dt>
                                <dd class="text-sm font-medium text-gray-900">
                                    @php
                                        $paymentTypeLabels = [
                                            'asuransi' => 'Asuransi',
                                            'kantor' => 'Pembayaran Kantor'
                                        ];
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                        {{ $paymentTypeLabels[$service->payment_type] ?? ($service->payment_type ?: '-') }}
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

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <!-- Documents List -->
                            <div>
                                <h4 class="text-md font-semibold text-gray-900 mb-3">Dokumen</h4>
                                <ul class="space-y-2">
                                    @foreach($service->documents as $document)
                                    <li>
                                        <a href="{{ Storage::url($document) }}" target="_blank"
                                           class="flex items-center p-3 bg-gray-50 rounded-lg border border-gray-200 hover:bg-gray-100 transition-all duration-200">
                                            <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h10M7 12h10m-5 5h5"></path>
                                            </svg>
                                            <div class="flex-1">
                                                <p class="text-sm font-medium text-gray-900">{{ basename($document) }}</p>
                                                <p class="text-xs text-gray-500">{{ $service->created_at ? $service->created_at->diffForHumans() : '-' }}</p>
                                            </div>
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>

                            <!-- Photos Gallery -->
                            <div>
                                <h4 class="text-md font-semibold text-gray-900 mb-3">Foto</h4>
                                <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                                    @foreach($service->photos as $photo)
                                    <div>
                                        <a href="{{ Storage::url($photo) }}" target="_blank"
                                           class="block aspect-w-1 aspect-h-1 rounded-lg overflow-hidden bg-gray-100 hover:bg-gray-200 transition-all duration-200">
                                            <img src="{{ Storage::url($photo) }}" alt="{{ basename($photo) }}"
                                                 class="object-cover object-center w-full h-full">
                                        </a>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
