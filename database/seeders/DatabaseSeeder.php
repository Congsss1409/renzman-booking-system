<?php
// database/seeders/DatabaseSeeder.php

namespace Illuminate\Database\Seeder;

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

        // 1. Create the Admin User (now the only user)
        User::create([
            'name' => 'Admin',
            'email' => 'admin@renzman.com',
            'password' => Hash::make('password'),
        ]);

        // 2. Call other seeders
        $this->call([
            BranchSeeder::class,
            ServiceSeeder::class,
        ]);

        // 3. Create all therapists without user accounts
        $malaria = Branch::where('name', 'Metro Plaza Malaria')->first();
        $bagongSilang = Branch::where('name', 'Metro Plaza Bagong Silang')->first();
        $zabarte = Branch::where('name', 'Zabarte Town Center')->first();
        $genLuis = Branch::where('name', 'Metro Plaza Gen Luis')->first();

        if ($malaria) {
            Therapist::create(['name' => 'Anna', 'branch_id' => $malaria->id]);
            Therapist::create(['name' => 'Ben', 'branch_id' => $malaria->id]);
        }
        if ($bagongSilang) {
            Therapist::create(['name' => 'Carla', 'branch_id' => $bagongSilang->id]);
            Therapist::create(['name' => 'David', 'branch_id' => $bagongSilang->id]);
        }
        if ($zabarte) {
            Therapist::create(['name' => 'Elena', 'branch_id' => $zabarte->id]);
            Therapist::create(['name' => 'Frank', 'branch_id' => $zabarte->id]);
        }
        if ($genLuis) {
            Therapist::create(['name' => 'Grace', 'branch_id' => $genLuis->id]);
            Therapist::create(['name' => 'Henry', 'branch_id' => $genLuis->id]);
        }
    }
}
