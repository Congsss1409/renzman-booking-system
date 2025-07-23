<?php
// database/seeders/TherapistSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Therapist;
use App\Models\Branch;
use Illuminate\Support\Facades\Schema;

class TherapistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key checks to truncate the table
        Schema::disableForeignKeyConstraints();
        Therapist::truncate();
        Schema::enableForeignKeyConstraints();

        // Get branch IDs to assign therapists
        $malaria = Branch::where('name', 'Metro Plaza Malaria')->first();
        $bagongSilang = Branch::where('name', 'Metro Plaza Bagong Silang')->first();
        $zabarte = Branch::where('name', 'Zabarte Town Center')->first();
        $genLuis = Branch::where('name', 'Metro Plaza Gen Luis')->first();

        // Assign therapists to specific branches
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
