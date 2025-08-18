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
        Schema::create('borrowings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id')->constrained()->onDelete('cascade'); // ID Kendaraan
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // ID Operator yang input
            $table->enum('borrower_type', ['internal', 'eksternal']); // Peminjam
            $table->string('borrower_name'); // Nama Peminjam
            $table->date('start_date'); // Tanggal Mulai
            $table->date('end_date'); // Tanggal Selesai
            $table->text('purpose'); // Keperluan
            $table->enum('location_type', ['dalam_kota', 'luar_kota']); // Lokasi
            $table->string('destination')->nullable(); // Tujuan (jika luar kota)
            $table->integer('unit_count')->default(1); // Jumlah Unit
            $table->string('request_letter')->nullable(); // Surat Permohonan
            $table->string('statement_letter')->nullable(); // Surat Pernyataan
            $table->enum('status', ['pending', 'approved', 'rejected', 'in_use', 'returned'])->default('pending');
            $table->text('notes')->nullable(); // Catatan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrowings');
    }
};
