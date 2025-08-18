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
            <nav style="background-color: white; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);">
                <div style="max-width: 80rem; margin: 0 auto; padding: 0 1rem;">
                    <div style="display: flex; justify-content: space-between; height: 4rem; align-items: center;">
                        <div style="display: flex; align-items: center;">
                            <!-- Logo -->
                            <div style="flex-shrink: 0; display: flex; align-items: center;">
                                <h1 style="font-size: 1.25rem; font-weight: 700; color: #1f2937;">
                                    Kendaraan Dinas - Kementerian Pemuda dan Olahraga
                                </h1>
                            </div>

                            <!-- Navigation Links -->
                            <div style="display: flex; margin-left: 2.5rem; align-items: center; gap: 2rem;">
                                @if(auth()->user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}"
                                       style="@if(request()->routeIs('admin.dashboard')) border-bottom: 2px solid #6366f1; color: #1f2937; @else border-bottom: 2px solid transparent; color: #6b7280; @endif padding: 1rem 0.25rem; font-size: 0.875rem; font-weight: 500; text-decoration: none; transition: all 0.2s;">
                                        Dashboard
                                    </a>
                                    <a href="{{ route('admin.vehicles.index') }}"
                                       style="@if(request()->routeIs('admin.vehicles.*')) border-bottom: 2px solid #6366f1; color: #1f2937; @else border-bottom: 2px solid transparent; color: #6b7280; @endif padding: 1rem 0.25rem; font-size: 0.875rem; font-weight: 500; text-decoration: none; transition: all 0.2s;">
                                        Data Kendaraan
                                    </a>
                                    <a href="{{ route('admin.users.index') }}"
                                       style="@if(request()->routeIs('admin.users.*')) border-bottom: 2px solid #6366f1; color: #1f2937; @else border-bottom: 2px solid transparent; color: #6b7280; @endif padding: 1rem 0.25rem; font-size: 0.875rem; font-weight: 500; text-decoration: none; transition: all 0.2s;">
                                        Data Operator
                                    </a>

                                @elseif(auth()->user()->isOperator())
                                    <a href="{{ route('operator.dashboard') }}"
                                       style="@if(request()->routeIs('operator.dashboard')) border-bottom: 2px solid #6366f1; color: #1f2937; @else border-bottom: 2px solid transparent; color: #6b7280; @endif padding: 1rem 0.25rem; font-size: 0.875rem; font-weight: 500; text-decoration: none; transition: all 0.2s;">
                                        Dashboard
                                    </a>
                                    <a href="{{ route('operator.services.index') }}"
                                       style="@if(request()->routeIs('operator.services.*')) border-bottom: 2px solid #6366f1; color: #1f2937; @else border-bottom: 2px solid transparent; color: #6b7280; @endif padding: 1rem 0.25rem; font-size: 0.875rem; font-weight: 500; text-decoration: none; transition: all 0.2s;">
                                        Service Kendaraan
                                    </a>
                                    <a href="{{ route('operator.borrowings.index') }}"
                                       style="@if(request()->routeIs('operator.borrowings.*')) border-bottom: 2px solid #6366f1; color: #1f2937; @else border-bottom: 2px solid transparent; color: #6b7280; @endif padding: 1rem 0.25rem; font-size: 0.875rem; font-weight: 500; text-decoration: none; transition: all 0.2s;">
                                        Peminjaman
                                    </a>
                                    <a href="{{ route('operator.payments.index') }}"
                                       style="@if(request()->routeIs('operator.payments.*')) border-bottom: 2px solid #6366f1; color: #1f2937; @else border-bottom: 2px solid transparent; color: #6b7280; @endif padding: 1rem 0.25rem; font-size: 0.875rem; font-weight: 500; text-decoration: none; transition: all 0.2s;">
                                        Pembayaran
                                    </a>
                                @endif
                            </div>
                        </div>

                        <!-- User Dropdown -->
                        <div style="display: flex; align-items: center; margin-left: 1.5rem;">
                            <div style="margin-left: 0.75rem; position: relative;">
                                <div style="display: flex; align-items: center; gap: 0.75rem;">
                                    <span style="color: #374151;">{{ auth()->user()->name }}</span>
                                    <span style="padding: 0.25rem 0.5rem; font-size: 0.75rem; border-radius: 9999px; @if(auth()->user()->isAdmin()) background-color: #fee2e2; color: #991b1b; @else background-color: #dbeafe; color: #1e40af; @endif">
                                        {{ auth()->user()->role === 'admin' ? 'Admin' : 'Operator' }}
                                    </span>
                                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                                        @csrf
                                        <button type="submit" style="color: #6b7280; background: none; border: none; cursor: pointer; transition: color 0.2s;" onmouseover="this.style.color='#374151'" onmouseout="this.style.color='#6b7280'">
                                            Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
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
