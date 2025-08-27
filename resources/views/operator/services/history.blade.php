@extends('layouts.app')

@section('title', 'Riwayat Service')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
    <div class="flex items-center justify-between mb-4">
        <div>
            <h1 class="text-xl font-bold text-gray-900">Riwayat Service</h1>
            <p class="mt-1 text-sm text-gray-600">Daftar riwayat service kendaraan — responsif dan mudah dicari</p>
        </div>
        <div class="flex items-center space-x-2">
            @php
                $manageBg = (request()->routeIs('operator.services.index') || (request()->routeIs('operator.services.*') && !request()->routeIs('operator.services.history'))) ? 'bg-blue-700' : 'bg-blue-600';
                $createBg = request()->routeIs('operator.services.create') ? 'bg-green-700' : 'bg-green-600';
            @endphp
            <a href="{{ route('operator.services.index') }}" class="px-3 py-2 text-sm font-medium text-white {{ $manageBg }} hover:bg-blue-700 rounded-md transition-colors">Kelola Service</a>
            <a href="{{ route('operator.services.create') }}" class="px-3 py-2 text-sm font-medium text-white {{ $createBg }} hover:bg-green-700 rounded-md transition-colors">Tambah Service</a>
        </div>
    </div>

    <!-- Navbar filters -->
    <div class="bg-white rounded-md shadow-sm border border-gray-200 p-3 mb-4">
        <nav class="flex overflow-auto space-x-2 sm:space-x-4">
            <a href="{{ route('operator.services.history') }}" class="px-3 py-2 text-sm rounded-md border {{ request()->filled('type') ? 'border-transparent text-gray-700' : 'bg-blue-600 text-white' }}">Semua ({{ $counts['all'] ?? 0 }})</a>
            <a href="{{ route('operator.services.history', ['type' => 'service_rutin']) }}" class="px-3 py-2 text-sm rounded-md border {{ request('type')=='service_rutin' ? 'bg-blue-600 text-white' : 'text-gray-700' }}">Service Rutin ({{ $counts['service_rutin'] ?? 0 }})</a>
            <a href="{{ route('operator.services.history', ['type' => 'kerusakan']) }}" class="px-3 py-2 text-sm rounded-md border {{ request('type')=='kerusakan' ? 'bg-blue-600 text-white' : 'text-gray-700' }}">Kerusakan ({{ $counts['kerusakan'] ?? 0 }})</a>
            <a href="{{ route('operator.services.history', ['type' => 'perbaikan']) }}" class="px-3 py-2 text-sm rounded-md border {{ request('type')=='perbaikan' ? 'bg-blue-600 text-white' : 'text-gray-700' }}">Perbaikan ({{ $counts['perbaikan'] ?? 0 }})</a>
            <a href="{{ route('operator.services.history', ['type' => 'penggantian_part']) }}" class="px-3 py-2 text-sm rounded-md border {{ request('type')=='penggantian_part' ? 'bg-blue-600 text-white' : 'text-gray-700' }}">Ganti Part ({{ $counts['penggantian_part'] ?? 0 }})</a>
        </nav>
    </div>

    <!-- Search + Pagination top -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-3 space-y-3 sm:space-y-0">
    <form method="GET" action="{{ route('operator.services.history') }}" class="flex-1 mr-3">
            <div class="flex">
                <input type="text" name="search" placeholder="Cari plat, merk, model, deskripsi..." value="{{ request('search') }}" class="w-full px-3 py-2 border border-gray-300 rounded-l-md focus:ring-1 focus:ring-blue-500">
        <button type="submit" class="px-3 py-2 bg-blue-600 text-white rounded-r-md">Cari</button>
            </div>
        </form>
    <div class="flex items-center space-x-3">
        <div class="text-sm text-gray-600">Menampilkan {{ $services->total() }} hasil</div>
        <a href="{{ route('operator.services.history.export-pdf', request()->query()) }}" class="px-3 py-2 text-sm font-medium text-white bg-gray-700 hover:bg-gray-800 rounded-md">Export PDF</a>
    </div>
    </div>

    <!-- List -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @forelse($services as $service)
        <div class="bg-white rounded-md shadow-sm border border-gray-200 p-4">
            <div class="flex items-start space-x-3">
                <div class="flex-1">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-sm font-semibold text-gray-900">{{ $service->vehicle?->brand ?? '-' }} {{ $service->vehicle?->model ?? '' }} <span class="text-xs text-gray-500">({{ $service->vehicle?->license_plate ?? '-' }})</span></div>
                            <div class="text-xs text-gray-500 mt-0.5">{{ $service->service_date?->format('d M Y') ?? '-' }} • {{ $service->user?->name ?? '-' }}</div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <a href="{{ route('operator.services.show', $service) }}" class="text-blue-600 text-sm">Lihat</a>
                        </div>
                    </div>

                    <div class="mt-2 text-sm text-gray-700">
                        <div class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $service->service_type == 'kerusakan' ? 'bg-red-100 text-red-800' : ($service->service_type == 'perbaikan' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">{{ $service->service_type }}</div>
                        <div class="mt-2 text-xs text-gray-600">{{ Str::limit($service->description ?? ($service->damage_description ?? ''), 120) }}</div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-1">
            <div class="bg-white rounded-md shadow-sm border border-gray-200 p-6 text-center">
                <p class="text-sm text-gray-600">Tidak ada riwayat service untuk jenis ini.</p>
            </div>
        </div>
        @endforelse
    </div>

    <div class="mt-6">{{ $services->links() }}</div>
</div>
@endsection
