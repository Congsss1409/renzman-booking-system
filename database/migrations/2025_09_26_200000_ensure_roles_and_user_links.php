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
        // Ensure `role` column exists on users table
        if (!Schema::hasColumn('users', 'role')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('role')->default('therapist')->after('password');
            });
        }

        // Ensure `user_id` exists on therapists table and is a foreign key to users
        if (Schema::hasTable('therapists') && !Schema::hasColumn('therapists', 'user_id')) {
            Schema::table('therapists', function (Blueprint $table) {
                $table->foreignId('user_id')->nullable()->after('branch_id')->constrained('users')->onDelete('set null');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('therapists', 'user_id')) {
            Schema::table('therapists', function (Blueprint $table) {
                $table->dropForeign(['user_id']);
                $table->dropColumn('user_id');
            });
        }

        if (Schema::hasColumn('users', 'role')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('role');
            });
        }
    }
};
