<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Booking;
use App\Models\Branch; // Import the Branch model

class LandingPageController extends Controller
{
    /**
     * Display the landing page with services, branches, and featured feedback.
     */
    public function index()
    {
        // Fetch all services to display on the page
        $services = Service::orderBy('name')->get();

        // Fetch all branches to display on the page
        $branches = Branch::orderBy('name')->get();

        // Fetch only the bookings that have feedback and are marked to be shown on the landing page
        $feedbacks = Booking::where('show_on_landing', true)
            ->whereNotNull('feedback')
            ->with(['service', 'therapist'])
            ->latest('updated_at') // Show the most recently approved feedback first
            ->take(6) // Limit to a maximum of 6 testimonials
            ->get();

        return view('landing', compact('services', 'branches', 'feedbacks'));
    }

    /**
     * Display the services page.
     */
    public function services()
    {
        $services = Service::orderBy('name')->get();
        return view('services', compact('services'));
    }
    
    /**
     * Display the about page.
     */
    public function about()
    {
        return view('about');
    }
}

