<?php
// The new migration file you just created, e.g.,
// database/migrations/YYYY_MM_DD_HHMMSS_add_image_to_therapists_table.php

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
        Schema::table('therapists', function (Blueprint $table) {
            // Add a column to store the URL or path to the therapist's photo
            $table->string('image_url')->nullable()->after('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('therapists', function (Blueprint $table) {
            $table->dropColumn('image_url');
        });
    }
};
