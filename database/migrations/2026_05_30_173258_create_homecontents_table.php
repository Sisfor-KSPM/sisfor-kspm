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
        Schema::create('homecontents', function (Blueprint $table) {
            $table->id();
            $table->string('tagline');
            $table->string('judul');
            $table->string('deskripsi');
            $table->string('gambar_home');
            $table->string('tombol_1_text')->nullable();
            $table->string('tombol_2_text')->nullable();
            $table->string('ig_link')->nullable();
            $table->string('yt_link')->nullable();
            $table->string('linkedin_link')->nullable();
            $table->string('tt_link')->nullable();
            $table->string('email')->nullable();
            $table->string('whatsapp')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('homecontents');
    }
};
