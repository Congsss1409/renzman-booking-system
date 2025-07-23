<?php
// app/Http/Controllers/BookingController.php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Branch;
use App\Models\Service;
use App\Models\Therapist;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingConfirmed;
use Illuminate\Support\Str; // Import the Str facade to generate UUIDs

class BookingController extends Controller
{
    // Step 1: Show Branch & Service Selection
    public function createStepOne(Request $request)
    {
        $branches = Branch::all();
        $services = Service::all();
        $booking = $request->session()->get('booking');
        return view('booking.step-one', compact('branches', 'services', 'booking'));
    }

    // Step 1: Store Branch & Service Selection
    public function storeStepOne(Request $request)
    {
        $validated = $request->validate(['branch_id' => 'required|exists:branches,id', 'service_id' => 'required|exists:services,id']);
        $booking = new \stdClass();
        $booking->branch_id = $validated['branch_id'];
        $booking->service_id = $validated['service_id'];
        $request->session()->put('booking', $booking);
        return redirect()->route('booking.create.step-two');
    }

    // Step 2: Show Therapist Selection
    public function createStepTwo(Request $request)
    {
        $booking = $request->session()->get('booking');
        if (empty($booking->branch_id)) {
            return redirect()->route('booking.create.step-one');
        }
        $therapists = Therapist::where('branch_id', $booking->branch_id)->get();
        $branch = Branch::find($booking->branch_id);
        return view('booking.step-two', compact('therapists', 'branch', 'booking'));
    }

    // Step 2: Store Therapist Selection
    public function storeStepTwo(Request $request)
    {
        $validated = $request->validate(['therapist_id' => 'required|exists:therapists,id']);
        $booking = $request->session()->get('booking');
        $booking->therapist_id = $validated['therapist_id'];
        $request->session()->put('booking', $booking);
        return redirect()->route('booking.create.step-three');
    }

    // Step 3: Show Date & Time Selection
    public function createStepThree(Request $request)
    {
        $booking = $request->session()->get('booking');
        if (empty($booking->therapist_id)) {
            return redirect()->route('booking.create.step-two');
        }
        $therapist = Therapist::find($booking->therapist_id);
        return view('booking.step-three', compact('therapist', 'booking'));
    }

    // Step 3: Store Date & Time Selection
    public function storeStepThree(Request $request)
    {
        $validated = $request->validate(['booking_date' => 'required|date|after_or_equal:today', 'booking_time' => 'required|string']);
        $booking = $request->session()->get('booking');
        $booking->date = $validated['booking_date'];
        $booking->time = $validated['booking_time'];
        $request->session()->put('booking', $booking);
        return redirect()->route('booking.create.step-four');
    }

    // Step 4: Show Confirmation Page
    public function createStepFour(Request $request)
    {
        $booking = $request->session()->get('booking');
        if (empty($booking->date)) {
            return redirect()->route('booking.create.step-three');
        }
        $branch = Branch::find($booking->branch_id);
        $service = Service::find($booking->service_id);
        $therapist = Therapist::find($booking->therapist_id);
        return view('booking.step-four', compact('booking', 'branch', 'service', 'therapist'));
    }

    // Step 4: Store Final Booking
    public function storeStepFour(Request $request)
    {
        $validated = $request->validate(['client_name' => 'required|string|max:255', 'client_email' => 'required|email|max:255', 'client_phone' => 'required|string|max:20']);
        $bookingData = $request->session()->get('booking');
        $service = Service::find($bookingData->service_id);
        $startTime = Carbon::parse($bookingData->date . ' ' . $bookingData->time);
        $endTime = $startTime->copy()->addMinutes($service->duration);

        $booking = Booking::create([
            'client_name' => $validated['client_name'],
            'client_email' => $validated['client_email'],
            'client_phone' => $validated['client_phone'],
            'branch_id' => $bookingData->branch_id,
            'service_id' => $bookingData->service_id,
            'therapist_id' => $bookingData->therapist_id,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'price' => $service->price,
            'status' => 'Confirmed',
            'feedback_token' => Str::uuid(), // Generate a unique token for the feedback link
        ]);

        // Send the confirmation email
        Mail::to($validated['client_email'])->send(new BookingConfirmed($booking));

        $request->session()->forget('booking');
        return redirect()->route('booking.success');
    }

    // Success Page
    public function success()
    {
        return view('booking.success');
    }

    /**
     * Get the availability for a given therapist on a specific date.
     * This method is called by the JavaScript on the booking page.
     */
    public function getAvailability(Request $request, Therapist $therapist, $date)
    {
        try {
            $selectedDate = Carbon::parse($date);
        } catch (\Exception $e) {
            // Handle cases where the date format is invalid
            return response()->json(['error' => 'Invalid date format'], 400);
        }

        // Get all bookings for the specified therapist on the selected date
        $bookings = Booking::where('therapist_id', $therapist->id)
                            ->whereDate('start_time', $selectedDate->toDateString())
                            ->where('status', '!=', 'Cancelled') // Ignore cancelled bookings
                            ->get();

        // Extract the start times and format them as 'h:i A' (e.g., 09:00 AM)
        $bookedTimes = $bookings->map(function ($booking) {
            return Carbon::parse($booking->start_time)->format('h:i A');
        });

        return response()->json($bookedTimes);
    }
}
