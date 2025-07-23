<?php
// database/seeders/TherapistSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Therapist;

class TherapistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Therapist::create(['name' => 'Anna']);
        Therapist::create(['name' => 'Ben']);
        Therapist::create(['name' => 'Carla']);
        Therapist::create(['name' => 'David']);
    }
}