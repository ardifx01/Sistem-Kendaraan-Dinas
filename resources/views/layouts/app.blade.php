<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Kendaraan Dinas') - Kementerian Pemuda dan Olahraga</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Figtree', 'ui-sans-serif', 'system-ui', '-apple-system', 'BlinkMacSystemFont', 'Segoe UI', 'Roboto', 'Helvetica Neue', 'Arial', 'Noto Sans', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .card {
            background: white;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            border: 1px solid #f3f4f6;
        }

        /* Logout Confirmation Modal */
        .logout-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }

        .logout-modal.show {
            opacity: 1;
            visibility: visible;
        }

        .logout-modal-content {
            background: white;
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            max-width: 400px;
            width: 90%;
            transform: scale(0.9);
            transition: transform 0.3s ease;
        }

        .logout-modal.show .logout-modal-content {
            transform: scale(1);
        }

        .logout-icon {
            width: 48px;
            height: 48px;
            margin: 0 auto 1rem;
            background-color: #fef2f2;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s;
            border: none;
            cursor: pointer;
        }

        .btn-primary {
            background: linear-gradient(to right, #3b82f6, #2563eb);
            color: white;
        }

        .btn-primary:hover {
            background: linear-gradient(to right, #2563eb, #1d4ed8);
            transform: translateY(-1px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .btn-secondary {
            background: linear-gradient(to right, #10b981, #059669);
            color: white;
        }

        .btn-secondary:hover {
            background: linear-gradient(to right, #059669, #047857);
            transform: translateY(-1px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .btn-success {
            background: linear-gradient(to right, #6366f1, #4f46e5);
            color: white;
        }

        .btn-success:hover {
            background: linear-gradient(to right, #4f46e5, #4338ca);
            transform: translateY(-1px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .btn-danger {
            background: linear-gradient(to right, #ef4444, #dc2626);
            color: white;
        }

        .btn-danger:hover {
            background: linear-gradient(to right, #dc2626, #b91c1c);
            transform: translateY(-1px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .alert {
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
        }

        .alert-success {
            background: linear-gradient(to right, #dcfce7, #bbf7d0);
            border-left: 4px solid #22c55e;
            color: #166534;
        }

        .alert-error {
            background: linear-gradient(to right, #fef2f2, #fecaca);
            border-left: 4px solid #ef4444;
            color: #991b1b;
        }

        .alert-warning {
            background: linear-gradient(to right, #fefce8, #fef08a);
            border-left: 4px solid #eab308;
            color: #92400e;
        }

        .group:hover .group-hover\:scale-110 {
            transform: scale(1.1);
        }

        .group:hover .group-hover\:translate-x-1 {
            transform: translateX(0.25rem);
        }

        .transition-all {
            transition-property: all;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 300ms;
        }

        .transition-colors {
            transition-property: color, background-color, border-color, text-decoration-color, fill, stroke;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 200ms;
        }

        .transition-transform {
            transition-property: transform;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 300ms;
        }

        .duration-200 {
            transition-duration: 200ms;
        }

        .duration-300 {
            transition-duration: 300ms;
        }

        .sm\:grid-cols-2 {
            @media (min-width: 640px) {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        .lg\:grid-cols-4 {
            @media (min-width: 1024px) {
                grid-template-columns: repeat(4, minmax(0, 1fr));
            }
        }

        .lg\:grid-cols-3 {
            @media (min-width: 1024px) {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
        }

        .xl\:grid-cols-3 {
            @media (min-width: 1280px) {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
        }

        .lg\:col-span-2 {
            @media (min-width: 1024px) {
                grid-column: span 2 / span 2;
            }
        }

        .lg\:col-span-1 {
            @media (min-width: 1024px) {
                grid-column: span 1 / span 1;
            }
        }

        /* Hidden pada mobile, visible pada sm+ */
        .hidden {
            display: none;
        }

        .sm\:table-cell {
            @media (min-width: 640px) {
                display: table-cell;
            }
        }

        .sm\:flex {
            @media (min-width: 640px) {
                display: flex;
            }
        }

        .sm\:text-4xl {
            @media (min-width: 640px) {
                font-size: 2.25rem;
                line-height: 2.5rem;
            }
        }

        .sm\:text-base {
            @media (min-width: 640px) {
                font-size: 1rem;
                line-height: 1.5rem;
            }
        }
    </style>

    @stack('styles')
</head>
<body style="background-color: #f9fafb;">
    <div style="min-height: 100vh;">
        @if(auth()->check())
            <nav class="bg-blue-600 shadow-lg">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16 items-center">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 flex items-center">
                                <h1 class="text-lg font-bold text-white">Kendaraan Dinas</h1>
                            </div>
                        </div>
                        <div class="flex lg:hidden">
                            <button type="button" class="inline-flex items-center justify-center p-2 rounded-md text-white hover:text-white focus:outline-none" aria-controls="mobile-menu" aria-expanded="false" onclick="document.getElementById('mobile-menu').classList.toggle('hidden')">
                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                </svg>
                            </button>
                        </div>
                        <div class="hidden lg:flex items-center ml-10 space-x-8">
                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" class="py-4 px-2 text-sm font-medium transition-all @if(request()->routeIs('admin.dashboard')) border-b-2 border-white text-white @else border-b-2 border-transparent text-white hover:text-gray-600 @endif">Dashboard</a>
                                <a href="{{ route('admin.vehicles.index') }}" class="py-4 px-2 text-sm font-medium transition-all @if(request()->routeIs('admin.vehicles.*')) border-b-2 border-white text-white @else border-b-2 border-transparent text-white hover:text-gray-600 @endif">Data Kendaraan</a>
                                <a href="{{ route('admin.operators.index') }}" class="py-4 px-2 text-sm font-medium transition-all @if(request()->routeIs('admin.operators.*')) border-b-2 border-white text-white @else border-b-2 border-transparent text-white hover:text-gray-600 @endif">Data Operator</a>
                            @elseif(auth()->user()->isOperator())
                                <a href="{{ route('operator.dashboard') }}" class="py-4 px-2 text-sm font-medium transition-all @if(request()->routeIs('operator.dashboard')) border-b-2 border-white text-white @else border-b-2 border-transparent text-white hover:text-gray-800 @endif">Dashboard</a>
                                <a href="{{ route('operator.services.index') }}" class="py-4 px-2 text-sm font-medium transition-all @if(request()->routeIs('operator.services.*')) border-b-2 border-white text-gray-800 @else border-b-2 border-transparent text-white hover:text-gray-800 @endif">Service Kendaraan</a>
                                <a href="{{ route('operator.borrowings.index') }}" class="py-4 px-2 text-sm font-medium transition-all @if(request()->routeIs('operator.borrowings.*')) border-b-2 border-white text-gray-800 @else border-b-2 border-transparent text-white hover:text-gray-800 @endif">Peminjaman</a>
                            @endif
                        </div>
                        <div class="hidden lg:flex items-center ml-6">
                            <span class="text-white mr-2">{{ auth()->user()->name }}</span>
                            <span class="px-2 py-1 text-xs rounded-full @if(auth()->user()->isAdmin()) bg-white text-red-700 @else bg-blue-100 text-blue-700 @endif">
                                {{ auth()->user()->role === 'admin' ? 'Admin' : 'Operator' }}
                            </span>
                            <form method="POST" action="{{ route('logout') }}" class="ml-4" id="logoutFormDesktop">
                                @csrf
                                <button type="button" onclick="showLogoutConfirmation()" class="btn btn-danger">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                    </svg>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="lg:hidden hidden" id="mobile-menu">
                    <div class="px-2 pt-2 pb-3 space-y-1">
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="block py-2 px-4 text-sm font-medium transition-all @if(request()->routeIs('admin.dashboard')) border-l-4 border-white bg-blue-700 text-white @else border-l-4 border-transparent text-white hover:text-gray-200 hover:bg-blue-700 @endif">Dashboard</a>
                            <a href="{{ route('admin.vehicles.index') }}" class="block py-2 px-4 text-sm font-medium transition-all @if(request()->routeIs('admin.vehicles.*')) border-l-4 border-white bg-blue-700 text-white @else border-l-4 border-transparent text-white hover:text-gray-200 hover:bg-blue-700 @endif">Data Kendaraan</a>
                            <a href="{{ route('admin.operators.index') }}" class="block py-2 px-4 text-sm font-medium transition-all @if(request()->routeIs('admin.operators.*')) border-l-4 border-white bg-blue-700 text-white @else border-l-4 border-transparent text-white hover:text-gray-200 hover:bg-blue-700 @endif">Data Operator</a>
                        @elseif(auth()->user()->isOperator())
                            <a href="{{ route('operator.dashboard') }}" class="block py-2 px-4 text-sm font-medium transition-all @if(request()->routeIs('operator.dashboard')) border-l-4 border-white bg-blue-700 text-white @else border-l-4 border-transparent text-white hover:text-gray-200 hover:bg-blue-700 @endif">Dashboard</a>
                            <a href="{{ route('operator.services.index') }}" class="block py-2 px-4 text-sm font-medium transition-all @if(request()->routeIs('operator.services.*')) border-l-4 border-white bg-blue-700 text-white @else border-l-4 border-transparent text-white hover:text-gray-200 hover:bg-blue-700 @endif">Service Kendaraan</a>
                            <a href="{{ route('operator.borrowings.index') }}" class="block py-2 px-4 text-sm font-medium transition-all @if(request()->routeIs('operator.borrowings.*')) border-l-4 border-white bg-blue-700 text-white @else border-l-4 border-transparent text-white hover:text-gray-200 hover:bg-blue-700 @endif">Peminjaman</a>
                            <a href="{{ route('operator.payments.index') }}" class="block py-2 px-4 text-sm font-medium transition-all @if(request()->routeIs('operator.payments.*')) border-l-4 border-white bg-blue-700 text-white @else border-l-4 border-transparent text-white hover:text-gray-200 hover:bg-blue-700 @endif">Pembayaran</a>
                        @endif
                        <div class="border-t border-blue-500 mt-3 pt-3">
                            <div class="flex items-center px-4 py-2">
                                <span class="text-white mr-2">{{ auth()->user()->name }}</span>
                                <span class="px-2 py-1 text-xs rounded-full @if(auth()->user()->isAdmin()) bg-white text-blue-700 @else bg-blue-100 text-blue-700 @endif">
                                    {{ auth()->user()->role === 'admin' ? 'Admin' : 'Operator' }}
                                </span>
                            </div>
                            <form method="POST" action="{{ route('logout') }}" class="w-full px-4 py-2" id="logoutFormMobile">
                                @csrf
                                <button type="button" onclick="showLogoutConfirmation()" class="btn btn-danger w-full">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                    </svg>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </nav>
        @endif

        <main style="@if(auth()->check()) padding: 1.5rem 0; @endif">
            @if(session('success'))
                <div style="max-width: 80rem; margin: 0 auto; padding: 0 1rem; margin-bottom: 1.5rem;">
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div style="max-width: 80rem; margin: 0 auto; padding: 0 1rem; margin-bottom: 1.5rem;">
                    <div class="alert alert-error">
                        {{ session('error') }}
                    </div>
                </div>
            @endif

            @if(session('warning'))
                <div style="max-width: 80rem; margin: 0 auto; padding: 0 1rem; margin-bottom: 1.5rem;">
                    <div class="alert alert-warning">
                        {{ session('warning') }}
                    </div>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <div id="logoutModal" class="logout-modal">
        <div class="logout-modal-content">
            <div class="logout-icon">
                <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 text-center mb-2">Konfirmasi Logout</h3>
            <p class="text-gray-600 text-center mb-6">Apakah Anda yakin ingin keluar dari sistem?</p>
            <div class="flex space-x-3 justify-center">
                <button type="button"
                        onclick="hideLogoutConfirmation()"
                        class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors">
                    Batal
                </button>
                <button type="button"
                        onclick="confirmLogout()"
                        class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors">
                    Ya, Logout
                </button>
            </div>
        </div>
    </div>

    <script>
        function showLogoutConfirmation() {
            const modal = document.getElementById('logoutModal');
            modal.classList.add('show');
        }

        function hideLogoutConfirmation() {
            const modal = document.getElementById('logoutModal');
            modal.classList.remove('show');
        }

        function confirmLogout() {
            // Submit form logout, coba cari desktop dulu, kalau tidak ada baru mobile
            const desktopForm = document.getElementById('logoutFormDesktop');
            const mobileForm = document.getElementById('logoutFormMobile');

            // Cek visibilitas, hanya submit form yang terlihat
            if (desktopForm && window.getComputedStyle(desktopForm).display !== 'none') {
                desktopForm.submit();
            } else if (mobileForm) {
                mobileForm.submit();
            }
        }

        // Close modal when clicking outside
        document.getElementById('logoutModal').addEventListener('click', function(e) {
            if (e.target === this) {
                hideLogoutConfirmation();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                hideLogoutConfirmation();
            }
        });
    </script>

    @stack('scripts')
</body>
</html>
