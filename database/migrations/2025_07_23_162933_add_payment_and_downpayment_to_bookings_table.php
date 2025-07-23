<?php
// You will create this file in: database/migrations/
// Example filename: 2025_07_24_000000_add_payment_and_downpayment_to_bookings_table.php

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
            // Add all new columns in the correct order after the 'price' column
            $table->decimal('downpayment_amount', 8, 2)->nullable()->after('price');
            $table->decimal('remaining_balance', 8, 2)->nullable()->after('downpayment_amount');
            $table->string('payment_method')->nullable()->after('remaining_balance');
            $table->string('payment_status')->default('Pending')->after('payment_method');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // This will correctly remove all four columns if you ever need to roll back
            $table->dropColumn([
                'downpayment_amount',
                'remaining_balance',
                'payment_method',
                'payment_status'
            ]);
        });
    }
};
    