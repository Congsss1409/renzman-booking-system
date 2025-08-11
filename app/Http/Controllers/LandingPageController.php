<?php
// app/Http/Controllers/LandingPageController.php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    /**
     * Display the landing page.
     */
    public function index()
    {
        // No changes here
        return view('landing');
    }

    /**
     * NEW: Display the services page.
     */
    public function services()
    {
        // Fetch all services from the database, ordered by price
        $services = Service::orderBy('price')->get();
        
        return view('services', compact('services'));
    }
}
