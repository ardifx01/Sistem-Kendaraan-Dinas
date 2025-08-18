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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->constrained()->onDelete('cascade'); // ID Service
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // ID Operator yang input
            $table->enum('payment_source', ['kantor', 'asuransi']); // Sumber Pembayaran
            $table->text('description')->nullable(); // Deskripsi
            $table->date('payment_date'); // Tanggal Pembayaran
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
