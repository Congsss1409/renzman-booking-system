<?php
// app/Http/Controllers/LandingPageController.php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Branch; // Import the Branch model
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    /**
     * Display the landing page.
     */
    public function index()
    {
        return view('landing');
    }

    /**
     * Display the services page.
     */
    public function services()
    {
        $services = Service::orderBy('price')->get();
        return view('services', compact('services'));
    }

    /**
     * NEW: Display the about page.
     */
    public function about()
    {
        // Fetch all branches to display their locations
        $branches = Branch::all();
        
        return view('about', compact('branches'));
    }
}
