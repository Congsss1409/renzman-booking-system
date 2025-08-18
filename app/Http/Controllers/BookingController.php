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
use Illuminate\Support\Str;
use App\Events\BookingCreated;
use Illuminate\Validation\Rule;

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
        $now = Carbon::now();
        foreach ($therapists as $therapist) {
            $currentBooking = Booking::where('therapist_id', $therapist->id)
                ->where('start_time', '<=', $now)
                ->where('end_time', '>=', $now)
                ->where('status', '!=', 'Cancelled')
                ->first();
            if ($currentBooking) {
                $therapist->status = 'In Session';
                $therapist->available_at = Carbon::parse($currentBooking->end_time)->format('g:i A');
            } else {
                $therapist->status = 'Available';
                $therapist->available_at = null;
            }
        }
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
        $validated = $request->validate([
            'booking_date' => 'required|date|after_or_equal:today',
            'booking_time' => 'required|string',
        ]);

        $selectedDateTime = Carbon::parse($validated['booking_date'] . ' ' . $validated['booking_time']);
        if ($selectedDateTime->isPast()) {
            return back()->withErrors(['booking_time' => 'You cannot book an appointment in the past.'])->withInput();
        }

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
    
    // Step 4: Store Client Details and Proceed to Payment
    public function storeStepFour(Request $request)
    {
        $validated = $request->validate([
            'client_name' => 'required|string|max:255',
            'client_email' => 'required|email|max:255',
            'client_phone' => 'required|string|max:20',
        ]);

        $booking = $request->session()->get('booking');
        $booking->client_name = $validated['client_name'];
        $booking->client_email = $validated['client_email'];
        $booking->client_phone = $validated['client_phone'];
        $request->session()->put('booking', $booking);

        return redirect()->route('booking.create.step-five');
    }

    // Step 5: Show Payment Page
    public function createStepFive(Request $request)
    {
        $booking = $request->session()->get('booking');
        if (empty($booking->client_name)) {
            return redirect()->route('booking.create.step-four');
        }
        $service = Service::find($booking->service_id);
        return view('booking.step-five', compact('booking', 'service'));
    }

    // Step 5: Store Payment Method and Finalize Booking
    public function storeStepFive(Request $request)
    {
        $validated = $request->validate([
            'payment_method' => 'required|string|in:GCash,Maya,On-Site',
        ]);

        $bookingData = $request->session()->get('booking');
        $service = Service::find($bookingData->service_id);
        $startTime = Carbon::parse($bookingData->date . ' ' . $bookingData->time);
        $endTime = $startTime->copy()->addMinutes($service->duration);

        $downpaymentAmount = 0;
        $remainingBalance = $service->price;
        $paymentStatus = 'Pending';

        if ($validated['payment_method'] !== 'On-Site') {
            $downpaymentAmount = $service->price * 0.50;
            $remainingBalance = $service->price - $downpaymentAmount;
            $paymentStatus = 'Paid Downpayment';
        }

        $booking = Booking::create([
            'client_name' => $bookingData->client_name,
            'client_email' => $bookingData->client_email,
            'client_phone' => $bookingData->client_phone,
            'branch_id' => $bookingData->branch_id,
            'service_id' => $bookingData->service_id,
            'therapist_id' => $bookingData->therapist_id,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'price' => $service->price,
            'downpayment_amount' => $downpaymentAmount,
            'remaining_balance' => $remainingBalance,
            'payment_method' => $validated['payment_method'],
            'payment_status' => $paymentStatus,
            'status' => 'Confirmed',
            'feedback_token' => Str::uuid(),
        ]);

        Mail::to($booking->client_email)->send(new BookingConfirmed($booking));
        
        broadcast(new BookingCreated($booking))->toOthers();

        $request->session()->forget('booking');
        return redirect()->route('booking.success');
    }

    // Success Page
    public function success()
    {
        return view('booking.success');
    }

    public function getAvailability(Request $request, Therapist $therapist, $date)
    {
        try {
            $selectedDate = Carbon::parse($date);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Invalid date format'], 400);
        }

        $bookings = Booking::where('therapist_id', $therapist->id)
                            ->whereDate('start_time', $selectedDate->toDateString())
                            ->where('status', '!=', 'Cancelled')
                            ->get();

        $bookedTimes = $bookings->map(function ($booking) {
            return Carbon::parse($booking->start_time)->format('h:i A');
        });

        return response()->json($bookedTimes);
    }
}
