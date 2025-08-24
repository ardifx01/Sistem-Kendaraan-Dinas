@extends('layouts.app')

@section('title', 'Pengembalian Menunggu Konfirmasi')

@push('styles')
<style>
    /* Card Container Responsive */
    .cards-container {
        display: flex;
        overflow-x: auto;
        scroll-behavior: smooth;
        gap: 1rem;
        padding: 1rem 0;
        -webkit-overflow-scrolling: touch;
    }

    .cards-container::-webkit-scrollbar {
        height: 6px;
    }

    .cards-container::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 3px;
    }

    .cards-container::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 3px;
    }

    .cards-container::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }

    /* Card Styling */
    .borrowing-card {
        flex: 0 0 auto;
        width: 320px;
        min-height: 200px;
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        border: 1px solid #e2e8f0;
        transition: all 0.3s ease;
    }

    .borrowing-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px -5px rgba(0, 0, 0, 0.1);
    }

    /* Responsive breakpoints */
    @media (min-width: 640px) {
        .borrowing-card {
            width: 350px;
        }
    }

    @media (min-width: 768px) {
        .cards-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 1.5rem;
            overflow-x: visible;
        }

        .borrowing-card {
            width: 100%;
        }
    }

    @media (min-width: 1024px) {
        .cards-container {
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
        }
    }

    /* Status Badge */
    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 0.25rem 0.75rem;
        font-size: 0.75rem;
        font-weight: 500;
        border-radius: 9999px;
    }

    .status-waiting {
        background-color: #fef3c7;
        color: #92400e;
    }

    /* Action buttons */
    .action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
        font-weight: 500;
        border-radius: 8px;
        transition: all 0.2s;
        text-decoration: none;
        border: none;
        cursor: pointer;
    }

    .btn-primary {
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        color: white;
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
        transform: translateY(-1px);
    }

    .btn-success {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
    }

    .btn-success:hover {
        background: linear-gradient(135deg, #059669, #047857);
        transform: translateY(-1px);
    }
</style>
@endpush

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <!-- Header Section -->
        <div class="mb-6">
            <div class="flex flex-col space-y-4 sm:flex-row sm:items-center sm:justify-between sm:space-y-0">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Pengembalian Menunggu Konfirmasi</h1>
                    <p class="text-gray-600 mt-1 text-sm sm:text-base">Kendaraan yang sudah dikembalikan menunggu konfirmasi admin</p>
                </div>
                <a href="{{ route('admin.borrowings.index') }}"
                   class="action-btn btn-primary w-full sm:w-auto text-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali ke Daftar Peminjaman
                </a>
            </div>
        </div>

        @if($borrowings->count() > 0)
            <!-- Mobile scroll hint -->
            <div class="md:hidden mb-4">
                <p class="text-sm text-gray-500 flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path>
                    </svg>
                    Geser ke kanan untuk melihat lebih banyak
                </p>
            </div>

            <!-- Cards Container -->
            <div class="cards-container">
            <!-- Cards Container -->
            <div class="cards-container">
                @foreach($borrowings as $borrowing)
                    <div class="borrowing-card">
                        <!-- Card Header -->
                        <div class="p-4 border-b border-gray-100">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <h3 class="text-lg font-semibold text-gray-900">{{ $borrowing->borrower_name }}</h3>
                                    <p class="text-sm text-gray-500 capitalize">{{ $borrowing->borrower_type }}</p>
                                </div>
                                <span class="status-badge status-waiting">
                                    Menunggu Konfirmasi
                                </span>
                            </div>
                        </div>

                        <!-- Card Content -->
                        <div class="p-4 space-y-3">
                            <!-- Vehicle Info -->
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0">
                                    <svg class="w-5 h-5 text-blue-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2v0a2 2 0 01-2-2v-4a2 2 0 00-2-2H8z"></path>
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900">
                                        @if($borrowing->vehicle)
                                            {{ $borrowing->vehicle->license_plate }}
                                        @else
                                            {{ $borrowing->unit_count }} Unit
                                        @endif
                                    </p>
                                    <p class="text-sm text-gray-500 truncate">
                                        @if($borrowing->vehicle)
                                            {{ $borrowing->vehicle->brand }} {{ $borrowing->vehicle->model }}
                                        @else
                                            Multiple vehicles
                                        @endif
                                    </p>
                                </div>
                            </div>

                            <!-- Return Date -->
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0">
                                    <svg class="w-5 h-5 text-green-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-900">Dikembalikan Pada</p>
                                    <p class="text-sm text-gray-500">{{ $borrowing->checked_in_at->format('d/m/Y H:i') }}</p>
                                </div>
                            </div>

                            <!-- Returned By -->
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0">
                                    <svg class="w-5 h-5 text-purple-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-900">Dikembalikan Oleh</p>
                                    <p class="text-sm text-gray-500">{{ $borrowing->checkedInBy->name ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Card Actions -->
                        <div class="p-4 bg-gray-50 border-t border-gray-100 space-y-2">
                            <a href="{{ route('admin.borrowings.show', $borrowing) }}"
                               class="action-btn btn-primary w-full text-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                Lihat Detail
                            </a>
                            <button type="button"
                                    onclick="approveReturn({{ $borrowing->id }})"
                                    class="action-btn btn-success w-full">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Konfirmasi Pengembalian
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $borrowings->links() }}
            </div>
        @else
            <div class="bg-white rounded-xl shadow-sm p-8 text-center">
                <div class="max-w-md mx-auto">
                    <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada pengembalian menunggu konfirmasi</h3>
                    <p class="text-gray-500 mb-6">Semua kendaraan yang dikembalikan sudah dikonfirmasi.</p>
                    <a href="{{ route('admin.borrowings.index') }}"
                       class="action-btn btn-primary">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali ke Daftar Peminjaman
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
function approveReturn(borrowingId) {
    // Enhanced confirmation with better styling
    const modal = document.createElement('div');
    modal.className = 'fixed inset-0 z-50 overflow-y-auto';
    modal.style.backgroundColor = 'rgba(0, 0, 0, 0.5)';

    modal.innerHTML = `
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="bg-white rounded-xl shadow-xl max-w-md w-full p-6">
                <div class="flex items-center justify-center w-12 h-12 mx-auto bg-green-100 rounded-full mb-4">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-center text-gray-900 mb-2">Konfirmasi Pengembalian</h3>
                <p class="text-center text-gray-600 mb-6">Apakah Anda yakin ingin mengkonfirmasi pengembalian kendaraan ini?</p>
                <div class="flex space-x-3">
                    <button onclick="this.closest('.fixed').remove()"
                            class="flex-1 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-lg transition-colors">
                        Batal
                    </button>
                    <button onclick="confirmApproveReturn(${borrowingId})"
                            class="flex-1 px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors">
                        Ya, Konfirmasi
                    </button>
                </div>
            </div>
        </div>
    `;

    document.body.appendChild(modal);
}

function confirmApproveReturn(borrowingId) {
    // Remove modal
    document.querySelector('.fixed').remove();

    // Show loading
    const loadingModal = document.createElement('div');
    loadingModal.className = 'fixed inset-0 z-50 flex items-center justify-center';
    loadingModal.style.backgroundColor = 'rgba(0, 0, 0, 0.5)';
    loadingModal.innerHTML = `
        <div class="bg-white rounded-xl p-6 text-center">
            <svg class="animate-spin h-8 w-8 text-blue-600 mx-auto mb-4" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <p class="text-gray-600">Memproses konfirmasi...</p>
        </div>
    `;
    document.body.appendChild(loadingModal);

    fetch(`/admin/borrowings/${borrowingId}/approve-return`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        loadingModal.remove();

        if (data.success) {
            // Success notification
            showNotification('Pengembalian berhasil dikonfirmasi!', 'success');
            setTimeout(() => {
                window.location.reload();
            }, 1500);
        } else {
            showNotification(data.message || 'Terjadi kesalahan!', 'error');
        }
    })
    .catch(error => {
        loadingModal.remove();
        console.error('Error:', error);
        showNotification('Terjadi kesalahan saat memproses permintaan!', 'error');
    });
}

