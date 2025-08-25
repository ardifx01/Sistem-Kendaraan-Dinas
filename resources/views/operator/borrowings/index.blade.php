@extends('layouts.app')

@section('title', 'Daftar Peminjaman Kendaraan')

@section('content')
<div class="max-w-full mx-auto px-2 sm:px-4 lg:px-6 py-2 sm:py-4">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-3 space-y-2 sm:space-y-0">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Daftar Peminjaman Kendaraan</h1>
            <p class="mt-1 text-xs text-gray-600">Kelola dan monitor semua pengajuan peminjaman kendaraan dinas</p>
        </div>
        <a href="{{ route('operator.borrowings.create') }}"
           class="inline-flex items-center justify-center px-3 py-1.5 bg-green-600 hover:bg-green-700 text-white text-xs font-medium rounded-md shadow-sm transition-colors duration-200 w-full sm:w-auto create-btn"
           data-action="create">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Ajukan Peminjaman
        </a>
    </div>

    <!-- Info Alert -->
    <div class="bg-green-50 border border-green-200 rounded-md p-2 mb-3">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <svg class="w-4 h-4 text-green-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="ml-2">
                <h3 class="text-xs font-medium text-green-800">Informasi Peminjaman</h3>
                <p class="text-xs text-green-700 mt-0.5">
                    Halaman ini menampilkan semua pengajuan peminjaman kendaraan dinas.
                    Anda dapat mengajukan peminjaman baru, melihat status, dan mengelola pengajuan.
                </p>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 mb-3">
        <!-- Total Borrowings -->
        <div class="bg-white rounded-md shadow-sm border border-gray-200 p-3">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-600">Total Pengajuan</p>
                    <p class="text-lg font-bold text-gray-900">{{ $totalBorrowings }}</p>
                </div>
            </div>
        </div>

        <!-- Active Borrowings -->
        <div class="bg-white rounded-md shadow-sm border border-gray-200 p-3">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-3">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-600">Sedang Digunakan</p>
                    <p class="text-lg font-bold text-green-600">{{ $activeBorrowings }}</p>
                </div>
            </div>
        </div>

        <!-- Pending Borrowings -->
        <div class="bg-white rounded-md shadow-sm border border-gray-200 p-3">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center mr-3">
                    <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-600">Menunggu Persetujuan</p>
                    <p class="text-lg font-bold text-yellow-600">{{ $pendingBorrowings }}</p>
                </div>
            </div>
        </div>

        <!-- Available Vehicles -->
        <div class="bg-white rounded-md shadow-sm border border-gray-200 p-3">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center mr-3">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12a7.5 7.5 0 0 0 15 0m-15 0a7.5 7.5 0 1 1 15 0m-15 0H3m16.5 0H21m-1.5 0H12m-8.457 3.077 1.41-.513m14.095-5.13 1.41-.513M5.106 17.785l1.15-.964m11.49-9.642 1.149-.964M7.501 19.795l.75-1.3m7.5-12.99.75-1.3m-6.063 16.658.26-1.477m2.605-14.772.26-1.477m0 17.726-.26-1.477M10.698 4.614l-.26-1.477M16.5 19.794l-.75-1.299M7.5 4.205 12 12m6.894 5.785-1.149-.964M6.256 7.178l-1.15-.964m15.352 8.864-1.41-.513M4.954 9.435l-1.41-.514M12.002 12l-3.75 6.495" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-600">Kendaraan Tersedia</p>
                    <p class="text-lg font-bold text-purple-600">{{ \App\Models\Vehicle::count() - $activeBorrowings }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Search Section -->
    <div class="bg-white rounded-md shadow-sm border border-gray-200 mb-3 p-2">
        <form method="GET" action="{{ route('operator.borrowings.index') }}" class="flex flex-col sm:flex-row gap-2">
            <div class="flex-1">
                <label for="search" class="block text-xs font-medium text-gray-700 mb-1">Cari Peminjaman</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}"
                       placeholder="Nama peminjam, kendaraan, tujuan..."
                       class="w-full px-2 py-1.5 border border-gray-300 rounded text-xs focus:outline-none focus:ring-1 focus:ring-green-500 focus:border-transparent">
            </div>
            <div class="flex items-end space-x-1">
                <select name="status" class="px-2 py-1.5 border border-gray-300 rounded text-xs focus:outline-none focus:ring-1 focus:ring-green-500">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                    <option value="in_use" {{ request('status') == 'in_use' ? 'selected' : '' }}>Sedang Digunakan</option>
                    <option value="returned" {{ request('status') == 'returned' ? 'selected' : '' }}>Dikembalikan</option>
                </select>
                <button type="submit" class="px-3 py-1.5 bg-green-600 hover:bg-green-700 text-white text-xs font-medium rounded transition-colors duration-200">
                    Cari
                </button>
                <a href="{{ route('operator.borrowings.index') }}" class="px-3 py-1.5 bg-gray-300 hover:bg-gray-400 text-gray-700 text-xs font-medium rounded transition-colors duration-200">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Table Section -->
    <div class="bg-white rounded-md shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto table-container">
            <table class="min-w-full divide-y divide-gray-200 table-mobile-card table-compact">
                <thead class="bg-gray-50 hidden sm:table-header-group">
                    <tr>
                        <th class="px-2 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-12">No</th>
                        <th class="px-2 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-40">Peminjam</th>
                        <th class="px-2 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-32">Kendaraan</th>
                        <th class="px-2 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-28 hidden lg:table-cell">Periode</th>
                        <th class="px-2 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-36 hidden xl:table-cell">Keperluan</th>
                        <th class="px-2 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24 hidden lg:table-cell">Lokasi</th>
                        <th class="px-2 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-20">Status</th>
                        <th class="px-2 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($borrowings as $borrowing)
                    <tr class="hover:bg-gray-50 transition-colors duration-200 borrowing-row">
                        <td class="px-2 py-2 whitespace-nowrap text-xs text-gray-900" data-label="No">
                            {{ ($borrowings->currentPage() - 1) * $borrowings->perPage() + $loop->iteration }}
                        </td>

                        <!-- Borrower Info -->
                        <td class="px-2 py-2 whitespace-nowrap" data-label="Peminjam">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-6 w-6">
                                    <div class="h-6 w-6 rounded-full {{ $borrowing->borrower_type == 'internal' ? 'bg-blue-100' : 'bg-orange-100' }} flex items-center justify-center">
                                        @if($borrowing->borrower_type == 'internal')
                                            <svg class="h-3 w-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                        @else
                                            <svg class="h-3 w-3 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                            </svg>
                                        @endif
                                    </div>
                                </div>
                                <div class="ml-2">
                                    <div class="text-xs font-medium text-gray-900 truncate max-w-32" title="{{ $borrowing->borrower_name }}">
                                        {{ Str::limit($borrowing->borrower_name, 20) }}
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        <span class="inline-flex items-center px-1 py-0.5 rounded-full {{ $borrowing->borrower_type == 'internal' ? 'bg-blue-100 text-blue-800' : 'bg-orange-100 text-orange-800' }}">
                                            {{ $borrowing->borrower_type == 'internal' ? 'Internal' : 'Eksternal' }}
                                        </span>
                                    </div>
                                    <!-- Mobile-only additional info -->
                                    <div class="sm:hidden mt-1 space-y-0.5">
                                        <div class="text-xs text-gray-600">
                                            📅 {{ $borrowing->start_date->format('d/m/y') }} - {{ $borrowing->end_date->format('d/m/y') }}
                                        </div>
                                        <div class="text-xs text-gray-600 truncate">
                                            🎯 {{ Str::limit($borrowing->purpose, 30) }}
                                        </div>
                                        <div class="text-xs text-gray-600">
                                            📍 {{ $borrowing->location_type == 'dalam_kota' ? 'Dalam Kota' : 'Luar Kota' }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>

                        <!-- Vehicle Info -->
                        <td class="px-2 py-2 whitespace-nowrap" data-label="Kendaraan">
                            <div class="text-xs font-medium text-gray-900">
                                {{ $borrowing->unit_count }} Unit
                            </div>
                            <div class="text-xs text-gray-500">
                                Kendaraan Dinas
                            </div>
                        </td>

                        <!-- Period -->
                        <td class="px-2 py-2 whitespace-nowrap text-xs text-gray-900 hidden lg:table-cell" data-label="Periode">
                            <div class="text-xs">{{ $borrowing->start_date->format('d/m/y') }}</div>
                            <div class="text-xs text-gray-600">s/d</div>
                            <div class="text-xs">{{ $borrowing->end_date->format('d/m/y') }}</div>
                            <div class="text-xs text-gray-500 mt-0.5">
                                ({{ $borrowing->start_date->diffInDays($borrowing->end_date) + 1 }} hari)
                            </div>
                        </td>

                        <!-- Purpose -->
                        <td class="px-2 py-2 text-xs text-gray-900 hidden xl:table-cell max-w-xs" data-label="Keperluan">
                            <div class="truncate" title="{{ $borrowing->purpose }}">
                                {{ Str::limit($borrowing->purpose, 40) }}
                            </div>
                        </td>

                        <!-- Location -->
                        <td class="px-2 py-2 whitespace-nowrap text-xs text-gray-900 hidden lg:table-cell" data-label="Lokasi">
                            <div class="text-xs font-medium">
                                {{ $borrowing->location_type == 'dalam_kota' ? 'Dalam Kota' : 'Luar Kota' }}
                            </div>
                        </td>

                        <!-- Status -->
                        <td class="px-2 py-2 whitespace-nowrap" data-label="Status">
                            @php
                                $statusLabels = [
                                    'pending' => 'Pending',
                                    'approved' => 'Disetujui',
                                    'rejected' => 'Ditolak',
                                    'in_use' => 'Digunakan',
                                    'returned' => 'Dikembalikan'
                                ];
                                $statusColors = [
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    'approved' => 'bg-green-100 text-green-800',
                                    'rejected' => 'bg-red-100 text-red-800',
                                    'in_use' => 'bg-blue-100 text-blue-800',
                                    'returned' => 'bg-gray-100 text-gray-800'
                                ];
                            @endphp
                            <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-xs font-medium badge-status {{ $statusColors[$borrowing->status] ?? 'bg-gray-100 text-gray-800' }}">
                                {{ $statusLabels[$borrowing->status] ?? $borrowing->status }}
                            </span>
                        </td>

                        <!-- Actions -->
                        <td class="px-2 py-2 whitespace-nowrap text-xs font-medium" data-label="Aksi">
                            <div class="flex flex-col sm:flex-row sm:items-center space-y-0.5 sm:space-y-0 sm:space-x-1 action-buttons">
                                <a href="{{ route('operator.borrowings.show', $borrowing) }}"
                                   class="text-blue-600 hover:text-blue-800 transition-colors duration-200 text-center sm:text-left btn-detail text-xs">Detail</a>

                                @if($borrowing->status == 'pending')
                                    <a href="{{ route('operator.borrowings.edit', $borrowing) }}"
                                       class="text-green-600 hover:text-green-800 transition-colors duration-200 text-center sm:text-left btn-edit edit-btn text-xs"
                                       data-borrowing-id="{{ $borrowing->id }}"
                                       data-borrowing-name="{{ $borrowing->borrower_name }}"
                                       data-borrowing-period="{{ $borrowing->start_date->format('d/m/Y') }} - {{ $borrowing->end_date->format('d/m/Y') }}">Edit</a>
                                @endif

                                <!-- Checkout Button -->
                                @if($borrowing->status == 'approved' && !$borrowing->checked_out_at)
                                    <button type="button"
                                            onclick="checkoutVehicle({{ $borrowing->id }})"
                                            class="text-purple-600 hover:text-purple-800 transition-colors duration-200 text-xs">
                                        Checkout
                                    </button>
                                @endif

                                <!-- Checkin Button -->
                                @if($borrowing->status == 'in_use' && $borrowing->checked_out_at && !$borrowing->checked_in_at)
                                    <button type="button"
                                            onclick="checkinVehicle({{ $borrowing->id }})"
                                            class="text-orange-600 hover:text-orange-800 transition-colors duration-200 text-xs">
                                        Checkin
                                    </button>
                                @endif

                                @if(in_array($borrowing->status, ['pending', 'rejected']))
                                    <button type="button"
                                            class="text-red-600 hover:text-red-800 transition-colors duration-200 btn-delete delete-btn text-xs"
                                            data-borrowing-id="{{ $borrowing->id }}"
                                            data-borrowing-name="{{ $borrowing->borrower_name }}"
                                            data-borrowing-period="{{ $borrowing->start_date->format('d/m/Y') }} - {{ $borrowing->end_date->format('d/m/Y') }}"
                                            data-delete-url="{{ route('operator.borrowings.destroy', $borrowing) }}">
                                        Hapus
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-8 text-center">
                            <div class="flex flex-col items-center">
                                <svg class="w-8 h-8 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <p class="text-gray-500 text-sm font-medium">Tidak ada data peminjaman</p>
                                <p class="text-gray-400 text-xs mt-0.5">Belum ada pengajuan peminjaman kendaraan yang tercatat</p>
                                <a href="{{ route('operator.borrowings.create') }}"
                                   class="mt-2 inline-flex items-center px-3 py-1.5 bg-green-600 hover:bg-green-700 text-white text-xs font-medium rounded transition-colors duration-200 create-btn"
                                   data-action="create">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Ajukan Peminjaman
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($borrowings->hasPages())
        <div class="px-3 py-2 border-t border-gray-200">
            {{ $borrowings->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
            </div>
            <h3 class="text-lg leading-6 font-medium text-gray-900 mt-4">Konfirmasi Hapus Data</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500 mb-3">Apakah Anda yakin ingin menghapus pengajuan peminjaman berikut?</p>
                <div class="bg-gray-50 p-3 rounded-md text-left">
                    <div class="text-sm">
                        <div class="font-medium text-gray-900" id="deleteBorrowingName"></div>
                        <div class="text-gray-600 mt-1" id="deleteBorrowingDetails"></div>
                    </div>
                </div>
                <p class="text-xs text-red-600 mt-3 font-medium">⚠️ Tindakan ini tidak dapat dibatalkan!</p>
            </div>
            <div class="items-center px-4 py-3 space-x-3 flex justify-center">
                <button id="cancelDelete" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 text-base font-medium rounded-md w-auto shadow-sm transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-gray-300">
                    Batal
                </button>
                <button id="confirmDelete" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-base font-medium rounded-md w-auto shadow-sm transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-red-300">
                    Ya, Hapus
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Success Modal -->
<div id="successModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100">
                <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h3 class="text-lg leading-6 font-medium text-gray-900 mt-4">Berhasil</h3>
            <div class="mt-2 px-7 py-3">
                <p id="successMessage" class="text-sm text-gray-500"></p>
            </div>
            <div class="items-center px-4 py-3">
                <button id="closeSuccess" class="px-4 py-2 bg-green-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-300">
                    OK
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Error Modal -->
<div id="errorModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </div>
            <h3 class="text-lg leading-6 font-medium text-gray-900 mt-4">Error</h3>
            <div class="mt-2 px-7 py-3">
                <p id="errorMessage" class="text-sm text-gray-500"></p>
            </div>
            <div class="items-center px-4 py-3">
                <button id="closeError" class="px-4 py-2 bg-red-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-300">
                    OK
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Loading Modal -->
<div id="loadingModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-blue-100">
                <svg class="animate-spin h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>
            <h3 class="text-lg leading-6 font-medium text-gray-900 mt-4">Memproses</h3>
            <div class="mt-2 px-7 py-3">
                <p id="loadingMessage" class="text-sm text-gray-500">Mohon tunggu...</p>
            </div>
        </div>
    </div>
</div>

@if(session('success'))
<div id="success-alert" class="fixed top-4 right-4 z-50 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-md shadow-lg">
    <div class="flex items-center">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
        </svg>
        {{ session('success') }}
        <button onclick="document.getElementById('success-alert').remove()" class="ml-4 text-green-600 hover:text-green-800">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>
</div>
<script>
    setTimeout(() => {
        const alert = document.getElementById('success-alert');
        if (alert) alert.remove();
    }, 5000);
</script>
@endif

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle delete buttons
    const deleteButtons = document.querySelectorAll('.delete-btn');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const borrowingId = this.dataset.borrowingId;
            const borrowingName = this.dataset.borrowingName;
            const borrowingPeriod = this.dataset.borrowingPeriod;
            const deleteUrl = this.dataset.deleteUrl;

            showDeleteConfirm(borrowingId, borrowingName, borrowingPeriod, deleteUrl);
        });
    });
});

