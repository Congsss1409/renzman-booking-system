<?php
// The new migration file you just created, e.g.,
// database/migrations/YYYY_MM_DD_HHMMSS_add_branch_id_to_therapists_table.php

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
            // Add the branch_id column. It's nullable in case a therapist isn't assigned to a branch yet.
            // It's constrained to the 'branches' table. If a branch is deleted, the therapist's branch_id will be set to null.
            $table->foreignId('branch_id')->nullable()->after('name')->constrained('branches')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('therapists', function (Blueprint $table) {
            // This properly removes the column and the foreign key constraint if you ever need to rollback.
            $table->dropForeign(['branch_id']);
            $table->dropColumn('branch_id');
        });
    }
};
