@extends('layouts.app')

@section('title', 'Dashboard Operator')

@push('styles')
<style>
    /* Custom Animations */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes pulse {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: .8;
        }
    }

    @keyframes bounce {
        0%, 100% {
            transform: translateY(-25%);
            animation-timing-function: cubic-bezier(0.8,0,1,1);
        }
        50% {
            transform: none;
            animation-timing-function: cubic-bezier(0,0,0.2,1);
        }
    }

    .animate-fadeInUp {
        animation: fadeInUp 0.6s ease-out;
    }

    .animate-slideInRight {
        animation: slideInRight 0.6s ease-out;
    }

    .animate-pulse {
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }

    .animate-bounce {
        animation: bounce 1s infinite;
    }

    /* Glass Morphism Effect */
    .glass {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .glass-dark {
        background: rgba(0, 0, 0, 0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    /* Gradient Backgrounds */
    .bg-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .bg-gradient-success {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    }

    .bg-gradient-warning {
        background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
    }

    .bg-gradient-danger {
        background: linear-gradient(135deg, #ff6b6b 0%, #feca57 100%);
    }

    /* Custom styles untuk responsive design yang sudah ada di attachment */
    .bg-gray-50 { background-color: #f9fafb; }
    .bg-white { background-color: #ffffff; }
    .text-gray-900 { color: #111827; }
    .text-gray-600 { color: #4b5563; }
    .text-gray-500 { color: #6b7280; }
    .text-green-600 { color: #16a34a; }
    .text-yellow-600 { color: #ca8a04; }
    .text-red-600 { color: #dc2626; }
    .text-indigo-600 { color: #4f46e5; }

    /* Grid responsif */
    .grid { display: grid; }
    .grid-cols-1 { grid-template-columns: repeat(1, minmax(0, 1fr)); }
    .gap-3 { gap: 0.75rem; }
    .gap-4 { gap: 1rem; }

    @media (min-width: 640px) {
        .sm\:gap-4 { gap: 1rem; }
        .sm\:grid-cols-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .sm\:text-sm { font-size: 0.875rem; line-height: 1.25rem; }
        .sm\:text-2xl { font-size: 1.5rem; line-height: 2rem; }
        .sm\:p-6 { padding: 1.5rem; }
        .sm\:w-12 { width: 3rem; }
        .sm\:h-12 { height: 3rem; }
        .sm\:w-6 { width: 1.5rem; }
        .sm\:h-6 { height: 1.5rem; }
        .sm\:rounded-2xl { border-radius: 1rem; }
        .sm\:rounded-xl { border-radius: 0.75rem; }
        .sm\:block { display: block; }
        .sm\:hidden { display: none; }
    }

    @media (min-width: 768px) {
        .md\:grid-cols-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    }

    @media (min-width: 1024px) {
        .lg\:grid-cols-4 { grid-template-columns: repeat(4, minmax(0, 1fr)); }
        .lg\:text-3xl { font-size: 1.875rem; line-height: 2.25rem; }
        .lg\:w-14 { width: 3.5rem; }
        .lg\:h-14 { height: 3.5rem; }
        .lg\:w-8 { width: 2rem; }
        .lg\:h-8 { height: 2rem; }
        .lg\:w-7 { width: 1.75rem; }
        .lg\:h-7 { height: 1.75rem; }
    }

    @media (min-width: 1280px) {
        .xl\:grid-cols-4 { grid-template-columns: repeat(4, minmax(0, 1fr)); }
    }

    @media (min-width: 1536px) {
        .\32xl\:grid-cols-5 { grid-template-columns: repeat(5, minmax(0, 1fr)); }
    }

    /* Layout dan styling lainnya */
    .relative { position: relative; }
    .flex { display: flex; }
    .items-center { align-items: center; }
    .justify-between { justify-content: space-between; }
    .flex-1 { flex: 1 1 0%; }
    .min-w-0 { min-width: 0px; }
    .flex-shrink-0 { flex-shrink: 0; }
    .truncate { overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    .p-4 { padding: 1rem; }
    .mb-1 { margin-bottom: 0.25rem; }
    .mt-1 { margin-top: 0.25rem; }
    .mr-1 { margin-right: 0.25rem; }
    .mr-3 { margin-right: 0.75rem; }
    .text-xs { font-size: 0.75rem; line-height: 1rem; }
    .text-xl { font-size: 1.25rem; line-height: 1.75rem; }
    .text-xxs { font-size: 0.625rem; line-height: 0.75rem; }
    .font-medium { font-weight: 500; }
    .font-bold { font-weight: 700; }
    .w-10 { width: 2.5rem; }
    .h-10 { height: 2.5rem; }
    .w-5 { width: 1.25rem; }
    .h-5 { height: 1.25rem; }
    .w-3 { width: 0.75rem; }
    .h-3 { height: 0.75rem; }
    .rounded-xl { border-radius: 0.75rem; }
    .rounded-lg { border-radius: 0.5rem; }
    .shadow-sm { box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); }
    .shadow-lg { box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05); }
    .border { border-width: 1px; }
    .border-gray-300 { border-color: #d1d5db; }
    .border-blue-200 { border-color: #bfdbfe; }
    .border-green-200 { border-color: #bbf7d0; }
    .border-yellow-200 { border-color: #fef08a; }
    .border-red-200 { border-color: #fecaca; }
    .border-indigo-200 { border-color: #c7d2fe; }
    .transition-all { transition-property: all; }
    .duration-300 { transition-duration: 300ms; }
    .group:hover .group-hover\:scale-110 { transform: scale(1.1); }
    .hover\:shadow-lg:hover { box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05); }
    .hover\:border-blue-200:hover { border-color: #bfdbfe; }
    .hover\:border-green-200:hover { border-color: #bbf7d0; }
    .hover\:border-yellow-200:hover { border-color: #fef08a; }
    .hover\:border-red-200:hover { border-color: #fecaca; }
    .hover\:border-indigo-200:hover { border-color: #c7d2fe; }

    /* Gradient backgrounds */
    .bg-gradient-to-br { background-image: linear-gradient(to bottom right, var(--tw-gradient-stops)); }
    .from-blue-500 { --tw-gradient-from: #3b82f6; --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to, rgba(59, 130, 246, 0)); }
    .to-blue-600 { --tw-gradient-to: #2563eb; }
    .from-green-500 { --tw-gradient-from: #22c55e; --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to, rgba(34, 197, 94, 0)); }
    .to-green-600 { --tw-gradient-to: #16a34a; }
    .from-yellow-500 { --tw-gradient-from: #eab308; --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to, rgba(234, 179, 8, 0)); }
    .to-yellow-600 { --tw-gradient-to: #ca8a04; }
    .from-red-500 { --tw-gradient-from: #ef4444; --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to, rgba(239, 68, 68, 0)); }
    .to-red-600 { --tw-gradient-to: #dc2626; }
    .from-indigo-500 { --tw-gradient-from: #6366f1; --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to, rgba(99, 102, 241, 0)); }
    .to-indigo-600 { --tw-gradient-to: #4f46e5; }

    .inline-flex { display: inline-flex; }
    .stroke-2 { stroke-width: 2; }
</style>
@endpush

@section('content')
@php
use Carbon\Carbon;
// Set locale ke Indonesia
Carbon::setLocale('id');
@endphp
<div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8 xl:px-10 2xl:px-12 2xl:max-w-8xl py-4 sm:py-6">
        <!-- Header with Welcome Message -->
        <div class="mb-6 sm:mb-8">
            <div class="flex flex-col space-y-3 sm:space-y-0 sm:flex-row sm:items-center sm:justify-between">
                <div class="flex-1 min-w-0">
                    <h1 class="text-xl sm:text-3xl lg:text-4xl xl:text-4xl font-bold text-gray-900 leading-tight">
                        Selamat datang, {{ auth()->user()->name }}
                    </h1>
                    <p class="mt-1 text-xs sm:text-sm lg:text-base text-gray-600">
                        Dashboard Operator - Sistem Manajemen Kendaraan Dinas
                    </p>
                </div>
                <div class="mt-2 sm:mt-0 flex-shrink-0">
                    <div class="flex items-center space-x-2 text-xs sm:text-sm text-gray-500 bg-white px-3 py-2 rounded-lg border border-gray-200 sm:bg-transparent sm:border-0 sm:px-0 sm:py-0">
                        <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span>{{ now()->format('d F Y') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kendaraan Berdasarkan Status -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-2 sm:mb-0">Informasi Kendaraan</h3>
            </div>

            <!-- Status Overview Cards -->
            <div class="grid grid-cols-2 gap-4 mb-6">
                <!-- Tersedia -->
                <div class="bg-green-50 rounded-lg p-4 border border-green-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-green-600">Tersedia</p>
                            <p class="text-2xl font-bold text-green-900">{{ $vehicles_by_status['tersedia'] ?? 0 }}</p>
                        </div>
                        <div class="w-8 h-8 bg-green-200 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Service -->
                <div class="bg-red-50 rounded-lg p-4 border border-red-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-red-600">Service</p>
                            <p class="text-2xl font-bold text-red-900">{{ $vehicles_by_status['service'] ?? 0 }}</p>
                        </div>
                        <div class="w-8 h-8 bg-red-200 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detail Kendaraan per Status -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Semua Kendaraan Tersedia -->
                <div class="bg-green-50 rounded-lg p-4 border border-green-200">
                    <h4 class="text-md font-semibold text-green-900 mb-3 flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Semua Kendaraan Tersedia
                    </h4>
                    @if($vehicles_by_status_detailed['tersedia']->count() > 0)
                        <div class="space-y-2 max-h-96 overflow-y-auto">
                            @foreach($vehicles_by_status_detailed['tersedia'] as $vehicle)
                                <div class="flex items-center justify-between p-3 bg-white rounded border hover:shadow-sm transition-shadow">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ $vehicle->license_plate }}</p>
                                        <p class="text-xs text-gray-600">{{ $vehicle->brand }} {{ $vehicle->model }}</p>
                                        <p class="text-xs text-gray-500">{{ $vehicle->type }}</p>
                                    </div>
                                    <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded">Siap Pakai</span>
                                </div>
                            @endforeach
                        </div>
                        @if($vehicles_by_status['tersedia'] > $vehicles_by_status_detailed['tersedia']->count())
                            <p class="text-xs text-gray-500 mt-2 text-center">
                                Dan {{ $vehicles_by_status['tersedia'] - $vehicles_by_status_detailed['tersedia']->count() }} kendaraan lainnya...
                            </p>
                        @endif
                    @else
                        <p class="text-sm text-green-600">Tidak ada kendaraan tersedia</p>
                    @endif
                </div>

                <!-- Kendaraan Service -->
                <div class="bg-red-50 rounded-lg p-4 border border-red-200">
                    <h4 class="text-md font-semibold text-red-900 mb-3 flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Kendaraan Dalam Service
                    </h4>
                    @if($vehicles_by_status_detailed['service']->count() > 0)
                        <div class="space-y-2 max-h-96 overflow-y-auto">
                            @foreach($vehicles_by_status_detailed['service'] as $vehicle)
                                <div class="flex items-center justify-between p-3 bg-white rounded border hover:shadow-sm transition-shadow">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ $vehicle->license_plate }}</p>
                                        <p class="text-xs text-gray-600">{{ $vehicle->brand }} {{ $vehicle->model }}</p>
                                        @if($vehicle->latestService)
                                            <p class="text-xs text-red-600">{{ $vehicle->latestService->service_type }}</p>
                                        @endif
                                    </div>
                                    <span class="text-xs bg-red-100 text-red-800 px-2 py-1 rounded">Dalam Service</span>
                                </div>
                            @endforeach
                        </div>
                        @if($vehicles_by_status['service'] > $vehicles_by_status_detailed['service']->count())
                            <p class="text-xs text-gray-500 mt-2 text-center">
                                Dan {{ $vehicles_by_status['service'] - $vehicles_by_status_detailed['service']->count() }} kendaraan lainnya...
                            </p>
                        @endif
                    @else
                        <p class="text-sm text-red-600">Tidak ada kendaraan dalam service</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Sederhana -->
<!-- 1. Modal Konfirmasi -->
<div id="confirmModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden justify-center items-center p-4">
    <div class="bg-white rounded-lg max-w-md w-full mx-4 transform transition-all duration-300 scale-95 opacity-0" id="confirmContent">
        <div class="p-6 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 15.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2" id="confirmTitle">Konfirmasi</h3>
            <p class="text-gray-600 mb-6" id="confirmMessage">Apakah Anda yakin?</p>
            <div class="flex space-x-3">
                <button id="confirmCancel" class="flex-1 px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors">
                    Batal
                </button>
                <button id="confirmOk" class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                    Hapus
                </button>
            </div>
        </div>
    </div>
</div>

<!-- 2. Modal Success -->
<div id="successModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden justify-center items-center p-4">
    <div class="bg-white rounded-lg max-w-md w-full mx-4 transform transition-all duration-300 scale-95 opacity-0" id="successContent">
        <div class="p-6 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100 mb-4">
                <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Berhasil!</h3>
            <p class="text-gray-600 mb-6" id="successMessage">Operasi berhasil dilakukan.</p>
            <button id="successOk" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                OK
            </button>
        </div>
    </div>
</div>

<!-- 3. Modal Error -->
<div id="errorModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden justify-center items-center p-4">
    <div class="bg-white rounded-lg max-w-md w-full mx-4 transform transition-all duration-300 scale-95 opacity-0" id="errorContent">
        <div class="p-6 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Terjadi Kesalahan!</h3>
            <p class="text-gray-600 mb-6" id="errorMessage">Operasi gagal dilakukan.</p>
            <button id="errorOk" class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                OK
            </button>
        </div>
    </div>
</div>

<!-- 4. Modal Loading -->
<div id="loadingModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden justify-center items-center p-4">
    <div class="bg-white rounded-lg max-w-sm w-full mx-4 transform transition-all duration-300 scale-95 opacity-0" id="loadingContent">
        <div class="p-6 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 mb-4">
                <svg class="animate-spin h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Memproses...</h3>
            <p class="text-gray-600" id="loadingMessage">Mohon tunggu sebentar.</p>
        </div>
    </div>
</div>

<!-- 5. Modal Info -->
<div id="infoModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden justify-center items-center p-4">
    <div class="bg-white rounded-lg max-w-md w-full mx-4 transform transition-all duration-300 scale-95 opacity-0" id="infoContent">
        <div class="p-6 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 mb-4">
                <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2" id="infoTitle">Informasi</h3>
            <p class="text-gray-600 mb-6" id="infoMessage">Informasi untuk Anda.</p>
            <button id="infoOk" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                Mengerti
            </button>
        </div>
    </div>
</div>

<!-- 6. Modal Validation -->
<div id="validationModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden justify-center items-center p-4">
    <div class="bg-white rounded-lg max-w-md w-full mx-4 transform transition-all duration-300 scale-95 opacity-0" id="validationContent">
        <div class="p-6">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <div class="flex items-center justify-center h-10 w-10 rounded-full bg-orange-100">
                        <svg class="h-6 w-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 15.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-4 flex-1">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Periksa Form Anda</h3>
                    <div class="text-sm text-gray-600" id="validationErrors">
                        <!-- Error list akan muncul di sini -->
                    </div>
                </div>
            </div>
            <div class="mt-6 text-center">
                <button id="validationOk" class="px-6 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition-colors">
                    OK, Saya Mengerti
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Simple Modal Manager untuk Dashboard
class DashboardModal {
    constructor() {
        this.modals = {
            confirm: document.getElementById('confirmModal'),
            success: document.getElementById('successModal'),
            error: document.getElementById('errorModal'),
            loading: document.getElementById('loadingModal'),
            info: document.getElementById('infoModal'),
            validation: document.getElementById('validationModal')
        };

        this.confirmCallback = null;
        this.init();
    }

    init() {
        // Event listeners untuk tombol modal
        document.getElementById('confirmOk')?.addEventListener('click', () => {
            this.hide('confirm');
            if (this.confirmCallback) this.confirmCallback();
        });

        document.getElementById('confirmCancel')?.addEventListener('click', () => {
            this.hide('confirm');
        });

        document.getElementById('successOk')?.addEventListener('click', () => {
            this.hide('success');
        });

        document.getElementById('errorOk')?.addEventListener('click', () => {
            this.hide('error');
        });

        document.getElementById('infoOk')?.addEventListener('click', () => {
            this.hide('info');
        });

        document.getElementById('validationOk')?.addEventListener('click', () => {
            this.hide('validation');
        });

        // Close modal ketika klik backdrop
        Object.values(this.modals).forEach(modal => {
            if (modal) {
                modal.addEventListener('click', (e) => {
                    if (e.target === modal) {
                        this.hideAll();
                    }
                });
            }
        });

        // Close dengan ESC key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                this.hideAll();
            }
        });
    }

    show(type) {
        const modal = this.modals[type];
        if (!modal) return;

        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';

        // Animate in
        const content = modal.querySelector(`#${type}Content`);
        if (content) {
            requestAnimationFrame(() => {
                content.style.transform = 'scale(1)';
                content.style.opacity = '1';
            });
        }
    }

    hide(type) {
        const modal = this.modals[type];
        if (!modal) return;

        const content = modal.querySelector(`#${type}Content`);
        if (content) {
            content.style.transform = 'scale(0.95)';
            content.style.opacity = '0';

            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                document.body.style.overflow = 'auto';
            }, 150);
        } else {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = 'auto';
        }
    }

    hideAll() {
        Object.keys(this.modals).forEach(type => this.hide(type));
    }

    // Show confirmation modal
    confirm(title, message, callback) {
        document.getElementById('confirmTitle').textContent = title;
        document.getElementById('confirmMessage').textContent = message;
        this.confirmCallback = callback;
        this.show('confirm');
    }

    // Show success modal
    success(message, autoHide = true) {
        document.getElementById('successMessage').textContent = message;
        this.show('success');

        if (autoHide) {
            setTimeout(() => this.hide('success'), 3000);
        }
    }

    // Show error modal
    error(message) {
        document.getElementById('errorMessage').textContent = message;
        this.show('error');
    }

    // Show loading modal
    loading(message = 'Memproses...') {
        document.getElementById('loadingMessage').textContent = message;
        this.show('loading');
    }

    // Hide loading modal
    hideLoading() {
        this.hide('loading');
    }

    // Show info modal
    info(title, message) {
        document.getElementById('infoTitle').textContent = title;
        document.getElementById('infoMessage').textContent = message;
        this.show('info');
    }

    // Show validation errors
    validation(errors) {
        const container = document.getElementById('validationErrors');
        let html = '<ul class="list-disc list-inside space-y-1 text-left">';

        if (Array.isArray(errors)) {
            errors.forEach(error => {
                html += `<li>${error}</li>`;
            });
        } else if (typeof errors === 'object') {
            Object.keys(errors).forEach(field => {
                if (Array.isArray(errors[field])) {
                    errors[field].forEach(error => {
                        html += `<li><strong>${this.formatField(field)}:</strong> ${error}</li>`;
                    });
                } else {
                    html += `<li><strong>${this.formatField(field)}:</strong> ${errors[field]}</li>`;
                }
            });
        } else {
            html += `<li>${errors}</li>`;
        }

        html += '</ul>';
        container.innerHTML = html;
        this.show('validation');
    }

    formatField(field) {
        const map = {
            'vehicle_id': 'Kendaraan',
            'service_date': 'Tanggal Service',
            'service_type': 'Jenis Service',
            'description': 'Deskripsi',
            'cost': 'Biaya',
            'garage_name': 'Nama Bengkel',
            'status': 'Status',
            'name': 'Nama',
            'email': 'Email'
        };
        return map[field] || field.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
    }
}

// Initialize modal
let dashModal;

document.addEventListener('DOMContentLoaded', function() {
    dashModal = new DashboardModal();

    // Global functions
    window.showConfirm = (title, message, callback) => dashModal.confirm(title, message, callback);
    window.showSuccess = (message, autoHide) => dashModal.success(message, autoHide);
    window.showError = (message) => dashModal.error(message);
    window.showInfo = (title, message) => dashModal.info(title, message);
    window.showLoading = (message) => dashModal.loading(message);
    window.hideLoading = () => dashModal.hideLoading();
    window.showValidation = (errors) => dashModal.validation(errors);
});

// Utility functions
async function deleteData(name, url) {
    showConfirm(
        'Konfirmasi Hapus',
        `Yakin ingin menghapus "${name}"? Tindakan ini tidak dapat dibatalkan.`,
        async () => {
            showLoading('Menghapus data...');

            try {
                const response = await fetch(url, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });

                const result = await response.json();
                hideLoading();

                if (result.success) {
                    showSuccess('Data berhasil dihapus!');
                    setTimeout(() => location.reload(), 1500);
                } else {
                    showError(result.message || 'Gagal menghapus data');
                }
            } catch (error) {
                hideLoading();
                showError('Terjadi kesalahan koneksi');
            }
        }
    );
}

async function updateStatus(name, newStatus, url) {
    showConfirm(
        'Konfirmasi Perubahan',
        `Yakin ingin mengubah status "${name}" ke "${newStatus}"?`,
        async () => {
            showLoading('Mengubah status...');

            try {
                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ status: newStatus })
                });

                const result = await response.json();
                hideLoading();

                if (result.success) {
                    showSuccess('Status berhasil diubah!');
                    setTimeout(() => location.reload(), 1500);
                } else {
                    showError(result.message || 'Gagal mengubah status');
                }
            } catch (error) {
                hideLoading();
                showError('Terjadi kesalahan koneksi');
            }
        }
    );
}

// Test modals (uncomment untuk test)
// setTimeout(() => {
//     showInfo('Test Modal', 'Modal berfungsi dengan baik!');
// }, 1000);
</script>
@endpush
<!-- 1. Modal Konfirmasi Hapus -->
<div id="deleteModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

        <!-- Modal panel -->
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="relative inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                        <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 15.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                            Konfirmasi Hapus
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500" id="deleteMessage">
                                Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" id="confirmDelete" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Hapus
                </button>
                <button type="button" id="cancelDelete" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Batal
                </button>
            </div>
        </div>
    </div>
</div>

<!-- 2. Modal Konfirmasi Status -->
<div id="statusModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="status-modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

        <!-- Modal panel -->
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="relative inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-yellow-100 sm:mx-0 sm:h-10 sm:w-10">
                        <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 15.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="status-modal-title">
                            Konfirmasi Perubahan Status
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500" id="statusMessage">
                                Apakah Anda yakin ingin mengubah status ini?
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" id="confirmStatus" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-yellow-600 text-base font-medium text-white hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 sm:ml-3 sm:w-auto sm:text-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Konfirmasi
                </button>
                <button type="button" id="cancelStatus" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Batal
                </button>
            </div>
        </div>
    </div>
</div>

<!-- 3. Modal Success -->
<div id="successModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="success-modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

        <!-- Modal panel -->
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="relative inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-green-100 sm:mx-0 sm:h-10 sm:w-10">
                        <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="success-modal-title">
                            Berhasil!
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500" id="successMessage">
                                Operasi berhasil dilakukan.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" id="closeSuccess" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
                    OK
                </button>
            </div>
        </div>
    </div>
</div>

<!-- 4. Modal Error -->
<div id="errorModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="error-modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

        <!-- Modal panel -->
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="relative inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                        <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="error-modal-title">
                            Terjadi Kesalahan!
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500" id="errorMessage">
                                Operasi gagal dilakukan.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" id="closeError" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                    OK
                </button>
            </div>
        </div>
    </div>
</div>

<!-- 5. Modal Loading -->
<div id="loadingModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="loading-modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

        <!-- Modal panel -->
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="relative inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-sm sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="text-center">
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 mb-4">
                        <svg class="animate-spin h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-2">
                        Memproses...
                    </h3>
                    <p class="text-sm text-gray-500" id="loadingMessage">
                        Mohon tunggu sebentar.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Modal Utilities
class ModalManager {
    constructor() {
        this.modals = {
            delete: document.getElementById('deleteModal'),
            status: document.getElementById('statusModal'),
            success: document.getElementById('successModal'),
            error: document.getElementById('errorModal'),
            loading: document.getElementById('loadingModal')
        };

        this.initializeEventListeners();
    }

    initializeEventListeners() {
        // Delete Modal
        const cancelDelete = document.getElementById('cancelDelete');
        if (cancelDelete) {
            cancelDelete.addEventListener('click', () => this.hide('delete'));
        }

        // Status Modal
        const cancelStatus = document.getElementById('cancelStatus');
        if (cancelStatus) {
            cancelStatus.addEventListener('click', () => this.hide('status'));
        }

        // Success Modal
        const closeSuccess = document.getElementById('closeSuccess');
        if (closeSuccess) {
            closeSuccess.addEventListener('click', () => this.hide('success'));
        }

        // Error Modal
        const closeError = document.getElementById('closeError');
        if (closeError) {
            closeError.addEventListener('click', () => this.hide('error'));
        }

        // Close modals when clicking backdrop
        Object.values(this.modals).forEach(modal => {
            if (modal) {
                modal.addEventListener('click', (e) => {
                    if (e.target === modal) {
                        this.hideAll();
                    }
                });
            }
        });

        // Close modals with Escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                this.hideAll();
            }
        });
    }

    show(type) {
        if (this.modals[type]) {
            this.modals[type].classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
    }

    hide(type) {
        if (this.modals[type]) {
            this.modals[type].classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
    }

    hideAll() {
        Object.keys(this.modals).forEach(type => this.hide(type));
    }

    // Show delete confirmation
    confirmDelete(message, onConfirm) {
        const messageEl = document.getElementById('deleteMessage');
        const confirmBtn = document.getElementById('confirmDelete');

        if (messageEl) messageEl.textContent = message;

        // Remove previous event listeners
        const newConfirmBtn = confirmBtn.cloneNode(true);
        confirmBtn.parentNode.replaceChild(newConfirmBtn, confirmBtn);

        // Add new event listener
        newConfirmBtn.addEventListener('click', () => {
            this.hide('delete');
            if (onConfirm) onConfirm();
        });

        this.show('delete');
    }

    // Show status confirmation
    confirmStatus(message, onConfirm) {
        const messageEl = document.getElementById('statusMessage');
        const confirmBtn = document.getElementById('confirmStatus');

        if (messageEl) messageEl.textContent = message;

        // Remove previous event listeners
        const newConfirmBtn = confirmBtn.cloneNode(true);
        confirmBtn.parentNode.replaceChild(newConfirmBtn, confirmBtn);

        // Add new event listener
        newConfirmBtn.addEventListener('click', () => {
            this.hide('status');
            if (onConfirm) onConfirm();
        });

        this.show('status');
    }

    // Show success message
    showSuccess(message) {
        const messageEl = document.getElementById('successMessage');
        if (messageEl) messageEl.textContent = message;
        this.show('success');

        // Auto hide after 3 seconds
        setTimeout(() => this.hide('success'), 3000);
    }

    // Show error message
    showError(message) {
        const messageEl = document.getElementById('errorMessage');
        if (messageEl) messageEl.textContent = message;
        this.show('error');
    }

    // Show loading
    showLoading(message = 'Memproses...') {
        const messageEl = document.getElementById('loadingMessage');
        if (messageEl) messageEl.textContent = message;
        this.show('loading');
    }

    // Hide loading
    hideLoading() {
        this.hide('loading');
    }
}

// Initialize modal manager
const modalManager = new ModalManager();

// Global functions for easy access
window.showDeleteConfirm = (message, onConfirm) => modalManager.confirmDelete(message, onConfirm);
window.showStatusConfirm = (message, onConfirm) => modalManager.confirmStatus(message, onConfirm);
window.showSuccess = (message) => modalManager.showSuccess(message);
window.showError = (message) => modalManager.showError(message);
window.showLoading = (message) => modalManager.showLoading(message);
window.hideLoading = () => modalManager.hideLoading();

// Example usage functions
function deleteItem(id, name) {
    showDeleteConfirm(
        `Apakah Anda yakin ingin menghapus "${name}"? Tindakan ini tidak dapat dibatalkan.`,
        () => {
            showLoading('Menghapus data...');

            // Simulate API call
            fetch(`/api/delete/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                hideLoading();
                if (data.success) {
                    showSuccess('Data berhasil dihapus!');
                    // Refresh page or remove element
                    setTimeout(() => location.reload(), 1500);
                } else {
                    showError(data.message || 'Terjadi kesalahan saat menghapus data');
                }
            })
            .catch(error => {
                hideLoading();
                showError('Terjadi kesalahan koneksi');
                console.error('Error:', error);
            });
        }
    );
}

function changeStatus(id, newStatus, currentStatus) {
    showStatusConfirm(
        `Apakah Anda yakin ingin mengubah status dari "${currentStatus}" ke "${newStatus}"?`,
        () => {
            showLoading('Mengubah status...');

            // Simulate API call
            fetch(`/api/change-status/${id}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ status: newStatus })
            })
            .then(response => response.json())
            .then(data => {
                hideLoading();
                if (data.success) {
                    showSuccess('Status berhasil diubah!');
                    setTimeout(() => location.reload(), 1500);
                } else {
                    showError(data.message || 'Terjadi kesalahan saat mengubah status');
                }
            })
            .catch(error => {
                hideLoading();
                showError('Terjadi kesalahan koneksi');
                console.error('Error:', error);
            });
        }
    );
}

// Form submission with validation
function submitFormWithValidation(formId, successMessage) {
    const form = document.getElementById(formId);
    if (!form) return;

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        showLoading('Menyimpan data...');

        const formData = new FormData(form);

        fetch(form.action, {
            method: form.method,
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            hideLoading();
            if (data.success) {
                showSuccess(successMessage || 'Data berhasil disimpan!');
                setTimeout(() => {
                    if (data.redirect) {
                        window.location.href = data.redirect;
                    } else {
                        location.reload();
                    }
                }, 1500);
            } else {
                showError(data.message || 'Terjadi kesalahan saat menyimpan data');
            }
        })
        .catch(error => {
            hideLoading();
            showError('Terjadi kesalahan koneksi');
            console.error('Error:', error);
        });
    });
}

// Status card click handlers untuk navigasi ke halaman services dengan filter
document.addEventListener('DOMContentLoaded', function() {
    // Add click handlers untuk status cards
    const statusCards = document.querySelectorAll('.status-card');
    statusCards.forEach(card => {
        card.addEventListener('click', function() {
            const status = this.getAttribute('data-status');
            if (status) {
                window.location.href = `{{ route('operator.services.index') }}?status=${status}`;
            }
        });
    });
});
</script>
@endpush
@endsection
