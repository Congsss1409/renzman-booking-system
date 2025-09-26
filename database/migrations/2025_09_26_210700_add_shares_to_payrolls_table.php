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
        if (!Schema::hasTable('payrolls')) {
            return;
        }

        Schema::table('payrolls', function (Blueprint $table) {
            if (!Schema::hasColumn('payrolls', 'therapist_share')) {
                $table->decimal('therapist_share', 10, 2)->default(0)->after('gross');
            }
            if (!Schema::hasColumn('payrolls', 'owner_share')) {
                $table->decimal('owner_share', 10, 2)->default(0)->after('therapist_share');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasTable('payrolls')) {
            return;
        }

        Schema::table('payrolls', function (Blueprint $table) {
            if (Schema::hasColumn('payrolls', 'owner_share')) {
                $table->dropColumn('owner_share');
            }
            if (Schema::hasColumn('payrolls', 'therapist_share')) {
                $table->dropColumn('therapist_share');
            }
        });
    }
};
