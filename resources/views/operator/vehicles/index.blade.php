@extends('layouts.app')

@section('title', 'Data Kendaraan (Operator)')

@php
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
Carbon::setLocale('id');
@endphp

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="sm:flex sm:items-center sm:justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Data Kendaraan</h1>
            <p class="mt-2 text-sm text-gray-700">Kelola kendaraan (Operator)</p>
        </div>
        <div class="mt-4 sm:mt-0 flex space-x-2">
            <a href="{{ route('operator.vehicles.export.pdf', request()->query()) }}" class="btn bg-green-600 hover:bg-green-700 text-white">Export PDF</a>
            <a href="{{ route('operator.vehicles.create') }}" class="btn btn-primary">Tambah Kendaraan</a>
        </div>
    </div>

    <div class="card overflow-hidden">
        <div class="hidden lg:block">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-blue-500">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Kendaraan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Plat</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Pajak</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($vehicles as $vehicle)
                            <tr>
                                <td class="px-6 py-4">{{ $vehicle->brand }} {{ $vehicle->model }}</td>
                                <td class="px-6 py-4">{{ $vehicle->license_plate }}</td>
                                <td class="px-6 py-4">{{ ucfirst($vehicle->availability_status) }}</td>
                                <td class="px-6 py-4">{{ $vehicle->tax_expiry_date ? $vehicle->tax_expiry_date->translatedFormat('d F Y') : '-' }}</td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('operator.vehicles.show', $vehicle) }}" class="text-indigo-600">Detail</a>
                                    <a href="{{ route('operator.vehicles.edit', $vehicle) }}" class="ml-2 text-yellow-600">Edit</a>
                                    <button type="button" onclick="showDeleteModal({{ json_encode($vehicle->brand . ' ' . $vehicle->model . ' (' . $vehicle->license_plate . ')') }}, {{ json_encode(route('operator.vehicles.destroy', $vehicle)) }})" class="ml-2 text-red-600">Hapus</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center">Tidak ada data kendaraan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Mobile list: visible on small screens -->
        <div class="lg:hidden p-2">
            @forelse($vehicles as $vehicle)
                <div class="bg-white rounded-lg shadow-sm border mb-3 p-3 flex items-start justify-between">
                    <div class="min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">{{ $vehicle->brand }} {{ $vehicle->model }}</p>
                        <p class="text-xs text-gray-600">{{ $vehicle->license_plate }} • {{ ucfirst($vehicle->availability_status) }}</p>
                        <p class="text-xxs text-gray-500 mt-1">Pajak: {{ $vehicle->tax_expiry_date ? $vehicle->tax_expiry_date->translatedFormat('d F Y') : '-' }}</p>
                    </div>
                    <div class="flex-shrink-0 ml-3 text-right">
                        <a href="{{ route('operator.vehicles.show', $vehicle) }}" class="inline-block text-indigo-600 text-sm mb-1">Detail</a>
                        <a href="{{ route('operator.vehicles.edit', $vehicle) }}" class="inline-block text-yellow-600 text-sm mb-1">Edit</a>
                        <button type="button" onclick="showDeleteModal({{ json_encode($vehicle->brand . ' ' . $vehicle->model . ' (' . $vehicle->license_plate . ')') }}, {{ json_encode(route('operator.vehicles.destroy', $vehicle)) }})" class="text-red-600 text-sm">Hapus</button>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-lg shadow-sm border p-4 text-center text-gray-600">Tidak ada data kendaraan</div>
            @endforelse
        </div>

        <div class="p-4 bg-white">
            @if($vehicles->hasPages())
                <div class="flex items-center justify-between">
                    <div class="text-xs text-gray-600">Menampilkan {{ $vehicles->firstItem() }}–{{ $vehicles->lastItem() }} dari {{ $vehicles->total() }}</div>
                    <div>
                        {{ $vehicles->withQueryString()->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function showDeleteModal(name, url){
    const modal = document.getElementById('deleteModal');
    if(!modal) return alert('Modal tidak ditemukan');
    const nameEl = document.getElementById('deleteName');
    nameEl.textContent = name;
    modal.dataset.url = url;
    modal.classList.remove('hidden'); modal.classList.add('flex'); document.body.style.overflow='hidden';
}

function hideDeleteModal(){ const m = document.getElementById('deleteModal'); if(m){ m.classList.add('hidden'); m.classList.remove('flex'); document.body.style.overflow='auto'; }}

async function confirmDelete(){ const m = document.getElementById('deleteModal'); const url = m.dataset.url; if(!url) return hideDeleteModal();
    const tokenMeta = document.querySelector('meta[name="csrf-token"]');
    const token = tokenMeta ? tokenMeta.getAttribute('content') : null;
    try{
        const res = await fetch(url, { method: 'DELETE', headers: { 'X-CSRF-TOKEN': token, 'Accept': 'application/json' } });
        // try to parse json safely
        let result = {};
        try{ result = await res.json(); }catch(e){ /* non-json response */ }
        if(res.ok){ window.location.reload(); } else { alert(result.message || 'Gagal menghapus'); hideDeleteModal(); }
    }catch(e){ alert('Koneksi gagal'); hideDeleteModal(); }
}
</script>

<!-- Universal delete modal (desktop & mobile) -->
<div id="deleteModal" class="hidden fixed inset-0 z-50 bg-black bg-opacity-50 items-center justify-center p-4">
    <div class="bg-white rounded-lg w-full max-w-md p-4">
        <h3 class="text-lg font-semibold mb-2">Hapus Kendaraan</h3>
        <p class="text-sm text-gray-700 mb-4">Yakin ingin menghapus <strong id="deleteName"></strong>? Tindakan ini tidak dapat dibatalkan.</p>
        <div class="flex space-x-3">
            <button onclick="hideDeleteModal()" class="flex-1 px-4 py-2 bg-gray-300 rounded">Batal</button>
            <button onclick="confirmDelete()" class="flex-1 px-4 py-2 bg-red-600 text-white rounded">Hapus</button>
        </div>
    </div>
</div>

@endpush
