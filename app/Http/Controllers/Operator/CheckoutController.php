<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Borrowing;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    /**
     * Checkout vehicle for approved borrowing
     */
    public function checkout(Borrowing $borrowing)
    {
        try {
            // Validation
            if (!$borrowing->canCheckOut()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Peminjaman tidak dapat di-checkout.'
                ], 400);
            }

            DB::beginTransaction();

            // Update borrowing status
            $borrowing->update([
                'status' => 'in_use',
                'checked_out_at' => now(),
                'checked_out_by' => Auth::id(),
                'checkout_notes' => request('notes')
            ]);

            // Update vehicle status to not available if specific vehicle
            if ($borrowing->vehicle_id) {
                $borrowing->vehicle->update(['status' => 'in_use']);
            }

            // Update multiple vehicles if vehicles_data exists
            if ($borrowing->vehicles_data && is_array($borrowing->vehicles_data)) {
                foreach ($borrowing->vehicles_data as $vehicleData) {
                    if (isset($vehicleData['id'])) {
                        Vehicle::where('id', $vehicleData['id'])->update(['status' => 'in_use']);
                    }
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Kendaraan berhasil di-checkout!'
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Checkin vehicle (operator marks as returned)
     */
    public function checkin(Borrowing $borrowing)
    {
        try {
            // Validation
            if (!$borrowing->canCheckIn()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kendaraan tidak dapat di-checkin.'
                ], 400);
            }

            // Update borrowing with checkin data (but keep status as in_use until admin approval)
            $borrowing->update([
                'checked_in_at' => now(),
                'checked_in_by' => Auth::id(),
                'checkin_notes' => request('notes')
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Kendaraan telah dikembalikan. Menunggu konfirmasi admin.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
