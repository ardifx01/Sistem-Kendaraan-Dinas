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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id')->constrained()->onDelete('cascade'); // ID Kendaraan
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // ID Operator yang input
            $table->string('service_type'); // Jenis Service
            $table->text('damage_description')->nullable(); // Kerusakan
            $table->text('repair_description')->nullable(); // Perbaikan
            $table->text('parts_replaced')->nullable(); // Penggantian Part
            $table->text('description')->nullable(); // Deskripsi
            $table->json('documents')->nullable(); // Dokumen (JSON array)
            $table->json('photos')->nullable(); // Foto Perbaikan (JSON array)
            $table->date('service_date'); // Tanggal Service
            $table->enum('status', ['pending', 'in_progress', 'completed'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
