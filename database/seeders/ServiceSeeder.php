<?php
// database/seeders/ServiceSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Service;
use Illuminate\Support\Facades\Schema;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Temporarily disable foreign key checks to allow truncation
        Schema::disableForeignKeyConstraints();
        Service::truncate();
        Schema::enableForeignKeyConstraints();

        // Data based on the Renzman flyer
        Service::create([
            'name' => 'Chair Massage (Half Body)',
            'description' => 'A quick, focused massage on the upper body, perfect for immediate relief.',
            'price' => 250.00,
            'duration' => 30
        ]);
        Service::create([
            'name' => 'Chair Massage (Whole Body)',
            'description' => 'A full-body massage performed on a specialized ergonomic massage chair.',
            'price' => 450.00,
            'duration' => 60
        ]);
        Service::create([
            'name' => 'Bed Massage (Whole Body)',
            'description' => 'A traditional full-body massage on a comfortable massage bed for deep relaxation.',
            'price' => 500.00,
            'duration' => 60
        ]);
        Service::create([
            'name' => 'Solo Massage (Half Body)',
            'description' => 'A focused half-body massage, targeting either the upper or lower body.',
            'price' => 300.00,
            'duration' => 30
        ]);
        Service::create([
            'name' => 'Pressure Massage',
            'description' => 'A therapeutic massage focusing on applying firm pressure to relieve chronic muscle tension.',
            'price' => 550.00,
            'duration' => 60
        ]);
        Service::create([
            'name' => 'Ventosa (Cupping Therapy)',
            'description' => 'An ancient form of alternative medicine using special cups to create suction.',
            'price' => 400.00,
            'duration' => 45
        ]);
        Service::create([
            'name' => 'Hot Stone Therapy',
            'description' => 'Uses smooth, heated stones to warm and relax muscles, allowing for deeper pressure.',
            'price' => 600.00,
            'duration' => 75
        ]);
        Service::create([
            'name' => 'Ear Candling',
            'description' => 'A holistic procedure intended to help remove earwax and improve general health.',
            'price' => 200.00,
            'duration' => 20
        ]);
    }
}
