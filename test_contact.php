<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Borrowing;
use App\Models\User;

echo "Testing borrower contact field saving:\n";
echo "=====================================\n";

// Find a user to test with
$user = User::first();
if (!$user) {
    echo "No users found. Please create a user first.\n";
    exit;
}

// Create a test borrowing with contact
$testData = [
    'user_id' => $user->id,
    'borrower_type' => 'internal',
    'borrower_name' => 'Test User Contact',
    'borrower_contact' => '08123456789',
    'start_date' => now()->addDays(1),
    'end_date' => now()->addDays(2),
    'purpose' => 'Testing contact field saving functionality',
    'location_type' => 'dalam_kota',
    'unit_count' => 1,
    'vehicles_data' => json_encode([]),
    'status' => 'pending'
];

try {
    echo "Creating test borrowing...\n";
    $borrowing = Borrowing::create($testData);

    echo "Test borrowing created successfully!\n";
    echo "ID: {$borrowing->id}\n";
    echo "Name: {$borrowing->borrower_name}\n";
    echo "Contact: " . ($borrowing->borrower_contact ?? 'NULL') . "\n";
    echo "Contact saved correctly: " . ($borrowing->borrower_contact === '08123456789' ? 'YES' : 'NO') . "\n";

    // Clean up
    $borrowing->delete();
    echo "Test borrowing deleted.\n";

} catch (Exception $e) {
    echo "Error creating test borrowing: " . $e->getMessage() . "\n";
    echo "Check if all required fields are provided.\n";
}

echo "\n";
echo "Checking recent borrowings for contact data:\n";
echo "==========================================\n";

$recentBorrowings = Borrowing::select('id', 'borrower_name', 'borrower_contact', 'created_at')
    ->orderBy('created_at', 'desc')
    ->take(5)
    ->get();

if ($recentBorrowings->count() > 0) {
    foreach($recentBorrowings as $borrowing) {
        $hasContact = !empty($borrowing->borrower_contact) ? 'YES' : 'NO';
        echo "ID: {$borrowing->id} | Name: {$borrowing->borrower_name} | Contact: " . ($borrowing->borrower_contact ?? 'NULL') . " | Has Contact: {$hasContact}\n";
    }
} else {
    echo "No borrowings found.\n";
}

echo "\nDone!\n";
