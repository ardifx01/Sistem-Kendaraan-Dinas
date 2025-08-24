<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Borrowing;

// Find the borrowing record for 'jaka'
$borrowing = Borrowing::where('borrower_name', 'jaka')->first();

if ($borrowing) {
    echo "=== DEBUGGING VEHICLES DATA FOR JAKA ===\n";
    echo "Borrowing ID: " . $borrowing->id . "\n";
    echo "Borrower Name: " . $borrowing->borrower_name . "\n";
    echo "Status: " . $borrowing->status . "\n\n";

    echo "=== RAW vehicles_data ===\n";
    echo "Type: " . gettype($borrowing->vehicles_data) . "\n";
    echo "Raw Data: " . var_export($borrowing->vehicles_data, true) . "\n\n";

    if (is_string($borrowing->vehicles_data)) {
        echo "=== DECODED vehicles_data ===\n";
        $decoded = json_decode($borrowing->vehicles_data, true);
        echo "Decoded Type: " . gettype($decoded) . "\n";
        echo "Decoded Data: " . var_export($decoded, true) . "\n";

        if (is_array($decoded)) {
            echo "\n=== VEHICLES COUNT ===\n";
            echo "Total vehicles: " . count($decoded) . "\n\n";

            foreach ($decoded as $index => $vehicleData) {
                echo "=== VEHICLE " . ($index + 1) . " ===\n";
                echo "Type: " . gettype($vehicleData) . "\n";
                echo "Data: " . var_export($vehicleData, true) . "\n";

                // Check for nested structure
                if (isset($vehicleData['vehicle_info'])) {
                    echo "Has vehicle_info nested structure\n";
                    echo "vehicle_info: " . var_export($vehicleData['vehicle_info'], true) . "\n";
                } else {
                    echo "Direct structure (no vehicle_info nesting)\n";
                }
                echo "\n";
            }
        }
    }

    echo "=== RELATED VEHICLE MODEL ===\n";
    if ($borrowing->vehicle_id) {
        echo "vehicle_id: " . $borrowing->vehicle_id . "\n";
        if ($borrowing->vehicle) {
            echo "Vehicle model data: " . var_export($borrowing->vehicle->toArray(), true) . "\n";
        }
    } else {
        echo "No vehicle_id (multiple vehicles case)\n";
    }

} else {
    echo "No borrowing record found for 'jaka'\n";
}

?>