// Modal Manager Functions
function showDeleteConfirm(borrowingId, borrowingName, borrowingPeriod, deleteUrl) {
    const modal = document.getElementById('deleteModal');
    const borrowingNameEl = document.getElementById('deleteBorrowingName');
    const borrowingDetailsEl = document.getElementById('deleteBorrowingDetails');
    const confirmBtn = document.getElementById('confirmDelete');
    const cancelBtn = document.getElementById('cancelDelete');

    if (borrowingNameEl) {
        borrowingNameEl.textContent = borrowingName;
    }

    if (borrowingDetailsEl) {
        borrowingDetailsEl.innerHTML = `
            <div class="space-y-1">
                <div><span class="font-medium">Periode:</span> ${borrowingPeriod}</div>
            </div>
        `;
    }

    // Remove previous event listeners
    const newConfirmBtn = confirmBtn.cloneNode(true);
    confirmBtn.parentNode.replaceChild(newConfirmBtn, confirmBtn);

    // Add new event listeners
    newConfirmBtn.addEventListener('click', () => {
        hideModal('deleteModal');
        performDelete(deleteUrl);
    });

    cancelBtn.addEventListener('click', () => {
        hideModal('deleteModal');
    });

    showModal('deleteModal');
}

function performDelete(deleteUrl) {
    showLoading('Menghapus data peminjaman...');

    fetch(deleteUrl, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        hideLoading();
        if (data.success) {
            showSuccess('Data peminjaman berhasil dihapus!');
            setTimeout(() => {
                location.reload();
            }, 1500);
        } else {
            showError(data.message || 'Terjadi kesalahan saat menghapus data');
        }
    })
    .catch(error => {
        hideLoading();
        showError('Terjadi kesalahan koneksi. Silakan coba lagi.');
        console.error('Error:', error);
    });
}

