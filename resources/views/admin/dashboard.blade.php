@extends('layouts.app')

@section('title', 'Dashboard Admin')

@push('styles')
<style>
    /* Ensure navbar is always visible and properly positioned */
    /* Hapus CSS yang override Tailwind hidden/md:flex agar navbar desktop normal */

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

    /* Colors */
    .bg-gray-50 { background-color: #f9fafb; }
    .bg-gray-100 { background-color: #f3f4f6; }
    .bg-gray-200 { background-color: #e5e7eb; }
    .bg-gray-800 { background-color: #1f2937; }
    .bg-white { background-color: #ffffff; }

    .text-gray-900 { color: #111827; }
    .text-gray-600 { color: #4b5563; }
    .text-gray-500 { color: #6b7280; }
    .text-gray-400 { color: #9ca3af; }

    .text-blue-500 { color: #3b82f6; }
    .text-blue-600 { color: #2563eb; }
    .bg-blue-100 { background-color: #dbeafe; }
    .bg-blue-200 { background-color: #bfdbfe; }
    .bg-blue-500 { background-color: #3b82f6; }
    .bg-blue-600 { background-color: #2563eb; }
    .border-blue-200 { border-color: #bfdbfe; }

    .text-green-600 { color: #16a34a; }
    .text-green-800 { color: #166534; }
    .bg-green-100 { background-color: #dcfce7; }
    .bg-green-500 { background-color: #22c55e; }
    .bg-green-600 { background-color: #16a34a; }
    .border-green-200 { border-color: #bbf7d0; }

    .text-yellow-600 { color: #ca8a04; }
    .text-yellow-800 { color: #92400e; }
    .bg-yellow-100 { background-color: #fef3c7; }
    .bg-yellow-500 { background-color: #eab308; }
    .bg-yellow-600 { background-color: #ca8a04; }
    .border-yellow-200 { border-color: #fef08a; }

    .text-red-400 { color: #f87171; }
    .text-red-500 { color: #ef4444; }
    .text-red-600 { color: #dc2626; }
    .text-red-700 { color: #b91c1c; }
    .text-red-800 { color: #991b1b; }
    .bg-red-50 { background-color: #fef2f2; }
    .bg-red-100 { background-color: #fee2e2; }
    .bg-red-800 { background-color: #991b1b; }
    .border-red-400 { border-color: #f87171; }

    .text-indigo-500 { color: #6366f1; }
    .text-indigo-600 { color: #4f46e5; }
    .text-indigo-900 { color: #312e81; }
    .bg-indigo-500 { background-color: #6366f1; }
    .bg-indigo-600 { background-color: #4f46e5; }
    .bg-indigo-700 { background-color: #4338ca; }
    .border-indigo-200 { border-color: #c7d2fe; }

    .border-gray-100 { border-color: #f3f4f6; }
    .border-gray-200 { border-color: #e5e7eb; }

    /* Hover Effects */
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

    /* Group Hover Effects */
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

    .hover\:from-blue-600:hover { --tw-gradient-from: #2563eb; }
    .hover\:to-blue-700:hover { --tw-gradient-to: #1d4ed8; }
    .hover\:from-green-600:hover { --tw-gradient-from: #16a34a; }
    .hover\:to-green-700:hover { --tw-gradient-to: #15803d; }
    .hover\:from-indigo-600:hover { --tw-gradient-from: #4f46e5; }
    .hover\:to-indigo-700:hover { --tw-gradient-to: #4338ca; }

    /* Layout */
    .grid { display: grid; }
    .grid-cols-1 { grid-template-columns: repeat(1, minmax(0, 1fr)); }
    .gap-3 { gap: 0.75rem; }
    .gap-4 { gap: 1rem; }
    .gap-6 { gap: 1.5rem; }

    /* Spacing */
    .p-3 { padding: 0.75rem; }
    .p-4 { padding: 1rem; }
    .p-6 { padding: 1.5rem; }
    .px-2 { padding-left: 0.5rem; padding-right: 0.5rem; }
    .px-3 { padding-left: 0.75rem; padding-right: 0.75rem; }
    .px-4 { padding-left: 1rem; padding-right: 1rem; }
    .px-6 { padding-left: 1.5rem; padding-right: 1.5rem; }
    .py-2 { padding-top: 0.5rem; padding-bottom: 0.5rem; }
    .py-3 { padding-top: 0.75rem; padding-bottom: 0.75rem; }
    .py-4 { padding-top: 1rem; padding-bottom: 1rem; }
    .py-5 { padding-top: 1.25rem; padding-bottom: 1.25rem; }
    .py-6 { padding-top: 1.5rem; padding-bottom: 1.5rem; }
    .py-12 { padding-top: 3rem; padding-bottom: 3rem; }

    .m-1 { margin: 0.25rem; }
    .mt-1 { margin-top: 0.25rem; }
    .mt-2 { margin-top: 0.5rem; }
    .mt-3 { margin-top: 0.75rem; }
    .mt-4 { margin-top: 1rem; }
    .mt-6 { margin-top: 1.5rem; }
    .mt-8 { margin-top: 2rem; }
    .mb-1 { margin-bottom: 0.25rem; }
    .mb-4 { margin-bottom: 1rem; }
    .mb-6 { margin-bottom: 1.5rem; }
    .mb-8 { margin-bottom: 2rem; }
    .ml-1 { margin-left: 0.25rem; }
    .ml-2 { margin-left: 0.5rem; }
    .ml-3 { margin-left: 0.75rem; }
    .ml-4 { margin-left: 1rem; }
    .mr-1 { margin-right: 0.25rem; }
    .mr-2 { margin-right: 0.5rem; }

    /* Sizing */
    .w-2 { width: 0.5rem; }
    .w-3 { width: 0.75rem; }
    .w-4 { width: 1rem; }
    .w-5 { width: 1.25rem; }
    .w-7 { width: 1.75rem; }
    .w-8 { width: 2rem; }
    .w-10 { width: 2.5rem; }
    .w-12 { width: 3rem; }
    .w-14 { width: 3.5rem; }

    .h-2 { height: 0.5rem; }
    .h-3 { height: 0.75rem; }
    .h-4 { height: 1rem; }
    .h-5 { height: 1.25rem; }
    .h-7 { height: 1.75rem; }
    .h-8 { height: 2rem; }
    .h-10 { height: 2.5rem; }
    .h-12 { height: 3rem; }
    .h-14 { height: 3.5rem; }

    /* Typography */
    .text-xs { font-size: 0.75rem; line-height: 1rem; }
    .text-sm { font-size: 0.875rem; line-height: 1.25rem; }
    .text-base { font-size: 1rem; line-height: 1.5rem; }
    .text-lg { font-size: 1.125rem; line-height: 1.75rem; }
    .text-xl { font-size: 1.25rem; line-height: 1.75rem; }
    .text-2xl { font-size: 1.5rem; line-height: 2rem; }
    .text-3xl { font-size: 1.875rem; line-height: 2.25rem; }
    .text-xxs { font-size: 0.625rem; line-height: 0.75rem; }

    .font-medium { font-weight: 500; }
    .font-semibold { font-weight: 600; }
    .font-bold { font-weight: 700; }
    .uppercase { text-transform: uppercase; }
    .tracking-wider { letter-spacing: 0.05em; }
    .text-center { text-align: center; }
    .text-left { text-align: left; }
    .text-right { text-align: right; }
    .truncate {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .whitespace-nowrap { white-space: nowrap; }

    /* Flexbox */
    .flex { display: flex; }
    .flex-col { flex-direction: column; }
    .items-center { align-items: center; }
    .items-start { align-items: flex-start; }
    .justify-between { justify-content: space-between; }
    .justify-center { justify-content: center; }
    .flex-1 { flex: 1 1 0%; }
    .flex-shrink-0 { flex-shrink: 0; }
    .min-w-0 { min-width: 0px; }
    .space-x-2 > :not([hidden]) ~ :not([hidden]) { margin-left: 0.5rem; }

    /* Display */
    .hidden { display: none; }
    .inline-flex { display: inline-flex; }
    .table { display: table; }
    .table-cell { display: table-cell; }

    /* Borders */
    .border { border-width: 1px; }
    .border-l-4 { border-left-width: 4px; }
    .border-b { border-bottom-width: 1px; }
    .border-transparent { border-color: transparent; }
    .rounded-lg { border-radius: 0.5rem; }
    .rounded-xl { border-radius: 0.75rem; }
    .rounded-2xl { border-radius: 1rem; }
    .rounded-full { border-radius: 9999px; }

    /* Shadow */
    .shadow-sm { box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); }
    .shadow-lg { box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05); }

    /* Layout utilities */
    .min-h-screen { min-height: 100vh; }
    .max-w-7xl { max-width: 80rem; }
    .mx-auto { margin-left: auto; margin-right: auto; }
    .overflow-hidden { overflow: hidden; }
    .overflow-x-auto { overflow-x: auto; }
    .relative { position: relative; }
    .min-w-full { min-width: 100%; }
    .divide-y { border-top-width: 1px; }
    .divide-gray-200 > :not([hidden]) ~ :not([hidden]) {
        border-top-color: #e5e7eb;
        border-top-width: 1px;
    }
    .transform { transform: var(--tw-transform); }
    .opacity-90 { opacity: 0.9; }
    .group { position: relative; }

    /* Badge specific styles */
    .px-2\.5 { padding-left: 0.625rem; padding-right: 0.625rem; }
    .py-0\.5 { padding-top: 0.125rem; padding-bottom: 0.125rem; }

    /* Responsive utilities */
    @media (min-width: 640px) {
        .sm\:grid-cols-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .sm\:text-3xl { font-size: 1.875rem; line-height: 2.25rem; }
        .sm\:text-4xl { font-size: 2.25rem; line-height: 2.5rem; }
        .sm\:text-base { font-size: 1rem; line-height: 1.5rem; }
        .sm\:text-sm { font-size: 0.875rem; line-height: 1.25rem; }
        .sm\:flex-row { flex-direction: row; }
        .sm\:items-center { align-items: center; }
        .sm\:justify-between { justify-content: space-between; }
        .sm\:table-cell { display: table-cell; }
        .sm\:px-6 { padding-left: 1.5rem; padding-right: 1.5rem; }
        .sm\:py-4 { padding-top: 1rem; padding-bottom: 1rem; }
        .sm\:py-6 { padding-top: 1.5rem; padding-bottom: 1.5rem; }
        .sm\:w-12 { width: 3rem; }
        .sm\:h-12 { height: 3rem; }
        .sm\:gap-4 { gap: 1rem; }
        .sm\:mb-8 { margin-bottom: 2rem; }
        .sm\:p-6 { padding: 1.5rem; }
        .sm\:rounded-2xl { border-radius: 1rem; }
        .sm\:block { display: block; }
        .sm\:hidden { display: none; }
        .sm\:inline { display: inline; }
    }

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
        .md\:table-cell { display: table-cell; }
        .md\:col-span-2 { grid-column: span 2 / span 2; }
    }

    @media (min-width: 1024px) {
        .lg\:grid-cols-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }
        .lg\:grid-cols-4 { grid-template-columns: repeat(4, minmax(0, 1fr)); }
        .lg\:col-span-1 { grid-column: span 1 / span 1; }
        .lg\:col-span-2 { grid-column: span 2 / span 2; }
        .lg\:text-xl { font-size: 1.25rem; line-height: 1.75rem; }
        .lg\:text-3xl { font-size: 1.875rem; line-height: 2.25rem; }
        .lg\:text-4xl { font-size: 2.25rem; line-height: 2.5rem; }
        .lg\:px-8 { padding-left: 2rem; padding-right: 2rem; }
        .lg\:gap-8 { gap: 2rem; }
        .lg\:block { display: block; }
        .lg\:flex { display: flex; }
        .lg\:w-14 { width: 3.5rem; }
        .lg\:h-14 { height: 3.5rem; }
        .lg\:w-8 { width: 2rem; }
        .lg\:h-8 { height: 2rem; }
        .lg\:w-7 { width: 1.75rem; }
        .lg\:h-7 { height: 1.75rem; }
    }

    @media (min-width: 1280px) {
        .xl\:grid-cols-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }
        .xl\:grid-cols-4 { grid-template-columns: repeat(4, minmax(0, 1fr)); }
        .xl\:px-10 { padding-left: 2.5rem; padding-right: 2.5rem; }
        .xl\:text-2xl { font-size: 1.5rem; line-height: 2rem; }
        .xl\:text-4xl { font-size: 2.25rem; line-height: 2.5rem; }
    }

    @media (min-width: 1536px) {
        .\32xl\:grid-cols-5 { grid-template-columns: repeat(5, minmax(0, 1fr)); }
        .\32xl\:px-12 { padding-left: 3rem; padding-right: 3rem; }
        .\32xl\:max-w-8xl { max-width: 88rem; }
    }
</style>
@endpush

@section('content')
@php
use Carbon\Carbon;
// Set locale ke Indonesia
Carbon::setLocale('id');
@endphp
<div class="bg-gray-50 min-h-screen">
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
                                <p>Ada <strong>{{ $data['vehicles_tax_expiring'] }}</strong> kendaraan dengan pajak akan habis dalam 2 bulan ke depan atau sudah expired. Segera lakukan perpanjangan!</p>
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

    {{-- Service due section removed — compact card is shown under Quick Actions. --}}

        <!-- Stats Cards with Enhanced Responsive Design -->
        <div class="grid grid-cols-1 gap-3 sm:gap-4 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 2xl:grid-cols-6 mb-6 sm:mb-8">
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

            <!-- Menunggu Pengembalian -->
            <div class="group relative bg-white rounded-xl sm:rounded-2xl shadow-sm border border-gray-300 hover:shadow-lg hover:border-orange-200 transition-all duration-300">
                <div class="p-4 sm:p-6">
                    <div class="flex items-center justify-between">
                        <div class="flex-1 min-w-0">
                            <p class="text-xs sm:text-sm font-medium text-gray-600 mb-1 truncate">Menunggu Pengembalian</p>
                            <p class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-900">{{ $data['awaiting_return'] ?? 0 }}</p>
                            <p class="text-xxs sm:text-xs text-orange-600 mt-1 hidden sm:block">
                                <span class="inline-flex items-center">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                    </svg>
                                    Butuh konfirmasi
                                </span>
                            </p>
                            <p class="text-xxs text-orange-600 mt-1 sm:hidden">
                                📥 Konfirmasi
                            </p>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 sm:w-12 sm:h-12 lg:w-14 lg:h-14 bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg sm:rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-5 h-5 sm:w-6 sm:h-6 lg:w-7 lg:h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
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

            <!-- Peminjaman Menunggu Persetujuan -->
            <a href="{{ route('admin.borrowings.index') }}" class="group relative bg-white rounded-xl sm:rounded-2xl shadow-sm border border-gray-300 hover:shadow-lg hover:border-purple-200 transition-all duration-300">
                <div class="p-4 sm:p-6">
                    <div class="flex items-center justify-between">
                        <div class="flex-1 min-w-0">
                            <p class="text-xs sm:text-sm font-medium text-gray-600 mb-1 truncate">Peminjaman Menunggu</p>
                            <p class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-900">{{ $data['pending_borrowings'] ?? 0 }}</p>
                            <p class="text-xxs sm:text-xs text-purple-600 mt-1 hidden sm:block">
                                <span class="inline-flex items-center">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M8 2a1 1 0 00-1 1v1H5a2 2 0 00-2 2v9a2 2 0 002 2h10a2 2 0 002-2V6a2 2 0 00-2-2h-2V3a1 1 0 00-1-1H8zM7 7a1 1 0 112 0 1 1 0 01-2 0zm4 0a1 1 0 112 0 1 1 0 01-2 0z" />
                                    </svg>
                                    Perlu disetujui oleh admin
                                </span>
                            </p>
                            <p class="text-xxs text-purple-600 mt-1 sm:hidden">
                                � Menunggu
                            </p>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 sm:w-12 sm:h-12 lg:w-14 lg:h-14 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-lg sm:rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M2 3a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1H2Zm0 4.5h16l-.811 7.71a2 2 0 0 1-1.99 1.79H4.802a2 2 0 0 1-1.99-1.79L2 7.5ZM10 9a.75.75 0 0 1 .75.75v2.546l.943-1.048a.75.75 0 1 1 1.114 1.004l-2.25 2.5a.75.75 0 0 1-1.114 0l-2.25-2.5a.75.75 0 1 1 1.114-1.004l.943 1.048V9.75A.75.75 0 0 1 10 9Z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

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

                        <a href="{{ route('admin.operators.create') }}" class="group relative bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white rounded-lg sm:rounded-xl p-4 sm:p-6 transition-all duration-300 transform hover:scale-100 hover:shadow-lg">
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

    <!-- Charts: Borrowings & Services -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6 mt-6 mb-6 items-start">
            <!-- Borrowings Chart Card -->
            <div class="w-full bg-white rounded-xl sm:rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-4 sm:px-6 py-4 sm:py-5 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="text-base sm:text-lg font-semibold text-gray-900">Peminjaman</h3>
                    <div class="inline-flex items-center space-x-2">
                        <button data-target="borrowings" data-range="week" class="chart-range-btn px-2 py-1 text-xs bg-gray-100 rounded text-gray-700">Minggu</button>
                        <button data-target="borrowings" data-range="month" class="chart-range-btn px-2 py-1 text-xs bg-gray-100 rounded text-gray-700">Bulan</button>
                        <button data-target="borrowings" data-range="year" class="chart-range-btn px-2 py-1 text-xs bg-gray-100 rounded text-gray-700">Tahun</button>
                    </div>
                </div>
                <div class="p-4 sm:p-6 h-56">
                    <canvas id="chart-borrowings" class="w-full h-full"></canvas>
                </div>
            </div>

            <!-- Services Chart Card -->
            <div class="w-full bg-white rounded-xl sm:rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-4 sm:px-6 py-4 sm:py-5 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="text-base sm:text-lg font-semibold text-gray-900">Servis</h3>
                    <div class="inline-flex items-center space-x-2">
                        <button data-target="services" data-range="week" class="chart-range-btn px-2 py-1 text-xs bg-gray-100 rounded text-gray-700">Minggu</button>
                        <button data-target="services" data-range="month" class="chart-range-btn px-2 py-1 text-xs bg-gray-100 rounded text-gray-700">Bulan</button>
                        <button data-target="services" data-range="year" class="chart-range-btn px-2 py-1 text-xs bg-gray-100 rounded text-gray-700">Tahun</button>
                    </div>
                </div>
                <div class="p-4 sm:p-6 h-56">
                    <canvas id="chart-services" class="w-full h-full"></canvas>
                </div>
            </div>
        </div>

        <!-- Service Due Card (placed under Quick Actions) -->
        <div class="mt-6 sm:mt-8 mb-6 sm:mb-8">
            <div class="bg-white rounded-xl sm:rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-4 sm:px-6 py-4 sm:py-5 border-b border-gray-100 bg-gradient-to-r from-yellow-50 to-yellow-100">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-yellow-700 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <h3 class="text-base sm:text-lg font-semibold text-gray-900">Kendaraan Butuh Service</h3>
                            <p class="ml-3 text-sm text-yellow-800 hidden sm:inline">(≥ 90 hari sejak service terakhir)</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="divide-y divide-gray-200">
                    @if(isset($service_due_vehicles) && $service_due_vehicles->count() > 0)
                        @foreach($service_due_vehicles as $vehicle)
                            <div class="px-4 sm:px-6 py-3 sm:py-4 hover:bg-yellow-50 transition-colors duration-150">
                                <div class="flex items-center justify-between">
                                    <div class="min-w-0">
                                        <p class="text-sm font-medium text-gray-900 truncate">{{ $vehicle->brand }} {{ $vehicle->model }}</p>
                                        <p class="text-xs text-gray-500">{{ $vehicle->license_plate }}</p>
                                    </div>
                                    <div class="text-right ml-4">
                                        @php
                                            $latest = $vehicle->latestService;
                                            if ($latest && $latest->service_date) {
                                                $signed = \Carbon\Carbon::parse($latest->service_date)->diffInDays(now(), false);
                                                $days = (int) abs($signed);
                                                $days_since_created = null;
                                            } else {
                                                $days = null;
                                                // jika tidak ada riwayat servis, hitung juga hari sejak kendaraan dibuat
                                                $days_since_created = $vehicle->created_at ? \Carbon\Carbon::parse($vehicle->created_at)->diffInDays(now(), false) : null;
                                            }
                                        @endphp
                                        @if($days !== null)
                                            @php
                                                $urgent = $days >= 90;
                                                $dayClass = $urgent ? 'text-sm font-semibold text-red-600' : 'text-sm font-semibold text-yellow-800';
                                                $serviceDateLabel = $latest && $latest->service_date ? \Carbon\Carbon::parse($latest->service_date)->format('d M Y') : null;
                                            @endphp
                                            <p class="{{ $dayClass }}" title="Terakhir servis: {{ $serviceDateLabel ?? 'N/A' }}">{{ number_format($days, 0, ',', '.') }} hari</p>
                                            <p class="text-xs text-gray-500">sejak service</p>
                                        @else
                                            <p class="text-sm font-semibold text-yellow-800">—</p>
                                            @if($days_since_created !== null)
                                                <p class="text-xs text-gray-500">tanpa riwayat • {{ number_format($days_since_created, 0, ',', '.') }} hari sejak dibuat</p>
                                            @else
                                                <p class="text-xs text-gray-500">tanpa riwayat</p>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <div class="px-4 sm:px-6 py-3 bg-white">
                            <div class="mt-1 text-xs text-gray-400">Menampilkan halaman {{ $service_due_vehicles->currentPage() }} dari {{ $service_due_vehicles->lastPage() }} — total {{ $service_due_vehicles->total() }} item</div>
                            <!-- PAGINATOR_DEBUG: total={{ $service_due_vehicles->total() }}, perPage={{ $service_due_vehicles->perPage() }}, currentPage={{ $service_due_vehicles->currentPage() }}, lastPage={{ $service_due_vehicles->lastPage() }} -->
                            <div class="mt-2 flex flex-col sm:flex-row sm:justify-end sm:items-center gap-1">
                                @php
                                    $current = $service_due_vehicles->currentPage();
                                    $last = $service_due_vehicles->lastPage();
                                    $baseQuery = request()->except('service_due_page');
                                @endphp

                                {{-- Previous button --}}
                                @if($current > 1)
                                    <a href="{{ request()->fullUrlWithQuery(array_merge($baseQuery, ['service_due_page' => $current - 1])) }}" class="px-1 sm:px-2 py-1 rounded bg-white border border-gray-200 text-xs sm:text-sm text-gray-700 hover:bg-gray-50 min-w-[32px] text-center">Prev</a>
                                @else
                                    <span class="px-1 sm:px-2 py-1 rounded bg-gray-100 border border-gray-200 text-xs sm:text-sm text-gray-400 min-w-[32px] text-center">Prev</span>
                                @endif

                                {{-- Page number buttons (wrap on small screens) --}}
                                <div class="inline-flex flex-wrap items-center gap-1">
                                    @for($p = 1; $p <= $last; $p++)
                                        @php $url = request()->fullUrlWithQuery(array_merge($baseQuery, ['service_due_page' => $p])); @endphp
                                        @if($p == $current)
                                            <span class="px-1 sm:px-2 py-1 rounded bg-yellow-600 text-white text-xs sm:text-sm font-medium min-w-[32px] text-center">{{ $p }}</span>
                                        @else
                                            <a href="{{ $url }}" class="px-1 sm:px-2 py-1 rounded bg-white border border-gray-200 text-xs sm:text-sm text-gray-700 hover:bg-gray-50 min-w-[32px] text-center">{{ $p }}</a>
                                        @endif
                                    @endfor
                                </div>

                                {{-- Next button --}}
                                @if($current < $last)
                                    <a href="{{ request()->fullUrlWithQuery(array_merge($baseQuery, ['service_due_page' => $current + 1])) }}" class="px-1 sm:px-2 py-1 rounded bg-white border border-gray-200 text-xs sm:text-sm text-gray-700 hover:bg-gray-50 min-w-[32px] text-center">Next</a>
                                @else
                                    <span class="px-1 sm:px-2 py-1 rounded bg-gray-100 border border-gray-200 text-xs sm:text-sm text-gray-400 min-w-[32px] text-center">Next</span>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="px-4 sm:px-6 py-6 text-center text-sm text-gray-500">
                            Tidak ada kendaraan yang butuh service.
                        </div>
                    @endif
                </div>

        <!-- Konfirmasi Pengembalian Kendaraan - New Section -->
        @if(isset($awaiting_returns) && $awaiting_returns->count() > 0)
            <div class="mt-6 sm:mt-8 mb-6 sm:mb-8">
                <div class="bg-white rounded-xl sm:rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-4 sm:px-6 py-4 sm:py-5 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-blue-100">
                        <div class="flex items-center justify-between">
                            <h3 class="text-base sm:text-lg font-semibold text-gray-900 flex items-center">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                                Konfirmasi Pengembalian Kendaraan
                            </h3>
                            <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                {{ $awaiting_returns->count() }} menunggu
                            </span>
                        </div>
                    </div>

                    <div class="divide-y divide-gray-200">
                        @foreach($awaiting_returns as $borrowing)
                            <div class="p-4 sm:p-6 hover:bg-gray-50 transition-colors duration-200">
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-3 sm:space-y-0">
                                    <!-- Info Pengembalian -->
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-start space-x-3">
                                            <div class="flex-shrink-0">
                                                <div class="h-8 w-8 sm:h-10 sm:w-10 rounded-lg bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center">
                                                    <svg class="h-4 w-4 sm:h-5 sm:w-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                                                    <div>
                                                        <p class="text-sm font-medium text-gray-900 truncate">
                                                            {{ $borrowing->borrower_name }}
                                                        </p>
                                                        <p class="text-xs text-gray-500">{{ $borrowing->borrower_institution ?? 'N/A' }}</p>
                                                    </div>
                                                    <div class="mt-1 sm:mt-0">
                                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                            <svg class="w-2 h-2 mr-1" fill="currentColor" viewBox="0 0 8 8">
                                                                <circle cx="4" cy="4" r="3"/>
                                                            </svg>
                                                            Menunggu Konfirmasi
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="mt-2 text-xs text-gray-600">
                                                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-1 sm:gap-4">
                                                        <div>
                                                            <span class="font-medium">Dikembalikan:</span>
                                                            {{ $borrowing->checked_in_at ? $borrowing->checked_in_at->format('d/m/Y H:i') : 'N/A' }}
                                                        </div>
                                                        <div>
                                                            <span class="font-medium">Kendaraan:</span>
                                                            @if(is_array($borrowing->vehicles_data) && count($borrowing->vehicles_data) > 0)
                                                                @foreach($borrowing->vehicles_data as $index => $vehicleData)
                                                                    {{ $vehicleData['license_plate'] ?? 'N/A' }}@if(!$loop->last), @endif
                                                                @endforeach
                                                            @elseif($borrowing->vehicle)
                                                                {{ $borrowing->vehicle->license_plate }}
                                                            @else
                                                                N/A
                                                            @endif
                                                        </div>
                                                        <div>
                                                            <span class="font-medium">Catatan:</span>
                                                            {{ Str::limit($borrowing->checkin_notes ?? 'Tidak ada catatan', 30) }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="flex-shrink-0">
                                        <div class="flex flex-col sm:flex-row gap-2 w-full sm:w-auto">
                                            <button type="button"
                                                    onclick="approveReturn({{ $borrowing->id }})"
                                                    class="w-full sm:w-auto inline-flex items-center justify-center px-3 py-2 border border-transparent text-xs font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                                Konfirmasi
                                            </button>
                                            <a href="{{ route('admin.borrowings.show', $borrowing->id) }}"
                                               class="w-full sm:w-auto inline-flex items-center justify-center px-3 py-2 border border-gray-300 text-xs font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                                Detail
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Footer dengan link ke halaman awaiting return -->
                    <div class="px-4 sm:px-6 py-3 sm:py-4 bg-gray-50">
                        <a href="{{ route('admin.borrowings.awaiting-return') }}" class="text-indigo-600 hover:text-indigo-900 text-xs sm:text-sm font-medium flex items-center group">
                            Lihat semua pengembalian
                            <svg class="ml-1 w-3 h-3 sm:w-4 sm:h-4 group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        @endif

        <!-- Main Content Grid - Enhanced Responsive -->
        <div class="grid grid-cols-1 gap-4 sm:gap-6 lg:grid-cols-3 xl:grid-cols-3">
            <!-- Kendaraan Tersedia - Enhanced Mobile Layout -->
            <div class="lg:col-span-2 order-1">
                <div class="bg-white rounded-xl sm:rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-4 sm:px-6 py-4 sm:py-5 border-b border-gray-100">
                        <h3 class="text-base sm:text-lg font-semibold text-gray-900 flex items-center">
                            <svg class="w-9 h-9 sm:w-9 sm:h-9 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                 <path stroke-linecap="round" stroke-linejoin="round" d="M16.712 4.33a9.027 9.027 0 0 1 1.652 1.306c.51.51.944 1.064 1.306 1.652M16.712 4.33l-3.448 4.138m3.448-4.138a9.014 9.014 0 0 0-9.424 0M19.67 7.288l-4.138 3.448m4.138-3.448a9.014 9.014 0 0 1 0 9.424m-4.138-5.976a3.736 3.736 0 0 0-.88-1.388 3.737 3.737 0 0 0-1.388-.88m2.268 2.268a3.765 3.765 0 0 1 0 2.528m-2.268-4.796a3.765 3.765 0 0 0-2.528 0m4.796 4.796c-.181.506-.475.982-.88 1.388a3.736 3.736 0 0 1-1.388.88m2.268-2.268 4.138 3.448m0 0a9.027 9.027 0 0 1-1.306 1.652c-.51.51-1.064.944-1.652 1.306m0 0-3.448-4.138m3.448 4.138a9.014 9.014 0 0 1-9.424 0m5.976-4.138a3.765 3.765 0 0 1-2.528 0m0 0a3.736 3.736 0 0 1-1.388-.88 3.737 3.737 0 0 1-.88-1.388m2.268 2.268L7.288 19.67m0 0a9.024 9.024 0 0 1-1.652-1.306 9.027 9.027 0 0 1-1.306-1.652m0 0 4.138-3.448M4.33 16.712a9.014 9.014 0 0 1 0-9.424m4.138 5.976a3.765 3.765 0 0 1 0-2.528m0 0c.181-.506.475-.982.88-1.388a3.736 3.736 0 0 1 1.388-.88m-2.268 2.268L4.33 7.288m6.406 1.18L7.288 4.33m0 0a9.024 9.024 0 0 0-1.652 1.306A9.025 9.025 0 0 0 4.33 7.288" />
                            </svg>
                            Kendaraan Tersedia
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
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12a7.5 7.5 0 0 0 15 0m-15 0a7.5 7.5 0 1 1 15 0m-15 0H3m16.5 0H21m-1.5 0H12m-8.457 3.077 1.41-.513m14.095-5.13 1.41-.513M5.106 17.785l1.15-.964m11.49-9.642 1.149-.964M7.501 19.795l.75-1.3m7.5-12.99.75-1.3m-6.063 16.658.26-1.477m2.605-14.772.26-1.477m0 17.726-.26-1.477M10.698 4.614l-.26-1.477M16.5 19.794l-.75-1.299M7.5 4.205 12 12m6.894 5.785-1.149-.964M6.256 7.178l-1.15-.964m15.352 8.864-1.41-.513M4.954 9.435l-1.41-.514M12.002 12l-3.75 6.495" />
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
                                                @elseif($vehicle->availability_status == 'digunakan_pejabat')
                                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                        Tidak Tersedia
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
                                                               <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12a7.5 7.5 0 0 0 15 0m-15 0a7.5 7.5 0 1 1 15 0m-15 0H3m16.5 0H21m-1.5 0H12m-8.457 3.077 1.41-.513m14.095-5.13 1.41-.513M5.106 17.785l1.15-.964m11.49-9.642 1.149-.964M7.501 19.795l.75-1.3m7.5-12.99.75-1.3m-6.063 16.658.26-1.477m2.605-14.772.26-1.477m0 17.726-.26-1.477M10.698 4.614l-.26-1.477M16.5 19.794l-.75-1.299M7.5 4.205 12 12m6.894 5.785-1.149-.964M6.256 7.178l-1.15-.964m15.352 8.864-1.41-.513M4.954 9.435l-1.41-.514M12.002 12l-3.75 6.495" />
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
                                                @elseif($vehicle->availability_status == 'tidak_tersedia')
                                                    <span class="inline-flex items-center px-2 sm:px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                        <svg class="w-2 h-2 mr-1" fill="currentColor" viewBox="0 0 8 8">
                                                            <circle cx="4" cy="4" r="3"/>
                                                        </svg>
                                                        <span class="hidden sm:inline">Tidak Tersedia</span>
                                                        <span class="sm:hidden">✖</span>
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
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada kendaraan tersedia</h3>
                            <p class="mt-1 text-xs sm:text-sm text-gray-500">Semua kendaraan sedang dipinjam, dalam service, atau tidak tersedia.</p>
                            <div class="mt-4 sm:mt-6">
                                <a href="{{ route('admin.vehicles.index') }}" class="inline-flex items-center px-3 py-2 sm:px-4 sm:py-2 border border-transparent shadow-sm text-xs sm:text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                                    Lihat Semua Kendaraan
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Kendaraan Pajak Akan Habis - Enhanced Mobile Layout -->
            <div id="tax-expiring" class="lg:col-span-1 order-2 lg:order-none">
                <div class="bg-red-200 rounded-xl sm:rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-4 sm:px-6 py-4 sm:py-5 border-b border-gray-100">
                        <h3 class="text-base sm:text-lg font-semibold text-gray-900 flex items-center">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-red-700 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                                                <p class="text-xs sm:text-sm font-medium {{ $vehicle->isTaxExpired() ? 'text-red-800' : 'text-red-600' }}">
                                                    {{ $vehicle->tax_expiry_date->translatedFormat('d F Y') }}
                                                </p>
                                                @if($vehicle->isTaxExpired())
                                                    <p class="text-xs text-red-800 font-semibold">
                                                        <span class="hidden sm:inline">Pajak Sudah Expired</span>
                                                        <span class="sm:hidden">Expired</span>
                                                    </p>
                                                    <p class="text-xs text-red-600">
                                                        <span class="hidden sm:inline">{{ abs($vehicle->days_until_tax_expiry) }} hari yang lalu</span>
                                                        <span class="sm:hidden">-{{ abs($vehicle->days_until_tax_expiry) }}d</span>
                                                    </p>
                                                @else
                                                    <p class="text-xs text-red-500">
                                                        <span class="hidden sm:inline">{{ $vehicle->days_until_tax_expiry }} hari lagi</span>
                                                        <span class="sm:hidden">{{ $vehicle->days_until_tax_expiry }}d</span>
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination untuk Pajak Akan Habis -->
                        @if($expiring_tax_vehicles->hasPages())
                            <div class="bg-gray-50 px-3 py-3 border-t border-gray-200">
                                <div class="flex flex-col sm:flex-row items-center justify-between space-y-2 sm:space-y-0">
                                    <!-- Info Pagination -->
                                    <div class="text-xs text-gray-600">
                                        Menampilkan
                                        <span class="font-medium">{{ $expiring_tax_vehicles->firstItem() ?? 0 }}</span>
                                        sampai
                                        <span class="font-medium">{{ $expiring_tax_vehicles->lastItem() ?? 0 }}</span>
                                        dari
                                        <span class="font-medium">{{ $expiring_tax_vehicles->total() }}</span>
                                        kendaraan
                                    </div>

                                    <!-- Tombol Pagination -->
                                    <div class="flex items-center space-x-1">
                                        @if($expiring_tax_vehicles->onFirstPage())
                                            <span class="px-2 py-1 text-xs text-gray-400 bg-gray-200 rounded cursor-not-allowed">
                                                «
                                            </span>
                                        @else
                                            <a href="{{ $expiring_tax_vehicles->previousPageUrl() }}"
                                               class="px-2 py-1 text-xs text-gray-600 bg-white border border-gray-300 rounded hover:bg-gray-50 transition-colors">
                                                «
                                            </a>
                                        @endif

                                        @php
                                            $currentPage = $expiring_tax_vehicles->currentPage();
                                            $lastPage = $expiring_tax_vehicles->lastPage();
                                            $start = max(1, $currentPage - 1);
                                            $end = min($lastPage, $currentPage + 1);
                                        @endphp

                                        @for($page = $start; $page <= $end; $page++)
                                            @if($page == $currentPage)
                                                <span class="px-2 py-1 text-xs font-medium text-white bg-red-600 rounded">
                                                    {{ $page }}
                                                </span>
                                            @else
                                                <a href="{{ $expiring_tax_vehicles->url($page) }}"
                                                   class="px-2 py-1 text-xs text-gray-600 bg-white border border-gray-300 rounded hover:bg-gray-50 transition-colors">
                                                    {{ $page }}
                                                </a>
                                            @endif
                                        @endfor

                                        @if($expiring_tax_vehicles->hasMorePages())
                                            <a href="{{ $expiring_tax_vehicles->nextPageUrl() }}"
                                               class="px-2 py-1 text-xs text-gray-600 bg-white border border-gray-300 rounded hover:bg-gray-50 transition-colors">
                                                »
                                            </a>
                                        @else
                                            <span class="px-2 py-1 text-xs text-gray-400 bg-gray-200 rounded cursor-not-allowed">
                                                »
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
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

<!-- Approve Modal -->
<div id="approveModal" class="hidden fixed inset-0 bg-black bg-opacity-50 overflow-y-auto h-full w-full" style="z-index: 9999;">
    <div class="relative top-20 mx-auto p-5 border w-full max-w-md shadow-xl rounded-lg bg-white">
        <div class="mt-3">
            <div class="flex items-center">
                <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-green-100">
                    <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <div class="ml-4 text-left">
                    <h3 class="text-lg font-medium text-gray-900">Setujui Peminjaman</h3>
                    <p class="text-sm text-gray-500 mt-1">Apakah Anda yakin ingin menyetujui peminjaman ini?</p>
                </div>
            </div>
            <div class="mt-6 flex justify-end space-x-3">
                <button onclick="closeApproveModal()" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 text-sm font-medium rounded-md shadow-sm transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-gray-300">
                    Batal
                </button>
                <button onclick="confirmApprove()" id="confirmApproveBtn" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-md shadow-sm transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-green-500">
                    Ya, Setujui
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Approve Return Modal -->
<div id="approveReturnModal" class="hidden fixed inset-0 bg-black bg-opacity-50 overflow-y-auto h-full w-full" style="z-index: 9999;">
    <div class="relative top-20 mx-auto p-5 border w-full max-w-md shadow-xl rounded-lg bg-white">
        <div class="mt-3">
            <div class="flex items-center">
                <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100">
                    <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4 text-left">
                    <h3 class="text-lg font-medium text-gray-900">Konfirmasi Pengembalian</h3>
                    <p class="text-sm text-gray-500 mt-1">Apakah Anda yakin ingin mengkonfirmasi pengembalian kendaraan ini?</p>
                </div>
            </div>
            <div class="mt-6 flex justify-end space-x-3">
                <button onclick="closeApproveReturnModal()" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 text-sm font-medium rounded-md shadow-sm transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-gray-300">
                    Batal
                </button>
                <button onclick="confirmApproveReturn()" id="confirmApproveReturnBtn" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md shadow-sm transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Ya, Konfirmasi
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

<!-- Reject Modal -->
<div id="rejectModal" class="hidden fixed inset-0 bg-black bg-opacity-50 overflow-y-auto h-full w-full" style="z-index: 9999;">
    <div class="relative top-20 mx-auto p-5 border w-full max-w-md shadow-xl rounded-lg bg-white">
        <div class="mt-3">
            <div class="flex items-center">
                <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                    <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </div>
                <div class="ml-4 text-left">
                    <h3 class="text-lg font-medium text-gray-900">Tolak Peminjaman</h3>
                    <p class="text-sm text-gray-500 mt-1">Apakah Anda yakin ingin menolak peminjaman ini?</p>
                </div>
            </div>
            <div class="mt-4">
                <label for="rejectReason" class="block text-sm font-medium text-gray-700 mb-2">Alasan Penolakan (Opsional)</label>
                <textarea id="rejectReason" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500" placeholder="Masukkan alasan penolakan..."></textarea>
            </div>
            <div class="mt-6 flex justify-end space-x-3">
                <button onclick="closeRejectModal()" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 text-sm font-medium rounded-md shadow-sm transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-gray-300">
                    Batal
                </button>
                <button onclick="confirmReject()" id="confirmRejectBtn" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-md shadow-sm transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-red-500">
                    Ya, Tolak
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
let currentBorrowingId = null;

// Handle approval/rejection of borrowings
function approveBorrowing(borrowingId) {
    currentBorrowingId = borrowingId;
    document.getElementById('approveModal').classList.remove('hidden');
}

function rejectBorrowing(borrowingId) {
    currentBorrowingId = borrowingId;
    document.getElementById('rejectModal').classList.remove('hidden');
}

function closeApproveModal() {
    document.getElementById('approveModal').classList.add('hidden');
    currentBorrowingId = null;
}

function closeRejectModal() {
    document.getElementById('rejectModal').classList.add('hidden');
    document.getElementById('rejectReason').value = '';
    currentBorrowingId = null;
}

function closeApproveReturnModal() {
    document.getElementById('approveReturnModal').classList.add('hidden');
    currentBorrowingId = null;
}

function confirmApprove() {
    if (!currentBorrowingId) return;

    const btn = document.getElementById('confirmApproveBtn');
    const originalText = btn.textContent;
    btn.textContent = 'Memproses...';
    btn.disabled = true;

    fetch(`/admin/borrowings/${currentBorrowingId}/approve`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            status: 'approved'
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            closeApproveModal();
            showNotification('Peminjaman berhasil disetujui!', 'success');
            setTimeout(() => {
                window.location.reload();
            }, 1500);
        } else {
            showNotification(data.message || 'Terjadi kesalahan!', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Terjadi kesalahan saat memproses permintaan!', 'error');
    })
    .finally(() => {
        btn.textContent = originalText;
        btn.disabled = false;
    });
}

function confirmReject() {
    if (!currentBorrowingId) return;

    const btn = document.getElementById('confirmRejectBtn');
    const originalText = btn.textContent;
    btn.textContent = 'Memproses...';
    btn.disabled = true;

    const reason = document.getElementById('rejectReason').value;

    fetch(`/admin/borrowings/${currentBorrowingId}/reject`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            status: 'rejected',
            notes: reason
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            closeRejectModal();
            showNotification('Peminjaman berhasil ditolak!', 'success');
            setTimeout(() => {
                window.location.reload();
            }, 1500);
        } else {
            showNotification(data.message || 'Terjadi kesalahan!', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Terjadi kesalahan saat memproses permintaan!', 'error');
    })
    .finally(() => {
        btn.textContent = originalText;
        btn.disabled = false;
    });
}

function confirmApproveReturn() {
    if (!currentBorrowingId) return;

    const btn = document.getElementById('confirmApproveReturnBtn');
    const originalText = btn.textContent;
    btn.textContent = 'Memproses...';
    btn.disabled = true;

    fetch(`/admin/borrowings/${currentBorrowingId}/approve-return`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            closeApproveReturnModal();
            showNotification('Pengembalian kendaraan berhasil dikonfirmasi!', 'success');
            setTimeout(() => {
                window.location.reload();
            }, 1500);
        } else {
            showNotification(data.message || 'Terjadi kesalahan!', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Terjadi kesalahan saat memproses permintaan!', 'error');
    })
    .finally(() => {
        btn.textContent = originalText;
        btn.disabled = false;
    });
}

// Close modal when clicking outside
document.addEventListener('click', function(event) {
    const approveModal = document.getElementById('approveModal');
    const rejectModal = document.getElementById('rejectModal');
    const approveReturnModal = document.getElementById('approveReturnModal');

    if (event.target === approveModal) {
        closeApproveModal();
    }
    if (event.target === rejectModal) {
        closeRejectModal();
    }
    if (event.target === approveReturnModal) {
        closeApproveReturnModal();
    }
});

// Close modal with Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeApproveModal();
        closeRejectModal();
        closeApproveReturnModal();
    }
});

// Handle approval of returns
function approveReturn(borrowingId) {
    currentBorrowingId = borrowingId;
    document.getElementById('approveReturnModal').classList.remove('hidden');
}

// Show notification function
function showNotification(message, type = 'info') {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 max-w-sm w-full bg-white border border-gray-200 rounded-lg shadow-lg transform transition-all duration-300 translate-x-full`;

    const bgColor = type === 'success' ? 'bg-green-50 border-green-200' :
                   type === 'error' ? 'bg-red-50 border-red-200' :
                   'bg-blue-50 border-blue-200';

    const iconColor = type === 'success' ? 'text-green-400' :
                     type === 'error' ? 'text-red-400' :
                     'text-blue-400';

    const icon = type === 'success' ?
        '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>' :
        type === 'error' ?
        '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>' :
        '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>';

    notification.className = `fixed top-4 right-4 z-50 max-w-sm w-full ${bgColor} rounded-lg shadow-lg transform transition-all duration-300 translate-x-full`;

    notification.innerHTML = `
        <div class="p-4">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 ${iconColor}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        ${icon}
                    </svg>
                </div>
                <div class="ml-3 w-0 flex-1">
                    <p class="text-sm font-medium text-gray-900">${message}</p>
                </div>
                <div class="ml-4 flex-shrink-0 flex">
                    <button class="inline-flex text-gray-400 hover:text-gray-500 focus:outline-none" onclick="this.parentElement.parentElement.parentElement.parentElement.remove()">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    `;

    document.body.appendChild(notification);

    // Animate in
    setTimeout(() => {
        notification.classList.remove('translate-x-full');
    }, 100);

    // Auto remove after 5 seconds
    setTimeout(() => {
        notification.classList.add('translate-x-full');
        setTimeout(() => {
            if (notification.parentElement) {
                notification.remove();
            }
        }, 300);
    }, 5000);
}
</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Chart data from backend
const chartsData = @json($charts ?? []);
console.log('chartsData (debug):', chartsData);

function createLineChart(ctx, labels, data, label, color) {
    return new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: label,
                data: data,
                borderColor: color,
                backgroundColor: color.replace('rgb', 'rgba').replace(')', ',0.08)'),
                fill: true,
                tension: 0.2,
                pointRadius: 3
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: { beginAtZero: true, ticks: { precision:0 } }
            },
            plugins: { legend: { display: false } }
        }
    });
}

document.addEventListener('DOMContentLoaded', function() {
    // Borrowings chart
    const bCtx = document.getElementById('chart-borrowings').getContext('2d');
    const borrowingsChart = createLineChart(bCtx, chartsData.borrowings.week.labels, chartsData.borrowings.week.data, 'Peminjaman', 'rgb(99,102,241)');

    // Services chart
    const sCtx = document.getElementById('chart-services').getContext('2d');
    const servicesChart = createLineChart(sCtx, chartsData.services.week.labels, chartsData.services.week.data, 'Servis', 'rgb(34,197,94)');

    // Range buttons
    document.querySelectorAll('.chart-range-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const target = this.getAttribute('data-target');
            const range = this.getAttribute('data-range');
            const chart = target === 'borrowings' ? borrowingsChart : servicesChart;
            const datasetLabel = target === 'borrowings' ? 'Peminjaman' : 'Servis';
            const color = target === 'borrowings' ? 'rgb(99,102,241)' : 'rgb(34,197,94)';

            const newLabels = chartsData[target][range].labels;
            const newData = chartsData[target][range].data;

            chart.data.labels = newLabels;
            chart.data.datasets[0].data = newData;
            chart.data.datasets[0].label = datasetLabel;
            chart.data.datasets[0].borderColor = color;
            chart.data.datasets[0].backgroundColor = color.replace('rgb', 'rgba').replace(')', ',0.08)');
            chart.update();
        });
    });
});
</script>
@endpush
