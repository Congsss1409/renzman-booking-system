<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Safely drop the user_id column from therapists if it exists.
     * We catch and ignore foreign key drop errors so this is idempotent across environments.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('therapists') && Schema::hasColumn('therapists', 'user_id')) {
            Schema::table('therapists', function (Blueprint $table) {
                try {
                    $table->dropForeign(['user_id']);
                } catch (\Exception $e) {
                    // Foreign key may not exist, ignore.
                }

                try {
                    $table->dropColumn('user_id');
                } catch (\Exception $e) {
                    // Column may be removed by another migration; ignore.
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     * Recreate the user_id column as nullable and add FK to users.id if users table exists.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('therapists') && !Schema::hasColumn('therapists', 'user_id')) {
            Schema::table('therapists', function (Blueprint $table) {
                $table->unsignedBigInteger('user_id')->nullable()->after('branch_id');
            });

            if (Schema::hasTable('users')) {
                try {
                    Schema::table('therapists', function (Blueprint $table) {
                        $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
                    });
                } catch (\Exception $e) {
                    // If foreign key cannot be created, ignore.
                }
            }
        }
    }
};