function showSuccess(message) {
    const messageEl = document.getElementById('successMessage');
    if (messageEl) messageEl.textContent = message;
    showModal('successModal');
}

function showError(message) {
    const messageEl = document.getElementById('errorMessage');
    if (messageEl) messageEl.textContent = message;
    showModal('errorModal');
}

function showLoading(message = 'Memproses...') {
    const messageEl = document.getElementById('loadingMessage');
    if (messageEl) messageEl.textContent = message;
    showModal('loadingModal');
}

function hideLoading() {
    hideModal('loadingModal');
}

function showModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
}

function hideModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
}

// Close modal event listeners
document.addEventListener('DOMContentLoaded', function() {
    // Close buttons
    const closeButtons = ['cancelDelete', 'closeSuccess', 'closeError'];
    closeButtons.forEach(buttonId => {
        const button = document.getElementById(buttonId);
        if (button) {
            button.addEventListener('click', function() {
                const modal = this.closest('.fixed');
                if (modal) {
                    modal.classList.add('hidden');
                    document.body.style.overflow = 'auto';
                }
            });
        }
    });

    // Close on backdrop click
    const modals = ['deleteModal', 'successModal', 'errorModal', 'loadingModal'];
    modals.forEach(modalId => {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.addEventListener('click', function(e) {
                if (e.target === this) {
                    hideModal(modalId);
                }
            });
        }
    });

    // Close on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            modals.forEach(modalId => hideModal(modalId));
        }
    });
});
</script>

