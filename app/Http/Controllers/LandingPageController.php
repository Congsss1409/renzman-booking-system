<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class LandingPageController extends Controller
{
    /**
     * Display the landing page.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        // In the future, you could pass data like testimonials
        // or featured services from the database to this view.
        return view('landing');
    }
}
