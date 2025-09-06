<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Barryvdh\DomPDF\Facade\Pdf;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource for operator.
     */
    public function index(Request $request)
    {
        $query = Vehicle::query();

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

        $perPage = $request->get('per_page', 10);
        $perPage = in_array($perPage, [10, 25, 50, 100]) ? $perPage : 10;

        $vehicles = $query->orderBy('created_at', 'desc')->paginate($perPage);
        $vehicles->appends($request->query());

        return view('operator.vehicles.index', compact('vehicles'));
    }

    public function create()
    {
        return view('operator.vehicles.create');
    }

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
            'kedudukan' => 'nullable|in:BMN,Sewa,Lainnya',
            'kedudukan_detail' => 'required_if:kedudukan,BMN,Sewa,Lainnya|nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'availability_status' => 'required|in:tersedia,dipinjam,service,digunakan_pejabat',
            'bpkb_number' => 'required|string|max:100',
            'chassis_number' => 'required|string|max:100',
            'engine_number' => 'required|string|max:100',
            'cc_amount' => 'required|integer|min:50|max:10000',
        ]);

        $validated['status'] = 'tersedia';
        $validated['condition'] = 'baik';

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('vehicles', 'public');
        }

        Vehicle::create($validated);

        return redirect()->route('operator.vehicles.index')
            ->with('success', 'Data kendaraan berhasil ditambahkan.');
    }

    public function show(Vehicle $vehicle)
    {
        $vehicle->load(['services.user', 'borrowings.user']);
        return view('operator.vehicles.show', compact('vehicle'));
    }

    public function edit(Vehicle $vehicle)
    {
        return view('operator.vehicles.edit', compact('vehicle'));
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        $validated = $request->validate([
            'type' => 'required|in:motor,mobil',
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:1990|max:' . (date('Y') + 1),
            'license_plate' => [
                'required','string','max:20', Rule::unique('vehicles', 'license_plate')->ignore($vehicle->id)
            ],
            'color' => 'required|string|max:50',
            'tax_expiry_date' => 'required|date',
            'document_status' => 'required|in:lengkap,tidak_lengkap',
            'document_notes' => 'required_if:document_status,tidak_lengkap|nullable|string',
            'driver_name' => 'nullable|string|max:255',
            'user_name' => 'nullable|string|max:255',
            'kedudukan' => 'nullable|in:BMN,Sewa,Lainnya',
            'kedudukan_detail' => 'required_if:kedudukan,BMN,Sewa,Lainnya|nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'availability_status' => 'required|in:tersedia,dipinjam,service,digunakan_pejabat',
            'bpkb_number' => 'required|string|max:100',
            'chassis_number' => 'required|string|max:100',
            'engine_number' => 'required|string|max:100',
            'cc_amount' => 'required|integer|min:50|max:10000',
        ]);

        if ($request->hasFile('photo')) {
            if ($vehicle->photo) {
                Storage::disk('public')->delete($vehicle->photo);
            }
            $validated['photo'] = $request->file('photo')->store('vehicles', 'public');
        }

        // If kedudukan is empty, ensure kedudukan_detail is cleared so DB reflects change
        if (empty($validated['kedudukan'])) {
            $validated['kedudukan_detail'] = null;
        }

        $vehicle->update($validated);

        return redirect()->route('operator.vehicles.index')
            ->with('success', 'Data kendaraan berhasil diperbarui.');
    }

    public function destroy(Vehicle $vehicle)
    {
        if ($vehicle->photo) {
            Storage::disk('public')->delete($vehicle->photo);
        }

        $vehicle->delete();

        return redirect()->route('operator.vehicles.index')
            ->with('success', 'Kendaraan berhasil dihapus.');
    }

    // Optional: export methods (reuse admin views)
    public function exportPdf(Request $request)
    {
        $query = Vehicle::query();

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

    public function exportSinglePdf(Vehicle $vehicle)
    {
        $pdf = Pdf::loadView('admin.vehicles.pdf.single', compact('vehicle'));

        $filename = 'Kendaraan_' . $vehicle->license_plate . '_' . now()->format('Y-m-d_H-i-s') . '.pdf';

        return $pdf->download($filename);
    }
}
