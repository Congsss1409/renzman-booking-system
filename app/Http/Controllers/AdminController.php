<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Branch;
use App\Models\Service;
use App\Models\Therapist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingCancelled;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard with all bookings.
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        // Eager load relationships for efficiency
        $bookings = Booking::with(['service', 'therapist', 'branch'])->latest()->get();
        return view('admin.dashboard', compact('bookings'));
    }

    /**
     * Show the form for creating a new booking.
     *
     * @return \Illuminate\View\View
     */
    public function createBooking()
    {
        $services = Service::all();
        $therapists = Therapist::all();
        $branches = Branch::all();
        return view('admin.create-booking', compact('services', 'therapists', 'branches'));
    }

    /**
     * Store a newly created booking in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeBooking(Request $request)
    {
        // Validating request against the database schema from the SQL file
        $request->validate([
            'client_name' => 'required|string|max:255',
            'client_email' => 'required|email|max:255',
            'client_phone' => 'required|string|max:20',
            'service_id' => 'required|exists:services,id',
            'therapist_id' => 'required|exists:therapists,id',
            'branch_id' => 'required|exists:branches,id',
            'start_time' => 'required|date',
            'downpayment_amount' => 'nullable|numeric',
            // Other fields from your form can be added here
        ]);

        // Manually creating the booking to match the database columns
        $service = Service::find($request->service_id);
        Booking::create([
            'client_name' => $request->client_name,
            'client_email' => $request->client_email,
            'client_phone' => $request->client_phone,
            'service_id' => $request->service_id,
            'therapist_id' => $request->therapist_id,
            'branch_id' => $request->branch_id,
            'start_time' => Carbon::parse($request->start_time),
            'end_time' => Carbon::parse($request->start_time)->addMinutes($service->duration),
            'price' => $service->price,
            'downpayment_amount' => $request->downpayment_amount,
            'payment_method' => $request->payment_method,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Booking created successfully.');
    }

    /**
     * Show the form for editing the specified booking.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\View\View
     */
    public function editBooking(Booking $booking)
    {
        $services = Service::all();
        $therapists = Therapist::all();
        $branches = Branch::all();
        return view('admin.edit-booking', compact('booking', 'services', 'therapists', 'branches'));
    }

    /**
     * Update the specified booking in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateBooking(Request $request, Booking $booking)
    {
        // Manually merge date and time into a single start_time field before validation.
        $request->merge([
            'start_time' => Carbon::parse($request->input('date') . ' ' . $request->input('time'))->toDateTimeString(),
            'status' => strtolower($request->input('status'))
        ]);

        // We don't want to validate or update the email, so it's removed from the rules.
        $validatedData = $request->validate([
            'client_name' => 'required|string|max:255',
            'client_phone' => 'required|string|max:20',
            'service_id' => 'required|exists:services,id',
            'therapist_id' => 'required|exists:therapists,id',
            'branch_id' => 'required|exists:branches,id',
            'start_time' => 'required|date',
            'status' => 'required|string|in:pending,confirmed,cancelled,completed',
            'downpayment_amount' => 'nullable|numeric',
        ]);

        // Prepare the data for updating the model.
        $updateData = $validatedData;
        
        // If service or start time changes, update price and end time accordingly.
        $service = Service::find($validatedData['service_id']);
        if ($service) {
            $updateData['price'] = $service->price;
            $updateData['end_time'] = Carbon::parse($updateData['start_time'])->addMinutes($service->duration);
        }

        $booking->update($updateData);

        return redirect()->route('admin.dashboard')->with('success', 'Booking updated successfully.');
    }

    /**
     * Cancel the specified booking and send a notification email.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cancelBooking(Booking $booking)
    {
        // Update the status to 'cancelled' instead of deleting
        $booking->update(['status' => 'cancelled']);

        // Send cancellation email to the user.
        // The try-catch block has been removed for debugging.
        // If there's an issue with sending the email, an error will now be displayed.
        Mail::to($booking->client_email)->send(new BookingCancelled($booking));

        return redirect()->route('admin.dashboard')->with('success', 'Booking has been cancelled successfully.');
    }

    /**
     * Display analytics.
     *
     * @return \Illuminate\View\View
     */
    public function analytics()
    {
        $totalBookings = Booking::count();
        // Correctly calculating revenue by summing the 'price' column from the 'bookings' table itself
        $totalRevenue = Booking::where('status', 'completed')->sum('price');
        $averageRating = Booking::whereNotNull('rating')->avg('rating');

        $popularServices = Booking::select('service_id', DB::raw('count(*) as total'))
            ->groupBy('service_id')
            ->orderBy('total', 'desc')
            ->with('service')
            ->take(5)
            ->get();

        $busiestTherapists = Booking::select('therapist_id', DB::raw('count(*) as total'))
            ->groupBy('therapist_id')
            ->orderBy('total', 'desc')
            ->with('therapist')
            ->take(5)
            ->get();

        return view('admin.analytics', compact('totalBookings', 'totalRevenue', 'averageRating', 'popularServices', 'busiestTherapists'));
    }

    /**
     * Display customer feedback.
     *
     * @return \Illuminate\View\View
     */
    public function feedback()
    {
        $feedbacks = Booking::whereNotNull('rating')->with('service', 'therapist', 'branch')->get();
        return view('admin.feedback', compact('feedbacks'));
    }
}
