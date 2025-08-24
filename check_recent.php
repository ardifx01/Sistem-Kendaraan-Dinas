<?php

require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Borrowing;

echo "Recent borrowings in database:\n";
echo "=============================\n";

$borrowings = Borrowing::select('id', 'borrower_name', 'borrower_contact', 'purpose', 'created_at')
    ->orderBy('created_at', 'desc')
    ->take(5)
    ->get();

foreach($borrowings as $b) {
    echo "ID: {$b->id} | Name: {$b->borrower_name} | Contact: {$b->borrower_contact} | Purpose: " . substr($b->purpose, 0, 30) . "... | Created: {$b->created_at}\n";
}

echo "\nTotal borrowings: " . Borrowing::count() . "\n";
