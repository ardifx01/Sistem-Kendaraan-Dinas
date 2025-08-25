<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Barryvdh\DomPDF\Facade\Pdf;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Vehicle::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('license_plate', 'like', "%{$search}%")
                  ->orWhere('brand', 'like', "%{$search}%")
                  ->orWhere('model', 'like', "%{$search}%");
            });
        }

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter by availability
        if ($request->filled('availability')) {
            $query->where('availability_status', $request->availability);
        }

        // Get per_page parameter, default to 10
        $perPage = $request->get('per_page', 10);
        $perPage = in_array($perPage, [10, 25, 50, 100]) ? $perPage : 10;

        $vehicles = $query->orderBy('created_at', 'desc')->paginate($perPage);
        $vehicles->appends($request->query());

        return view('admin.vehicles.index', compact('vehicles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.vehicles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:motor,mobil',
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:1990|max:' . (date('Y') + 1),
            'license_plate' => 'required|string|max:20|unique:vehicles,license_plate',
            'color' => 'required|string|max:50',
            'tax_expiry_date' => 'required|date|after:today',
            'document_status' => 'required|in:lengkap,tidak_lengkap',
            'document_notes' => 'required_if:document_status,tidak_lengkap|nullable|string',
            'driver_name' => 'nullable|string|max:255',
            'user_name' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:5120', // 5MB
            'bpkb_number' => 'required|string|max:100',
            'chassis_number' => 'required|string|max:100',
            'engine_number' => 'required|string|max:100',
            'cc_amount' => 'required|integer|min:50|max:10000',
        ]);

        // Set default values for fields not in form
        $validated['status'] = 'tersedia'; // Default status
        $validated['condition'] = 'baik'; // Default condition
        $validated['availability_status'] = 'tersedia'; // Default availability

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('vehicles', 'public');
        }

        Vehicle::create($validated);

        return redirect()->route('admin.vehicles.index')
            ->with('success', 'Data kendaraan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Vehicle $vehicle)
    {
        $vehicle->load(['services.user', 'borrowings.user']);
        return view('admin.vehicles.show', compact('vehicle'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vehicle $vehicle)
    {
        return view('admin.vehicles.edit', compact('vehicle'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Vehicle $vehicle)
    {
        $validated = $request->validate([
            'type' => 'required|in:motor,mobil',
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:1990|max:' . (date('Y') + 1),
            'license_plate' => [
                'required',
                'string',
                'max:20',
                Rule::unique('vehicles', 'license_plate')->ignore($vehicle->id)
            ],
            'color' => 'required|string|max:50',
            'tax_expiry_date' => 'required|date',
            'document_status' => 'required|in:lengkap,tidak_lengkap',
            'document_notes' => 'required_if:document_status,tidak_lengkap|nullable|string',
            'driver_name' => 'nullable|string|max:255',
            'user_name' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:5120', // 5MB
            'availability_status' => 'required|in:tersedia,dipinjam,service,tidak_tersedia',
            'bpkb_number' => 'required|string|max:100',
            'chassis_number' => 'required|string|max:100',
            'engine_number' => 'required|string|max:100',
            'cc_amount' => 'required|integer|min:50|max:10000',
        ]);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo
            if ($vehicle->photo) {
                Storage::disk('public')->delete($vehicle->photo);
            }
            $validated['photo'] = $request->file('photo')->store('vehicles', 'public');
        }

        $vehicle->update($validated);

        return redirect()->route('admin.vehicles.index')
            ->with('success', 'Data kendaraan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vehicle $vehicle)
    {
        // Delete photo if exists
        if ($vehicle->photo) {
            Storage::disk('public')->delete($vehicle->photo);
        }

        $vehicle->delete();

        return redirect()->route('admin.vehicles.index')
            ->with('success', 'Kendaraan berhasil dihapus.');
    }

    /**
     * Export all vehicles to PDF
     */
    public function exportPdf(Request $request)
    {
        $query = Vehicle::query();

        // Apply same filters as index
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('license_plate', 'like', "%{$search}%")
                  ->orWhere('brand', 'like', "%{$search}%")
                  ->orWhere('model', 'like', "%{$search}%");
            });
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('availability')) {
            $query->where('availability_status', $request->availability);
        }

        $vehicles = $query->orderBy('created_at', 'desc')->get();

        $pdf = Pdf::loadView('admin.vehicles.pdf.all', compact('vehicles', 'request'));

        $filename = 'Data_Kendaraan_' . now()->format('Y-m-d_H-i-s') . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Export single vehicle to PDF
     */
    public function exportSinglePdf(Vehicle $vehicle)
    {
        $pdf = Pdf::loadView('admin.vehicles.pdf.single', compact('vehicle'));

        $filename = 'Kendaraan_' . $vehicle->license_plate . '_' . now()->format('Y-m-d_H-i-s') . '.pdf';

        return $pdf->download($filename);
    }
}