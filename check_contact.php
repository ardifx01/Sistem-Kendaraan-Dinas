<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Borrowing;

echo "Checking borrowing contact data:\n";
echo "================================\n";

$borrowings = Borrowing::select('id', 'borrower_name', 'borrower_contact')
    ->orderBy('created_at', 'desc')
    ->take(10)
    ->get();

foreach($borrowings as $borrowing) {
    echo "ID: {$borrowing->id}\n";
    echo "Name: {$borrowing->borrower_name}\n";
    echo "Contact: " . ($borrowing->borrower_contact ?? 'NULL') . "\n";
    echo "Contact Length: " . (strlen($borrowing->borrower_contact ?? '') ?: 'NULL') . "\n";
    echo "Contact Raw: " . var_export($borrowing->borrower_contact, true) . "\n";
    echo "---\n";
}
