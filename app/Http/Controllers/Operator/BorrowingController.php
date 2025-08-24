<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Borrowing;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class BorrowingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $borrowings = Borrowing::with(['vehicle', 'user'])
            ->notReturned()
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $totalBorrowings = Borrowing::notReturned()->count();
        $activeBorrowings = Borrowing::whereIn('status', ['approved', 'in_use'])->count();
        $pendingBorrowings = Borrowing::where('status', 'pending')->count();

        return view('operator.borrowings.index', compact(
            'borrowings',
            'totalBorrowings',
            'activeBorrowings',
            'pendingBorrowings'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Get all vehicle IDs that are currently borrowed (from both single and multiple vehicle bookings)
        $borrowedVehicleIds = collect();

        // Get vehicle IDs from single vehicle borrowings
        $singleVehicleBorrowings = Borrowing::whereIn('status', ['pending', 'approved', 'in_use'])
            ->whereNotNull('vehicle_id')
            ->pluck('vehicle_id');

        $borrowedVehicleIds = $borrowedVehicleIds->merge($singleVehicleBorrowings);

        // Get vehicle IDs from multiple vehicle borrowings (vehicles_data)
        $multipleVehicleBorrowings = Borrowing::whereIn('status', ['pending', 'approved', 'in_use'])
            ->whereNotNull('vehicles_data')
            ->get();

        foreach ($multipleVehicleBorrowings as $borrowing) {
            $vehiclesData = [];

            // Handle both array (from cast) and string JSON format
            if (is_array($borrowing->vehicles_data)) {
                $vehiclesData = $borrowing->vehicles_data;
            } elseif (is_string($borrowing->vehicles_data)) {
                $decoded = json_decode($borrowing->vehicles_data, true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                    $vehiclesData = $decoded;
                }
            }

            foreach ($vehiclesData as $vehicleData) {
                if (isset($vehicleData['vehicle_id'])) {
                    $borrowedVehicleIds->push((int)$vehicleData['vehicle_id']);
                }
            }
        }

        // Remove duplicates and get unique borrowed vehicle IDs
        $borrowedVehicleIds = $borrowedVehicleIds->unique()->values();

        // Only show vehicles with 'tersedia' status and not currently being borrowed
        $availableVehicles = Vehicle::where('availability_status', 'tersedia')
            ->whereNotIn('id', $borrowedVehicleIds->toArray())
            ->orderBy('brand')
            ->orderBy('model')
            ->get();

        return view('operator.borrowings.create', compact('availableVehicles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        \Log::info('=== BORROWING STORE METHOD STARTED ===');
        \Log::info('Request method: ' . $request->method());
        \Log::info('Request URL: ' . $request->url());
        \Log::info('User ID: ' . Auth::id());

        // Debug: Log all request data
        \Log::info('Borrowing store request data:', $request->all());

        // Determine validation rules based on unit count
        $unitCount = (int) $request->input('unit_count', 1);

        // Get validation rules and messages
        $rules = $this->getValidationRules($unitCount, false);
        $messages = $this->getValidationMessages(false);

        // Perform validation
        try {
            $validatedData = $request->validate($rules, $messages);
            \Log::info('Validation passed successfully');
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation failed:', $e->errors());
            throw $e;
        }

        // Debug: Log validated data
        \Log::info('Borrowing validated data:', $validatedData);

        // Prepare vehicle data
        $vehicleIds = [];
        $vehiclesData = [];

        if ($unitCount > 1) {
            foreach ($validatedData['vehicles'] as $index => $vehicleData) {
                $vehicleIds[] = $vehicleData['vehicle_id'];
                $vehicle = Vehicle::find($vehicleData['vehicle_id']);
                $vehiclesData[] = [
                    'vehicle_id' => $vehicleData['vehicle_id'],
                    'unit_number' => $index + 1,
                    'vehicle_info' => [
                        'brand' => $vehicle->brand,
                        'model' => $vehicle->model,
                        'license_plate' => $vehicle->license_plate,
                        'year' => $vehicle->year,
                        'fuel_type' => $vehicle->fuel_type,
                    ]
                ];
            }
            // Set primary vehicle_id to first vehicle for compatibility
            $validatedData['vehicle_id'] = $vehicleIds[0];
        } else {
            $vehicleIds = [$validatedData['vehicle_id']];
            $vehicle = Vehicle::find($validatedData['vehicle_id']);
            $vehiclesData = [[
                'vehicle_id' => $validatedData['vehicle_id'],
                'unit_number' => 1,
                'vehicle_info' => [
                    'brand' => $vehicle->brand,
                    'model' => $vehicle->model,
                    'license_plate' => $vehicle->license_plate,
                    'year' => $vehicle->year,
                    'fuel_type' => $vehicle->fuel_type,
                ]
            ]];
        }

        // Check if any vehicles are currently in use
        $unavailableVehicles = [];
        foreach ($vehicleIds as $vehicleId) {
            $vehicle = Vehicle::findOrFail($vehicleId);
            $hasActiveBorrowing = $vehicle->borrowings()
                ->whereIn('status', ['approved', 'in_use'])
                ->exists();

            if ($hasActiveBorrowing) {
                $unavailableVehicles[] = $vehicle->brand . ' ' . $vehicle->model . ' (' . $vehicle->license_plate . ')';
            }
        }

        if (!empty($unavailableVehicles)) {
            $errorMessage = 'Kendaraan berikut sedang digunakan: ' . implode(', ', $unavailableVehicles);
            if ($unitCount > 1) {
                return back()->withErrors(['vehicles' => $errorMessage])->withInput();
            } else {
                return back()->withErrors(['vehicle_id' => $errorMessage])->withInput();
            }
        }

        try {
            // Upload files
            $suratPermohonanPath = null;
            $suratTugasPath = null;

            if ($request->hasFile('surat_permohonan')) {
                $suratPermohonanPath = $request->file('surat_permohonan')->store('borrowings/surat_permohonan', 'public');
            }

            if ($request->hasFile('surat_tugas')) {
                $suratTugasPath = $request->file('surat_tugas')->store('borrowings/surat_tugas', 'public');
            }

            // Prepare destination data based on location type
            $destination = null;
            if ($validatedData['location_type'] === 'luar_kota') {
                $destination = json_encode([
                    'province' => $validatedData['province'],
                    'city' => $validatedData['city']
                ]);
            }

            // Create borrowing record
            $createData = [
                'vehicle_id' => $validatedData['vehicle_id'],
                'user_id' => Auth::id(),
                'borrower_type' => $validatedData['borrower_type'],
                'borrower_name' => $validatedData['borrower_name'],
                'borrower_contact' => $validatedData['borrower_contact'],
                'start_date' => $validatedData['start_date'],
                'end_date' => $validatedData['end_date'],
                'purpose' => $validatedData['purpose'],
                'location_type' => $validatedData['location_type'],
                'destination' => $destination,
                'unit_count' => $validatedData['unit_count'],
                'vehicles_data' => json_encode($vehiclesData), // Convert to JSON string
                'surat_permohonan' => $suratPermohonanPath,
                'surat_tugas' => $suratTugasPath,
                'status' => 'pending',
                'notes' => $validatedData['notes'] ?? null,
            ];

            // Debug: Log data before create
            \Log::info('Data before Borrowing::create:', $createData);

            $borrowing = Borrowing::create($createData);

            // Debug: Log created borrowing
            \Log::info('Created borrowing:', $borrowing->toArray());

            return redirect()->route('operator.borrowings.show', $borrowing)
                ->with('success', 'Pengajuan peminjaman kendaraan berhasil dibuat dan menunggu persetujuan.');

        } catch (\Exception $e) {
            // Log the error
            \Log::error('Error creating borrowing:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'validated_data' => $validatedData ?? null,
                'create_data' => $createData ?? null
            ]);

            // Clean up uploaded files if database insertion fails
            if ($suratPermohonanPath && Storage::disk('public')->exists($suratPermohonanPath)) {
                Storage::disk('public')->delete($suratPermohonanPath);
            }
            if ($suratTugasPath && Storage::disk('public')->exists($suratTugasPath)) {
                Storage::disk('public')->delete($suratTugasPath);
            }

            return back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Borrowing $borrowing)
    {
        $borrowing->load(['vehicle', 'user']);
        return view('operator.borrowings.show', compact('borrowing'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Borrowing $borrowing)
    {
        // Only allow editing if status is pending
        if ($borrowing->status !== 'pending') {
            return redirect()->route('operator.borrowings.show', $borrowing)
                ->with('error', 'Hanya pengajuan dengan status pending yang dapat diedit.');
        }

        // Get currently used vehicles by this borrowing
        $currentVehicleIds = [];
        if ($borrowing->vehicle_id) {
            $currentVehicleIds[] = $borrowing->vehicle_id;
        }
        if ($borrowing->vehicles_data) {
            $vehiclesData = [];
            if (is_string($borrowing->vehicles_data)) {
                $decoded = json_decode($borrowing->vehicles_data, true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                    $vehiclesData = $decoded;
                }
            } elseif (is_array($borrowing->vehicles_data)) {
                $vehiclesData = $borrowing->vehicles_data;
            }

            foreach ($vehiclesData as $vehicleData) {
                if (is_array($vehicleData) && isset($vehicleData['vehicle_id'])) {
                    $currentVehicleIds[] = (int)$vehicleData['vehicle_id'];
                }
            }
        }

        // Get all vehicle IDs that are currently borrowed (excluding current borrowing)
        $borrowedVehicleIds = collect();

        // Get vehicle IDs from single vehicle borrowings (excluding current borrowing)
        $singleVehicleBorrowings = Borrowing::whereIn('status', ['pending', 'approved', 'in_use'])
            ->where('id', '!=', $borrowing->id)
            ->whereNotNull('vehicle_id')
            ->pluck('vehicle_id');

        $borrowedVehicleIds = $borrowedVehicleIds->merge($singleVehicleBorrowings);

        // Get vehicle IDs from multiple vehicle borrowings (excluding current borrowing)
        $multipleVehicleBorrowings = Borrowing::whereIn('status', ['pending', 'approved', 'in_use'])
            ->where('id', '!=', $borrowing->id)
            ->whereNotNull('vehicles_data')
            ->get();

        foreach ($multipleVehicleBorrowings as $otherBorrowing) {
            $vehiclesData = [];

            // Handle both array (from cast) and string JSON format
            if (is_array($otherBorrowing->vehicles_data)) {
                $vehiclesData = $otherBorrowing->vehicles_data;
            } elseif (is_string($otherBorrowing->vehicles_data)) {
                $decoded = json_decode($otherBorrowing->vehicles_data, true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                    $vehiclesData = $decoded;
                }
            }

            foreach ($vehiclesData as $vehicleData) {
                if (isset($vehicleData['vehicle_id'])) {
                    $borrowedVehicleIds->push((int)$vehicleData['vehicle_id']);
                }
            }
        }

        // Remove duplicates and get unique borrowed vehicle IDs
        $borrowedVehicleIds = $borrowedVehicleIds->unique()->values();

        // Get available vehicles (not borrowed by others) + currently used by this borrowing
        $availableVehicles = Vehicle::where('availability_status', 'tersedia')
            ->where(function ($query) use ($currentVehicleIds, $borrowedVehicleIds) {
                $query->whereNotIn('id', $borrowedVehicleIds->toArray())
                      ->orWhereIn('id', $currentVehicleIds);
            })
            ->orderBy('brand')
            ->orderBy('model')
            ->get();

        // Parse destination data for edit form
        $destinationData = [];
        if ($borrowing->destination && $borrowing->location_type === 'luar_kota') {
            if (is_string($borrowing->destination)) {
                $destinationData = json_decode($borrowing->destination, true) ?? [];
            } elseif (is_array($borrowing->destination)) {
                $destinationData = $borrowing->destination;
            }
        }

        return view('operator.borrowings.edit', compact('borrowing', 'availableVehicles', 'destinationData'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Borrowing $borrowing)
    {
        // Only allow updating if status is pending
        if ($borrowing->status !== 'pending') {
            return redirect()->route('operator.borrowings.show', $borrowing)
                ->with('error', 'Hanya pengajuan dengan status pending yang dapat diedit.');
        }

        // Determine validation rules based on unit count
        $unitCount = (int) $request->input('unit_count', 1);

        // Get validation rules and messages
        $rules = $this->getValidationRules($unitCount, true);
        $messages = $this->getValidationMessages(true);

        // Perform validation
        try {
            $validatedData = $request->validate($rules, $messages);
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Update validation failed:', $e->errors());
            throw $e;
        }

        // Check vehicle availability
        $unavailableVehicles = [];

        if ($validatedData['unit_count'] > 1) {
            // Check multiple vehicles
            foreach ($request->vehicles as $index => $vehicleData) {
                $vehicle = Vehicle::find($vehicleData['vehicle_id']);
                if ($vehicle) {
                    $hasActiveBorrowing = $vehicle->borrowings()
                        ->whereIn('status', ['approved', 'in_use'])
                        ->where('id', '!=', $borrowing->id)
                        ->where(function ($query) use ($validatedData) {
                            $query->whereBetween('start_date', [$validatedData['start_date'], $validatedData['end_date']])
                                  ->orWhereBetween('end_date', [$validatedData['start_date'], $validatedData['end_date']])
                                  ->orWhere(function ($q) use ($validatedData) {
                                      $q->where('start_date', '<=', $validatedData['start_date'])
                                        ->where('end_date', '>=', $validatedData['end_date']);
                                  });
                        })->exists();

                    if ($hasActiveBorrowing) {
                        $unavailableVehicles[] = $vehicle->brand . ' ' . $vehicle->model . ' (' . $vehicle->license_plate . ')';
                    }
                }
            }
        } else {
            // Check single vehicle (only if different from current)
            if ($validatedData['vehicle_id'] != $borrowing->vehicle_id) {
                $vehicle = Vehicle::findOrFail($validatedData['vehicle_id']);
                $hasActiveBorrowing = $vehicle->borrowings()
                    ->whereIn('status', ['approved', 'in_use'])
                    ->where('id', '!=', $borrowing->id)
                    ->where(function ($query) use ($validatedData) {
                        $query->whereBetween('start_date', [$validatedData['start_date'], $validatedData['end_date']])
                              ->orWhereBetween('end_date', [$validatedData['start_date'], $validatedData['end_date']])
                              ->orWhere(function ($q) use ($validatedData) {
                                  $q->where('start_date', '<=', $validatedData['start_date'])
                                    ->where('end_date', '>=', $validatedData['end_date']);
                              });
                    })->exists();

                if ($hasActiveBorrowing) {
                    $unavailableVehicles[] = $vehicle->brand . ' ' . $vehicle->model . ' (' . $vehicle->license_plate . ')';
                }
            }
        }

        if (!empty($unavailableVehicles)) {
            $errorMessage = 'Kendaraan berikut sedang digunakan: ' . implode(', ', $unavailableVehicles);
            return back()->withErrors(['vehicles' => $errorMessage])->withInput();
        }

        try {
            // Prepare destination data based on location type
            $destination = null;
            if ($validatedData['location_type'] === 'luar_kota') {
                $destination = json_encode([
                    'province' => $validatedData['province'],
                    'city' => $validatedData['city']
                ]);
            }

            $updateData = [
                'borrower_type' => $validatedData['borrower_type'],
                'borrower_name' => $validatedData['borrower_name'],
                'borrower_institution' => $validatedData['borrower_institution'] ?? null,
                'borrower_contact' => $validatedData['borrower_contact'],
                'start_date' => $validatedData['start_date'],
                'end_date' => $validatedData['end_date'],
                'purpose' => $validatedData['purpose'],
                'location_type' => $validatedData['location_type'],
                'destination' => $destination,
                'unit_count' => $validatedData['unit_count'],
                'notes' => $validatedData['notes'],
            ];

            // Handle vehicle data based on unit count
            if ($validatedData['unit_count'] > 1) {
                // Multiple vehicles - store in vehicles_data JSON
                $vehiclesData = [];
                foreach ($request->vehicles as $index => $vehicleData) {
                    $vehicle = Vehicle::find($vehicleData['vehicle_id']);
                    $vehiclesData[] = [
                        'vehicle_id' => $vehicle->id,
                        'unit_number' => $index + 1,
                        'vehicle_info' => [
                            'brand' => $vehicle->brand,
                            'model' => $vehicle->model,
                            'license_plate' => $vehicle->license_plate,
                            'year' => $vehicle->year,
                            'fuel_type' => $vehicle->fuel_type ?? null
                        ]
                    ];
                }
                $updateData['vehicles_data'] = json_encode($vehiclesData);
                $updateData['vehicle_id'] = null; // Clear single vehicle reference
            } else {
                // Single vehicle - store in vehicle_id
                $updateData['vehicle_id'] = $validatedData['vehicle_id'];
                $updateData['vehicles_data'] = null; // Clear multiple vehicles data
            }

            // Handle file uploads
            if ($request->hasFile('surat_permohonan')) {
                // Delete old file
                if ($borrowing->surat_permohonan && Storage::disk('public')->exists($borrowing->surat_permohonan)) {
                    Storage::disk('public')->delete($borrowing->surat_permohonan);
                }
                $updateData['surat_permohonan'] = $request->file('surat_permohonan')->store('borrowings/surat_permohonan', 'public');
            }

            if ($request->hasFile('surat_tugas')) {
                // Delete old file
                if ($borrowing->surat_tugas && Storage::disk('public')->exists($borrowing->surat_tugas)) {
                    Storage::disk('public')->delete($borrowing->surat_tugas);
                }
                $updateData['surat_tugas'] = $request->file('surat_tugas')->store('borrowings/surat_tugas', 'public');
            }

            $borrowing->update($updateData);

            return redirect()->route('operator.borrowings.show', $borrowing)
                ->with('success', 'Data peminjaman kendaraan berhasil diperbarui.');

        } catch (\Exception $e) {
            \Log::error('Error updating borrowing: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Terjadi kesalahan saat memperbarui data. Silakan coba lagi.'])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Borrowing $borrowing)
    {
        // Only allow deletion if status is pending or rejected
        if (!in_array($borrowing->status, ['pending', 'rejected'])) {
            return response()->json([
                'success' => false,
                'message' => 'Hanya pengajuan dengan status pending atau rejected yang dapat dihapus.'
            ], 400);
        }

        try {
            // Delete uploaded files
            if ($borrowing->request_letter && Storage::disk('public')->exists($borrowing->request_letter)) {
                Storage::disk('public')->delete($borrowing->request_letter);
            }

            if ($borrowing->statement_letter && Storage::disk('public')->exists($borrowing->statement_letter)) {
                Storage::disk('public')->delete($borrowing->statement_letter);
            }

            $borrowing->delete();

            return response()->json([
                'success' => true,
                'message' => 'Data peminjaman kendaraan berhasil dihapus.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus data. Silakan coba lagi.'
            ], 500);
        }
    }

    /**
     * Print borrowing details.
     */
    public function print(Borrowing $borrowing)
    {
        $borrowing->load(['vehicle', 'user']);
        return view('operator.borrowings.print', compact('borrowing'));
    }

    /**
     * Get validation rules for borrowing forms
     */
    private function getValidationRules($unitCount, $isUpdate = false)
    {
        // Base validation rules
        $rules = [
            'borrower_type' => 'required|in:internal,eksternal',
            'borrower_name' => 'required|string|max:255',
            'borrower_contact' => 'required|string|max:255',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'purpose' => 'required|string|max:1000',
            'location_type' => 'required|in:dalam_kota,luar_kota',
            'unit_count' => 'required|integer|min:1|max:10',
            'notes' => 'nullable|string|max:1000',
            'province' => 'nullable|string|max:255|required_if:location_type,luar_kota',
            'city' => 'nullable|string|max:255|required_if:location_type,luar_kota',
        ];

        // Add update-specific rules
        if ($isUpdate) {
            $rules['purpose'] = 'required|string|min:10|max:500';
            $rules['surat_permohonan'] = 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120';
            $rules['surat_tugas'] = 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120';
        } else {
            // Store-specific rules
            $rules['surat_permohonan'] = 'required|file|mimes:pdf,jpg,jpeg,png|max:5120';
            $rules['surat_tugas'] = 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120';
        }

        // Dynamic vehicle validation based on unit count
        if ($unitCount > 1) {
            $rules['vehicles'] = 'required|array|min:' . $unitCount . '|max:' . $unitCount;
            $rules['vehicles.*.vehicle_id'] = 'required|exists:vehicles,id|distinct';
        } else {
            $rules['vehicle_id'] = 'required|exists:vehicles,id';
        }

        return $rules;
    }

    /**
     * Get custom validation messages
     */
    private function getValidationMessages($isUpdate = false)
    {
        $messages = [
            // Borrower validation messages
            'borrower_type.required' => 'Jenis peminjam wajib dipilih.',
            'borrower_type.in' => 'Jenis peminjam tidak valid.',
            'borrower_name.required' => 'Nama peminjam wajib diisi.',
            'borrower_name.max' => 'Nama peminjam maksimal 255 karakter.',
            'borrower_contact.required' => 'Kontak peminjam wajib diisi.',
            'borrower_contact.max' => 'Kontak peminjam maksimal 255 karakter.',

            // Date validation messages
            'start_date.required' => 'Tanggal mulai wajib diisi.',
            'start_date.date' => 'Format tanggal mulai tidak valid.',
            'start_date.after_or_equal' => 'Tanggal mulai tidak boleh kurang dari hari ini.',
            'end_date.required' => 'Tanggal selesai wajib diisi.',
            'end_date.date' => 'Format tanggal selesai tidak valid.',
            'end_date.after_or_equal' => 'Tanggal selesai tidak boleh kurang dari tanggal mulai.',

            // Purpose and location validation messages
            'purpose.required' => 'Tujuan penggunaan wajib diisi.',
            'purpose.max' => 'Tujuan penggunaan maksimal 1000 karakter.',
            'location_type.required' => 'Jenis lokasi wajib dipilih.',
            'location_type.in' => 'Jenis lokasi tidak valid.',
            'province.required_if' => 'Provinsi wajib dipilih untuk perjalanan luar kota.',
            'city.required_if' => 'Kota/Kabupaten wajib dipilih untuk perjalanan luar kota.',

            // Unit count validation messages
            'unit_count.required' => 'Jumlah unit wajib diisi.',
            'unit_count.integer' => 'Jumlah unit harus berupa angka.',
            'unit_count.min' => 'Jumlah unit minimal 1.',
            'unit_count.max' => 'Jumlah unit maksimal 10.',

            // File upload validation messages (store)
            'surat_permohonan.file' => 'Surat permohonan harus berupa file.',
            'surat_permohonan.mimes' => 'Surat permohonan harus berformat PDF, JPG, JPEG, atau PNG.',
            'surat_permohonan.max' => 'Ukuran surat permohonan maksimal 5MB.',
            'surat_tugas.file' => 'Surat tugas harus berupa file.',
            'surat_tugas.mimes' => 'Surat tugas harus berformat PDF, JPG, JPEG, atau PNG.',
            'surat_tugas.max' => 'Ukuran surat tugas maksimal 5MB.',

            // Vehicle validation messages
            'vehicle_id.required' => 'Pilih kendaraan yang akan dipinjam.',
            'vehicle_id.exists' => 'Kendaraan yang dipilih tidak valid.',
            'vehicles.required' => 'Pilih kendaraan untuk setiap unit.',
            'vehicles.array' => 'Data kendaraan tidak valid.',
            'vehicles.min' => 'Jumlah kendaraan harus sesuai dengan jumlah unit.',
            'vehicles.max' => 'Jumlah kendaraan tidak boleh melebihi jumlah unit.',
            'vehicles.*.vehicle_id.required' => 'Pilih kendaraan untuk unit ini.',
            'vehicles.*.vehicle_id.exists' => 'Kendaraan yang dipilih tidak valid.',
            'vehicles.*.vehicle_id.distinct' => 'Setiap unit harus menggunakan kendaraan yang berbeda.',

            // Notes validation messages
            'notes.max' => 'Catatan maksimal 1000 karakter.',
        ];

        // Add update-specific messages
        if ($isUpdate) {
            $messages['purpose.min'] = 'Tujuan penggunaan minimal 10 karakter.';
            $messages['purpose.max'] = 'Tujuan penggunaan maksimal 500 karakter.';
            $messages['surat_permohonan.required'] = null; // Remove required message for update
        } else {
            $messages['surat_permohonan.required'] = 'Surat permohonan wajib diupload.';
        }

        return $messages;
    }

    /**
     * Check vehicle availability for given dates
     */
    private function checkVehicleAvailability($vehicleIds, $startDate, $endDate, $excludeBorrowingId = null)
    {
        $unavailableVehicles = [];

        foreach ($vehicleIds as $vehicleId) {
            $vehicle = Vehicle::find($vehicleId);
            if (!$vehicle) {
                continue;
            }

            // Check if vehicle is available
            $hasActiveBorrowing = $vehicle->borrowings()
                ->whereIn('status', ['pending', 'approved', 'in_use'])
                ->when($excludeBorrowingId, function ($query) use ($excludeBorrowingId) {
                    return $query->where('id', '!=', $excludeBorrowingId);
                })
                ->where(function ($query) use ($startDate, $endDate) {
                    $query->whereBetween('start_date', [$startDate, $endDate])
                          ->orWhereBetween('end_date', [$startDate, $endDate])
                          ->orWhere(function ($q) use ($startDate, $endDate) {
                              $q->where('start_date', '<=', $startDate)
                                ->where('end_date', '>=', $endDate);
                          });
                })->exists();

            if ($hasActiveBorrowing) {
                $unavailableVehicles[] = $vehicle->brand . ' ' . $vehicle->model . ' (' . $vehicle->license_plate . ')';
            }
        }

        return $unavailableVehicles;
    }
}