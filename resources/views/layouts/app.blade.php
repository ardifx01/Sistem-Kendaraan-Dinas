<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Kendaraan Dinas') - Kementerian Pemuda dan Olahraga</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Tailwind CSS CDN (Fallback) -->
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

    <!-- Vite Assets (Will load if available) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Custom CSS untuk styling yang tidak ada di Tailwind -->
    <style>
        .card {
            background: white;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            border: 1px solid #f3f4f6;
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

        /* Animasi dan transisi modern */
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

        /* Responsive breakpoints */
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

    <!-- Additional Styles -->
    @stack('styles')
</head>
<body style="background-color: #f9fafb;">
    <div style="min-height: 100vh;">
        <!-- Navigation -->
        @if(auth()->check())
            <nav class="bg-white shadow-lg">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16 items-center">
                        <div class="flex items-center">
                            <!-- Logo -->
                            <div class="flex-shrink-0 flex items-center">
                                <h1 class="text-lg font-bold text-gray-800">Kendaraan Dinas</h1>
                            </div>
                        </div>
                        <!-- Hamburger menu for mobile -->
                        <div class="flex lg:hidden">
                            <button type="button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-500 hover:text-gray-700 focus:outline-none" aria-controls="mobile-menu" aria-expanded="false" onclick="document.getElementById('mobile-menu').classList.toggle('hidden')">
                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                </svg>
                            </button>
                        </div>
                        <!-- Navigation Links (Desktop) -->
                        <div class="hidden lg:flex items-center ml-10 space-x-8">
                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" class="py-4 px-2 text-sm font-medium transition-all @if(request()->routeIs('admin.dashboard')) border-b-2 border-indigo-500 text-gray-800 @else border-b-2 border-transparent text-gray-500 hover:text-gray-800 @endif">Dashboard</a>
                                <a href="{{ route('admin.vehicles.index') }}" class="py-4 px-2 text-sm font-medium transition-all @if(request()->routeIs('admin.vehicles.*')) border-b-2 border-indigo-500 text-gray-800 @else border-b-2 border-transparent text-gray-500 hover:text-gray-800 @endif">Data Kendaraan</a>
                                <a href="{{ route('admin.users.index') }}" class="py-4 px-2 text-sm font-medium transition-all @if(request()->routeIs('admin.users.*')) border-b-2 border-indigo-500 text-gray-800 @else border-b-2 border-transparent text-gray-500 hover:text-gray-800 @endif">Data Operator</a>
                            @elseif(auth()->user()->isOperator())
                                <a href="{{ route('operator.dashboard') }}" class="py-4 px-2 text-sm font-medium transition-all @if(request()->routeIs('operator.dashboard')) border-b-2 border-indigo-500 text-gray-800 @else border-b-2 border-transparent text-gray-500 hover:text-gray-800 @endif">Dashboard</a>
                                <a href="{{ route('operator.services.index') }}" class="py-4 px-2 text-sm font-medium transition-all @if(request()->routeIs('operator.services.*')) border-b-2 border-indigo-500 text-gray-800 @else border-b-2 border-transparent text-gray-500 hover:text-gray-800 @endif">Service Kendaraan</a>
                                <a href="{{ route('operator.borrowings.index') }}" class="py-4 px-2 text-sm font-medium transition-all @if(request()->routeIs('operator.borrowings.*')) border-b-2 border-indigo-500 text-gray-800 @else border-b-2 border-transparent text-gray-500 hover:text-gray-800 @endif">Peminjaman</a>
                                <a href="{{ route('operator.payments.index') }}" class="py-4 px-2 text-sm font-medium transition-all @if(request()->routeIs('operator.payments.*')) border-b-2 border-indigo-500 text-gray-800 @else border-b-2 border-transparent text-gray-500 hover:text-gray-800 @endif">Pembayaran</a>
                            @endif
                        </div>
                        <!-- User Dropdown (Desktop) -->
                        <div class="hidden lg:flex items-center ml-6">
                            <span class="text-gray-700 mr-2">{{ auth()->user()->name }}</span>
                            <span class="px-2 py-1 text-xs rounded-full @if(auth()->user()->isAdmin()) bg-red-100 text-red-700 @else bg-blue-100 text-blue-700 @endif">
                                {{ auth()->user()->role === 'admin' ? 'Admin' : 'Operator' }}
                            </span>
                            <form method="POST" action="{{ route('logout') }}" class="ml-3">
                                @csrf
                                <button type="submit" class="text-gray-500 hover:text-gray-700 transition-colors">Logout</button>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Mobile Menu -->
                <div class="lg:hidden hidden" id="mobile-menu">
                    <div class="px-2 pt-2 pb-3 space-y-1">
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="block py-2 px-4 text-sm font-medium transition-all @if(request()->routeIs('admin.dashboard')) border-l-4 border-indigo-500 bg-indigo-50 text-gray-800 @else border-l-4 border-transparent text-gray-500 hover:bg-gray-100 hover:text-gray-800 @endif">Dashboard</a>
                            <a href="{{ route('admin.vehicles.index') }}" class="block py-2 px-4 text-sm font-medium transition-all @if(request()->routeIs('admin.vehicles.*')) border-l-4 border-indigo-500 bg-indigo-50 text-gray-800 @else border-l-4 border-transparent text-gray-500 hover:bg-gray-100 hover:text-gray-800 @endif">Data Kendaraan</a>
                            <a href="{{ route('admin.users.index') }}" class="block py-2 px-4 text-sm font-medium transition-all @if(request()->routeIs('admin.users.*')) border-l-4 border-indigo-500 bg-indigo-50 text-gray-800 @else border-l-4 border-transparent text-gray-500 hover:bg-gray-100 hover:text-gray-800 @endif">Data Operator</a>
                        @elseif(auth()->user()->isOperator())
                            <a href="{{ route('operator.dashboard') }}" class="block py-2 px-4 text-sm font-medium transition-all @if(request()->routeIs('operator.dashboard')) border-l-4 border-indigo-500 bg-indigo-50 text-gray-800 @else border-l-4 border-transparent text-gray-500 hover:bg-gray-100 hover:text-gray-800 @endif">Dashboard</a>
                            <a href="{{ route('operator.services.index') }}" class="block py-2 px-4 text-sm font-medium transition-all @if(request()->routeIs('operator.services.*')) border-l-4 border-indigo-500 bg-indigo-50 text-gray-800 @else border-l-4 border-transparent text-gray-500 hover:bg-gray-100 hover:text-gray-800 @endif">Service Kendaraan</a>
                            <a href="{{ route('operator.borrowings.index') }}" class="block py-2 px-4 text-sm font-medium transition-all @if(request()->routeIs('operator.borrowings.*')) border-l-4 border-indigo-500 bg-indigo-50 text-gray-800 @else border-l-4 border-transparent text-gray-500 hover:bg-gray-100 hover:text-gray-800 @endif">Peminjaman</a>
                            <a href="{{ route('operator.payments.index') }}" class="block py-2 px-4 text-sm font-medium transition-all @if(request()->routeIs('operator.payments.*')) border-l-4 border-indigo-500 bg-indigo-50 text-gray-800 @else border-l-4 border-transparent text-gray-500 hover:bg-gray-100 hover:text-gray-800 @endif">Pembayaran</a>
                        @endif
                        <div class="flex items-center px-4 py-2">
                            <span class="text-gray-700 mr-2">{{ auth()->user()->name }}</span>
                            <span class="px-2 py-1 text-xs rounded-full @if(auth()->user()->isAdmin()) bg-red-100 text-red-700 @else bg-blue-100 text-blue-700 @endif">
                                {{ auth()->user()->role === 'admin' ? 'Admin' : 'Operator' }}
                            </span>
                            <form method="POST" action="{{ route('logout') }}" class="ml-3">
                                @csrf
                                <button type="submit" class="text-gray-500 hover:text-gray-700 transition-colors">Logout</button>
                            </form>
                        </div>
                    </div>
                </div>
            </nav>
        @endif

        <!-- Page Content -->
        <main style="@if(auth()->check()) padding: 1.5rem 0; @endif">
            <!-- Flash Messages -->
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

    <!-- Additional Scripts -->
    @stack('scripts')
</body>
</html>
