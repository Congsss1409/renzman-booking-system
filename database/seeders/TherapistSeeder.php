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
        $branches = Branch::all()->keyBy('name');

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
                        // NEW: Add a placeholder image URL for each therapist
                        'image_url' => 'https://ui-avatars.com/api/?name=' . urlencode($name) . '&color=FFFFFF&background=059669&size=128',
                    ]);
                }
            }
        }
    }
}
