<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function index()
    {
        $testimonials = Booking::where('rating', 5)
            ->where('show_on_landing', true)
            ->whereNotNull('feedback')
            ->latest('start_time')
            ->limit(3)
            ->get();
            
        return view('landing', compact('testimonials'));
    }

    public function services()
    {
        return view('services');
    }

    public function about()
    {
        return view('about');
    }
}
