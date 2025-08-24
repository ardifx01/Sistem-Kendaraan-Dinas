<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Borrowing;
use App\Models\User;
use App\Models\Vehicle;

echo "Testing borrowing creation:\n";
echo "==========================\n";

// Check if we have users and vehicles
$userCount = User::count();
$vehicleCount = Vehicle::count();

echo "Users in database: {$userCount}\n";
echo "Vehicles in database: {$vehicleCount}\n\n";

if ($userCount == 0) {
    echo "❌ No users found! Please create a user first.\n";
    exit;
}

if ($vehicleCount == 0) {
    echo "❌ No vehicles found! Please create a vehicle first.\n";
    exit;
}

// Get first user and vehicle
$user = User::first();
$vehicle = Vehicle::where('availability_status', 'tersedia')->first();

if (!$vehicle) {
    $vehicle = Vehicle::first();
}

echo "Test user: {$user->name} (ID: {$user->id})\n";
echo "Test vehicle: {$vehicle->brand} {$vehicle->model} - {$vehicle->license_plate} (ID: {$vehicle->id})\n\n";

// Test data creation
$testData = [
    'vehicle_id' => $vehicle->id,
    'user_id' => $user->id,
    'borrower_type' => 'internal',
    'borrower_name' => 'Test User ' . date('His'),
    'borrower_contact' => '08123456789',
    'start_date' => now()->addDay(),
    'end_date' => now()->addDays(3),
    'purpose' => 'Test purpose for system debugging',
    'location_type' => 'dalam_kota',
    'unit_count' => 1,
    'vehicles_data' => json_encode([
        [
            'vehicle_id' => $vehicle->id,
            'license_plate' => $vehicle->license_plate,
            'brand' => $vehicle->brand,
            'model' => $vehicle->model
        ]
    ]),
    'status' => 'pending',
    'surat_permohonan' => 'test/path/document.pdf',
];

echo "Creating test borrowing with data:\n";
echo "==================================\n";
foreach($testData as $key => $value) {
    if (is_object($value)) {
        echo "{$key}: " . $value->format('Y-m-d H:i:s') . "\n";
    } else {
        echo "{$key}: {$value}\n";
    }
}
echo "\n";

try {
    $borrowing = Borrowing::create($testData);
    echo "✅ SUCCESS! Borrowing created with ID: {$borrowing->id}\n";
    echo "Data stored: {$borrowing->borrower_name} - {$borrowing->borrower_contact}\n";
    
    // Clean up test data
    $borrowing->delete();
    echo "🧹 Test data cleaned up.\n";
    
} catch (Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
}
