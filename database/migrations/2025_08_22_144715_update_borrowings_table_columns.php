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
            // Check if columns exist before renaming
            if (Schema::hasColumn('borrowings', 'request_letter')) {
                $table->renameColumn('request_letter', 'surat_permohonan');
            } else if (!Schema::hasColumn('borrowings', 'surat_permohonan')) {
                // Add column if neither exists
                $table->string('surat_permohonan')->nullable();
            }

            if (Schema::hasColumn('borrowings', 'statement_letter')) {
                $table->renameColumn('statement_letter', 'surat_tugas');
            } else if (!Schema::hasColumn('borrowings', 'surat_tugas')) {
                // Add column if neither exists
                $table->string('surat_tugas')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('borrowings', function (Blueprint $table) {
            // Rename columns back if they exist
            if (Schema::hasColumn('borrowings', 'surat_permohonan')) {
                $table->renameColumn('surat_permohonan', 'request_letter');
            }

            if (Schema::hasColumn('borrowings', 'surat_tugas')) {
                $table->renameColumn('surat_tugas', 'statement_letter');
            }
        });
    }
};
