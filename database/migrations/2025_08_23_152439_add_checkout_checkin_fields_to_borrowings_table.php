<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('borrowings', function (Blueprint $table) {
            $table->timestamp('checked_out_at')->nullable()->after('status');
            $table->timestamp('checked_in_at')->nullable()->after('checked_out_at');
            $table->foreignId('checked_out_by')->nullable()->constrained('users')->after('checked_in_at');
            $table->foreignId('checked_in_by')->nullable()->constrained('users')->after('checked_out_by');
            $table->text('checkout_notes')->nullable()->after('checked_in_by');
            $table->text('checkin_notes')->nullable()->after('checkout_notes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('borrowings', function (Blueprint $table) {
            $table->dropForeign(['checked_out_by']);
            $table->dropForeign(['checked_in_by']);
            $table->dropColumn([
                'checked_out_at',
                'checked_in_at',
                'checked_out_by',
                'checked_in_by',
                'checkout_notes',
                'checkin_notes'
            ]);
        });
    }
};