<!-- Modal Checkout Kendaraan -->
<div id="checkoutModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
            <div class="p-6">
                <div class="flex items-center justify-center w-12 h-12 mx-auto bg-purple-100 rounded-full mb-4">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 text-center mb-2">Checkout Kendaraan</h3>
                <p class="text-sm text-gray-500 text-center mb-4">Konfirmasi untuk checkout kendaraan yang sudah disetujui</p>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Catatan Checkout (Opsional)</label>
                    <textarea id="checkoutNotes"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-purple-500 focus:border-purple-500"
                              rows="3"
                              placeholder="Tambahkan catatan checkout (kondisi kendaraan, kelengkapan, dll.)..."></textarea>
                </div>

                <div class="flex space-x-3">
                    <button type="button" onclick="closeCheckoutModal()"
                            class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg">
                        Batal
                    </button>
                    <button type="button" onclick="confirmCheckout()"
                            class="flex-1 bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg">
                        Checkout Kendaraan
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Checkin Kendaraan -->
<div id="checkinModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
            <div class="p-6">
                <div class="flex items-center justify-center w-12 h-12 mx-auto bg-orange-100 rounded-full mb-4">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 text-center mb-2">Checkin Kendaraan</h3>
                <p class="text-sm text-gray-500 text-center mb-4">Konfirmasi bahwa kendaraan telah dikembalikan</p>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Catatan Checkin (Opsional)</label>
                    <textarea id="checkinNotes"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-orange-500 focus:border-orange-500"
                              rows="3"
                              placeholder="Tambahkan catatan checkin (kondisi kendaraan saat kembali, kerusakan, dll.)..."></textarea>
                </div>

                <div class="flex space-x-3">
                    <button type="button" onclick="closeCheckinModal()"
                            class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg">
                        Batal
                    </button>
                    <button type="button" onclick="confirmCheckin()"
                            class="flex-1 bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded-lg">
                        Checkin Kendaraan
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Borrowing row styling */
.borrowing-row {
    transition: all 0.3s ease;
}

