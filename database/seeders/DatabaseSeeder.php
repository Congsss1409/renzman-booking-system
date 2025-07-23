<?php
// database/seeders/DatabaseSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User; // Import the User model
use Illuminate\Support\Facades\Hash; // Import the Hash facade

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create a default admin user
        User::create([
            'name' => 'Admin',
            'email' => 'admin@renzman.com',
            'password' => Hash::make('password'), // The password is 'password'
        ]);

        // This method calls all your other seeders
        $this->call([
            BranchSeeder::class,
            ServiceSeeder::class,
            TherapistSeeder::class,
        ]);
    }
}
