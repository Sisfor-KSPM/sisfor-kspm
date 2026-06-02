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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('kegiatan'); // Nama acara (Seminar, RUPS, dll)
            $table->string('tipe'); // Deskripsi acara
            $table->string('tanggal'); // Tanggal acara
            $table->string('waktu_mulai')->nullable();
            $table->string('waktu_selesai')->nullable();
            $table->string('tempat')->nullable(); // Lokasi / Link Zoom
            $table->string('pic')->nullable(); // Lokasi / Link Zoom
            $table->text('deskripsi')->nullable(); // Lokasi / Link Zoom
            $table->enum('status', ['upcoming', 'berlangsung', 'selesai', 'dibatalkan']); // Lokasi / Link Zoom
            $table->string('kuota')->nullable(); // Lokasi / Link Zoom
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
