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
            'client_phone' => 'required|string|max:20',
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
        $isExtended = $request->query('extended') === '1';
        $durationInMinutes = $service->duration + ($isExtended ? 60 : 0);
    
        $selectedDate = Carbon::parse($date, 'Asia/Manila')->startOfDay();
        
        // --- START: MODIFIED LOGIC ---
        
        // Define default working hours
        $dayStart = $selectedDate->copy()->hour(10); // Default open time: 10 AM
        $dayEnd = $selectedDate->copy()->hour(21);   // Shop closes at 9 PM
    
        $now = Carbon::now('Asia/Manila');
    
        // Apply special logic if the selected date is today
        if ($selectedDate->isToday()) {
            // Define the special 4:00 PM start time for today
            $specialStartTime = $selectedDate->copy()->setTime(16, 0); // 4:00 PM
    
            // The earliest booking can start is the later of the current time or 4:00 PM.
            $effectiveStartTime = $now->gt($specialStartTime) ? $now : $specialStartTime;
    
            // If this effective start time is later than the normal opening time, use it.
            if ($effectiveStartTime->gt($dayStart)) {
                $dayStart = $effectiveStartTime;
            }
    
            // Round up the start time to the next full hour to maintain clean 1-hour intervals.
            if ($dayStart->minute > 0 || $dayStart->second > 0) {
                $dayStart->addHour()->startOfHour();
            }
        } else if ($selectedDate->isPast()) {
            // If a past date is somehow selected, return no slots.
            return response()->json([]);
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

