<?php
// The new migration file you just created, e.g.,
// database/migrations/YYYY_MM_DD_HHMMSS_remove_therapist_login_fields.php

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
        // We need to check if the columns exist before trying to drop them
        // to avoid errors if the migration is run on a clean database.
        if (Schema::hasColumn('users', 'role')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('role');
            });
        }

        if (Schema::hasColumn('therapists', 'user_id')) {
            Schema::table('therapists', function (Blueprint $table) {
                // Drop the foreign key constraint before dropping the column
                $table->dropForeign(['user_id']);
                $table->dropColumn('user_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     * (This is the logic from the old migration to add the columns back if needed)
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('therapist')->after('password');
        });

        Schema::table('therapists', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->after('branch_id')->constrained('users')->onDelete('set null');
        });
    }
};