.borrowing-row:hover {
    background-color: #f9fafb;
    transform: translateY(-1px);
    box-shadow: 0 2px 4px -1px rgba(0, 0, 0, 0.1);
}

/* Badge styling */
.badge-status {
    font-size: 0.6875rem;
    padding: 0.125rem 0.375rem;
    transition: all 0.2s ease-in-out;
}

.badge-status:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

/* Table compact styles */
.table-compact {
    font-size: 0.75rem;
    line-height: 1;
}

.table-compact th,
.table-compact td {
    padding: 0.375rem 0.5rem;
    vertical-align: middle;
}

.table-compact th {
    font-weight: 600;
    font-size: 0.7rem;
    text-transform: uppercase;
    letter-spacing: 0.025em;
}

/* Desktop table layout optimization */
@media (min-width: 1024px) {
    .table-compact {
        table-layout: fixed;
        width: 100%;
    }
}

/* Mobile responsive styles */
@media (max-width: 640px) {
    .table-mobile-card {
        display: block !important;
        border: none !important;
    }

    .table-mobile-card tbody {
        display: block !important;
    }

    .table-mobile-card tr {
        display: block !important;
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        margin-bottom: 16px;
        padding: 16px;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
    }

    .table-mobile-card td {
        display: block !important;
        text-align: left !important;
        border: none !important;
        padding: 4px 0 !important;
    }

    .table-mobile-card td:before {
        content: attr(data-label) ": ";
        font-weight: 600;
        color: #374151;
        display: inline-block;
        width: 120px;
        flex-shrink: 0;
    }

    .action-buttons {
        display: flex;
        flex-direction: column;
        gap: 8px;
        margin-top: 12px;
    }

    .action-buttons a,
    .action-buttons button {
        text-align: center;
        padding: 8px 16px;
        border-radius: 6px;
        font-weight: 500;
        transition: all 0.2s;
    }

    .action-buttons .btn-detail {
        background-color: #dbeafe;
        color: #1d4ed8;
    }

    .action-buttons .btn-edit {
        background-color: #dcfce7;
        color: #166534;
    }

    .action-buttons .btn-delete {
        background-color: #fee2e2;
        color: #dc2626;
        border: none;
    }
}

