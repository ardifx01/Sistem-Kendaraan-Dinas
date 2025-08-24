<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Borrowing;

echo "Updating borrowings without contact information:\n";
echo "===============================================\n";

// Find borrowings without contact
$borrowingsWithoutContact = Borrowing::whereNull('borrower_contact')
    ->orWhere('borrower_contact', '')
    ->with('user')
    ->get();

echo "Found {$borrowingsWithoutContact->count()} borrowings without contact.\n\n";

$updated = 0;
$skipped = 0;

foreach($borrowingsWithoutContact as $borrowing) {
    echo "Processing borrowing ID: {$borrowing->id} - {$borrowing->borrower_name}\n";

    // Try to get contact from user or generate placeholder
    $newContact = null;

    if ($borrowing->user && $borrowing->user->email) {
        // For older records, we'll use email as fallback
        // or generate a placeholder phone number
        $newContact = 'Tidak tersedia'; // Default placeholder
        echo "  No phone available, setting placeholder\n";
    } else {
        $newContact = 'Tidak tersedia';
        echo "  No user linked, setting placeholder\n";
    }

    try {
        $borrowing->update(['borrower_contact' => $newContact]);
        $updated++;
        echo "  ✓ Updated successfully\n";
    } catch (Exception $e) {
        echo "  ✗ Failed to update: " . $e->getMessage() . "\n";
        $skipped++;
    }

    echo "\n";
}

echo "Summary:\n";
echo "========\n";
echo "Updated: {$updated} borrowings\n";
echo "Skipped: {$skipped} borrowings\n";
echo "Done!\n";
