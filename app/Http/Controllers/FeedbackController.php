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
        // Find the booking using the secure token
        $booking = Booking::where('feedback_token', $token)->firstOrFail();

        // Check if feedback has already been submitted
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

        // Validate the submitted data
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'feedback' => 'nullable|string',
        ]);

        // Update the booking with the feedback
        $booking->rating = $validated['rating'];
        $booking->feedback = $validated['feedback'];
        $booking->save();

        return redirect()->route('feedback.thanks');
    }

    /**
     * Show a "thank you" page after submission.
     */
    public function thanks()
    {
        return view('feedback.thanks');
    }
}
