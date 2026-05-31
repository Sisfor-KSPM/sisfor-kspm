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
        Schema::create('about_us', function (Blueprint $table) {
            $table->id();
            $table->string('logo')->nullable(); // Sejarah KSPM
            $table->string('nama'); // Misi
            $table->string('singkatan')->nullable(); // Misi
            $table->string('kepanjangan')->nullable(); // Misi
            $table->text('deskripsi')->nullable(); // Misi
            $table->text('visi')->nullable();  // Visi
            $table->text('misi')->nullable(); // Misi
            $table->string('tahun_berdiri')->nullable(); // Misi
            $table->string('total_anggota')->nullable(); // Misi
            $table->string('tahun_aktif')->nullable(); // Misi
            $table->string('program_kerja')->nullable(); // Misi
            $table->string('publikasi_riset')->nullable(); // Misi
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_us');
    }
};
