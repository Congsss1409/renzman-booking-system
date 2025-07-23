<?php
// database/seeders/ServiceSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Service::create([
            'name' => 'Swedish Massage',
            'description' => 'A gentle, relaxing massage.',
            'price' => 500.00,
            'duration' => 60,
        ]);

        Service::create([
            'name' => 'Shiatsu Massage',
            'description' => 'A traditional Japanese massage using finger pressure.',
            'price' => 600.00,
            'duration' => 60,
        ]);

        Service::create([
            'name' => 'Deep Tissue Massage',
            'description' => 'Focuses on deeper layers of muscle tissue.',
            'price' => 750.00,
            'duration' => 90,
        ]);

        Service::create([
            'name' => 'Hot Stone Massage',
            'description' => 'Uses smooth, heated stones to relax muscles.',
            'price' => 800.00,
            'duration' => 90,
        ]);
    }
}