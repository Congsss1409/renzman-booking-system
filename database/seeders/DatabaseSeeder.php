<?php
// database/seeders/DatabaseSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Therapist;
use App\Models\Branch;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user via dedicated seeder and call other seeders
        $this->call([
            \Database\Seeders\AdminUserSeeder::class,
            BranchSeeder::class,
            ServiceSeeder::class,
            TherapistSeeder::class,
        ]);
    }
}
