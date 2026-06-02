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
        // Add missing columns to activity_logs table
        Schema::table('activity_logs', function (Blueprint $table) {
            // Check if columns don't already exist
            if (!Schema::hasColumn('activity_logs', 'activity_type')) {
                $table->string('activity_type')->nullable()->after('page_name');
            }
            if (!Schema::hasColumn('activity_logs', 'description')) {
                $table->string('description')->nullable()->after('activity_type');
            }
            // Make page_name nullable if it's not already
            if (Schema::hasColumn('activity_logs', 'page_name')) {
                $table->string('page_name')->nullable()->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('activity_logs', function (Blueprint $table) {
            if (Schema::hasColumn('activity_logs', 'activity_type')) {
                $table->dropColumn('activity_type');
            }
            if (Schema::hasColumn('activity_logs', 'description')) {
                $table->dropColumn('description');
            }
            // Revert page_name back to NOT NULL if needed
            if (Schema::hasColumn('activity_logs', 'page_name')) {
                $table->string('page_name')->nullable(false)->change();
            }
        });
    }
};
