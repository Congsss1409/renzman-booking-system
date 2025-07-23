<?php
// app/Http/Controllers/AdminController.php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Branch;
use App\Models\Service;
use App\Models\Therapist;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminController extends Controller
{
    /**
     * Show the admin dashboard with all bookings.
     */
    public function dashboard()
    {
        $bookings = Booking::with('service', 'therapist', 'branch')
                             ->orderBy('start_time', 'desc')
                             ->get();
        return view('admin.dashboard', compact('bookings'));
    }

    /**
     * Cancel a specific booking.
     */
    public function cancelBooking(Booking $booking)
    {
        $booking->status = 'Cancelled';
        $booking->save();
        return redirect()->route('admin.dashboard')->with('success', 'Booking has been successfully cancelled.');
    }

    /**
     * Show the form for creating a new booking.
     */
    public function createBooking()
    {
        $branches = Branch::all();
        $services = Service::all();
        return view('admin.create-booking', compact('branches', 'services'));
    }

    /**
     * Store a new booking made by an admin.
     */
    public function storeBooking(Request $request)
    {
        $validated = $request->validate([
            'client_name' => 'required|string|max:255',
            'client_phone' => 'required|string|max:20',
            'branch_id' => 'required|exists:branches,id',
            'therapist_id' => 'required|exists:therapists,id',
            'service_id' => 'required|exists:services,id',
            'booking_date' => 'required|date',
            'booking_time' => 'required',
        ]);

        $service = Service::find($validated['service_id']);
        $startTime = Carbon::parse($validated['booking_date'] . ' ' . $validated['booking_time']);
        $endTime = $startTime->copy()->addMinutes($service->duration);

        Booking::create([
            'client_name' => $validated['client_name'],
            'client_email' => 'walkin@renzman.com',
            'client_phone' => $validated['client_phone'],
            'branch_id' => $validated['branch_id'],
            'service_id' => $validated['service_id'],
            'therapist_id' => $validated['therapist_id'],
            'start_time' => $startTime,
            'end_time' => $endTime,
            'price' => $service->price,
            'status' => 'Confirmed',
            // Note: We are not creating a feedback token for admin-created bookings
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'New booking created successfully.');
    }

    /**
     * API endpoint to get therapists for a selected branch.
     */
    public function getTherapistsByBranch(Branch $branch)
    {
        return response()->json($branch->therapists);
    }

    /**
     * Show the feedback page with all submitted feedback.
     */
    public function feedback()
    {
        // Get only the bookings that have a rating
        $feedbacks = Booking::with('therapist', 'service', 'branch')
                            ->whereNotNull('rating')
                            ->orderBy('start_time', 'desc')
                            ->get();
        
        return view('admin.feedback', compact('feedbacks'));
    }
}
