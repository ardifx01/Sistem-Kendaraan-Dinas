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

        <!-- Stats Cards with Enhanced Responsive Design -->
        <div class="grid grid-cols-1 gap-3 sm:gap-4 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-4 2xl:grid-cols-5 mb-6 sm:mb-8">
            <!-- Total Kendaraan -->
            <div class="group relative bg-white rounded-xl sm:rounded-2xl shadow-sm border border-gray-300 hover:shadow-lg hover:border-blue-200 transition-all duration-300">
                <div class="p-4 sm:p-6">
                    <div class="flex items-center justify-between">
                        <div class="flex-1 min-w-0">
                            <p class="text-xs sm:text-sm font-medium text-gray-600 mb-1 truncate">Total Kendaraan</p>
                            <p class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-900">{{ $data['total_vehicles'] }}</p>
                            <p class="text-xxs sm:text-xs text-green-600 mt-1 hidden sm:block">
                                <span class="inline-flex items-center">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    Semua unit terdaftar
                                </span>
                            </p>
                            <!-- Mobile version - simplified -->
                            <p class="text-xxs text-green-600 mt-1 sm:hidden">
                                ✓ Terdaftar
                            </p>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 sm:w-12 sm:h-12 lg:w-14 lg:h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg sm:rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-9 h-9 sm:w-6 sm:h-6 lg:w-8 lg:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.712 4.33a9.027 9.027 0 0 1 1.652 1.306c.51.51.944 1.064 1.306 1.652M16.712 4.33l-3.448 4.138m3.448-4.138a9.014 9.014 0 0 0-9.424 0M19.67 7.288l-4.138 3.448m4.138-3.448a9.014 9.014 0 0 1 0 9.424m-4.138-5.976a3.736 3.736 0 0 0-.88-1.388 3.737 3.737 0 0 0-1.388-.88m2.268 2.268a3.765 3.765 0 0 1 0 2.528m-2.268-4.796a3.765 3.765 0 0 0-2.528 0m4.796 4.796c-.181.506-.475.982-.88 1.388a3.736 3.736 0 0 1-1.388.88m2.268-2.268 4.138 3.448m0 0a9.027 9.027 0 0 1-1.306 1.652c-.51.51-1.064.944-1.652 1.306m0 0-3.448-4.138m3.448 4.138a9.014 9.014 0 0 1-9.424 0m5.976-4.138a3.765 3.765 0 0 1-2.528 0m0 0a3.736 3.736 0 0 1-1.388-.88 3.737 3.737 0 0 1-.88-1.388m2.268 2.268L7.288 19.67m0 0a9.024 9.024 0 0 1-1.652-1.306 9.027 9.027 0 0 1-1.306-1.652m0 0 4.138-3.448M4.33 16.712a9.014 9.014 0 0 1 0-9.424m4.138 5.976a3.765 3.765 0 0 1 0-2.528m0 0c.181-.506.475-.982.88-1.388a3.736 3.736 0 0 1 1.388-.88m-2.268 2.268L4.33 7.288m6.406 1.18L7.288 4.33m0 0a9.024 9.024 0 0 0-1.652 1.306A9.025 9.025 0 0 0 4.33 7.288" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kendaraan Tersedia -->
            <div class="group relative bg-white rounded-xl sm:rounded-2xl shadow-sm border border-gray-300 hover:shadow-lg hover:border-green-200 transition-all duration-300">
                <div class="p-4 sm:p-6">
                    <div class="flex items-center justify-between">
                        <div class="flex-1 min-w-0">
                            <p class="text-xs sm:text-sm font-medium text-gray-600 mb-1 truncate">Kendaraan Tersedia</p>
                            <p class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-900">{{ $data['available_vehicles'] }}</p>
                            <p class="text-xxs sm:text-xs text-green-600 mt-1 hidden sm:block">
                                <span class="inline-flex items-center">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    Siap digunakan
                                </span>
                            </p>
                            <p class="text-xxs text-green-600 mt-1 sm:hidden">
                                ✓ Siap pakai
                            </p>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 sm:w-12 sm:h-12 lg:w-14 lg:h-14 bg-gradient-to-br from-green-500 to-green-600 rounded-lg sm:rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-5 h-5 sm:w-6 sm:h-6 lg:w-7 lg:h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kendaraan Dipinjam -->
            <div class="group relative bg-white rounded-xl sm:rounded-2xl shadow-sm border border-gray-300 hover:shadow-lg hover:border-yellow-200 transition-all duration-300">
                <div class="p-4 sm:p-6">
                    <div class="flex items-center justify-between">
                        <div class="flex-1 min-w-0">
                            <p class="text-xs sm:text-sm font-medium text-gray-600 mb-1 truncate">Sedang Dipinjam</p>
                            <p class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-900">{{ $data['borrowed_vehicles'] }}</p>
                            <p class="text-xxs sm:text-xs text-yellow-600 mt-1 hidden sm:block">
                                <span class="inline-flex items-center">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                    </svg>
                                    Dalam penggunaan
                                </span>
                            </p>
                            <p class="text-xxs text-yellow-600 mt-1 sm:hidden">
                                ⏰ Digunakan
                            </p>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 sm:w-12 sm:h-12 lg:w-14 lg:h-14 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-lg sm:rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-5 h-5 sm:w-6 sm:h-6 lg:w-7 lg:h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kendaraan Service -->
            <div class="group relative bg-white rounded-xl sm:rounded-2xl shadow-sm border border-gray-300 hover:shadow-lg hover:border-red-200 transition-all duration-300">
                <div class="p-4 sm:p-6">
                    <div class="flex items-center justify-between">
                        <div class="flex-1 min-w-0">
                            <p class="text-xs sm:text-sm font-medium text-gray-600 mb-1 truncate">Sedang Service</p>
                            <p class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-900">{{ $data['vehicles_in_service'] ?? 0 }}</p>
                            <p class="text-xxs sm:text-xs text-red-600 mt-1 hidden sm:block">
                                <span class="inline-flex items-center">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.293l-3-3a1 1 0 00-1.414 1.414L10.586 9.5 9.293 10.793a1 1 0 101.414 1.414l3-3a1 1 0 000-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                    Dalam perbaikan
                                </span>
                            </p>
                            <p class="text-xxs text-red-600 mt-1 sm:hidden">
                                🔧 Perbaikan
                            </p>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 sm:w-12 sm:h-12 lg:w-14 lg:h-14 bg-gradient-to-br from-red-500 to-red-600 rounded-lg sm:rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-5 h-5 sm:w-6 sm:h-6 lg:w-7 lg:h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Operator -->
            <div class="group relative bg-white rounded-xl sm:rounded-2xl shadow-sm border border-gray-300 hover:shadow-lg hover:border-indigo-200 transition-all duration-300">
                <div class="p-4 sm:p-6">
                    <div class="flex items-center justify-between">
                        <div class="flex-1 min-w-0">
                            <p class="text-xs sm:text-sm font-medium text-gray-600 mb-1 truncate">Total Operator</p>
                            <p class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-900">{{ $data['total_operators'] }}</p>
                            <p class="text-xxs sm:text-xs text-indigo-600 mt-1 hidden sm:block">
                                <span class="inline-flex items-center">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path>
                                    </svg>
                                    User aktif
                                </span>
                            </p>
                            <p class="text-xxs text-indigo-600 mt-1 sm:hidden">
                                👥 Aktif
                            </p>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 sm:w-12 sm:h-12 lg:w-14 lg:h-14 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-lg sm:rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-5 h-5 sm:w-6 sm:h-6 lg:w-8 lg:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                  <path d="M4.5 6.375a4.125 4.125 0 1 1 8.25 0 4.125 4.125 0 0 1-8.25 0ZM14.25 8.625a3.375 3.375 0 1 1 6.75 0 3.375 3.375 0 0 1-6.75 0ZM1.5 19.125a7.125 7.125 0 0 1 14.25 0v.003l-.001.119a.75.75 0 0 1-.363.63 13.067 13.067 0 0 1-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 0 1-.364-.63l-.001-.122ZM17.25 19.128l-.001.144a2.25 2.25 0 0 1-.233.96 10.088 10.088 0 0 0 5.06-1.01.75.75 0 0 0 .42-.643 4.875 4.875 0 0 0-6.957-4.611 8.586 8.586 0 0 1 1.71 5.157v.003Z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions untuk Operator -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Aksi Cepat</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <a href="#" class="flex flex-col items-center justify-center p-4 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors duration-200">
                    <svg class="w-8 h-8 text-blue-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    <span class="text-sm font-medium text-blue-900">Tambah Kendaraan</span>
                </a>

                <a href="#" class="flex flex-col items-center justify-center p-4 bg-green-50 hover:bg-green-100 rounded-lg transition-colors duration-200">
                    <svg class="w-8 h-8 text-green-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    <span class="text-sm font-medium text-green-900">Laporan</span>
                </a>

                <a href="#" class="flex flex-col items-center justify-center p-4 bg-yellow-50 hover:bg-yellow-100 rounded-lg transition-colors duration-200">
                    <svg class="w-8 h-8 text-yellow-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <span class="text-sm font-medium text-yellow-900">Service</span>
                </a>

                <a href="#" class="flex flex-col items-center justify-center p-4 bg-purple-50 hover:bg-purple-100 rounded-lg transition-colors duration-200">
                    <svg class="w-8 h-8 text-purple-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <span class="text-sm font-medium text-purple-900">Profil</span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
