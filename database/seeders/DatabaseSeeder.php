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
        // 1. Create the Admin User (now the only user type)
        User::create([
            'name' => 'Admin',
            'email' => 'admin@renzman.com',
            'password' => Hash::make('password'),
        ]);

        // 2. Call other seeders
        $this->call([
            BranchSeeder::class,
            ServiceSeeder::class,
            TherapistSeeder::class, // This will now create therapists without logins
        ]);
    }
}
