@extends('layouts.app')

@section('title', 'Daftar Service Kendaraan')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">Daftar Service Kendaraan</h1>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 rounded-xl shadow-lg">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kendaraan</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Plat Nomor</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Service</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($services as $service)
                <tr>
                    <td class="px-4 py-3 whitespace-nowrap">{{ $loop->iteration }}</td>
                    <td class="px-4 py-3 whitespace-nowrap">{{ $service->vehicle->brand }} {{ $service->vehicle->model }}</td>
                    <td class="px-4 py-3 whitespace-nowrap">{{ $service->vehicle->license_plate }}</td>
                    <td class="px-4 py-3 whitespace-nowrap">{{ $service->service_date->format('d-m-Y') }}</td>
                    <td class="px-4 py-3 whitespace-nowrap">
                        <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $service->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : ($service->status == 'completed' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') }}">
                            {{ ucfirst($service->status) }}
                        </span>
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap">
                        <a href="{{ route('operator.services.show', $service) }}" class="text-blue-600 hover:text-blue-800 font-medium">Detail</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-4 py-6 text-center text-gray-500">Tidak ada data service kendaraan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-6">
        {{ $services->links() }}
    </div>
</div>
@endsection
