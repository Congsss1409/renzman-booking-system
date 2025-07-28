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
        // Temporarily disable foreign key checks for clean truncation
        Schema::disableForeignKeyConstraints();
        User::truncate();
        Therapist::truncate();
        Schema::enableForeignKeyConstraints();

        // 1. Create the Admin User
        User::create([
            'name' => 'Admin',
            'email' => 'admin@renzman.com',
            'password' => Hash::make('password'),
            'role' => 'admin', // Explicitly set role
        ]);

        // 2. Create a Therapist User with a login
        $therapistUser = User::create([
            'name' => 'Elena',
            'email' => 'elena@renzman.com',
            'password' => Hash::make('password'),
            'role' => 'therapist', // Set role to therapist
        ]);

        // 3. Call other seeders
        $this->call([
            BranchSeeder::class,
            ServiceSeeder::class,
            // TherapistSeeder::class, // We are handling therapist creation here now
        ]);

        // 4. Link the therapist user to a therapist record and branch
        $zabarteBranch = Branch::where('name', 'Zabarte Town Center')->first();
        if ($zabarteBranch) {
            Therapist::create([
                'name' => 'Elena',
                'branch_id' => $zabarteBranch->id,
                'user_id' => $therapistUser->id, // Link to the user account
            ]);
        }
        
        // 5. Create other therapists without logins
        $malaria = Branch::where('name', 'Metro Plaza Malaria')->first();
        $bagongSilang = Branch::where('name', 'Metro Plaza Bagong Silang')->first();
        $genLuis = Branch::where('name', 'Metro Plaza Gen Luis')->first();

        if ($malaria) {
            Therapist::create(['name' => 'Anna', 'branch_id' => $malaria->id]);
            Therapist::create(['name' => 'Ben', 'branch_id' => $malaria->id]);
        }
        if ($bagongSilang) {
            Therapist::create(['name' => 'Carla', 'branch_id' => $bagongSilang->id]);
            Therapist::create(['name' => 'David', 'branch_id' => $bagongSilang->id]);
        }
        if ($zabarteBranch) {
            Therapist::create(['name' => 'Frank', 'branch_id' => $zabarteBranch->id]);
        }
        if ($genLuis) {
            Therapist::create(['name' => 'Grace', 'branch_id' => $genLuis->id]);
            Therapist::create(['name' => 'Henry', 'branch_id' => $genLuis->id]);
        }
    }
}
