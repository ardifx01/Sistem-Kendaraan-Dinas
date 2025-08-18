@extends('layouts.guest')

@section('title', 'Login')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-green-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <!-- Back to Landing Page -->
    <div class="absolute top-4 left-4">
        <a href="{{ route('landing') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-600 bg-white rounded-lg shadow-md hover:bg-gray-50 hover:text-gray-900 transition-all duration-200">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali
        </a>
    </div>

    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <!-- Logo dan Header -->
        <div class="flex justify-center">
            <div class="w-16 h-16 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-full flex items-center justify-center shadow-lg">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                </svg>
            </div>
        </div>

        <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
            Sistem Kendaraan Dinas
        </h2>
        <p class="mt-1 text-center text-xs text-gray-500">
            Masuk untuk mengakses sistem manajemen
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-4 shadow-xl rounded-2xl sm:px-10 border border-gray-100">
            <form class="space-y-6" method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Username Field -->
                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700 mb-2">
                        Username
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <input id="username" name="username" type="text" required
                               class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out sm:text-sm"
                               placeholder="Masukkan username"
                               value="{{ old('username') }}">
                    </div>
                </div>

                <!-- Password Field -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        Password
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <input id="password" name="password" type="password" required
                               class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out sm:text-sm"
                               placeholder="Masukkan password">
                    </div>
                </div>

                <!-- Error Messages -->
                @if($errors->any())
                    <div class="rounded-lg bg-red-50 p-4 border border-red-200">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">
                                    Terjadi kesalahan:
                                </h3>
                                <div class="mt-2 text-sm text-red-700">
                                    <ul class="list-disc pl-5 space-y-1">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Remember Me -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember" name="remember" type="checkbox"
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="remember" class="ml-2 block text-sm text-gray-700">
                            Ingat saya
                        </label>
                    </div>
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit"
                            class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transform transition-all duration-150 ease-in-out hover:scale-105 shadow-lg">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-blue-300 group-hover:text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                            </svg>
                        </span>
                        Masuk ke Sistem
                    </button>
                </div>
            </form>

            <!-- Default Accounts Info -->
            <div class="mt-8 border-t border-gray-200 pt-6">
                <div class="text-center">
                    <h3 class="text-sm font-medium text-gray-900 mb-3">Akun Default untuk Testing</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <!-- Admin Account -->
                        <div class="bg-red-50 border border-red-200 rounded-lg p-3">
                            <div class="flex items-center justify-center mb-2">
                                <div class="w-6 h-6 bg-red-500 rounded-full flex items-center justify-center">
                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                </div>
                                <span class="ml-2 text-xs font-semibold text-red-800">ADMIN</span>
                            </div>
                            <p class="text-xs text-red-700">Username: <span class="font-mono font-semibold">admin</span></p>
                            <p class="text-xs text-red-700">Password: <span class="font-mono font-semibold">password</span></p>
                        </div>

                        <!-- Operator Account -->
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-3">
                            <div class="flex items-center justify-center mb-2">
                                <div class="w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center">
                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <span class="ml-2 text-xs font-semibold text-blue-800">OPERATOR</span>
                            </div>
                            <p class="text-xs text-blue-700">Username: <span class="font-mono font-semibold">operator1</span></p>
                            <p class="text-xs text-blue-700">Password: <span class="font-mono font-semibold">password</span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="mt-8 text-center">
            <p class="text-xs text-gray-500">
                &copy; {{ date('Y') }} Sistem Kendaraan Dinas
            </p>
        </div>
    </div>
</div>

<!-- Loading Animation -->
<style>
    .loading {
        display: none;
    }

    .form-loading .loading {
        display: inline-block;
    }

    .form-loading .button-text {
        display: none;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        const submitButton = form.querySelector('button[type="submit"]');

        form.addEventListener('submit', function() {
            submitButton.disabled = true;
            submitButton.classList.add('form-loading');
            submitButton.innerHTML = `
                <div class="flex items-center justify-center">
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Memproses...
                </div>
            `;
        });
    });
</script>
@endsection
