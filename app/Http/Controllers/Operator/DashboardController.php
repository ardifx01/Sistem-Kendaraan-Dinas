<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\Models\Service;
use App\Models\Borrowing;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Data untuk dashboard operator - fokus pada kendaraan yang sedang service
        $data = [
            'total_vehicles' => Vehicle::count(),
            'vehicles_in_service' => Vehicle::where('availability_status', 'service')->count(),
            'total_service_records' => Service::withTrashed()->whereHas('vehicle', function($q) {
                $q->where('availability_status', 'service');
            })->count(),
            'total_operators' => User::where('role', 'operator')->count(),
            'active_operators' => User::where('role', 'operator')->where('is_active', true)->count(),
            'vehicles_tax_expiring' => Vehicle::taxExpiringSoon()->count(),
        ];

        // Data kendaraan service berdasarkan status kendaraan
        $vehicles_by_status = [
            'tersedia' => Vehicle::where('availability_status', 'tersedia')->count(),
            'dipinjam' => Vehicle::where('availability_status', 'dipinjam')->count(),
            'service' => Vehicle::where('availability_status', 'service')->count(),
            'tidak_tersedia' => Vehicle::where('availability_status', 'tidak_tersedia')->count(),
        ];

        // Kendaraan yang sedang dalam service dengan detailnya
        $vehicles_in_service = Vehicle::with(['latestService', 'latestService.user'])
            ->where('availability_status', 'service')
            ->orderBy('updated_at', 'desc')
            ->limit(10)
            ->get();

        // Kendaraan berdasarkan status dengan service terbaru (menampilkan semua kendaraan tersedia)
        $vehicles_by_status_detailed = [
            'tersedia' => Vehicle::with('latestService')
                ->where('availability_status', 'tersedia')
                ->orderBy('license_plate', 'asc')
                ->get(),
            'service' => Vehicle::with('latestService')
                ->where('availability_status', 'service')
                ->orderBy('updated_at', 'desc')
                ->get(),
        ];

        // Service terbaru untuk kendaraan yang sedang service
        $recent_services = Service::withTrashed()->with(['vehicle', 'user'])
            ->whereHas('vehicle', function($q) {
                $q->where('availability_status', 'service');
            })
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Data kendaraan untuk tabel dengan pagination - fokus pada kendaraan yang sedang service
        $vehicles = Vehicle::with(['latestService'])
            ->where('availability_status', 'service')
            ->orderBy('updated_at', 'desc')
            ->paginate(10, ['*'], 'vehicles_page');

        // Kendaraan dengan pajak akan habis dalam 2 bulan ke depan
        $vehicles_tax_expiring = Vehicle::whereDate('tax_expiry_date', '<=', now()->addMonths(2))
            ->whereDate('tax_expiry_date', '>=', now())
            ->orderBy('tax_expiry_date', 'asc')
            ->get();

        // Pilih kendaraan yang belum diservis selama >= 90 hari (atau tanpa riwayat servis)
        $thresholdDate = now()->subDays(90)->startOfDay();

        $serviceDueQuery = Vehicle::where(function ($query) use ($thresholdDate) {
            $query->whereDoesntHave('services')
                  ->orWhereHas('services', function ($q) use ($thresholdDate) {
                      // groupBy + havingRaw to compare the MAX(service_date) per vehicle
                      $q->select('vehicle_id')
                        ->groupBy('vehicle_id')
                        ->havingRaw('MAX(service_date) <= ?', [$thresholdDate->toDateString()]);
                  });
        });

        // Return full collection so the view can show a scrollable list instead of paginated pages
        $serviced_last_90 = $serviceDueQuery
            ->with('latestService')
            ->select('vehicles.*')
            ->selectRaw('(SELECT MAX(service_date) FROM services WHERE services.vehicle_id = vehicles.id) as last_service_date')
            // place NULLs (no service) first, then oldest service_date -> newest
            ->orderByRaw('(last_service_date IS NOT NULL) asc, last_service_date asc')
            ->get();

        // Also provide a paginated set for the 'Kendaraan Butuh Service' card (used by operator view)
        $serviceDueBase = $serviceDueQuery
            ->with('latestService')
            ->select('vehicles.*')
            ->selectRaw('(SELECT MAX(service_date) FROM services WHERE services.vehicle_id = vehicles.id) as last_service_date')
            ->orderByRaw('(last_service_date IS NOT NULL) asc, last_service_date asc');

        // paginate for the small card (change per-page as desired)
        $service_due_vehicles = $serviceDueBase->paginate(5, ['*'], 'service_due_page');

        // update any dashboard counters if desired
        $data['vehicles_service_due'] = $serviceDueQuery->count();

        return view('operator.dashboard', compact(
            'data',
            'vehicles',
            'vehicles_tax_expiring',
            'vehicles_by_status',
            'vehicles_in_service',
            'vehicles_by_status_detailed',
            'recent_services',
            'serviced_last_90',
            'service_due_vehicles'
        ));
    }
}
