<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Carbon\Carbon;

class BookingController extends Controller
{
    /**
     * Show Step 1: Location Selection
     */
    public function showStepOne(Request $request): View
    {
        $locations = [
            "Metro Plaza Malaria",
            "Metro Plaza Bagong Silang",
            "Zabarte Town Center",
            "Metro Plaza Gen Luis"
        ];
        $request->session()->forget('booking');
        return view('booking.step-one', ['locations' => $locations]);
    }

    /**
     * Process Step 1 submission and redirect to Step 2
     */
    public function processStepOne(Request $request): RedirectResponse
    {
        $validated = $request->validate(['location' => 'required|string']);
        $request->session()->put('booking.location', $validated['location']);
        return redirect()->route('booking.stepTwo');
    }

    /**
     * Show Step 2: Service Selection
     */
    public function showStepTwo(Request $request): View|RedirectResponse
    {
        if (!$request->session()->has('booking.location')) {
            return redirect()->route('booking.stepOne');
        }
        $services = [
            "Chair Massage" => ["Half Body" => ["duration" => 30, "price" => 300], "Whole Body" => ["duration" => 60, "price" => 500]],
            "Bed Massage" => ["Whole Body" => ["duration" => 60, "price" => 600], "Solo Massage (Half Body)" => ["duration" => 30, "price" => 350], "Pressure Massage" => ["duration" => 60, "price" => 650]],
            "Specialty Services" => ["Ventosa (Cupping)" => ["duration" => 45, "price" => 700], "Hot Stone Therapy" => ["duration" => 90, "price" => 1200], "Ear Candling" => ["duration" => 30, "price" => 400]]
        ];
        return view('booking.step-two', ['services' => $services]);
    }

     /**
     * Process Step 2 submission and redirect to Step 3
     */
    public function processStepTwo(Request $request): RedirectResponse
    {
        $validated = $request->validate(['service' => 'required|string']);
        list($category, $name) = explode('|', $validated['service']);
        $allServices = [
            "Chair Massage" => ["Half Body" => ["duration" => 30, "price" => 300], "Whole Body" => ["duration" => 60, "price" => 500]],
            "Bed Massage" => ["Whole Body" => ["duration" => 60, "price" => 600], "Solo Massage (Half Body)" => ["duration" => 30, "price" => 350], "Pressure Massage" => ["duration" => 60, "price" => 650]],
            "Specialty Services" => ["Ventosa (Cupping)" => ["duration" => 45, "price" => 700], "Hot Stone Therapy" => ["duration" => 90, "price" => 1200], "Ear Candling" => ["duration" => 30, "price" => 400]]
        ];
        $details = $allServices[$category][$name] ?? null;

        if (!$details) {
            return redirect()->route('booking.stepTwo')->withErrors(['service' => 'Invalid service selected.']);
        }
        $request->session()->put('booking.service_category', $category);
        $request->session()->put('booking.service_name', $name);
        $request->session()->put('booking.service_details', $details);
        return redirect()->route('booking.stepThree');
    }

    /**
     * Show Step 3: Therapist & Time Selection
     */
    public function showStepThree(Request $request): View|RedirectResponse
    {
        if (!$request->session()->has('booking.service_name')) {
            return redirect()->route('booking.stepTwo');
        }
        
        $therapists = [
            ['id' => 1, 'name' => 'Anna Reyes', 'availability' => ['10:00 AM', '11:30 AM', '02:00 PM', '03:30 PM']],
            ['id' => 2, 'name' => 'Juan dela Cruz', 'availability' => ['09:00 AM', '10:30 AM', '01:00 PM', '04:00 PM']],
            ['id' => 3, 'name' => 'Maria Santos', 'availability' => ['11:00 AM', '02:30 PM', '05:00 PM']],
        ];

        return view('booking.step-three', ['therapists' => $therapists]);
    }

    /**
     * Process Step 3 submission
     */
    public function processStepThree(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'therapist_time' => 'required|string',
        ]);

        list($therapistId, $therapistName, $time) = explode('|', $validated['therapist_time']);

        $request->session()->put('booking.therapist_id', $therapistId);
        $request->session()->put('booking.therapist_name', $therapistName);
        $request->session()->put('booking.time', $time);
        $request->session()->put('booking.date', Carbon::today()->toDateString());

        return redirect()->route('booking.stepFour');
    }

    /**
     * Show Step 4: Confirmation
     */
    public function showStepFour(Request $request): View|RedirectResponse
    {
        if (!$request->session()->has('booking.time')) {
            return redirect()->route('booking.stepThree');
        }
        $bookingDetails = $request->session()->get('booking');
        return view('booking.step-four', ['booking' => $bookingDetails]);
    }

    /**
     * Store the final booking
     */
    public function storeBooking(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'client_name' => 'required|string|max:255',
            'client_mobile' => 'required|string|max:20',
            'client_email' => 'nullable|email|max:255',
        ]);

        // Get the current booking data from the session
        $bookingDetails = $request->session()->get('booking', []);

        // Add the final client details to the array
        $bookingDetails['client_name'] = $validated['client_name'];
        $bookingDetails['client_mobile'] = $validated['client_mobile'];
        $bookingDetails['client_email'] = $validated['client_email'];

        // Clear the old session data
        $request->session()->forget('booking');

        // Redirect and "flash" the complete booking details to the session for the next request only.
        // This is a more reliable way to pass data after a redirect.
        return redirect()->route('booking.success')->with('booking', $bookingDetails);
    }

    /**
     * Show the success page
     */
    public function showSuccess(Request $request): View|RedirectResponse
    {
        // Check if the 'booking' data was flashed to the session from the storeBooking method.
        if (!$request->session()->has('booking')) {
            // If not, the user tried to access the success page directly. Redirect them.
            return redirect()->route('booking.stepOne');
        }

        // Get the booking details from the flashed session data.
        $bookingDetails = $request->session()->get('booking');

        return view('booking.success', ['booking' => $bookingDetails]);
    }
}
