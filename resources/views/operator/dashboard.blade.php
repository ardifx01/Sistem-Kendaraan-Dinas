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

        <!-- Combined Service Card: Kendaraan Butuh Service + Service Terakhir -->
        <div class="mt-6 sm:mt-8 mb-6 sm:mb-8">
            <div class="bg-white rounded-xl sm:rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-4 sm:px-6 py-4 sm:py-5 border-b border-gray-100 bg-gradient-to-r from-orange-400 to-orange-300">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-yellow-700 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <h3 class="text-base sm:text-lg font-semibold text-gray-900">Kendaraan &amp; Riwayat Service</h3>
                            <p class="ml-3 text-sm text-yellow-800 hidden sm:inline">Ringkasan: Kendaraan yang butuh service dan riwayat service terakhir</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h4 class="text-sm font-semibold text-gray-900">Kendaraan Butuh Service</h4>
                    <p class="mt-1 text-xs text-yellow-800 hidden sm:inline">(≥ 90 hari sejak service terakhir)</p>
                    <div class="mt-4">
                        @if(isset($service_due_vehicles) && $service_due_vehicles->count() > 0)
                            <div class="space-y-2">
                                @foreach($service_due_vehicles as $vehicle)
                                    <div class="flex items-center justify-between p-3 bg-yellow-50 rounded-md border border-yellow-100 hover:shadow-sm transition-shadow">
                                        <div class="min-w-0">
                                            <p class="text-sm font-medium text-gray-900 truncate">{{ $vehicle->brand }} {{ $vehicle->model }} <span class="text-xs text-gray-500">• {{ $vehicle->license_plate }}</span></p>
                                            @if($vehicle->latestService && $vehicle->latestService->service_date)
                                                <p class="text-xxs text-gray-500">Terakhir servis: {{ \Carbon\Carbon::parse($vehicle->latestService->service_date)->translatedFormat('d F Y') }}</p>
                                            @else
                                                <p class="text-xxs text-gray-500">Tanpa riwayat servis</p>
                                            @endif
                                        </div>
                                        <div class="text-right ml-4">
                                            @php
                                                $latest = $vehicle->latestService;
                                                if ($latest && $latest->service_date) {
                                                    $signed = \Carbon\Carbon::parse($latest->service_date)->diffInDays(now(), false);
                                                    $days = (int) abs($signed);
                                                }
                                            @endphp
                                            <div class="px-4 sm:px-6 py-3 sm:py-4">
                                                <div class="flex items-center justify-between mb-2">
                                                    <div class="flex items-center">
                                                        <h4 class="text-sm font-semibold text-gray-900">Kendaraan Butuh Service</h4>
                                                        <p class="ml-3 text-xs text-yellow-800 hidden sm:inline">(≥ 90 hari sejak service terakhir)</p>
                                                    </div>
                                                    <div class="text-xs text-gray-500">Total: {{ $data['vehicles_service_due'] ?? ($service_due_vehicles->total() ?? 0) }} kendaraan</div>
                                                </div>

                                                @if($days !== null)
                                                    @php $urgent = $days >= 90; $dayClass = $urgent ? 'text-sm font-semibold text-red-600' : 'text-sm font-semibold text-yellow-800'; @endphp
                                                    <p class="{{ $dayClass }}">{{ number_format($days, 0, ',', '.') }} hari</p>
                                                    <p class="text-xs text-gray-500">sejak service</p>
                                                @else
                                                    <p class="text-sm font-semibold text-yellow-800">—</p>
                                                    @if(!empty($days_since_created))
                                                        <p class="text-xs text-gray-500">tanpa riwayat • {{ number_format($days_since_created, 0, ',', '.') }} hari sejak dibuat</p>
                                                    @else
                                                        <p class="text-xs text-gray-500">tanpa riwayat</p>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Pagination for service due vehicles -->
                            <div class="mt-3 px-0 sm:px-6 py-3 bg-white border-t border-gray-100">
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                                    <div class="text-xs text-gray-500">
                                        Menampilkan {{ $service_due_vehicles->firstItem() }}–{{ $service_due_vehicles->lastItem() }} dari {{ $service_due_vehicles->total() }} kendaraan
                                    </div>
                                    <div>
                                        {{-- Laravel paginator (Tailwind) --}}
                                        {{ $service_due_vehicles->withQueryString()->links() }}
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="py-3 text-sm text-gray-500">Tidak ada kendaraan yang butuh service.</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-2 sm:mb-0">Informasi Kendaraan</h3>
        </div>

        <!-- Card Pajak Hampir Habis -->
        <div class="mb-6">
            <div class="bg-red-50 rounded-lg p-4 border border-red-200">
                <div class="flex items-center justify-between mb-3">
                    <h4 class="text-md font-semibold text-red-900 flex items-center">
                        Kendaraan Pajak Hampir Habis
                    </h4>
                    <span class="text-xs bg-red-100 text-red-800 px-2 py-1 rounded">{{ $vehicles_tax_expiring->count() }} kendaraan</span>
                </div>
                @if($vehicles_tax_expiring->count() > 0)
                    <div class="space-y-2 max-h-96 overflow-y-auto">
                        @foreach($vehicles_tax_expiring as $vehicle)
                            <div class="flex items-center justify-between p-3 bg-white rounded border hover:shadow-sm transition-shadow">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $vehicle->license_plate }}</p>
                                    <p class="text-xs text-gray-600">{{ $vehicle->brand }} {{ $vehicle->model }}</p>
                                    <p class="text-xs text-gray-500">{{ $vehicle->type }}</p>
                                    <p class="text-xs text-red-600">Pajak habis: {{ \Carbon\Carbon::parse($vehicle->tax_expiry_date)->translatedFormat('d F Y') }}</p>
                                </div>
                                <span class="text-xs bg-red-100 text-red-800 px-2 py-1 rounded font-semibold">Segera Perpanjang</span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-red-600">Tidak ada kendaraan yang pajaknya akan habis dalam waktu dekat.</p>
                @endif
            </div>
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
            <div class="bg-yellow-50 rounded-lg p-4 border border-yellow-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-yellow-600">Service</p>
                        <p class="text-2xl font-bold text-yellow-900">{{ $vehicles_by_status['service'] ?? 0 }}</p>
                    </div>
                    <div class="w-8 h-8 bg-yellow-200 rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
            <div class="bg-yellow-50 rounded-lg p-4 border border-yellow-200">
                <h4 class="text-md font-semibold text-yellow-900 mb-3 flex items-center">
                    <svg class="w-4 h-4 mr-2 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                                <span class="text-xs bg-yellow-100 text-red-800 px-2 py-1 rounded">Dalam Service</span>
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

// Status card click handlers untuk navigasi ke halaman services dengan filter
document.addEventListener('DOMContentLoaded', function() {
    // Add click handlers untuk status cards
    const statusCards = document.querySelectorAll('.status-card');
    statusCards.forEach(card => {
        card.addEventListener('click', function() {
            const status = this.getAttribute('data-status');
            if (status) {
                // Use concatenation to avoid mixing Blade echos with JS template literals
                window.location.href = "{{ route('operator.services.index') }}" + '?status=' + encodeURIComponent(status);
            }
        });
    });
});
</script>
@endpush
@endsection
