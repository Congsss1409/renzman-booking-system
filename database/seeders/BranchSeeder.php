<?php
// database/seeders/BranchSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Branch;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data extracted from the flyer provided
        Branch::create(['name' => 'Metro Plaza Malaria', 'address' => 'Malaria, Caloocan, Metro Manila']);
        Branch::create(['name' => 'Metro Plaza Bagong Silang', 'address' => 'Bagong Silang, Caloocan, Metro Manila']);
        Branch::create(['name' => 'Zabarte Town Center', 'address' => 'Zabarte Rd, Novaliches, Quezon City']);
        Branch::create(['name' => 'Metro Plaza Gen Luis', 'address' => 'Gen. Luis St, Novaliches, Quezon City']);
    }
}
