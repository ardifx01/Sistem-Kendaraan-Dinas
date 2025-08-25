@extends('layouts.guest')

@section('title', 'Beranda')

@section('content')
<div class="min-h-screen bg-white">
    <!-- Navigation Header -->
    <nav class="fixed w-full top-0 z-50 bg-blue-600 backdrop-blur-md border-b-4 border-yellow-400">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex items-center">
                        <span class="text-xl font-bold text-white">Sistem Kendaraan Dinas</span>
                    </div>
                </div>
                <div class="flex items-center">
                    <a href="{{ route('login') }}" class="bg-yellow-400 hover:from-yellow-500 hover:to-yellow-500 text-white px-6 py-2.5 rounded-xl font-medium transition-all duration-300 shadow-lg hover:shadow-blue-500/25 hover:-translate-y-0.5">
                        Masuk
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="pt-16 bg-gradient-to-br from-gray-50 via-white to-blue-50/30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10 md:gap-20 items-center py-16 md:py-24 lg:py-32">
                <div>
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-gray-900 leading-tight mb-8">
                        Sistem Manajemen
                        <span class="bg-gradient-to-r from-blue-600 to-blue-700 bg-clip-text text-transparent">Kendaraan Dinas</span>
                    </h1>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-8 py-4 md:px-10 md:py-5 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-bold rounded-2xl hover:from-blue-700 hover:to-blue-800 transition-all duration-300 shadow-xl hover:shadow-blue-500/25 hover:-translate-y-1 text-base md:text-lg">
                            <span>Login</span>
                            <svg class="ml-2 h-5 w-5 md:h-6 md:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </a>
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow-lg p-6 md:p-8 border border-gray-200 transition-transform duration-300 hover:-translate-y-1">
                    <p class="text-lg md:text-xl lg:text-2xl text-gray-700 leading-relaxed">
                        Sistem Manajemen Kendaraan Dinas adalah platform digital terintegrasi yang dirancang untuk memudahkan pengelolaan, pemantauan, dan pelaporan seluruh kendaraan dinas operasional secara real-time. Dengan fitur lengkap seperti pencatatan data kendaraan, tracking service dan perbaikan, validasi peminjaman dan pengembalian, serta notifikasi pajak, sistem ini membantu menjaga efisiensi, transparansi, dan keamanan aset kendaraan.
                    </p>
                </div>
            </div>
        </div>

    <!-- Features Section -->
    <div class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center space-y-4 mb-16">
                <h2 class="text-4xl lg:text-5xl font-bold text-gray-900">
                    Fitur Sistem
                </h2>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="group relative bg-gradient-to-br from-white to-gray-50 p-8 rounded-3xl border border-gray-300 hover:shadow-2xl hover:shadow-blue-500/10 transition-all duration-500 hover:-translate-y-2">
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-600/5 to-purple-600/5 rounded-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="relative">
                        <div class="h-14 w-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                            <svg class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">Manajemen Data Kendaraan</h3>
                        <p class="text-gray-600 leading-relaxed">Kelola Seluruh Data Kendaraan Dinas Dengan Sistem CRUD yang Lengkap, Dokumentasi Digital, dan Foto Kendaraan.</p>
                    </div>
                </div>

                <div class="group relative bg-gradient-to-br from-white to-gray-50 p-8 rounded-3xl border border-gray-300 hover:shadow-2xl hover:shadow-blue-500/10 transition-all duration-500 hover:-translate-y-2">
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-600/5 to-purple-600/5 rounded-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="relative">
                        <div class="h-14 w-14 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                            <svg class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">Tracking Service & Perbaikan</h3>
                        <p class="text-gray-600 leading-relaxed">Pantau Riwayat Service dan Maintenance Dengan Dokumentasi Lengkap.</p>
                    </div>
                </div>

                <div class="group relative bg-gradient-to-br from-white to-gray-50 p-8 rounded-3xl border border-gray-300 hover:shadow-2xl hover:shadow-blue-500/10 transition-all duration-500 hover:-translate-y-2">
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-600/5 to-green-600/5 rounded-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="relative">
                        <div class="h-14 w-14 bg-gradient-to-br from-yellow-300 to-yellow-500 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                            <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path fill-rule="evenodd" d="M15.97 2.47a.75.75 0 0 1 1.06 0l4.5 4.5a.75.75 0 0 1 0 1.06l-4.5 4.5a.75.75 0 1 1-1.06-1.06l3.22-3.22H7.5a.75.75 0 0 1 0-1.5h11.69l-3.22-3.22a.75.75 0 0 1 0-1.06Zm-7.94 9a.75.75 0 0 1 0 1.06l-3.22 3.22H16.5a.75.75 0 0 1 0 1.5H4.81l3.22 3.22a.75.75 0 1 1-1.06 1.06l-4.5-4.5a.75.75 0 0 1 0-1.06l4.5-4.5a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">Validasi Peminjaman & Pengembalian</h3>
                        <p class="text-gray-600 leading-relaxed">Proses validasi peminjaman dan pengembalian kendaraan dinas secara digital dan real-time.</p>
                    </div>
                </div>

                <div class="group relative bg-gradient-to-br from-white to-gray-50 p-8 rounded-3xl border border-gray-300 hover:shadow-2xl hover:shadow-blue-500/10 transition-all duration-500 hover:-translate-y-2">
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-600/5 to-purple-600/5 rounded-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="relative">
                        <div class="h-14 w-14 bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                            <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                               <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 3.75V16.5L12 14.25 7.5 16.5V3.75m9 0H18A2.25 2.25 0 0 1 20.25 6v12A2.25 2.25 0 0 1 18 20.25H6A2.25 2.25 0 0 1 3.75 18V6A2.25 2.25 0 0 1 6 3.75h1.5m9 0h-9" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">Sistem Peminjaman</h3>
                        <p class="text-gray-600 leading-relaxed">Pencatatan Peminjaman Kendaraan dengan Approval Workflow dan Tracking Status Real - Time.</p>
                    </div>
                </div>

                <div class="group relative bg-gradient-to-br from-white to-gray-50 p-8 rounded-3xl border border-gray-300 hover:shadow-2xl hover:shadow-blue-500/10 transition-all duration-500 hover:-translate-y-2">
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-600/5 to-purple-600/5 rounded-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="relative">
                        <div class="h-14 w-14 bg-gradient-to-br from-red-500 to-red-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                           <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0M3.124 7.5A8.969 8.969 0 0 1 5.292 3m13.416 0a8.969 8.969 0 0 1 2.168 4.5" />
                           </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">Notifikasi</h3>
                        <p class="text-gray-600 leading-relaxed">Sistem peringatan Pembayaran Pajak Kendaraan Dinas yang Mendekati Masa Habis.</p>
                    </div>
                </div>

                <div class="group relative bg-gradient-to-br from-white to-gray-50 p-8 rounded-3xl border border-gray-300 hover:shadow-2xl hover:shadow-blue-500/10 transition-all duration-500 hover:-translate-y-2">
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-600/5 to-purple-600/5 rounded-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="relative">
                        <div class="h-14 w-14 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                            <svg class="h-9 w-9 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">Multi-Role Access</h3>
                        <p class="text-gray-600 leading-relaxed">Sistem role-based dengan keamanan tinggi untuk Admin dan Operator dengan hak akses berbeda.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900">
        <div class="max-w-7xl mx-auto py-16 px-4 sm:px-6 lg:px-8">
            <div class="text-center space-y-6">
                <div class="flex justify-center items-center">
                    <span class="ml-4 text-2xl font-semibold text-white">Sistem Kendaraan Dinas</span>
                </div>
                <div class="space-y-2">
                    <p class="text-gray-300">
                        &copy; {{ date('Y') }} Sistem Manajemen Kendaraan Dinas
                    </p>
                </div>
            </div>
        </div>
    </footer>
</div>
@endsection
