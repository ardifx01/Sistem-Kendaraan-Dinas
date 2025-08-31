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

                <!-- Captcha Field -->
                <div>
                    <label for="captcha" class="block text-sm font-medium text-gray-700 mb-2">
                        Verifikasi Keamanan
                    </label>
                    <div class="flex space-x-3">
                        <!-- Captcha Display -->
                        <div class="flex-1">
                            <div class="bg-gradient-to-r from-gray-50 to-gray-100 border-2 border-gray-300 rounded-lg p-4 flex items-center justify-center h-12 relative overflow-hidden">
                                <!-- Background pattern -->
                                <div class="absolute inset-0 opacity-10">
                                    <div class="absolute top-0 left-0 w-full h-full" style="background-image: repeating-linear-gradient(45deg, transparent, transparent 2px, #000 2px, #000 4px);"></div>
                                </div>
                                <div class="flex items-center space-x-2 relative z-10">
                                    <span id="captcha-text" class="text-xl font-bold text-gray-800 tracking-widest font-mono select-none transform skew-y-1 shadow-sm"></span>
                                    <button type="button" id="refresh-captcha"
                                            class="ml-3 p-2 text-gray-500 hover:text-blue-600 focus:outline-none focus:text-blue-600 transition-all duration-200 rounded-full hover:bg-white hover:shadow-md"
                                            title="Refresh Captcha">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- Captcha Input -->
                        <div class="flex-1">
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <input id="captcha" name="captcha" type="text" required maxlength="5"
                                       class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out sm:text-sm"
                                       placeholder="Masukkan kode"
                                       autocomplete="off">
                            </div>
                            <div id="captcha-error" class="mt-1 text-sm text-red-600 hidden">
                                Kode verifikasi tidak cocok
                            </div>
                        </div>
                    </div>
                    <p class="mt-2 text-xs text-gray-500 flex items-center">
                        <svg class="w-3 h-3 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Masukkan kode yang ditampilkan untuk verifikasi keamanan
                    </p>
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

                <!-- Forgot Password Link -->
                <div class="text-center">
                    <a href="{{ route('password.request') }}"
                       class="text-sm text-blue-600 hover:text-blue-500 transition-colors duration-200 inline-flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        Lupa password?
                    </a>
                </div>
            </form>
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

        // Captcha functionality
        let captchaCode = '';

        function generateCaptcha() {
            const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            captchaCode = '';
            for (let i = 0; i < 5; i++) {
                captchaCode += chars.charAt(Math.floor(Math.random() * chars.length));
            }

            const captchaDisplay = document.getElementById('captcha-text');

            // Add fade effect during generation
            captchaDisplay.style.opacity = '0';
            captchaDisplay.style.transform = 'scale(0.8) skew(-2deg)';

            setTimeout(() => {
                captchaDisplay.textContent = captchaCode;
                captchaDisplay.style.opacity = '1';
                captchaDisplay.style.transform = 'scale(1) skew(1deg)';

                // Add random colors for each character (keeping readability)
                const colors = ['text-gray-800', 'text-blue-800', 'text-green-800', 'text-purple-800', 'text-red-800'];
                captchaDisplay.className = `text-xl font-bold tracking-widest font-mono select-none transform skew-y-1 shadow-sm transition-all duration-300 ${colors[Math.floor(Math.random() * colors.length)]}`;
            }, 150);

            // Clear previous input and error
            document.getElementById('captcha').value = '';
            document.getElementById('captcha-error').classList.add('hidden');

            // Reset input field styling
            const captchaInput = document.getElementById('captcha');
            captchaInput.classList.remove('border-red-300', 'ring-red-500', 'border-green-300', 'ring-green-500');
            captchaInput.classList.add('border-gray-300');
        }

        // Generate initial captcha
        generateCaptcha();

        // Refresh captcha button
        document.getElementById('refresh-captcha').addEventListener('click', function() {
            // Add loading state
            this.innerHTML = `
                <svg class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
            `;

            // Generate new captcha after short delay
            setTimeout(() => {
                generateCaptcha();

                // Restore original icon
                this.innerHTML = `
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                `;

                // Add success feedback
                this.classList.add('text-green-600');
                setTimeout(() => {
                    this.classList.remove('text-green-600');
                }, 1000);
            }, 500);
        });

        // Validate captcha on input
        document.getElementById('captcha').addEventListener('input', function() {
            const userInput = this.value.toUpperCase();
            const errorDiv = document.getElementById('captcha-error');

            if (userInput.length === 5) {
                if (userInput !== captchaCode) {
                    errorDiv.classList.remove('hidden');
                    this.classList.add('border-red-300', 'ring-red-500');
                    this.classList.remove('border-gray-300', 'ring-blue-500');
                } else {
                    errorDiv.classList.add('hidden');
                    this.classList.remove('border-red-300', 'ring-red-500');
                    this.classList.add('border-green-300', 'ring-green-500');
                }
            } else {
                errorDiv.classList.add('hidden');
                this.classList.remove('border-red-300', 'ring-red-500', 'border-green-300', 'ring-green-500');
                this.classList.add('border-gray-300');
            }
        });

        form.addEventListener('submit', function(e) {
            const captchaInput = document.getElementById('captcha').value.toUpperCase();
            const errorDiv = document.getElementById('captcha-error');

            // Validate captcha before submission
            if (captchaInput !== captchaCode) {
                e.preventDefault();
                errorDiv.classList.remove('hidden');
                errorDiv.textContent = 'Kode verifikasi tidak cocok. Silakan coba lagi.';

                // Highlight error field
                document.getElementById('captcha').classList.add('border-red-300', 'ring-red-500');
                document.getElementById('captcha').focus();

                // Generate new captcha
                generateCaptcha();
                return false;
            }

            // Show loading state
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

        // OTP functionality (simulasi)
        let otpCode = '482193';
        function generateOtp() {
            otpCode = '';
            for (let i = 0; i < 6; i++) {
                otpCode += Math.floor(Math.random() * 10);
            }
            document.getElementById('otp-code').textContent = otpCode;
            document.getElementById('otp').value = '';
            document.getElementById('otp-error').classList.add('hidden');
        }
        // Generate initial OTP
        generateOtp();
        // Refresh OTP button
        document.getElementById('refresh-otp').addEventListener('click', function() {
            this.innerHTML = `<svg class=\"w-4 h-4 animate-spin\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15\" /></svg>`;
            setTimeout(() => {
                generateOtp();
                this.innerHTML = `<svg class=\"w-4 h-4\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15\" /></svg>`;
                this.classList.add('text-green-600');
                setTimeout(() => { this.classList.remove('text-green-600'); }, 1000);
            }, 500);
        });
        // Validasi OTP input
        document.getElementById('otp').addEventListener('input', function() {
            const userInput = this.value;
            const errorDiv = document.getElementById('otp-error');
            if (userInput.length === 6) {
                if (userInput !== otpCode) {
                    errorDiv.classList.remove('hidden');
                    this.classList.add('border-red-300', 'ring-red-500');
                    this.classList.remove('border-gray-300', 'ring-blue-500');
                } else {
                    errorDiv.classList.add('hidden');
                    this.classList.remove('border-red-300', 'ring-red-500');
                    this.classList.add('border-green-300', 'ring-green-500');
                }
            } else {
                errorDiv.classList.add('hidden');
                this.classList.remove('border-red-300', 'ring-red-500', 'border-green-300', 'ring-green-500');
                this.classList.add('border-gray-300');
            }
        });
        // Validasi OTP sebelum submit
        form.addEventListener('submit', function(e) {
            const otpInput = document.getElementById('otp').value;
            const errorDiv = document.getElementById('otp-error');
            if (otpInput !== otpCode) {
                e.preventDefault();
                errorDiv.classList.remove('hidden');
                errorDiv.textContent = 'Kode OTP tidak valid. Silakan coba lagi.';
                document.getElementById('otp').classList.add('border-red-300', 'ring-red-500');
                document.getElementById('otp').focus();
                generateOtp();
                return false;
            }
        });

        // Add transition styles for refresh button and captcha
        const refreshButton = document.getElementById('refresh-captcha');
        const captchaDisplay = document.getElementById('captcha-text');

        refreshButton.style.transition = 'all 0.2s ease-in-out';
        captchaDisplay.style.transition = 'all 0.3s cubic-bezier(0.4, 0, 0.2, 1)';

        // Add hover effects for captcha display
        const captchaContainer = captchaDisplay.parentElement.parentElement;
        captchaContainer.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.02)';
            this.style.boxShadow = '0 4px 12px rgba(0, 0, 0, 0.1)';
        });

        captchaContainer.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
            this.style.boxShadow = '0 1px 3px rgba(0, 0, 0, 0.1)';
        });

        captchaContainer.style.transition = 'all 0.2s ease-in-out';
    });
</script>
@endsection
