<?php

require_once 'vendor/autoload.php';

use App\Models\Borrowing;

// Initialize Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== DEBUG RETURNED BORROWINGS ===\n\n";

// Get returned borrowings
$borrowings = Borrowing::where('status', 'returned')->get();

echo "Found " . $borrowings->count() . " returned borrowings\n\n";

foreach($borrowings as $borrowing) {
    echo "Borrowing ID: " . $borrowing->id . "\n";
    echo "Borrower: " . $borrowing->borrower_name . "\n";
    echo "Status: " . $borrowing->status . "\n";
    echo "Unit Count: " . $borrowing->unit_count . "\n";
    echo "Vehicle ID: " . ($borrowing->vehicle_id ?: 'NULL') . "\n";
    echo "Vehicles Data Type: " . gettype($borrowing->vehicles_data) . "\n";

    if($borrowing->vehicles_data) {
        echo "Vehicles Data Raw: " . print_r($borrowing->vehicles_data, true) . "\n";

        if(is_string($borrowing->vehicles_data)) {
            $decoded = json_decode($borrowing->vehicles_data, true);
            echo "Vehicles Data Decoded: " . print_r($decoded, true) . "\n";
        }
    } else {
        echo "Vehicles Data: NULL\n";
    }

    echo "Returned At: " . ($borrowing->returned_at ?: 'NULL') . "\n";
    echo "---\n\n";
}
