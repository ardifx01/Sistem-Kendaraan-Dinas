<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Base query untuk service records
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

        // Total service records
        $totalServices = Service::count();

        return view('operator.services.index', compact('services', 'totalServices'));
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
            'user_id' => auth()->id(), // User yang sedang login
            'service_date' => $request->service_date,
            'service_type' => $request->service_type,
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
