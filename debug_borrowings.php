<?php

require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Vehicle;
use App\Models\Borrowing;

echo "=== TEST LOGIKA FINAL VEHICLE AVAILABILITY ===\n\n";

// Test logika final dari controller yang sudah diperbaiki
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
    echo "Processing borrowing ID {$borrowing->id}...\n";
    $vehiclesData = [];

    // Handle both array (from cast) and string JSON format
    if (is_array($borrowing->vehicles_data)) {
        $vehiclesData = $borrowing->vehicles_data;
        echo "  Data type: array\n";
    } elseif (is_string($borrowing->vehicles_data)) {
        $decoded = json_decode($borrowing->vehicles_data, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            $vehiclesData = $decoded;
            echo "  Data type: JSON string (decoded)\n";
        }
    }

    foreach ($vehiclesData as $vehicleData) {
        if (isset($vehicleData['vehicle_id'])) {
            $vehicleId = (int)$vehicleData['vehicle_id'];
            echo "  - Found vehicle ID: {$vehicleId}\n";
            $borrowedVehicleIds->push($vehicleId);
        }
    }
}

// Remove duplicates and get unique borrowed vehicle IDs
$borrowedVehicleIds = $borrowedVehicleIds->unique()->values();

echo "\nSemua Vehicle IDs yang sedang dipinjam:\n";
echo "IDs: " . $borrowedVehicleIds->implode(', ') . "\n";

// Test new logic from controller
$availableVehicles = Vehicle::where('availability_status', 'tersedia')
    ->whereNotIn('id', $borrowedVehicleIds->toArray())
    ->orderBy('brand')
    ->orderBy('model')
    ->get();

echo "\n=== KENDARAAN TERSEDIA (LOGIKA FINAL) ===\n";
if ($availableVehicles->count() > 0) {
    foreach ($availableVehicles as $vehicle) {
        echo "- ID: {$vehicle->id} | {$vehicle->brand} {$vehicle->model} ({$vehicle->license_plate})\n";
    }
    echo "\nTotal: {$availableVehicles->count()} kendaraan tersedia\n";
} else {
    echo "Tidak ada kendaraan yang tersedia untuk dipinjam.\n";
}

echo "\n=== KENDARAAN YANG SEDANG DIPINJAM ===\n";
$borrowedVehicles = Vehicle::whereIn('id', $borrowedVehicleIds->toArray())->get();
foreach ($borrowedVehicles as $vehicle) {
    echo "- ID: {$vehicle->id} | {$vehicle->brand} {$vehicle->model} ({$vehicle->license_plate})\n";
}
