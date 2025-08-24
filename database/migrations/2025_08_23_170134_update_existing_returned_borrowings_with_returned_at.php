<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update existing returned borrowings to have returned_at timestamp
        DB::table('borrowings')
            ->where('status', 'returned')
            ->whereNull('returned_at')
            ->update(['returned_at' => DB::raw('checked_in_at')]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert returned_at to null for existing records
        DB::table('borrowings')
            ->where('status', 'returned')
            ->update(['returned_at' => null]);
    }
};
