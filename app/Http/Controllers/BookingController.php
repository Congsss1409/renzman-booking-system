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
    $openHour = 8; // 8:00 AM
    $closeHour = 21; // 9:00 PM
    $isOpen = $now->hour >= $openHour && $now->hour < $closeHour;
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
        return view('booking.step-two', compact('therapists', 'bookingData', 'isOpen', 'openHour', 'closeHour'));
    }
    
    public function storeStepTwo(Request $request)
    {
        $validated = $request->validate([
            'therapist_id' => 'required|exists:therapists,id',
            'extended_session' => 'nullable|boolean',
        ]);

        $booking = $request->session()->get('booking', new \stdClass());
        $booking->therapist_id = $validated['therapist_id'];
        $booking->extended_session = !empty($validated['extended_session']);
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
        $extendedSession = $booking->extended_session ?? false;
        
        $manilaTime = Carbon::now('Asia/Manila');
        $now = $manilaTime->toIso8601String();
        $todayForJs = [
            'year' => $manilaTime->year,
            'month' => $manilaTime->month - 1, // JS months are 0-indexed
            'day' => $manilaTime->day
        ];

        return view('booking.step-three', compact('therapist', 'service', 'booking', 'now', 'extendedSession', 'todayForJs'));
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
            'client_phone' => 'required|digits:11',
        ], [
            'client_phone.required' => 'Phone number is required.',
            'client_phone.digits' => 'Phone number must be exactly 11 digits.',
        ]);
        
        $bookingData = $request->session()->get('booking', new \stdClass());
        $bookingData->client_name = $validated['client_name'];
        $bookingData->client_email = $validated['client_email'];
        $bookingData->client_phone = $validated['client_phone'];

        $service = Service::find($bookingData->service_id);
        $startTime = Carbon::parse($bookingData->date . ' ' . $bookingData->time, 'Asia/Manila');
        
        $isExtended = $bookingData->extended_session ?? false;
        $durationInMinutes = $service->duration + ($isExtended ? 60 : 0);
        $endTime = $startTime->copy()->addMinutes($durationInMinutes);

        // --- START: MODIFIED PRICE LOGIC ---
        // A fixed price of 500 is added for the one-hour extension.
        // This can be changed or moved to the database in the future.
        $extensionPrice = 500;
        $finalPrice = $service->price + ($isExtended ? $extensionPrice : 0);
        // --- END: MODIFIED PRICE LOGIC ---


        // Prevent double booking for the same therapist
        $conflictingBooking = Booking::where('therapist_id', $bookingData->therapist_id)
            ->where(function($query) use ($startTime, $endTime) {
                $query->where(function($q) use ($startTime) {
                    $q->where('start_time', '<=', $startTime)
                      ->where('end_time', '>', $startTime);
                })->orWhere(function($q) use ($endTime) {
                    $q->where('start_time', '<', $endTime)
                      ->where('end_time', '>=', $endTime);
                });
            })
            ->exists();

        if ($conflictingBooking) {
            return redirect()->route('booking.create.step-four')->with('error', 'The selected therapist is already booked for this time slot. Please choose another time or therapist.');
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
            'price' => $finalPrice, // Use the calculated final price
            'status' => 'Pending Verification',
            'verification_code' => rand(100000, 999999),
            // Set verification code TTL to 2 minutes to match UI/email
            'verification_expires_at' => Carbon::now()->addMinutes(2),
        ]);

        try {
            Mail::to($booking->client_email)->send(new BookingVerificationMail($booking));
        } catch (\Exception $e) {
            Log::error("Verification email failed for booking ID {$booking->id}: " . $e->getMessage());
            // Do NOT delete the booking on email failure; allow the user to proceed to verification
            // and attempt resend from the next page. Store booking id in session and proceed.
            $request->session()->put('booking_id_for_verification', $booking->id);
            return redirect()->route('booking.create.step-five')->with('error', 'Could not send verification email. You can still proceed to verification and request a new code.');
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

        // Prefer session-stored booking id but allow a hidden input fallback (helps when redirects clear session)
        $bookingId = $request->session()->get('booking_id_for_verification') ?? $request->input('booking_id');
        if (!$bookingId) {
            return redirect()->route('booking.create.step-one')->with('error', 'Your session has expired. Please start again.');
        }

        $booking = Booking::find($bookingId);
        if (!$booking) {
            return redirect()->route('booking.create.step-one')->with('error', 'Booking not found. Please start again.');
        }

        // Check code and expiry
        if ($booking->verification_code !== $validated['verification_code']) {
            return back()->withErrors(['verification_code' => 'Invalid verification code.'])->withInput();
        }

        if (Carbon::now()->gt($booking->verification_expires_at)) {
            return back()->withErrors(['verification_code' => 'Expired verification code. Please request a new one.'])->withInput();
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
        // store booking_id for success page
        $request->session()->put('booking_id', $booking->id);
        return redirect()->route('booking.success');
    }

    /**
     * Resend verification code for a pending booking.
     */
    public function resendCode(Request $request)
    {
        // allow booking_id via session or hidden input
        $bookingId = $request->session()->get('booking_id_for_verification') ?? $request->input('booking_id');
        if (!$bookingId) {
            return redirect()->route('booking.create.step-one')->with('error', 'Your session has expired. Please start again.');
        }

        $booking = Booking::find($bookingId);
        if (!$booking) {
            return redirect()->route('booking.create.step-one')->with('error', 'Booking not found.');
        }

        // Only allow resending if booking is still pending verification
        if ($booking->status !== 'Pending Verification') {
            return redirect()->route('booking.create.step-five')->with('error', 'Booking is not pending verification.');
        }

        // Generate new code and expiry
        $booking->verification_code = rand(100000, 999999);
        $booking->verification_expires_at = Carbon::now()->addMinutes(2);
        $booking->save();

        try {
            Mail::to($booking->client_email)->send(new BookingVerificationMail($booking));
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['success' => true, 'expires_at' => $booking->verification_expires_at->toIso8601String()]);
            }
            return redirect()->route('booking.create.step-five')->with('success', 'A new verification code has been sent.');
        } catch (\Exception $e) {
            Log::error("Failed to resend verification email for booking {$booking->id}: " . $e->getMessage());
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Failed to resend verification email. Please try again later.'], 500);
            }
            return redirect()->route('booking.create.step-five')->with('error', 'Failed to resend verification email. Please try again later.');
        }
    }

    public function success(Request $request)
    {
        $bookingId = $request->session()->get('booking_id');
        if(!$bookingId) return redirect()->route('landing');
        $booking = Booking::findOrFail($bookingId);
        // Ensure confirmation email is sent (idempotent if already sent)
        try {
            Mail::to($booking->client_email)->send(new BookingConfirmed($booking));
        } catch (\Exception $e) {
            Log::error("Failed to send booking confirmation for booking {$booking->id}: " . $e->getMessage());
        }
        return view('booking.success', compact('booking'));
    }

    public function getAvailability(Request $request, Therapist $therapist, $date, Service $service)
    {
        $isExtended = $request->query('extended') === '1';
        $durationInMinutes = $service->duration + ($isExtended ? 60 : 0);
    
        $selectedDate = Carbon::parse($date, 'Asia/Manila')->startOfDay();
        
        // --- START: MODIFIED LOGIC ---
        
        // Define default working hours
        $dayStart = $selectedDate->copy()->hour(8)->minute(0)->second(0); // 8:00 AM
        $dayEnd = $selectedDate->copy()->hour(21)->minute(0)->second(0);   // 9:00 PM

        $now = Carbon::now('Asia/Manila');

        if ($selectedDate->isPast()) {
            // If a past date is somehow selected, return no slots.
            return response()->json([]);
        }

        if ($selectedDate->isToday()) {
            // For today, only allow slots after the current time
            if ($now->gt($dayEnd)) {
                // If it's already past closing, no slots
                return response()->json([]);
            }
            if ($now->gt($dayStart)) {
                $dayStart = $now->copy();
                // Round up to next full hour
                if ($dayStart->minute > 0 || $dayStart->second > 0) {
                    $dayStart->addHour()->startOfHour();
                }
            }
        }
    
        // --- END: MODIFIED LOGIC ---
    
        $existingBookings = Booking::where('therapist_id', $therapist->id)
            ->whereDate('start_time', $selectedDate->toDateString())
            ->whereIn('status', ['Confirmed', 'In Progress', 'Pending Verification'])
            ->orderBy('start_time')
            ->get(['start_time', 'end_time']);
    
        $availableSlots = [];
        $potentialSlotStart = $dayStart->copy();
    
        // Loop through potential slots until the end of the working day
        while ($potentialSlotStart->copy()->addMinutes($durationInMinutes) <= $dayEnd) {
            $potentialSlotEnd = $potentialSlotStart->copy()->addMinutes($durationInMinutes);
    
            $isConflict = false;
            foreach ($existingBookings as $booking) {
                $bookingStart = Carbon::parse($booking->start_time);
                $bookingEnd = Carbon::parse($booking->end_time);
    
                if ($potentialSlotStart < $bookingEnd && $potentialSlotEnd > $bookingStart) {
                    $isConflict = true;
                    break;
                }
            }
    
            if (!$isConflict) {
                $availableSlots[] = $potentialSlotStart->format('H:i');
            }
            
            // --- INTERVAL CHANGE ---
            // Move to the next potential slot, 1 hour later
            $potentialSlotStart->addHour();
        }
    
        return response()->json($availableSlots);
    }
}

