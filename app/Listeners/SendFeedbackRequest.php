<?php

namespace App\Listeners;

use App\Events\BookingCompleted;
use App\Mail\FeedbackRequest;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class SendFeedbackRequest
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(BookingCompleted $event): void
    {
        $booking = $event->booking;
        
        // Generate feedback token if not exists
        if (!$booking->feedback_token) {
            $booking->feedback_token = Str::random(32);
            $booking->save();
        }
        
        // Send feedback request email
        Mail::to($booking->client_email)->send(new FeedbackRequest($booking));
    }
}
