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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['motor', 'mobil']); // Jenis Kendaraan
            $table->string('brand'); // Merek
            $table->string('model'); // Tipe
            $table->year('year'); // Tahun Kendaraan
            $table->string('license_plate')->unique(); // Nomor Polisi (unik)
            $table->string('color'); // Warna Kendaraan
            $table->date('tax_expiry_date'); // Tanggal Pajak Berlaku s/d
            $table->enum('document_status', ['lengkap', 'tidak_lengkap']); // Status Surat
            $table->text('document_notes')->nullable(); // Keterangan Surat (jika tidak lengkap)
            $table->string('driver_name')->nullable(); // Nama Pengemudi
            $table->string('user_name')->nullable(); // Pengguna Kendaraan
            $table->string('photo')->nullable(); // Foto Kendaraan
            $table->enum('availability_status', ['tersedia', 'dipinjam', 'service', 'tidak_tersedia'])->default('tersedia');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};