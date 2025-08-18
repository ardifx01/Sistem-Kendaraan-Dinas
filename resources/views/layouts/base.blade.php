<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Manajemen Kendaraan Dinas')</title>
    <meta name="description" content="@yield('description', 'Sistem manajemen kendaraan dinas untuk Kementerian Pemuda dan Olahraga')">
    
    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Additional CSS -->
    @stack('styles')
</head>
<body class="bg-gray-50 font-sans antialiased">
    @yield('content')
    
    <!-- Additional JavaScript -->
    @stack('scripts')
</body>
</html>
