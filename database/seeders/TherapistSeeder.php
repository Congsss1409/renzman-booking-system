<?php
// database/seeders/TherapistSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Therapist;
use App\Models\Branch;
use App\Models\User;
use Illuminate\Support\Facades\Schema;

class TherapistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // This seeder is now called from the DatabaseSeeder to ensure users are created first.
        // The logic has been moved there.
    }
}
