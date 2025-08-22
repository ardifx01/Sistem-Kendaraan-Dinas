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
        Schema::table('services', function (Blueprint $table) {
            $table->decimal('cost', 15, 2)->nullable()->after('service_date'); // Biaya service
            $table->string('garage_name')->nullable()->after('cost'); // Nama bengkel
            $table->dropColumn('status'); // Hapus enum lama
        });

        // Tambah ulang status dengan value yang baru
        Schema::table('services', function (Blueprint $table) {
            $table->enum('status', ['pending', 'in_progress', 'completed', 'cancelled'])->default('pending')->after('garage_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn(['cost', 'garage_name']);
            $table->dropColumn('status'); // Hapus enum baru
        });

        // Kembalikan status enum lama
        Schema::table('services', function (Blueprint $table) {
            $table->enum('status', ['pending', 'in_progress', 'completed'])->default('pending');
        });
    }
};
