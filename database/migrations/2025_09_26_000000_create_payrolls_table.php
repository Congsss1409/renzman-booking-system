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
        Schema::create('payrolls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('therapist_id')->nullable()->constrained('therapists')->nullOnDelete();
            $table->date('period_start');
            $table->date('period_end');
            $table->decimal('gross', 10, 2)->default(0);
            $table->decimal('therapist_share', 10, 2)->default(0);
            $table->decimal('owner_share', 10, 2)->default(0);
            $table->decimal('deductions', 10, 2)->default(0);
            $table->decimal('net', 10, 2)->default(0);
            $table->string('status')->default('draft');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payrolls');
    }
};
