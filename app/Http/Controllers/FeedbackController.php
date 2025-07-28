<?php
// app/Http/Controllers/FeedbackController.php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    /**
     * Show the feedback form for a specific booking.
     */
    public function create($token)
    {
        $booking = Booking::where('feedback_token', $token)->firstOrFail();

        if ($booking->rating) {
            return view('feedback.already-submitted');
        }

        return view('feedback.create', compact('booking'));
    }

    /**
     * Store the feedback for a specific booking.
     */
    public function store(Request $request, $token)
    {
        $booking = Booking::where('feedback_token', $token)->firstOrFail();

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'feedback' => 'nullable|string',
        ]);

        $booking->rating = $validated['rating'];
        $booking->feedback = $validated['feedback'];
        $booking->save();

        // --- RECODED LOGIC ---
        // Redirect to the homepage with a success message for SweetAlert2.
        return redirect('/')->with('feedback_success', 'Your feedback has been submitted. We appreciate you taking the time to help us improve!');
    }

    // The thanks() method is no longer needed and has been removed.
}
