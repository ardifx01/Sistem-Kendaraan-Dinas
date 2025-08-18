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
    public function index()
    {
        // Data untuk dashboard admin
        $data = [
            'total_vehicles' => Vehicle::count(),
            'available_vehicles' => Vehicle::where('availability_status', 'tersedia')->count(),
            'vehicles_in_service' => Vehicle::where('availability_status', 'service')->count(),
            'borrowed_vehicles' => Vehicle::where('availability_status', 'dipinjam')->count(),
            'total_operators' => User::where('role', 'operator')->count(),
            'active_operators' => User::where('role', 'operator')->where('is_active', true)->count(),
            'pending_services' => Service::where('status', 'pending')->count(),
            'pending_borrowings' => Borrowing::where('status', 'pending')->count(),
            'vehicles_tax_expiring' => Vehicle::taxExpiringSoon()->count(),
        ];

        // Data kendaraan untuk tabel
        $vehicles = Vehicle::with(['latestService'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // Kendaraan dengan pajak akan habis
        $expiring_tax_vehicles = Vehicle::taxExpiringSoon()
            ->orderBy('tax_expiry_date', 'asc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('data', 'vehicles', 'expiring_tax_vehicles'));
    }
}
