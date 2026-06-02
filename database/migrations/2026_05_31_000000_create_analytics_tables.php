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
        // Tabel untuk melacak activity log (semua aktivitas user)
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(); // User yang melakukan aktivitas
            $table->string('page_name')->nullable(); // Nama halaman yang dikunjungi
            $table->string('activity_type')->nullable(); // Tipe aktivitas (page_view, feature_usage, event_interaction, report_download)
            $table->string('description')->nullable(); // Deskripsi detail aktivitas
            $table->string('feature_name')->nullable(); // Nama fitur yang digunakan (download, view, click, dll)
            $table->string('action')->nullable(); // Aksi yang dilakukan (view, download, click, register, dll)
            $table->string('target_type')->nullable(); // Tipe target (report, event, gallery, dll)
            $table->unsignedBigInteger('target_id')->nullable(); // ID target (report_id, event_id, gallery_id, dll)
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->index('activity_type');
            $table->index('page_name');
            $table->index('feature_name');
            $table->index('action');
            $table->index('created_at');
        });

        // Tabel untuk summary analytics (ringkasan data analytics per hari)
        Schema::create('analytics_summaries', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->integer('total_page_views')->default(0); // Total view website
            $table->integer('unique_visitors')->default(0); // Unique visitors
            $table->integer('total_users_registered')->default(0); // Total registrasi user hari ini
            $table->integer('total_reports_downloaded')->default(0); // Total download riset
            $table->integer('total_event_clicks')->default(0); // Total klik event
            $table->integer('total_gallery_views')->default(0); // Total view gallery
            $table->integer('total_dictionary_views')->default(0); // Total view kamus
            $table->timestamps();
            
            $table->unique('date');
        });

        // Tabel untuk feature usage tracking
        Schema::create('feature_usage', function (Blueprint $table) {
            $table->id();
            $table->string('feature_name'); // Nama fitur (dashboard, calculator, library, events, gallery, dictionary, dll)
            $table->unsignedBigInteger('user_id')->nullable();
            $table->integer('usage_count')->default(1); // Berapa kali diakses
            $table->date('usage_date');
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->unique(['feature_name', 'user_id', 'usage_date']);
            $table->index('feature_name');
        });

        // Tabel untuk tracking downloads riset
        Schema::create('report_downloads', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('report_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('report_title');
            $table->integer('download_count')->default(0);
            $table->date('last_download_date')->nullable();
            $table->timestamps();
            
            $table->foreign('report_id')->references('id')->on('reports')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->index('report_id');
        });

        // Tabel untuk tracking event interactions
        Schema::create('event_interactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('event_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('interaction_type'); // 'view', 'click', 'register', 'attend'
            $table->timestamps();
            
            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->index('event_id');
            $table->index('interaction_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_interactions');
        Schema::dropIfExists('report_downloads');
        Schema::dropIfExists('feature_usage');
        Schema::dropIfExists('analytics_summaries');
        Schema::dropIfExists('activity_logs');
    }
};
