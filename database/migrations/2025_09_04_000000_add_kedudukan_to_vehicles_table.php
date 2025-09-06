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
        Schema::table('vehicles', function (Blueprint $table) {
            $table->string('kedudukan')->nullable()->after('availability_status');
            // single text field to hold BMN number/year, penyewa name, or other text
            $table->text('kedudukan_detail')->nullable()->after('kedudukan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropColumn(['kedudukan_detail', 'kedudukan']);
        });
    }
};