/* Better scrollbar */
.table-container::-webkit-scrollbar {
    height: 8px;
}

.table-container::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 4px;
}

.table-container::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 4px;
}

.table-container::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}
</style>

<script>
// Checkout Vehicle Function
function checkoutVehicle(borrowingId) {
    const notes = prompt('Catatan checkout (opsional):');

    if (notes !== null) { // User didn't cancel
        fetch(`/operator/borrowings/${borrowingId}/checkout`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                notes: notes
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                window.location.reload();
            } else {
                alert(data.message || 'Terjadi kesalahan!');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat memproses permintaan!');
        });
    }
}

// Checkin Vehicle Function
function checkinVehicle(borrowingId) {
    const notes = prompt('Catatan checkin/kondisi kendaraan (opsional):');

    if (notes !== null) { // User didn't cancel
        fetch(`/operator/borrowings/${borrowingId}/checkin`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                notes: notes
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                window.location.reload();
            } else {
                alert(data.message || 'Terjadi kesalahan!');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat memproses permintaan!');
        });
    }
}

// Variables untuk checkout/checkin
let currentBorrowingId = null;

// Function untuk membuka modal checkout
function checkoutVehicle(borrowingId) {
    currentBorrowingId = borrowingId;
    document.getElementById('checkoutNotes').value = '';
    document.getElementById('checkoutModal').classList.remove('hidden');
}

