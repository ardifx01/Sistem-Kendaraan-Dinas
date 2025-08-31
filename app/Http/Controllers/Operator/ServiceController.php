<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Base query untuk service records (exclude soft-deleted for index)
        $query = Service::with(['vehicle', 'user'])
            ->orderBy('created_at', 'desc');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('service_type', 'like', "%{$search}%")
                  ->orWhere('damage_description', 'like', "%{$search}%")
                  ->orWhere('repair_description', 'like', "%{$search}%")
                  ->orWhere('garage_name', 'like', "%{$search}%")
                  ->orWhereHas('vehicle', function($vehicleQuery) use ($search) {
                      $vehicleQuery->where('license_plate', 'like', "%{$search}%")
                                   ->orWhere('brand', 'like', "%{$search}%")
                                   ->orWhere('model', 'like', "%{$search}%");
                  });
            });
        }

        $services = $query->paginate(10)->withQueryString();

        // Total service records (exclude soft-deleted on index)
    $totalServices = Service::count();

        return view('operator.services.index', compact('services', 'totalServices'));
    }

    /**
     * Display service history for operators with a simple navbar filter.
     */
    public function history(Request $request)
    {
    $query = Service::withTrashed()->with(['vehicle', 'user'])->orderBy('service_date', 'desc');

        // optional filter by service_type
        if ($request->filled('type')) {
            $query->where('service_type', $request->type);
        }

        $services = $query->paginate(12)->withQueryString();

        // counts for navbar
        $counts = [
            'all' => Service::withTrashed()->count(),
            'service_rutin' => Service::withTrashed()->where('service_type', 'service_rutin')->count(),
            'kerusakan' => Service::withTrashed()->where('service_type', 'kerusakan')->count(),
            'perbaikan' => Service::withTrashed()->where('service_type', 'perbaikan')->count(),
            'penggantian_part' => Service::withTrashed()->where('service_type', 'penggantian_part')->count(),
        ];

        return view('operator.services.history', compact('services', 'counts'));
    }

    /**
     * Export the filtered service history as PDF.
     */
    public function exportHistoryPdf(Request $request)
    {
    $query = Service::withTrashed()->with(['vehicle', 'user'])->orderBy('service_date', 'desc');

        // optional filter by service_type
        if ($request->filled('type')) {
            $query->where('service_type', $request->type);
        }

        // optional search filter (same as index)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('service_type', 'like', "%{$search}%")
                  ->orWhere('damage_description', 'like', "%{$search}%")
                  ->orWhere('repair_description', 'like', "%{$search}%")
                  ->orWhere('garage_name', 'like', "%{$search}%")
                  ->orWhereHas('vehicle', function($vehicleQuery) use ($search) {
                      $vehicleQuery->where('license_plate', 'like', "%{$search}%")
                                   ->orWhere('brand', 'like', "%{$search}%")
                                   ->orWhere('model', 'like', "%{$search}%");
                  });
            });
        }

        $services = $query->get();

        $datePart = now()->format('Ymd_His');
        $pdf = PDF::loadView('operator.services.pdf', compact('services'));

        return $pdf->setPaper('a4', 'portrait')->download("riwayat-servis_{$datePart}.pdf");
    }

    /**
     * Display vehicles by status with their service information.
     */
    public function vehiclesByStatus(Request $request, $status = null)
    {
        // Validate status
        $validStatuses = ['tersedia', 'dipinjam', 'service', 'tidak_tersedia'];
        if ($status && !in_array($status, $validStatuses)) {
            abort(404);
        }

        $query = Vehicle::with(['latestService', 'latestService.user']);

        // Filter by vehicle status if provided
        if ($status) {
            $query->where('availability_status', $status);
        }

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('license_plate', 'like', "%{$search}%")
                  ->orWhere('brand', 'like', "%{$search}%")
                  ->orWhere('model', 'like', "%{$search}%");
            });
        }

        $vehicles = $query->orderBy('updated_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        // Status counts for navigation
        $statusCounts = [
            'total' => Vehicle::count(),
            'tersedia' => Vehicle::where('availability_status', 'tersedia')->count(),
            'dipinjam' => Vehicle::where('availability_status', 'dipinjam')->count(),
            'service' => Vehicle::where('availability_status', 'service')->count(),
            'tidak_tersedia' => Vehicle::where('availability_status', 'tidak_tersedia')->count(),
        ];

        return view('operator.services.vehicles-by-status', compact('vehicles', 'statusCounts', 'status'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $vehicles = Vehicle::where('availability_status', '!=', 'tidak_tersedia')
            ->orderBy('brand')
            ->orderBy('model')
            ->get();

        return view('operator.services.create', compact('vehicles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'service_date' => 'required|date',
            'service_type' => 'required|string|in:service_rutin,kerusakan,perbaikan,penggantian_part',
            'payment_type' => 'required|in:asuransi,kantor',
            'damage_description' => 'nullable|string',
            'repair_description' => 'nullable|string',
            'parts_replaced' => 'nullable|string',
            'description' => 'nullable|string',
            'documents.*' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240', // 10MB
            'photos.*' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:10240', // 10MB
        ]);

        // Handle document uploads
        $documentPaths = [];
        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $document) {
                $path = $document->store('service-documents', 'public');
                $documentPaths[] = $path;
            }
        }

        // Handle photo uploads
        $photoPaths = [];
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('service-photos', 'public');
                $photoPaths[] = $path;
            }
        }

        $service = Service::create([
            'vehicle_id' => $request->vehicle_id,
            'user_id' => auth()->id(),
            'service_date' => $request->service_date,
            'service_type' => $request->service_type,
            'payment_type' => $request->payment_type,
            'damage_description' => $request->damage_description,
            'repair_description' => $request->repair_description,
            'parts_replaced' => $request->parts_replaced,
            'description' => $request->description,
            'documents' => $documentPaths,
            'photos' => $photoPaths,
        ]);

        // Update vehicle status to service automatically
        Vehicle::find($request->vehicle_id)->update([
            'availability_status' => 'service'
        ]);

        return redirect()->route('operator.services.index')
            ->with('success', 'Data service kendaraan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
        $service->load('vehicle');
        return view('operator.services.show', compact('service'));
    }

    /**
     * Download a PDF representation of the service record (operator).
     */
    public function download(Service $service)
    {
    $service->load(['vehicle', 'user']);

    // The shared PDF view expects a collection named $services (used for exporting history).
    // Wrap the single service in a collection so the same view can be reused.
    $services = collect([$service]);

    $pdf = PDF::loadView('operator.services.pdf', compact('services'));

    $datePart = $service->service_date ? \Carbon\Carbon::parse($service->service_date)->format('Ymd') : now()->format('Ymd_His');
    $filename = sprintf('service-%d-%s.pdf', $service->id, $datePart);

    return $pdf->download($filename);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service)
    {
        $vehicles = Vehicle::orderBy('brand')
            ->orderBy('model')
            ->get();

        return view('operator.services.edit', compact('service', 'vehicles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Service $service)
    {
        $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'service_date' => 'required|date',
            'service_type' => 'required|string|in:service_rutin,kerusakan,perbaikan,penggantian_part',
            'payment_type' => 'required|in:asuransi,kantor',
            'damage_description' => 'nullable|string',
            'repair_description' => 'nullable|string',
            'parts_replaced' => 'nullable|string',
            'description' => 'nullable|string',
            'documents.*' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240', // 10MB
            'photos.*' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:10240', // 10MB
            'remove_documents.*' => 'nullable|integer',
            'remove_photos.*' => 'nullable|integer',
        ]);

        // Handle document removal
        $documentPaths = $service->documents ?? [];
        if ($request->has('remove_documents')) {
            foreach ($request->remove_documents as $index) {
                if (isset($documentPaths[$index])) {
                    // Delete file from storage
                    \Storage::disk('public')->delete($documentPaths[$index]);
                    unset($documentPaths[$index]);
                }
            }
            $documentPaths = array_values($documentPaths); // Reindex array
        }

        // Handle photo removal
        $photoPaths = $service->photos ?? [];
        if ($request->has('remove_photos')) {
            foreach ($request->remove_photos as $index) {
                if (isset($photoPaths[$index])) {
                    // Delete file from storage
                    \Storage::disk('public')->delete($photoPaths[$index]);
                    unset($photoPaths[$index]);
                }
            }
            $photoPaths = array_values($photoPaths); // Reindex array
        }

        // Handle new document uploads
        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $document) {
                $path = $document->store('service-documents', 'public');
                $documentPaths[] = $path;
            }
        }

        // Handle new photo uploads
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('service-photos', 'public');
                $photoPaths[] = $path;
            }
        }

        $service->update([
            'vehicle_id' => $request->vehicle_id,
            'service_date' => $request->service_date,
            'service_type' => $request->service_type,
            'payment_type' => $request->payment_type,
            'damage_description' => $request->damage_description,
            'repair_description' => $request->repair_description,
            'parts_replaced' => $request->parts_replaced,
            'description' => $request->description,
            'documents' => $documentPaths,
            'photos' => $photoPaths,
        ]);

        // Update vehicle availability status to service automatically
        Vehicle::find($request->vehicle_id)->update([
            'availability_status' => 'service'
        ]);

        return redirect()->route('operator.services.index')
            ->with('success', 'Data service kendaraan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        // If service is in progress, make vehicle available again
        if ($service->status === 'in_progress') {
            Vehicle::find($service->vehicle_id)->update([
                'availability_status' => 'tersedia'
            ]);
        }

        $service->delete();

        return redirect()->route('operator.services.index')
            ->with('success', 'Data service kendaraan berhasil dihapus.');
    }
}