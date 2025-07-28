<?php
// app/Http/Controllers/TherapistController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking;

class TherapistController extends Controller
{
    /**
     * Show the therapist's personal dashboard with their schedule.
     */
    public function dashboard()
    {
        // Get the currently logged-in user
        $user = Auth::user();

        // Find the therapist record linked to this user
        $therapist = $user->therapist;

        // If for some reason the user is not linked to a therapist record, handle it gracefully
        if (!$therapist) {
            // Log them out and redirect to login with an error
            Auth::logout();
            return redirect()->route('login')->withErrors(['email' => 'No therapist profile is associated with this account.']);
        }

        // Fetch upcoming bookings only for this specific therapist
        $bookings = Booking::with('service', 'branch')
                            ->where('therapist_id', $therapist->id)
                            ->where('start_time', '>=', now())
                            ->where('status', '!=', 'Cancelled')
                            ->orderBy('start_time', 'asc')
                            ->get();

        return view('therapist.dashboard', compact('bookings', 'therapist'));
    }
}
