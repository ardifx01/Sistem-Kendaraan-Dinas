<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\Models\Service;
use App\Models\Borrowing;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Data untuk dashboard admin
        $data = [
            'total_vehicles' => Vehicle::count(),
            'available_vehicles' => Vehicle::where('availability_status', 'tersedia')->count(),
            'vehicles_in_service' => Vehicle::where('availability_status', 'service')->count(),
            'borrowed_vehicles' => Vehicle::where('availability_status', 'dipinjam')->count(),
            'total_operators' => User::where('role', 'operator')->count(),
            'active_operators' => User::where('role', 'operator')->where('is_active', true)->count(),
            'total_services' => Service::withTrashed()->count(),
            'pending_borrowings' => Borrowing::where('status', 'pending')->count(),
            'awaiting_return' => Borrowing::awaitingReturn()->count(),
            'vehicles_tax_expiring' => Vehicle::taxExpiringSoon()->count(),
            // vehicles not serviced in the last 90 days
            'vehicles_service_due' => 0,
        ];

        // Data kendaraan yang tersedia untuk tabel dengan pagination
        $vehicles = Vehicle::with(['latestService'])
            ->where('availability_status', 'tersedia')
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'vehicles_page');

        // Kendaraan dengan pajak akan habis
        $expiring_tax_vehicles = Vehicle::taxExpiringSoon()
            ->orderBy('tax_expiry_date', 'asc')
            ->paginate(10, ['*'], 'tax_page');

                                // Kendaraan yang belum diservis selama >= 90 hari
                                $thresholdDate = now()->subDays(90)->startOfDay();

                                // Include vehicles with NO service history, or whose latest service is older than threshold
                                $serviceDueQuery = Vehicle::where(function ($query) use ($thresholdDate) {
                                        $query->whereDoesntHave('services')
                                                    ->orWhereHas('services', function ($q) use ($thresholdDate) {
                                                            $q->select('vehicle_id')
                                                                ->groupBy('vehicle_id')
                                                                ->havingRaw('MAX(service_date) <= ?', [$thresholdDate->toDateString()]);
                                                    });
                                });

                                // Order vehicles by how long since last service (oldest first).
                                // Vehicles with no service history (NULL last_service_date) should appear first.
                                $service_due_vehicles = $serviceDueQuery
                                    ->with(['latestService'])
                                    ->select('vehicles.*')
                                    ->selectRaw('(SELECT MAX(service_date) FROM services WHERE services.vehicle_id = vehicles.id) as last_service_date')
                                    // place NULLs (no service) first, then oldest service_date -> newest
                                    ->orderByRaw('(last_service_date IS NOT NULL) asc, last_service_date asc')
                                    ->paginate(10, ['*'], 'service_due_page');

                                // Update count into $data
                                $data['vehicles_service_due'] = $serviceDueQuery->count();

        // Peminjaman yang menunggu persetujuan
        $pending_borrowings = Borrowing::with(['user', 'vehicle'])
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Pengembalian yang menunggu konfirmasi
        $awaiting_returns = Borrowing::awaitingReturn()
            ->with(['user', 'vehicle', 'checkedInBy'])
            ->orderBy('checked_in_at', 'desc')
            ->limit(5)
            ->get();

    return view('admin.dashboard', compact('data', 'vehicles', 'expiring_tax_vehicles', 'pending_borrowings', 'awaiting_returns', 'service_due_vehicles'));
    }
}
