<?php
// app/Http/Controllers/LandingPageController.php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    /**
     * Display the landing page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Fetch a few services to feature on the homepage
        $featuredServices = Service::inRandomOrder()->take(3)->get();
        
        return view('landing', compact('featuredServices'));
    }
}