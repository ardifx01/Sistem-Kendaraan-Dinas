<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Borrowing;

echo "=== DEBUG BORROWINGS DATA ===\n";

$borrowings = Borrowing::all();

foreach ($borrowings as $borrowing) {
    echo "\nID: " . $borrowing->id . "\n";
    echo "Unit Count: " . $borrowing->unit_count . "\n";
    echo "Vehicle ID: " . $borrowing->vehicle_id . "\n";
    echo "Vehicles Data Type: " . gettype($borrowing->vehicles_data) . "\n";
    echo "Vehicles Data Raw: " . var_export($borrowing->vehicles_data, true) . "\n";

    if ($borrowing->vehicles_data) {
        if (is_string($borrowing->vehicles_data)) {
            $decoded = json_decode($borrowing->vehicles_data, true);
            echo "Decoded JSON: " . var_export($decoded, true) . "\n";
        }
    }
    echo "----------------------------------------\n";
}