function showNotification(message, type) {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 max-w-sm w-full transform transition-all duration-300 translate-x-full`;

    const bgColor = type === 'success' ? 'bg-green-500' : 'bg-red-500';
    const icon = type === 'success'
        ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>'
        : '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>';

    notification.innerHTML = `
        <div class="${bgColor} text-white px-4 py-3 rounded-lg shadow-lg flex items-center">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                ${icon}
            </svg>
            <span class="flex-1">${message}</span>
            <button onclick="this.closest('.fixed').remove()" class="ml-3 text-white hover:text-gray-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    `;

    document.body.appendChild(notification);

    // Animate in
    setTimeout(() => {
        notification.classList.remove('translate-x-full');
    }, 100);

    // Auto remove after 5 seconds
    setTimeout(() => {
        notification.classList.add('translate-x-full');
        setTimeout(() => {
            if (notification.parentNode) {
                notification.remove();
            }
        }, 300);
    }, 5000);
}

// Add touch scroll behavior for mobile
document.addEventListener('DOMContentLoaded', function() {
    const container = document.querySelector('.cards-container');
    if (container && window.innerWidth < 768) {
        let isDown = false;
        let startX;
        let scrollLeft;

        container.addEventListener('mousedown', (e) => {
            isDown = true;
            container.classList.add('active');
            startX = e.pageX - container.offsetLeft;
            scrollLeft = container.scrollLeft;
        });

        container.addEventListener('mouseleave', () => {
            isDown = false;
            container.classList.remove('active');
        });

        container.addEventListener('mouseup', () => {
            isDown = false;
            container.classList.remove('active');
        });

        container.addEventListener('mousemove', (e) => {
            if (!isDown) return;
            e.preventDefault();
            const x = e.pageX - container.offsetLeft;
            const walk = (x - startX) * 2;
            container.scrollLeft = scrollLeft - walk;
        });
    }
});
</script>
@endpush
@endsection
