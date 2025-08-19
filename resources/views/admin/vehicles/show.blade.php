@extends('layouts.app')

@section('title', 'Detail Kendaraan')

@php
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
// Set locale ke Indonesia
Carbon::setLocale('id');
@endphp

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.vehicles.index') }}"
                   class="text-gray-500 hover:text-gray-700 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <div>
                    <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Detail Kendaraan</h1>
                    <p class="mt-1 text-sm text-gray-700">{{ $vehicle->brand }} {{ $vehicle->model }} - {{ $vehicle->license_plate }}</p>
                </div>
            </div>
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center space-y-2 sm:space-y-0 sm:space-x-3">
                <a href="{{ route('admin.vehicles.edit', $vehicle) }}" class="btn btn-secondary justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit
                </a>
                <form method="POST" action="{{ route('admin.vehicles.destroy', $vehicle) }}"
                      onsubmit="event.preventDefault(); confirmAndDeleteShow(this)" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full sm:w-auto btn bg-red-600 hover:bg-red-700 text-white justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 lg:gap-8">
        <!-- Main Information -->
        <div class="xl:col-span-2 space-y-6">
            <!-- Basic Info Card -->
            <div class="card p-4 sm:p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Kendaraan</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jenis</label>
                        <div class="text-sm text-gray-900">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ ucfirst($vehicle->type) }}
                            </span>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Merk & Model</label>
                        <p class="text-sm text-gray-900">{{ $vehicle->brand }} {{ $vehicle->model }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tahun</label>
                        <p class="text-sm text-gray-900">{{ $vehicle->year }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Plat Nomor</label>
                        <p class="text-sm text-gray-900 font-mono bg-gray-50 px-2 py-1 rounded">{{ $vehicle->license_plate }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Warna</label>
                        <p class="text-sm text-gray-900">{{ $vehicle->color }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status Ketersediaan</label>
                        <div class="text-sm">
                            @php
                                $statusColors = [
                                    'tersedia' => 'bg-green-100 text-green-800',
                                    'dipinjam' => 'bg-yellow-100 text-yellow-800',
                                    'service' => 'bg-red-100 text-red-800',
                                    'tidak_tersedia' => 'bg-gray-100 text-gray-800'
                                ];
                                $statusTexts = [
                                    'tersedia' => 'Tersedia',
                                    'dipinjam' => 'Dipinjam',
                                    'service' => 'Service',
                                    'tidak_tersedia' => 'Tidak Tersedia'
                                ];
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusColors[$vehicle->availability_status] ?? 'bg-gray-100 text-gray-800' }}">
                                {{ $statusTexts[$vehicle->availability_status] ?? $vehicle->availability_status }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Document Info Card -->
            <div class="card p-4 sm:p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Dokumen</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Berakhir Pajak</label>
                        <div class="text-sm">
                            @if($vehicle->tax_expiry_date)
                                <p class="text-gray-900">{{ $vehicle->tax_expiry_date->translatedFormat('d F Y') }}</p>
                                @if($vehicle->isTaxExpiringSoon())
                                    <p class="text-red-600 font-medium mt-1">⚠️ Segera Expired! ({{ $vehicle->days_until_tax_expiry }} hari lagi)</p>
                                @endif
                            @else
                                <p class="text-gray-500">Tidak diatur</p>
                            @endif
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status Dokumen</label>
                        <div class="text-sm">
                            @if($vehicle->document_status === 'lengkap')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    ✓ Lengkap
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    ✗ Tidak Lengkap
                                </span>
                            @endif
                        </div>
                    </div>
                    @if($vehicle->document_notes)
                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Catatan Dokumen</label>
                            <p class="text-sm text-gray-900 bg-yellow-50 p-3 rounded-md border border-yellow-200">{{ $vehicle->document_notes }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Additional Info Card -->
            <div class="card p-4 sm:p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Tambahan</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Driver</label>
                        <p class="text-sm text-gray-900">{{ $vehicle->driver_name ?: 'Tidak ada' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Pengguna</label>
                        <p class="text-sm text-gray-900">{{ $vehicle->user_name ?: 'Tidak ada' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Ditambahkan</label>
                        <p class="text-sm text-gray-900">{{ $vehicle->created_at->translatedFormat('d F Y H:i') }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Terakhir Diperbarui</label>
                        <p class="text-sm text-gray-900">{{ $vehicle->updated_at->translatedFormat('d F Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Photo Card -->
            <div class="card p-4 sm:p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Foto Kendaraan</h3>
                @if($vehicle->photo)
                    <img src="{{ Storage::url($vehicle->photo) }}"
                         alt="Foto {{ $vehicle->brand }} {{ $vehicle->model }}"
                         class="w-full h-48 sm:h-64 object-cover rounded-lg border">
                @else
                    <div class="w-full h-48 sm:h-64 bg-gray-100 rounded-lg border-2 border-dashed border-gray-300 flex items-center justify-center">
                        <div class="text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13l-3 3 3 3m-6-6l3 3-3 3"></path>
                            </svg>
                            <p class="mt-2 text-sm text-gray-500">Tidak ada foto</p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Quick Actions -->
            <div class="card p-4 sm:p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Aksi Cepat</h3>
                <div class="space-y-3">
                    <a href="{{ route('admin.vehicles.edit', $vehicle) }}"
                       class="w-full btn btn-secondary justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit Kendaraan
                    </a>
                    @if($vehicle->availability_status === 'tersedia')
                        <button class="w-full btn bg-blue-600 hover:bg-blue-700 text-white justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Tambah Peminjaman
                        </button>
                        <button class="w-full btn bg-orange-600 hover:bg-orange-700 text-white justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Jadwalkan Service
                        </button>
                    @endif
                </div>
            </div>

            <!-- Statistics -->
            <div class="card p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Statistik</h3>
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Total Service</span>
                        <span class="text-sm font-medium text-gray-900">{{ $vehicle->services->count() }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Total Peminjaman</span>
                        <span class="text-sm font-medium text-gray-900">{{ $vehicle->borrowings->count() }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Service Terakhir</span>
                        <span class="text-sm font-medium text-gray-900">
                            @if($vehicle->services->count() > 0)
                                {{ $vehicle->services->latest()->first()->created_at->translatedFormat('d F Y') }}
                            @else
                                Belum ada
                            @endif
                        </span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Peminjaman Terakhir</span>
                        <span class="text-sm font-medium text-gray-900">
                            @if($vehicle->borrowings->count() > 0)
                                {{ $vehicle->borrowings->latest()->first()->created_at->translatedFormat('d F Y') }}
                            @else
                                Belum ada
                            @endif
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Service History -->
    @if($vehicle->services->count() > 0)
        <div class="mt-8">
            <div class="card">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Riwayat Service</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Service</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Operator</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Biaya</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($vehicle->services->take(5) as $service)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $service->service_date->translatedFormat('d F Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $service->service_type }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $service->user->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        Rp {{ number_format($service->cost, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            @if($service->status === 'selesai') bg-green-100 text-green-800
                                            @elseif($service->status === 'proses') bg-yellow-100 text-yellow-800
                                            @else bg-gray-100 text-gray-800 @endif">
                                            {{ ucfirst($service->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif

    <!-- Borrowing History -->
    @if($vehicle->borrowings->count() > 0)
        <div class="mt-8">
            <div class="card">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Riwayat Peminjaman</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Peminjam</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Pinjam</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Kembali</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tujuan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($vehicle->borrowings->take(5) as $borrowing)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $borrowing->user->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $borrowing->borrow_date->translatedFormat('d F Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $borrowing->return_date?->translatedFormat('d F Y') ?? 'Belum kembali' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $borrowing->purpose }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            @if($borrowing->status === 'dikembalikan') bg-green-100 text-green-800
                                            @elseif($borrowing->status === 'dipinjam') bg-yellow-100 text-yellow-800
                                            @else bg-gray-100 text-gray-800 @endif">
                                            {{ ucfirst($borrowing->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 items-center justify-center p-4 hidden z-50">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full transform transition-all">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>
                <h3 class="ml-3 text-lg font-medium text-gray-900">Konfirmasi Hapus Kendaraan</h3>
            </div>
        </div>
        <div class="px-6 py-4">
            <p class="text-sm text-gray-600 mb-4">Apakah Anda yakin ingin menghapus kendaraan berikut?</p>
            <div class="bg-red-50 border border-red-200 rounded-lg p-4 space-y-2">
                <div class="flex justify-between">
                    <span class="font-medium text-gray-700">Merek:</span>
                    <span class="text-gray-900">{{ $vehicle->brand }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="font-medium text-gray-700">Model:</span>
                    <span class="text-gray-900">{{ $vehicle->model }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="font-medium text-gray-700">Plat Nomor:</span>
                    <span class="text-gray-900">{{ $vehicle->license_plate }}</span>
                </div>
            </div>
            <div class="mt-4 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                <p class="text-sm text-yellow-800">
                    <span class="font-medium">Peringatan:</span> Data yang dihapus tidak dapat dikembalikan!
                </p>
            </div>
        </div>
        <div class="px-6 py-4 bg-gray-50 flex flex-col sm:flex-row sm:justify-end space-y-2 sm:space-y-0 sm:space-x-3">
            <button type="button" onclick="closeDeleteModal()"
                    class="w-full sm:w-auto px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                Batal
            </button>
            <button type="button" onclick="submitDeleteForm()"
                    class="w-full sm:w-auto px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
                Ya, Hapus
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let deleteFormToSubmit = null;

    // Confirm and delete vehicle from show page
    function confirmAndDeleteShow(form) {
        deleteFormToSubmit = form;

        // Show modal
        const modal = document.getElementById('deleteModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function closeDeleteModal() {
        const modal = document.getElementById('deleteModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = 'auto';
        deleteFormToSubmit = null;
    }

    function submitDeleteForm() {
        if (deleteFormToSubmit) {
            deleteFormToSubmit.submit();
        }
    }

    // Close modal when clicking outside
    document.getElementById('deleteModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeDeleteModal();
        }
    });

    // Close modal with ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeDeleteModal();
        }
    });
</script>
@endpush

@endsection
