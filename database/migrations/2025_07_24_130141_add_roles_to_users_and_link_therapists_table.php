<?php
// The new migration file you just created, e.g.,
// database/migrations/YYYY_MM_DD_HHMMSS_add_roles_to_users_and_link_therapists_table.php

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
        // Add a 'role' column to the users table to differentiate between admins and therapists
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('therapist')->after('password');
        });

        // Add a 'user_id' column to the therapists table to link a therapist to their login account
        Schema::table('therapists', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->after('branch_id')->constrained('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });

        Schema::table('therapists', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};
