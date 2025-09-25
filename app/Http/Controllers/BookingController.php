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
use App\Mail\BookingVerificationMail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{
    public function createStepOne(Request $request)
    {
        $branches = Branch::all();
        $services = Service::all();
        $booking = $request->session()->get('booking', new \stdClass());
        return view('booking.step-one', compact('branches', 'services', 'booking'));
    }

    public function storeStepOne(Request $request)
    {
        $validated = $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'service_id' => 'required|exists:services,id'
        ]);
        $booking = $request->session()->get('booking', new \stdClass());
        $booking->branch_id = $validated['branch_id'];
        $booking->service_id = $validated['service_id'];
        $request->session()->put('booking', $booking);
        return redirect()->route('booking.create.step-two');
    }

    public function createStepTwo(Request $request)
    {
        $bookingData = $request->session()->get('booking');
        if (empty($bookingData->branch_id)) {
            return redirect()->route('booking.create.step-one')->with('error', 'Please select a branch and service first.');
        }
        $therapists = Therapist::where('branch_id', $bookingData->branch_id)->get();
        $now = Carbon::now('Asia/Manila');
        foreach ($therapists as $therapist) {
            $currentBooking = Booking::where('therapist_id', $therapist->id)
                ->whereIn('status', ['Confirmed', 'In Progress'])
                ->where('start_time', '<=', $now)->where('end_time', '>', $now)->first();
            if ($currentBooking) {
                $therapist->current_status = 'In Session';
                $therapist->available_at = Carbon::parse($currentBooking->end_time)->format('h:i A');
            } else {
                $therapist->current_status = 'Available';
                $therapist->available_at = null;
            }
        }
        return view('booking.step-two', compact('therapists', 'bookingData'));
    }
    
    public function storeStepTwo(Request $request)
    {
        $validated = $request->validate(['therapist_id' => 'required|exists:therapists,id']);
        $therapist = Therapist::find($validated['therapist_id']);
        $now = Carbon::now('Asia/Manila');
        $currentBooking = Booking::where('therapist_id', $therapist->id)
            ->whereIn('status', ['Confirmed', 'In Progress'])
            ->where('start_time', '<=', $now)->where('end_time', '>', $now)->first();
        if ($currentBooking) {
            return redirect()->back()->withErrors(['therapist_id' => 'Sorry, ' . $therapist->name . ' is currently in a session. Please select another therapist.']);
        }
        $booking = $request->session()->get('booking', new \stdClass());
        $booking->therapist_id = $validated['therapist_id'];
        $request->session()->put('booking', $booking);
        return redirect()->route('booking.create.step-three');
    }

    public function createStepThree(Request $request)
    {
        $booking = $request->session()->get('booking');
        if (empty($booking->therapist_id) || empty($booking->service_id)) {
            return redirect()->route('booking.create.step-two')->with('error', 'Please select a therapist first.');
        }
        $therapist = Therapist::find($booking->therapist_id);
        $service = Service::find($booking->service_id);
        $now = Carbon::now('Asia/Manila')->toIso8601String();
        return view('booking.step-three', compact('therapist', 'service', 'booking', 'now'));
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
        $booking = $request->session()->get('booking', new \stdClass());
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
        return view('booking.step-four', compact('booking'));
    }

    public function storeStepFour(Request $request)
    {
        $validated = $request->validate([
            'client_name' => 'required|string|max:255',
            'client_email' => 'required|email|max:255',
            'client_phone' => 'required|string|max:20',
        ]);
        
        $bookingData = $request->session()->get('booking', new \stdClass());
        $bookingData->client_name = $validated['client_name'];
        $bookingData->client_email = $validated['client_email'];
        $bookingData->client_phone = $validated['client_phone'];

        $service = Service::find($bookingData->service_id);
        $startTime = Carbon::parse($bookingData->date . ' ' . $bookingData->time, 'Asia/Manila');
        $endTime = $startTime->copy()->addMinutes($service->duration);

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
            'status' => 'Pending Verification',
            'verification_code' => rand(100000, 999999),
            'verification_expires_at' => Carbon::now()->addMinutes(10),
        ]);

        try {
            Mail::to($booking->client_email)->send(new BookingVerificationMail($booking));
        } catch (\Exception $e) {
            Log::error("Verification email failed for booking ID {$booking->id}: " . $e->getMessage());
            $booking->delete();
            return redirect()->route('booking.create.step-four')->with('error', 'Could not send verification email. Please check the address and try again.');
        }
        
        $request->session()->forget('booking');
        $request->session()->put('booking_id_for_verification', $booking->id);

        return redirect()->route('booking.create.step-five');
    }

    public function createStepFive(Request $request)
    {
        $bookingId = $request->session()->get('booking_id_for_verification');
        if (!$bookingId) {
            return redirect()->route('booking.create.step-one')->with('error', 'Your session has expired. Please start again.');
        }
        $booking = Booking::findOrFail($bookingId);
        return view('booking.step-five', compact('booking'));
    }

    public function storeStepFive(Request $request)
    {
        $validated = $request->validate([ 'verification_code' => 'required|string|digits:6', ]);
        $bookingId = $request->session()->get('booking_id_for_verification');
        if (!$bookingId) {
            return redirect()->route('booking.create.step-one')->with('error', 'Your session has expired. Please start again.');
        }
        $booking = Booking::findOrFail($bookingId);
        if ($booking->verification_code !== $validated['verification_code'] || Carbon::now()->gt($booking->verification_expires_at)) {
            return back()->with('error', 'Invalid or expired verification code. Please try again.');
        }
        $booking->update([
            'status' => 'Confirmed', 'verification_code' => null, 'verification_expires_at' => null,
        ]);
        try {
            Mail::to($booking->client_email)->send(new BookingConfirmed($booking));
        } catch (\Exception $e) {
            Log::error("Confirmation email failed for booking ID {$booking->id}: " . $e->getMessage());
        }
        $request->session()->forget('booking_id_for_verification');
        return redirect()->route('booking.success')->with('booking_id', $booking->id);
    }

    public function success(Request $request)
    {
        $bookingId = $request->session()->get('booking_id');
        if(!$bookingId) return redirect()->route('landing');
        $booking = Booking::findOrFail($bookingId);
        return view('booking.success', compact('booking'));
    }

    public function getAvailability(Request $request, Therapist $therapist, $date, Service $service)
    {
        $selectedDate = Carbon::parse($date);
        $existingBookings = Booking::where('therapist_id', $therapist->id)
            ->whereDate('start_time', $selectedDate->toDateString())
            ->whereIn('status', ['Confirmed', 'In Progress', 'Pending Verification'])
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
        return response()->json(array_unique($unavailableSlots));
    }
}