// Function untuk menutup modal checkout
function closeCheckoutModal() {
    document.getElementById('checkoutModal').classList.add('hidden');
    currentBorrowingId = null;
}

// Function untuk konfirmasi checkout
function confirmCheckout() {
    if (!currentBorrowingId) return;

    const notes = document.getElementById('checkoutNotes').value;

    // Loading state
    const checkoutBtn = document.querySelector('#checkoutModal button[onclick="confirmCheckout()"]');
    const originalText = checkoutBtn.innerHTML;
    checkoutBtn.innerHTML = '<svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Memproses...';
    checkoutBtn.disabled = true;

    fetch(`/operator/borrowings/${currentBorrowingId}/checkout`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            notes: notes
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Success feedback
            checkoutBtn.innerHTML = '<svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Berhasil!';
            checkoutBtn.classList.remove('bg-purple-600', 'hover:bg-purple-700');
            checkoutBtn.classList.add('bg-purple-500');

            setTimeout(() => {
                closeCheckoutModal();
                window.location.reload();
            }, 1500);
        } else {
            throw new Error(data.message || 'Terjadi kesalahan!');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        checkoutBtn.innerHTML = originalText;
        checkoutBtn.disabled = false;
        alert('Terjadi kesalahan saat checkout kendaraan!');
    });
}

// Function untuk membuka modal checkin
function checkinVehicle(borrowingId) {
    currentBorrowingId = borrowingId;
    document.getElementById('checkinNotes').value = '';
    document.getElementById('checkinModal').classList.remove('hidden');
}

// Function untuk menutup modal checkin
function closeCheckinModal() {
    document.getElementById('checkinModal').classList.add('hidden');
    currentBorrowingId = null;
}

// Function untuk konfirmasi checkin
function confirmCheckin() {
    if (!currentBorrowingId) return;

    const notes = document.getElementById('checkinNotes').value;

    // Loading state
    const checkinBtn = document.querySelector('#checkinModal button[onclick="confirmCheckin()"]');
    const originalText = checkinBtn.innerHTML;
    checkinBtn.innerHTML = '<svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Memproses...';
    checkinBtn.disabled = true;

    fetch(`/operator/borrowings/${currentBorrowingId}/checkin`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            notes: notes
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Success feedback
            checkinBtn.innerHTML = '<svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Berhasil!';
            checkinBtn.classList.remove('bg-orange-600', 'hover:bg-orange-700');
            checkinBtn.classList.add('bg-orange-500');

            setTimeout(() => {
                closeCheckinModal();
                window.location.reload();
            }, 1500);
        } else {
            throw new Error(data.message || 'Terjadi kesalahan!');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        checkinBtn.innerHTML = originalText;
        checkinBtn.disabled = false;
        alert('Terjadi kesalahan saat checkin kendaraan!');
    });
}

// Event listener untuk menutup modal ketika klik di luar modal
document.addEventListener('click', function(event) {
    const checkoutModal = document.getElementById('checkoutModal');
    const checkinModal = document.getElementById('checkinModal');

    if (event.target === checkoutModal) {
        closeCheckoutModal();
    }

    if (event.target === checkinModal) {
        closeCheckinModal();
    }
});

// Event listener untuk ESC key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeCheckoutModal();
        closeCheckinModal();
    }
});
</script>
@endsection
