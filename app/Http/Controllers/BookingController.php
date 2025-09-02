<?php

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

class BookingController extends Controller
{
    public function createStepOne(Request $request)
    {
        $branches = Branch::all();
        $services = Service::all();
        $booking = $request->session()->get('booking');
        return view('booking.step-one', compact('branches', 'services', 'booking'));
    }

    public function storeStepOne(Request $request)
    {
        $validated = $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'service_id' => 'required|exists:services,id'
        ]);
        $booking = new \stdClass();
        $booking->branch_id = $validated['branch_id'];
        $booking->service_id = $validated['service_id'];
        $request->session()->put('booking', $booking);
        return redirect()->route('booking.create.step-two');
    }

    public function createStepTwo(Request $request)
    {
        $bookingData = $request->session()->get('booking');
        if (empty($bookingData->branch_id) || empty($bookingData->service_id)) {
            return redirect()->route('booking.create.step-one')->with('error', 'Please select a branch and service first.');
        }

        $therapists = Therapist::where('branch_id', $bookingData->branch_id)->get();
        $branch = Branch::find($bookingData->branch_id);
        $service = Service::find($bookingData->service_id);
        $now = Carbon::now('Asia/Manila');

        foreach ($therapists as $therapist) {
            // Check 1: Is the therapist currently in a session?
            $currentBooking = Booking::where('therapist_id', $therapist->id)
                ->where('status', '!=', 'Cancelled')
                ->where('start_time', '<=', $now)
                ->where('end_time', '>', $now)
                ->first();

            if ($currentBooking) {
                $therapist->current_status = 'In Session';
                $therapist->available_at = Carbon::parse($currentBooking->end_time)->format('h:i A');
            } else {
                // Check 2: If not in a session, do they have any availability left today?
                $therapist->current_status = 'Available'; // Default status
                $therapist->available_at = null;

                $todayString = $now->toDateString();
                $existingBookings = Booking::where('therapist_id', $therapist->id)
                    ->whereDate('start_time', $todayString)
                    ->where('status', '!=', 'Cancelled')
                    ->get();

                $unavailableSlots = [];
                foreach ($existingBookings as $booking) {
                    $start = Carbon::parse($booking->start_time);
                    $end = Carbon::parse($booking->end_time);
                    while ($start < $end) {
                        $unavailableSlots[] = $start->format('H:i');
                        $start->addMinutes(30);
                    }
                }
                
                $closingTime = $now->copy()->hour(21)->minute(0)->second(0);
                $hasFutureSlot = false;
                for ($hour = 8; $hour < 21; $hour++) {
                    $slotTime = $now->copy()->hour($hour)->minute(0);
                    $slotTime24 = $slotTime->format('H:i');

                    if ($slotTime > $now && !in_array($slotTime24, $unavailableSlots)) {
                        if ($slotTime->copy()->addMinutes($service->duration) <= $closingTime) {
                            $hasFutureSlot = true;
                            break;
                        }
                    }
                }

                if (!$hasFutureSlot) {
                    $therapist->current_status = 'Fully Booked';
                }
            }
        }
        
        return view('booking.step-two', ['therapists' => $therapists, 'branch' => $branch, 'booking' => $bookingData]);
    }
    
    public function storeStepTwo(Request $request)
    {
        $validated = $request->validate(['therapist_id' => 'required|exists:therapists,id']);
        $booking = $request->session()->get('booking');
        $booking->therapist_id = $validated['therapist_id'];
        $request->session()->put('booking', $booking);
        return redirect()->route('booking.create.step-three');
    }

    public function createStepThree(Request $request)
    {
        $booking = $request->session()->get('booking');
        if (empty($booking->therapist_id)) {
            return redirect()->route('booking.create.step-two')->with('error', 'Please select a therapist first.');
        }
        $therapist = Therapist::find($booking->therapist_id);
        return view('booking.step-three', compact('therapist', 'booking'));
    }

    public function storeStepThree(Request $request)
    {
        $validated = $request->validate([
            'booking_date' => 'required|date|after_or_equal:today',
            'booking_time' => 'required|string',
        ]);
        $selectedDateTime = Carbon::parse($validated['booking_date'] . ' ' . $validated['booking_time'], 'Asia/Manila');
        if ($selectedDateTime->isPast()) {
            return back()->withErrors(['booking_time' => 'You cannot book an appointment in the past.'])->withInput();
        }
        $booking = $request->session()->get('booking');
        $booking->date = $validated['booking_date'];
        $booking->time = $validated['booking_time'];
        $request->session()->put('booking', $booking);
        return redirect()->route('booking.create.step-four');
    }

    public function createStepFour(Request $request)
    {
        $booking = $request->session()->get('booking');
        if (empty($booking->date)) {
            return redirect()->route('booking.create.step-three')->with('error', 'Please select a date and time.');
        }
        $branch = Branch::find($booking->branch_id);
        $service = Service::find($booking->service_id);
        $therapist = Therapist::find($booking->therapist_id);
        return view('booking.step-four', compact('booking', 'branch', 'service', 'therapist'));
    }

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

    public function createStepFive(Request $request)
    {
        $booking = $request->session()->get('booking');
        if (empty($booking->client_name)) {
            return redirect()->route('booking.create.step-four')->with('error', 'Please enter your details.');
        }
        $service = Service::find($booking->service_id);
        return view('booking.step-five', compact('booking', 'service'));
    }

    public function storeStepFive(Request $request)
    {
        $validated = $request->validate([
            'payment_method' => 'required|string|in:GCash,Maya,On-Site',
        ]);
        $bookingData = $request->session()->get('booking');
        if (!$bookingData) {
            return redirect()->route('booking.create.step-one')->with('error', 'Your session has expired. Please start again.');
        }
        $service = Service::find($bookingData->service_id);
        $startTime = Carbon::parse($bookingData->date . ' ' . $bookingData->time, 'Asia/Manila');
        $endTime = $startTime->copy()->addMinutes($service->duration);
        $conflictingBooking = Booking::where('therapist_id', $bookingData->therapist_id)
            ->where('start_time', '<', $endTime)
            ->where('end_time', '>', $startTime)
            ->where('status', '!=', 'Cancelled')
            ->exists();
        if ($conflictingBooking) {
            return redirect()->route('booking.create.step-three')
                ->with('error', 'Sorry, that time slot was just booked by someone else. Please select another time.');
        }
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
        
        $request->session()->forget('booking');
        return redirect()->route('landing')->with('success', 'Your booking has been confirmed! We have sent the details to your email.');
    }

    public function success()
    {
        return view('booking.success');
    }

    public function getAvailability(Request $request, Therapist $therapist, $date, Service $service)
    {
        try {
            $selectedDate = Carbon::parse($date);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Invalid date format'], 400);
        }

        $existingBookings = Booking::where('therapist_id', $therapist->id)
            ->whereDate('start_time', $selectedDate->toDateString())
            ->where('status', '!=', 'Cancelled')
            ->get();

        $unavailableSlots = [];

        foreach ($existingBookings as $booking) {
            $start = Carbon::parse($booking->start_time);
            $end = Carbon::parse($booking->end_time);
            while ($start < $end) {
                $unavailableSlots[] = $start->format('H:i');
                $start->addMinutes(30);
            }
        }

        $closingTime = $selectedDate->copy()->hour(21)->minute(0)->second(0);
        $serviceDuration = $service->duration;

        for ($hour = 8; $hour < 21; $hour++) {
            $slotTime = $selectedDate->copy()->hour($hour)->minute(0);
            if ($slotTime->copy()->addMinutes($serviceDuration) > $closingTime) {
                $unavailableSlots[] = $slotTime->format('H:i');
            }
        }
        
        return response()->json(array_unique($unavailableSlots));
    }
}

