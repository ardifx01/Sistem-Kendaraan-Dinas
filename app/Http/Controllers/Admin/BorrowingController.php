<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Borrowing;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class BorrowingController extends Controller
{
    /**
     * Display a listing of borrowings
     */
    public function index(Request $request)
    {
        $borrowings = Borrowing::with(['user', 'vehicle'])
            ->notReturned()
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.borrowings.index', compact('borrowings'));
    }

    /**
     * Display the specified borrowing
     */
    public function show(Borrowing $borrowing)
    {
        $borrowing->load(['user', 'vehicle']);
        return view('admin.borrowings.show', compact('borrowing'));
    }

    /**
     * Approve a borrowing request
     */
    public function approve(Request $request, Borrowing $borrowing): JsonResponse
    {
        try {
            // Validate that borrowing is still pending
            if ($borrowing->status !== 'pending') {
                return response()->json([
                    'success' => false,
                    'message' => 'Peminjaman ini sudah diproses sebelumnya.'
                ], 400);
            }

            // Update borrowing status
            $borrowing->update([
                'status' => 'approved',
                'notes' => 'Disetujui oleh admin: ' . auth()->user()->name
            ]);

            // Update vehicle status if single vehicle
            if ($borrowing->vehicle_id) {
                $borrowing->vehicle->update([
                    'availability_status' => 'dipinjam'
                ]);
            }

            // Update multiple vehicles status if vehicles_data exists
            if (is_array($borrowing->vehicles_data) && count($borrowing->vehicles_data) > 0) {
                foreach ($borrowing->vehicles_data as $vehicleData) {
                    if (isset($vehicleData['id'])) {
                        Vehicle::where('id', $vehicleData['id'])
                            ->update(['availability_status' => 'dipinjam']);
                    }
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Peminjaman berhasil disetujui!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Reject a borrowing request
     */
    public function reject(Request $request, Borrowing $borrowing): JsonResponse
    {
        try {
            // Validate that borrowing is still pending
            if ($borrowing->status !== 'pending') {
                return response()->json([
                    'success' => false,
                    'message' => 'Peminjaman ini sudah diproses sebelumnya.'
                ], 400);
            }

            $notes = $request->input('notes', '');
            $rejectNotes = 'Ditolak oleh admin: ' . auth()->user()->name;
            if ($notes) {
                $rejectNotes .= '. Alasan: ' . $notes;
            }

            // Update borrowing status
            $borrowing->update([
                'status' => 'rejected',
                'notes' => $rejectNotes
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Peminjaman berhasil ditolak!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Approve vehicle return and mark as returned
     */
    public function approveReturn(Request $request, Borrowing $borrowing): JsonResponse
    {
        try {
            // Validation: must be in_use and checked_in_at must exist
            if ($borrowing->status !== 'in_use' || !$borrowing->checked_in_at) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kendaraan belum dikembalikan atau status tidak valid.'
                ], 400);
            }

            \DB::beginTransaction();

            // Update borrowing status to returned
            $borrowing->update([
                'status' => 'returned',
                'returned_at' => now()
            ]);

            // Update vehicle status back to available if specific vehicle
            if ($borrowing->vehicle_id) {
                $borrowing->vehicle->update(['status' => 'available']);
            }

            // Update multiple vehicles if vehicles_data exists
            if ($borrowing->vehicles_data && is_array($borrowing->vehicles_data)) {
                foreach ($borrowing->vehicles_data as $vehicleData) {
                    if (isset($vehicleData['id'])) {
                        Vehicle::where('id', $vehicleData['id'])->update(['status' => 'available']);
                    }
                }
            }

            \DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Pengembalian kendaraan berhasil dikonfirmasi!'
            ]);

        } catch (\Exception $e) {
            \DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get borrowings awaiting return approval
     */
    public function awaitingReturn()
    {
        $borrowings = Borrowing::awaitingReturn()
            ->with(['user', 'vehicle', 'checkedOutBy', 'checkedInBy'])
            ->orderBy('checked_in_at', 'desc')
            ->paginate(15);

        return view('admin.borrowings.awaiting-return', compact('borrowings'));
    }

    /**
     * Display borrowing history (returned borrowings)
     */
    public function history(Request $request)
    {
        $query = Borrowing::with(['user', 'vehicle', 'checkedOutBy', 'checkedInBy'])
            ->where('status', 'returned')
            ->orderBy('returned_at', 'desc');

        // Filter by date range if provided
        if ($request->filled('start_date')) {
            $query->whereDate('returned_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('returned_at', '<=', $request->end_date);
        }

        // Filter by vehicle if provided
        if ($request->filled('vehicle_id')) {
            $query->where('vehicle_id', $request->vehicle_id);
        }

        // Filter by user if provided
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        $borrowings = $query->paginate(15);

        // Get vehicles and users for filter dropdowns
        $vehicles = \App\Models\Vehicle::orderBy('brand')->get();
        $users = \App\Models\User::where('role', 'operator')->orderBy('name')->get();

        return view('admin.borrowings.history', compact('borrowings', 'vehicles', 'users'));
    }

    /**
     * Export borrowing history to PDF
     */
    public function exportHistoryPdf(Request $request)
    {
        $query = Borrowing::with(['user', 'vehicle', 'checkedOutBy', 'checkedInBy'])
            ->where('status', 'returned')
            ->orderBy('returned_at', 'desc');

        // Apply same filters as history method
        if ($request->filled('start_date')) {
            $query->whereDate('returned_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('returned_at', '<=', $request->end_date);
        }

        if ($request->filled('vehicle_id')) {
            $query->where('vehicle_id', $request->vehicle_id);
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        $borrowings = $query->get();

        $pdf = Pdf::loadView('admin.borrowings.history-pdf', compact('borrowings', 'request'));

        $filename = 'Laporan_History_Peminjaman_' . now()->format('Y-m-d_H-i-s') . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Remove the specified borrowing from storage
     */
    public function destroy(Borrowing $borrowing)
    {
        try {
            // Delete associated files if they exist
            if ($borrowing->surat_permohonan && Storage::exists('public/' . $borrowing->surat_permohonan)) {
                Storage::delete('public/' . $borrowing->surat_permohonan);
            }

            if ($borrowing->surat_tugas && Storage::exists('public/' . $borrowing->surat_tugas)) {
                Storage::delete('public/' . $borrowing->surat_tugas);
            }

            // Delete the borrowing record
            $borrowing->delete();

            return redirect()->route('admin.borrowings.history')
                ->with('success', 'Data peminjaman berhasil dihapus.');

        } catch (\Exception $e) {
            return redirect()->route('admin.borrowings.history')
                ->with('error', 'Gagal menghapus data peminjaman: ' . $e->getMessage());
        }
    }
}
