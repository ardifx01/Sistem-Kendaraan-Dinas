@extends('layouts.app')

@section('title', 'Dashboard Admin')

@push('styles')
<style>
    /* Additional Tailwind utilities untuk dashboard */
    .bg-gray-50 { background-color: #f9fafb; }
    .bg-white { background-color: #ffffff; }
    .text-gray-900 { color: #111827; }
    .text-gray-600 { color: #4b5563; }
    .text-gray-500 { color: #6b7280; }
    .text-gray-400 { color: #9ca3af; }
    .text-blue-500 { color: #3b82f6; }
    .text-blue-600 { color: #2563eb; }
    .text-green-600 { color: #16a34a; }
    .text-green-800 { color: #166534; }
    .text-yellow-600 { color: #ca8a04; }
    .text-yellow-800 { color: #92400e; }
    .text-red-600 { color: #dc2626; }
    .text-red-800 { color: #991b1b; }
    .text-red-400 { color: #f87171; }
    .text-red-500 { color: #ef4444; }
    .text-red-700 { color: #b91c1c; }
    .text-indigo-600 { color: #4f46e5; }
    .text-indigo-500 { color: #6366f1; }
    .text-indigo-900 { color: #312e81; }

    .bg-blue-500 { background-color: #3b82f6; }
    .bg-blue-600 { background-color: #2563eb; }
    .bg-blue-100 { background-color: #dbeafe; }
    .bg-blue-200 { background-color: #bfdbfe; }
    .bg-green-500 { background-color: #22c55e; }
    .bg-green-600 { background-color: #16a34a; }
    .bg-green-100 { background-color: #dcfce7; }
    .bg-yellow-500 { background-color: #eab308; }
    .bg-yellow-600 { background-color: #ca8a04; }
    .bg-yellow-100 { background-color: #fef3c7; }
    .bg-red-100 { background-color: #fee2e2; }
    .bg-red-800 { background-color: #991b1b; }
    .bg-red-50 { background-color: #fef2f2; }
    .bg-indigo-500 { background-color: #6366f1; }
    .bg-indigo-600 { background-color: #4f46e5; }
    .bg-indigo-700 { background-color: #4338ca; }
    .bg-gray-50 { background-color: #f9fafb; }
    .bg-gray-100 { background-color: #f3f4f6; }
    .bg-gray-200 { background-color: #e5e7eb; }
    .bg-gray-800 { background-color: #1f2937; }

    .border-gray-100 { border-color: #f3f4f6; }
    .border-gray-200 { border-color: #e5e7eb; }
    .border-blue-200 { border-color: #bfdbfe; }
    .border-green-200 { border-color: #bbf7d0; }
    .border-yellow-200 { border-color: #fef08a; }
    .border-indigo-200 { border-color: #c7d2fe; }
    .border-red-400 { border-color: #f87171; }

    .hover\:shadow-lg:hover {
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }

    .hover\:border-blue-200:hover { border-color: #bfdbfe; }
    .hover\:border-green-200:hover { border-color: #bbf7d0; }
    .hover\:border-yellow-200:hover { border-color: #fef08a; }
    .hover\:border-indigo-200:hover { border-color: #c7d2fe; }
    .hover\:bg-gray-50:hover { background-color: #f9fafb; }
    .hover\:bg-red-50:hover { background-color: #fef2f2; }
    .hover\:text-indigo-900:hover { color: #312e81; }
    .hover\:text-red-900:hover { color: #7f1d1d; }
    .hover\:scale-105:hover { transform: scale(1.05); }
    .hover\:shadow-lg:hover { box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); }

    .group:hover .group-hover\:scale-110 { transform: scale(1.1); }
    .group:hover .group-hover\:translate-x-1 { transform: translateX(0.25rem); }

    /* Gradient backgrounds */
    .bg-gradient-to-br { background-image: linear-gradient(to bottom right, var(--tw-gradient-stops)); }
    .bg-gradient-to-r { background-image: linear-gradient(to right, var(--tw-gradient-stops)); }
    .from-blue-500 { --tw-gradient-from: #3b82f6; --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to, rgba(59, 130, 246, 0)); }
    .to-blue-600 { --tw-gradient-to: #2563eb; }
    .from-blue-600 { --tw-gradient-from: #2563eb; --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to, rgba(37, 99, 235, 0)); }
    .to-blue-700 { --tw-gradient-to: #1d4ed8; }
    .from-green-500 { --tw-gradient-from: #22c55e; --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to, rgba(34, 197, 94, 0)); }
    .to-green-600 { --tw-gradient-to: #16a34a; }
    .from-green-600 { --tw-gradient-from: #16a34a; --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to, rgba(22, 163, 74, 0)); }
    .to-green-700 { --tw-gradient-to: #15803d; }
    .from-yellow-500 { --tw-gradient-from: #eab308; --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to, rgba(234, 179, 8, 0)); }
    .to-yellow-600 { --tw-gradient-to: #ca8a04; }
    .from-indigo-500 { --tw-gradient-from: #6366f1; --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to, rgba(99, 102, 241, 0)); }
    .to-indigo-600 { --tw-gradient-to: #4f46e5; }
    .from-indigo-600 { --tw-gradient-from: #4f46e5; --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to, rgba(79, 70, 229, 0)); }
    .to-indigo-700 { --tw-gradient-to: #4338ca; }
    .from-red-50 { --tw-gradient-from: #fef2f2; --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to, rgba(254, 242, 242, 0)); }
    .to-red-100 { --tw-gradient-to: #fee2e2; }

    /* Responsive grid */
    .grid { display: grid; }
    .grid-cols-1 { grid-template-columns: repeat(1, minmax(0, 1fr)); }
    .gap-4 { gap: 1rem; }
    .gap-6 { gap: 1.5rem; }
    .mb-8 { margin-bottom: 2rem; }

    /* Enhanced Responsive utilities */
    /* Mobile First - 320px to 639px */
    .text-xl { font-size: 1.25rem; line-height: 1.75rem; }
    .text-2xl { font-size: 1.5rem; line-height: 2rem; }
    .px-3 { padding-left: 0.75rem; padding-right: 0.75rem; }
    .py-2 { padding-top: 0.5rem; padding-bottom: 0.5rem; }
    .gap-3 { gap: 0.75rem; }
    .mb-6 { margin-bottom: 1.5rem; }
    .mt-4 { margin-top: 1rem; }
    .w-8 { width: 2rem; }
    .h-8 { height: 2rem; }
    .p-3 { padding: 0.75rem; }
    .text-xxs { font-size: 0.625rem; line-height: 0.75rem; }

    /* Small devices - 640px and up */
    @media (min-width: 640px) {
        .sm\:grid-cols-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .sm\:text-3xl { font-size: 1.875rem; line-height: 2.25rem; }
        .sm\:text-4xl { font-size: 2.25rem; line-height: 2.5rem; }
        .sm\:text-base { font-size: 1rem; line-height: 1.5rem; }
        .sm\:flex-row { flex-direction: row; }
        .sm\:items-center { align-items: center; }
        .sm\:justify-between { justify-content: space-between; }
        .sm\:table-cell { display: table-cell; }
        .sm\:px-6 { padding-left: 1.5rem; padding-right: 1.5rem; }
        .sm\:py-4 { padding-top: 1rem; padding-bottom: 1rem; }
        .sm\:w-12 { width: 3rem; }
        .sm\:h-12 { height: 3rem; }
        .sm\:text-sm { font-size: 0.875rem; line-height: 1.25rem; }
        .sm\:gap-4 { gap: 1rem; }
        .sm\:mb-8 { margin-bottom: 2rem; }
        .sm\:p-6 { padding: 1.5rem; }
    }

    /* Medium devices - 768px and up */
    @media (min-width: 768px) {
        .md\:grid-cols-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .md\:grid-cols-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }
        .md\:text-lg { font-size: 1.125rem; line-height: 1.75rem; }
        .md\:px-8 { padding-left: 2rem; padding-right: 2rem; }
        .md\:py-6 { padding-top: 1.5rem; padding-bottom: 1.5rem; }
        .md\:gap-6 { gap: 1.5rem; }
        .md\:flex-row { flex-direction: row; }
        .md\:items-center { align-items: center; }
        .md\:block { display: block; }
        .md\:hidden { display: none; }
    }

    /* Large devices - 1024px and up */
    @media (min-width: 1024px) {
        .lg\:grid-cols-4 { grid-template-columns: repeat(4, minmax(0, 1fr)); }
        .lg\:grid-cols-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }
        .lg\:col-span-2 { grid-column: span 2 / span 2; }
        .lg\:col-span-1 { grid-column: span 1 / span 1; }
        .lg\:text-xl { font-size: 1.25rem; line-height: 1.75rem; }
        .lg\:px-8 { padding-left: 2rem; padding-right: 2rem; }
        .lg\:gap-8 { gap: 2rem; }
        .lg\:block { display: block; }
        .lg\:flex { display: flex; }
    }

    /* Extra large devices - 1280px and up */
    @media (min-width: 1280px) {
        .xl\:grid-cols-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }
        .xl\:grid-cols-4 { grid-template-columns: repeat(4, minmax(0, 1fr)); }
        .xl\:px-10 { padding-left: 2.5rem; padding-right: 2.5rem; }
        .xl\:text-2xl { font-size: 1.5rem; line-height: 2rem; }
    }

    /* 2XL devices - 1536px and up */
    @media (min-width: 1536px) {
        .\32xl\:grid-cols-5 { grid-template-columns: repeat(5, minmax(0, 1fr)); }
        .\32xl\:px-12 { padding-left: 3rem; padding-right: 3rem; }
        .\32xl\:max-w-8xl { max-width: 88rem; }
    }

    /* Border radius */
    .rounded-2xl { border-radius: 1rem; }
    .rounded-xl { border-radius: 0.75rem; }
    .rounded-lg { border-radius: 0.5rem; }
    .rounded-full { border-radius: 9999px; }

    /* Shadow */
    .shadow-sm { box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); }
    .shadow-lg { box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05); }

    /* Other utilities */
    .min-h-screen { min-height: 100vh; }
    .max-w-7xl { max-width: 80rem; }
    .mx-auto { margin-left: auto; margin-right: auto; }
    .px-4 { padding-left: 1rem; padding-right: 1rem; }
    .px-6 { padding-left: 1.5rem; padding-right: 1.5rem; }
    .py-6 { padding-top: 1.5rem; padding-bottom: 1.5rem; }
    .py-5 { padding-top: 1.25rem; padding-bottom: 1.25rem; }
    .py-4 { padding-top: 1rem; padding-bottom: 1rem; }
    .py-3 { padding-top: 0.75rem; padding-bottom: 0.75rem; }
    .py-12 { padding-top: 3rem; padding-bottom: 3rem; }
    .p-6 { padding: 1.5rem; }
    .p-4 { padding: 1rem; }
    .mt-1 { margin-top: 0.25rem; }
    .mt-2 { margin-top: 0.5rem; }
    .mt-3 { margin-top: 0.75rem; }
    .mt-4 { margin-top: 1rem; }
    .mt-6 { margin-top: 1.5rem; }
    .mt-8 { margin-top: 2rem; }
    .mb-1 { margin-bottom: 0.25rem; }
    .mb-4 { margin-bottom: 1rem; }
    .ml-1 { margin-left: 0.25rem; }
    .ml-2 { margin-left: 0.5rem; }
    .ml-3 { margin-left: 0.75rem; }
    .ml-4 { margin-left: 1rem; }
    .mr-1 { margin-right: 0.25rem; }
    .mr-2 { margin-right: 0.5rem; }

    /* Flex utilities */
    .flex { display: flex; }
    .flex-col { flex-direction: column; }
    .items-center { align-items: center; }
    .items-start { align-items: flex-start; }
    .justify-between { justify-content: space-between; }
    .justify-center { align-items: center; }
    .flex-1 { flex: 1 1 0%; }
    .flex-shrink-0 { flex-shrink: 0; }
    .min-w-0 { min-width: 0px; }
    .space-x-2 > :not([hidden]) ~ :not([hidden]) { margin-left: 0.5rem; }

    /* Typography */
    .text-3xl { font-size: 1.875rem; line-height: 2.25rem; }
    .text-lg { font-size: 1.125rem; line-height: 1.75rem; }
    .text-sm { font-size: 0.875rem; line-height: 1.25rem; }
    .text-xs { font-size: 0.75rem; line-height: 1rem; }
    .font-bold { font-weight: 700; }
    .font-semibold { font-weight: 600; }
    .font-medium { font-weight: 500; }
    .uppercase { text-transform: uppercase; }
    .tracking-wider { letter-spacing: 0.05em; }
    .truncate {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    /* Borders */
    .border { border-width: 1px; }
    .border-l-4 { border-left-width: 4px; }
    .border-b { border-bottom-width: 1px; }
    .border-transparent { border-color: transparent; }

    /* Spacing and sizing */
    .w-4 { width: 1rem; }
    .w-5 { width: 1.25rem; }
    .w-7 { width: 1.75rem; }
    .w-14 { width: 3.5rem; }
    .w-2 { width: 0.5rem; }
    .h-4 { height: 1rem; }
    .h-5 { height: 1.25rem; }
    .h-7 { height: 1.75rem; }
    .h-14 { height: 3.5rem; }
    .h-2 { height: 0.5rem; }
    .h-10 { width: 2.5rem; height: 2.5rem; }
    .h-12 { width: 3rem; height: 3rem; }
    .w-10 { width: 2.5rem; }
    .w-12 { width: 3rem; }

    /* Display */
    .hidden { display: none; }
    .inline-flex { display: inline-flex; }
    .table { display: table; }
    .table-cell { display: table-cell; }

    /* Overflow */
    .overflow-hidden { overflow: hidden; }
    .overflow-x-auto { overflow-x: auto; }

    /* Text decoration and cursor */
    .text-center { text-align: center; }
    .text-left { text-align: left; }
    .text-right { text-align: right; }
    .whitespace-nowrap { white-space: nowrap; }

    /* Positioning */
    .relative { position: relative; }

    /* Table styles */
    .min-w-full { min-width: 100%; }
    .divide-y { border-top-width: 1px; }
    .divide-gray-200 > :not([hidden]) ~ :not([hidden]) { border-top-color: #e5e7eb; border-top-width: 1px; }

    /* Transform */
    .transform { transform: var(--tw-transform); }

    /* Additional button styles */
    .hover\:from-blue-600:hover { --tw-gradient-from: #2563eb; }
    .hover\:to-blue-700:hover { --tw-gradient-to: #1d4ed8; }
    .hover\:from-green-600:hover { --tw-gradient-from: #16a34a; }
    .hover\:to-green-700:hover { --tw-gradient-to: #15803d; }
    .hover\:from-indigo-600:hover { --tw-gradient-from: #4f46e5; }
    .hover\:to-indigo-700:hover { --tw-gradient-to: #4338ca; }

    .opacity-90 { opacity: 0.9; }

    /* Specific badge styles */
    .px-2\.5 { padding-left: 0.625rem; padding-right: 0.625rem; }
    .py-0\.5 { padding-top: 0.125rem; padding-bottom: 0.125rem; }

    .group { position: relative; }
</style>
@endpush

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8 xl:px-10 2xl:px-12 2xl:max-w-8xl py-4 sm:py-6">
        <!-- Header with Welcome Message - Enhanced Responsive -->
        <div class="mb-6 sm:mb-8">
            <div class="flex flex-col space-y-3 sm:space-y-0 sm:flex-row sm:items-center sm:justify-between">
                <div class="flex-1 min-w-0">
                    <h1 class="text-xl sm:text-3xl lg:text-4xl xl:text-4xl font-bold text-gray-900 leading-tight">
                        Selamat datang, {{ auth()->user()->name }}
                    </h1>
                    <p class="mt-1 text-xs sm:text-sm lg:text-base text-gray-600">
                        Dashboard Admin - Sistem Manajemen Kendaraan Dinas
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
                                <svg class="w-5 h-5 sm:w-6 sm:h-6 lg:w-8 lg:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
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

        <!-- Alert untuk Pajak Akan Habis - Enhanced Responsive -->
        @if($data['vehicles_tax_expiring'] > 0)
            <div class="mb-6 sm:mb-8">
                <div class="bg-gradient-to-r from-red-50 to-red-100 border-l-4 border-red-400 rounded-lg p-3 sm:p-4 shadow-sm">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="h-4 w-4 sm:h-5 sm:w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3 flex-1">
                            <h3 class="text-xs sm:text-sm font-medium text-red-800">Peringatan Pajak Kendaraan!</h3>
                            <div class="mt-1 text-xs sm:text-sm text-red-700">
                                <p>Ada <strong>{{ $data['vehicles_tax_expiring'] }}</strong> kendaraan dengan pajak akan habis dalam 30 hari ke depan. Segera lakukan perpanjangan!</p>
                            </div>
                            <div class="mt-2 sm:mt-3">
                                <a href="#tax-expiring" class="text-xs sm:text-sm font-medium text-red-800 hover:text-red-900 inline-flex items-center">
                                    Lihat detail
                                    <svg class="ml-1 w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Quick Actions - Enhanced Responsive -->
        <div class="mt-6 sm:mt-8 mb-6 sm:mb-8">
            <div class="bg-white rounded-xl sm:rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-4 sm:px-6 py-4 sm:py-5 border-b border-gray-300">
                    <h3 class="text-base sm:text-lg font-semibold text-gray-900 flex items-center">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-indigo-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        Aksi Cepat
                    </h3>
                </div>
                <div class="p-4 sm:p-6">
                    <div class="grid grid-cols-1 gap-3 sm:gap-4 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3">
                        <a href="{{ route('admin.vehicles.create') }}" class="group relative bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white rounded-lg sm:rounded-xl p-4 sm:p-6 transition-all duration-300 transform hover:scale-100 hover:shadow-lg">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 sm:h-6 sm:w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                </div>
                                <div class="ml-3 min-w-0 flex-1">
                                    <p class="text-sm sm:text-base font-medium truncate">Tambah Kendaraan</p>
                                    <p class="text-xs sm:text-sm opacity-90 hidden sm:block">Daftarkan unit baru</p>
                                </div>
                            </div>
                        </a>

                        <a href="{{ route('admin.users.create') }}" class="group relative bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white rounded-lg sm:rounded-xl p-4 sm:p-6 transition-all duration-300 transform hover:scale-100 hover:shadow-lg">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 sm:h-6 sm:w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                                    </svg>
                                </div>
                                <div class="ml-3 min-w-0 flex-1">
                                    <p class="text-sm sm:text-base font-medium truncate">Tambah Operator</p>
                                    <p class="text-xs sm:text-sm opacity-90 hidden sm:block">Daftarkan user baru</p>
                                </div>
                            </div>
                        </a>

                        <a href="{{ route('admin.vehicles.index') }}" class="group relative bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 text-white rounded-lg sm:rounded-xl p-4 sm:p-6 transition-all duration-300 transform hover:scale-100 hover:shadow-lg md:col-span-2 lg:col-span-1">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 sm:h-6 sm:w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                                <div class="ml-3 min-w-0 flex-1">
                                    <p class="text-sm sm:text-base font-medium truncate">Kelola Kendaraan</p>
                                    <p class="text-xs sm:text-sm opacity-90 hidden sm:block">Manajemen unit</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Grid - Enhanced Responsive -->
        <div class="grid grid-cols-1 gap-4 sm:gap-6 lg:grid-cols-3 xl:grid-cols-3">
            <!-- Kendaraan Terbaru - Enhanced Mobile Layout -->
            <div class="lg:col-span-2 order-1">
                <div class="bg-white rounded-xl sm:rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-4 sm:px-6 py-4 sm:py-5 border-b border-gray-100">
                        <h3 class="text-base sm:text-lg font-semibold text-gray-900 flex items-center">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            Kendaraan Terbaru
                        </h3>
                    </div>

                    @if($vehicles->count() > 0)
                        <!-- Mobile Card Layout -->
                        <div class="block sm:hidden">
                            <div class="divide-y divide-gray-200">
                                @foreach($vehicles as $vehicle)
                                    <div class="p-4 hover:bg-gray-50 transition-colors duration-200">
                                        <div class="flex items-center space-x-3">
                                            <div class="flex-shrink-0">
                                                <div class="h-8 w-8 rounded-lg bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center">
                                                    <svg class="h-4 w-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <div class="text-sm font-medium text-gray-900 truncate">
                                                    {{ $vehicle->brand }} {{ $vehicle->model }}
                                                </div>
                                                <div class="text-xs text-gray-500">{{ $vehicle->license_plate }} • {{ $vehicle->year }}</div>
                                            </div>
                                            <div class="flex-shrink-0">
                                                @if($vehicle->availability_status == 'tersedia')
                                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                        Tersedia
                                                    </span>
                                                @elseif($vehicle->availability_status == 'dipinjam')
                                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                        Dipinjam
                                                    </span>
                                                @elseif($vehicle->availability_status == 'service')
                                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                        Service
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                        {{ ucfirst($vehicle->availability_status) }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Desktop Table Layout -->
                        <div class="hidden sm:block overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kendaraan</th>
                                        <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">Tahun</th>
                                        <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($vehicles as $vehicle)
                                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-8 w-8 sm:h-10 sm:w-10">
                                                        <div class="h-8 w-8 sm:h-10 sm:w-10 rounded-lg bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center">
                                                            <svg class="h-4 w-4 sm:h-5 sm:w-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                                            </svg>
                                                        </div>
                                                    </div>
                                                    <div class="ml-3 sm:ml-4">
                                                        <div class="text-xs sm:text-sm font-medium text-gray-900">
                                                            {{ $vehicle->brand }} {{ $vehicle->model }}
                                                        </div>
                                                        <div class="text-xs text-gray-500">{{ $vehicle->license_plate }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-xs sm:text-sm text-gray-500 hidden md:table-cell">
                                                {{ $vehicle->year }}
                                            </td>
                                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                                @if($vehicle->availability_status == 'tersedia')
                                                    <span class="inline-flex items-center px-2 sm:px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                        <svg class="w-2 h-2 mr-1" fill="currentColor" viewBox="0 0 8 8">
                                                            <circle cx="4" cy="4" r="3"/>
                                                        </svg>
                                                        <span class="hidden sm:inline">Tersedia</span>
                                                        <span class="sm:hidden">✓</span>
                                                    </span>
                                                @elseif($vehicle->availability_status == 'dipinjam')
                                                    <span class="inline-flex items-center px-2 sm:px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                        <svg class="w-2 h-2 mr-1" fill="currentColor" viewBox="0 0 8 8">
                                                            <circle cx="4" cy="4" r="3"/>
                                                        </svg>
                                                        <span class="hidden sm:inline">Dipinjam</span>
                                                        <span class="sm:hidden">⏰</span>
                                                    </span>
                                                @elseif($vehicle->availability_status == 'service')
                                                    <span class="inline-flex items-center px-2 sm:px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                        <svg class="w-2 h-2 mr-1" fill="currentColor" viewBox="0 0 8 8">
                                                            <circle cx="4" cy="4" r="3"/>
                                                        </svg>
                                                        <span class="hidden sm:inline">Service</span>
                                                        <span class="sm:hidden">🔧</span>
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-2 sm:px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                        <svg class="w-2 h-2 mr-1" fill="currentColor" viewBox="0 0 8 8">
                                                            <circle cx="4" cy="4" r="3"/>
                                                        </svg>
                                                        {{ ucfirst($vehicle->availability_status) }}
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="px-4 sm:px-6 py-3 sm:py-4 bg-gray-50">
                            <a href="{{ route('admin.vehicles.index') }}" class="text-indigo-600 hover:text-indigo-900 text-xs sm:text-sm font-medium flex items-center group">
                                Lihat semua kendaraan
                                <svg class="ml-1 w-3 h-3 sm:w-4 sm:h-4 group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    @else
                        <div class="px-4 sm:px-6 py-8 sm:py-12 text-center">
                            <svg class="mx-auto h-10 w-10 sm:h-12 sm:w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada kendaraan</h3>
                            <p class="mt-1 text-xs sm:text-sm text-gray-500">Mulai dengan menambahkan kendaraan baru.</p>
                            <div class="mt-4 sm:mt-6">
                                <a href="{{ route('admin.vehicles.create') }}" class="inline-flex items-center px-3 py-2 sm:px-4 sm:py-2 border border-transparent shadow-sm text-xs sm:text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                                    Tambah Kendaraan
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Kendaraan Pajak Akan Habis - Enhanced Mobile Layout -->
            <div id="tax-expiring" class="lg:col-span-1 order-2 lg:order-none">
                <div class="bg-white rounded-xl sm:rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-4 sm:px-6 py-4 sm:py-5 border-b border-gray-100">
                        <h3 class="text-base sm:text-lg font-semibold text-gray-900 flex items-center">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="hidden sm:inline">Pajak Akan Habis</span>
                            <span class="sm:hidden">Pajak Expiry</span>
                        </h3>
                    </div>

                    @if($expiring_tax_vehicles->count() > 0)
                        <div class="divide-y divide-gray-200">
                            @foreach($expiring_tax_vehicles as $vehicle)
                                <div class="px-4 sm:px-6 py-3 sm:py-4 hover:bg-red-50 transition-colors duration-200">
                                    <div class="flex items-center justify-between">
                                        <div class="flex-1 min-w-0">
                                            <p class="text-xs sm:text-sm font-medium text-gray-900 truncate">
                                                {{ $vehicle->brand }} {{ $vehicle->model }}
                                            </p>
                                            <p class="text-xs text-gray-500">{{ $vehicle->license_plate }}</p>
                                        </div>
                                        <div class="flex-shrink-0 ml-2 sm:ml-4">
                                            <div class="text-right">
                                                <p class="text-xs sm:text-sm font-medium text-red-600">
                                                    {{ $vehicle->tax_expiry_date->format('d/m/Y') }}
                                                </p>
                                                <p class="text-xs text-red-500">
                                                    <span class="hidden sm:inline">{{ $vehicle->tax_expiry_date->diffInDays(now()) }} hari lagi</span>
                                                    <span class="sm:hidden">{{ $vehicle->tax_expiry_date->diffInDays(now()) }}d</span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="px-4 sm:px-6 py-8 sm:py-12 text-center">
                            <svg class="mx-auto h-8 w-8 sm:h-12 sm:w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <h3 class="mt-2 text-xs sm:text-sm font-medium text-gray-900">
                                <span class="hidden sm:inline">Semua pajak aman</span>
                                <span class="sm:hidden">Pajak aman</span>
                            </h3>
                            <p class="mt-1 text-xs sm:text-sm text-gray-500">
                                <span class="hidden sm:inline">Tidak ada kendaraan dengan pajak akan habis.</span>
                                <span class="sm:hidden">Tidak ada yang expired</span>
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>


    </div>
</div>
@endsection
