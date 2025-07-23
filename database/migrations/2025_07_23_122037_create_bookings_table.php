<?php
// database/migrations/YYYY_MM_DD_HHMMSS_create_bookings_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('client_name');
            $table->string('client_email');
            $table->string('client_phone');
            $table->foreignId('service_id')->constrained('services');
            $table->foreignId('therapist_id')->constrained('therapists');
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->decimal('price', 8, 2);
            $table->string('status')->default('confirmed');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};