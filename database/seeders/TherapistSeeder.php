<?php
// database/seeders/TherapistSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Therapist;
use App\Models\Branch;

class TherapistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all branches
        $branches = Branch::all()->keyBy('name');

        // Create therapists and assign them to branches
        $therapists = [
            'Metro Plaza Malaria' => ['Anna', 'Ben', 'Carlos', 'Diana'],
            'Metro Plaza Bagong Silang' => ['Carla', 'David', 'Fiona', 'George'],
            'Zabarte Town Center' => ['Elena', 'Frank', 'Hannah', 'Ian'],
            'Metro Plaza Gen Luis' => ['Grace', 'Henry', 'Ivy', 'Jack'],
        ];

        foreach ($therapists as $branchName => $therapistNames) {
            if (isset($branches[$branchName])) {
                foreach ($therapistNames as $name) {
                    Therapist::create([
                        'name' => $name,
                        'branch_id' => $branches[$branchName]->id,
                    ]);
                }
            }
        }
    }
}
