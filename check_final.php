<?php

require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Borrowing;

echo "Recent borrowings with contact data:\n";
echo "===================================\n";

$borrowings = Borrowing::select('id', 'borrower_name', 'borrower_contact')
    ->orderBy('created_at', 'desc')
    ->take(7)
    ->get();

foreach($borrowings as $b) {
    echo "ID: {$b->id} | Name: {$b->borrower_name} | Contact: {$b->borrower_contact}\n";
}
