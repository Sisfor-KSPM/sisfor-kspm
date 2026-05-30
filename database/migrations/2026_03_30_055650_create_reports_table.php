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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->string('judul_riset'); // Judul Laporan (Weekly Outlook, dsb)
            $table->string('kategori'); // Judul Laporan (Weekly Outlook, dsb)
            $table->string('penulis'); // Judul Laporan (Weekly Outlook, dsb)
            $table->string('tanggal_rilis'); // Judul Laporan (Weekly Outlook, dsb)
            $table->string('pdf_file'); // Path file PDF
            $table->enum('status', ['publik', 'draft', 'terbatas']); // Path file PDF
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
