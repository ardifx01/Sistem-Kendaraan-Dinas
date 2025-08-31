@extends('layouts.app')

@section('title', 'Detail Kendaraan')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-6 flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <a href="{{ route('operator.vehicles.index') }}" class="text-gray-500 hover:text-gray-700 transition-colors flex items-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ $vehicle->brand }} {{ $vehicle->model }}</h1>
                <p class="text-sm text-gray-600">{{ $vehicle->license_plate }} • Tahun {{ $vehicle->year }}</p>
            </div>
        </div>

        <div class="flex items-center space-x-3">
            <a href="{{ route('operator.vehicles.export.single.pdf', $vehicle) }}" class="inline-flex items-center px-3 py-2 border border-green-500 rounded-md text-sm text-gray-700 bg-green-400 hover:bg-green-600">
                Cetak PDF
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-1 bg-white rounded-md shadow p-4">
            <div class="mb-4">
                @if($vehicle->photo)
                    <img src="{{ Storage::url($vehicle->photo) }}" alt="Foto kendaraan" class="w-full h-48 object-cover rounded-md border">
                @else
                    <div class="w-full h-48 bg-gray-100 rounded-md flex items-center justify-center text-gray-400">Tidak ada foto</div>
                @endif
            </div>

            <div class="space-y-2 text-sm text-gray-700">
                <div>
                    <span class="font-medium">Jenis:</span> {{ ucfirst($vehicle->type) ?? '-' }}
                </div>
                <div>
                    <span class="font-medium">Warna:</span> {{ $vehicle->color ?? '-' }}
                </div>
                <div>
                    <span class="font-medium">Nomor BPKB:</span> {{ $vehicle->bpkb_number ?? '-' }}
                </div>
                <div>
                    <span class="font-medium">Nomor Rangka:</span> {{ $vehicle->chassis_number ?? '-' }}
                </div>
                <div>
                    <span class="font-medium">Nomor Mesin:</span> {{ $vehicle->engine_number ?? '-' }}
                </div>
            </div>
        </div>

        <div class="lg:col-span-2 bg-white rounded-md shadow p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-lg font-medium text-gray-900">Rincian Kendaraan</h2>
                    <p class="text-sm text-gray-600">Informasi lengkap mengenai kendaraan ini</p>
                </div>
                <div class="text-right">
                    @php
                        $days = $vehicle->tax_expiry_date ? now()->diffInDays(\Illuminate\Support\Carbon::parse($vehicle->tax_expiry_date), false) : null;
                    @endphp
                    @if($vehicle->tax_expiry_date)
                        @if(\Illuminate\Support\Carbon::parse($vehicle->tax_expiry_date)->isPast())
                            <span class="inline-flex items-center px-3 py-1 rounded-full bg-red-100 text-red-700 text-sm">Pajak kadaluarsa</span>
                        @elseif($days !== null && $days <= 30)
                            <span class="inline-flex items-center px-3 py-1 rounded-full bg-yellow-100 text-yellow-800 text-sm">Pajak hampir jatuh tempo ({{ $days }} hari)</span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full bg-green-100 text-green-800 text-sm">Pajak aktif</span>
                        @endif
                    @else
                        <span class="inline-flex items-center px-3 py-1 rounded-full bg-gray-100 text-gray-700 text-sm">Tanggal pajak tidak tersedia</span>
                    @endif
                </div>
            </div>

            <table class="w-full text-sm text-left">
                <tbody class="text-gray-700">
                    <tr class="border-t">
                        <th class="py-3 pr-6 font-medium text-gray-600 w-48">Plat Nomor</th>
                        <td class="py-3">{{ $vehicle->license_plate }}</td>
                    </tr>
                    <tr class="border-t">
                        <th class="py-3 pr-6 font-medium text-gray-600">Tahun</th>
                        <td class="py-3">{{ $vehicle->year }}</td>
                    </tr>
                    <tr class="border-t">
                        <th class="py-3 pr-6 font-medium text-gray-600">Isi Silinder (CC)</th>
                        <td class="py-3">{{ $vehicle->cc_amount }} cc</td>
                    </tr>
                    <tr class="border-t">
                        <th class="py-3 pr-6 font-medium text-gray-600">Status Dokumen</th>
                        <td class="py-3">{{ ucfirst(str_replace('_', ' ', $vehicle->document_status ?? '-')) }}</td>
                    </tr>
                    <tr class="border-t">
                        <th class="py-3 pr-6 font-medium text-gray-600">Catatan Dokumen</th>
                        <td class="py-3">{{ $vehicle->document_notes ?? '-' }}</td>
                    </tr>
                    <tr class="border-t">
                        <th class="py-3 pr-6 font-medium text-gray-600">Status Kendaraan</th>
                        <td class="py-3">{{ ucfirst(str_replace('_', ' ', $vehicle->availability_status ?? '-')) }}</td>
                    </tr>
                    <tr class="border-t">
                        <th class="py-3 pr-6 font-medium text-gray-600">Nama Driver</th>
                        <td class="py-3">{{ $vehicle->driver_name ?? '-' }}</td>
                    </tr>
                    <tr class="border-t">
                        <th class="py-3 pr-6 font-medium text-gray-600">Nama Pengguna</th>
                        <td class="py-3">{{ $vehicle->user_name ?? '-' }}</td>
                    </tr>
                    <tr class="border-t">
                        <th class="py-3 pr-6 font-medium text-gray-600">Tanggal Berakhir Pajak</th>
                        <td class="py-3">{{ $vehicle->tax_expiry_date ? \Illuminate\Support\Carbon::parse($vehicle->tax_expiry_date)->format('d M Y') : '-' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Service History -->
    @if($vehicle->servicesWithTrashed->count() > 0)
        <div class="mt-8">
            <div class="card">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Riwayat Service</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Servis</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Servis</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Pembayaran</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($vehicle->servicesWithTrashed->take(5) as $service)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $service->service_date?->format('d M Y') ?? ($service->created_at?->format('d M Y') ?? '-') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $service->service_type ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $service->payment_type ? ucfirst(str_replace('_', ' ', $service->payment_type)) : '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <div class="flex items-center space-x-2">
                                            <a href="{{ route('operator.services.show', $service) }}" class="text-indigo-600 hover:text-indigo-900 inline-flex items-center" title="Lihat">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>

                                            <a href="{{ route('operator.services.download', $service) }}" class="text-gray-600 hover:text-gray-900 inline-flex items-center" title="Download PDF">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v12m0 0l4-4m-4 4l-4-4M21 21H3" />
                                                </svg>
                                            </a>
                                        </div>
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
                                        {{ $borrowing->borrow_date->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $borrowing->return_date?->format('d M Y') ?? 'Belum kembali' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $borrowing->purpose }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $brwClass = $borrowing->status === 'dikembalikan'
                                                ? 'bg-green-100 text-green-800'
                                                : ($borrowing->status === 'dipinjam' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800');
                                        @endphp
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $brwClass }}">
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
                <p class="text-sm text-gray-600 mb-4">Apakah Anda yakin ingin menghapus kendaraan ini? Tindakan ini tidak dapat dibatalkan.</p>
                <div class="bg-red-50 rounded-lg p-4 space-y-2">
                    <div class="flex justify-between">
                        <span class="font-medium text-gray-700">Kendaraan:</span>
                        <span class="text-gray-900">{{ $vehicle->brand }} {{ $vehicle->model }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="font-medium text-gray-700">Plat Nomor:</span>
                        <span class="text-gray-900">{{ $vehicle->license_plate }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="font-medium text-gray-700">Status:</span>
                        <span class="text-gray-900">{{ ucfirst($vehicle->availability_status ?? 'tersedia') }}</span>
                    </div>
                </div>
            </div>
            <div class="px-6 py-4 bg-gray-50 flex flex-col sm:flex-row sm:justify-end space-y-2 sm:space-y-0 sm:space-x-3">
                <button type="button" onclick="closeDeleteModal()"
                        class="w-full sm:w-auto px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                    Batal
                </button>
                <button type="button" onclick="submitDelete()"
                        class="w-full sm:w-auto px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                    <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Ya, Hapus
                </button>
            </div>
        </div>
    </div>

    <!-- Hidden Delete Form -->
    <form id="deleteForm" method="POST" action="{{ route('operator.vehicles.destroy', $vehicle) }}" class="hidden">
        @csrf
        @method('DELETE')
    </form>

@push('scripts')
<script>
    function confirmDelete() {
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
    }

    function submitDelete() {
        document.getElementById('deleteForm').submit();
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
