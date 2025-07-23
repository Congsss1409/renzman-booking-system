<?php
// The new migration file you just created, e.g.,
// database/migrations/YYYY_MM_DD_HHMMSS_add_feedback_to_bookings_table.php

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
        Schema::table('bookings', function (Blueprint $table) {
            // A unique token for the feedback link to keep it secure
            $table->uuid('feedback_token')->nullable()->unique()->after('status');
            
            // The rating, from 1 to 5 stars
            $table->tinyInteger('rating')->nullable()->after('feedback_token');
            
            // The client's text feedback
            $table->text('feedback')->nullable()->after('rating');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['feedback_token', 'rating', 'feedback']);
        });
    }
};
