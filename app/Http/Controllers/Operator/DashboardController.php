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
    public function index(Request $request)
    {
        // Data untuk dashboard operator - fokus pada kendaraan yang sedang service
        $data = [
            'total_vehicles' => Vehicle::count(),
            'vehicles_in_service' => Vehicle::where('availability_status', 'service')->count(),
            'total_service_records' => Service::whereHas('vehicle', function($q) {
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
        $recent_services = Service::with(['vehicle', 'user'])
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

        // Kendaraan dengan pajak akan habis
        $expiring_tax_vehicles = Vehicle::taxExpiringSoon()
            ->orderBy('tax_expiry_date', 'asc')
            ->paginate(10, ['*'], 'tax_page');

        return view('operator.dashboard', compact(
            'data',
            'vehicles',
            'expiring_tax_vehicles',
            'vehicles_by_status',
            'vehicles_in_service',
            'vehicles_by_status_detailed',
            'recent_services'
        ));
    }
}