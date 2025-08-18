<?php
// app/Http/Controllers/AdminController.php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Branch;
use App\Models\Service;
use App\Models\Therapist;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Events\BookingCreated;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingCancelled; // Import the new Mailable
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    /**
     * Show the admin dashboard with all bookings.
     */
    public function dashboard()
    {
        Booking::where('status', 'Confirmed')
               ->where('start_time', '<', now())
               ->update(['status' => 'Completed']);

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

        // --- NEW: Send cancellation email to the client ---
        // We check if the client has a real email before sending
        if (filter_var($booking->client_email, FILTER_VALIDATE_EMAIL)) {
            Mail::to($booking->client_email)->send(new BookingCancelled($booking));
        }
        // --- END NEW ---

        return redirect()->route('admin.dashboard')->with('success', 'Booking has been successfully cancelled and the client has been notified.');
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

        $selectedDateTime = Carbon::parse($validated['booking_date'] . ' ' . $validated['booking_time']);
        if ($selectedDateTime->isPast()) {
            return back()->withErrors(['booking_time' => 'You cannot create an appointment in the past.'])->withInput();
        }

        $service = Service::find($validated['service_id']);
        $startTime = $selectedDateTime;
        $endTime = $startTime->copy()->addMinutes($service->duration);

        $booking = Booking::create([
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
        ]);

        broadcast(new BookingCreated($booking))->toOthers();

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
        $feedbacks = Booking::with('therapist', 'service', 'branch')
                            ->whereNotNull('rating')
                            ->orderBy('start_time', 'desc')
                            ->get();
        
        return view('admin.feedback', compact('feedbacks'));
    }

    /**
     * Show the analytics and reports page.
     */
    public function analytics()
    {
        $totalBookings = Booking::count();
        $totalRevenue = Booking::where('status', '!=', 'Cancelled')->sum('price');
        $averageRating = Booking::whereNotNull('rating')->avg('rating');

        $popularServicesQuery = Booking::select('service_id', DB::raw('count(*) as total'))
                                    ->groupBy('service_id')
                                    ->with('service')
                                    ->orderBy('total', 'desc')
                                    ->take(5)
                                    ->get();
        
        $popularServicesLabels = $popularServicesQuery->pluck('service.name');
        $popularServicesData = $popularServicesQuery->pluck('total');

        $busiestTherapistsQuery = Booking::select('therapist_id', DB::raw('count(*) as total'))
                                      ->where('status', '!=', 'Cancelled')
                                      ->groupBy('therapist_id')
                                      ->with('therapist')
                                      ->orderBy('total', 'desc')
                                      ->take(5)
                                      ->get();

        $busiestTherapistsLabels = $busiestTherapistsQuery->pluck('therapist.name');
        $busiestTherapistsData = $busiestTherapistsQuery->pluck('total');

        $aiInsight = "Based on the current data, the business is performing well. ";
        if ($popularServicesQuery->isNotEmpty()) {
            $aiInsight .= "The most popular service is currently **" . $popularServicesQuery->first()->service->name . "**. ";
        }
        if ($busiestTherapistsQuery->isNotEmpty()) {
            $aiInsight .= "The busiest therapist is **" . $busiestTherapistsQuery->first()->therapist->name . "**. ";
        }
        if ($averageRating > 4.5) {
            $aiInsight .= "Client satisfaction is exceptionally high with an average rating of **" . number_format($averageRating, 2) . " stars**. Focus on maintaining this excellent standard of service.";
        } elseif ($averageRating > 4.0) {
            $aiInsight .= "Client satisfaction is strong with an average rating of **" . number_format($averageRating, 2) . " stars**. Consider promoting services with lower ratings to gather more feedback.";
        } else {
            $aiInsight .= "There is an opportunity to improve client satisfaction, as the average rating is currently **" . number_format($averageRating, 2) . " stars**.";
        }

        return view('admin.analytics', compact(
            'totalBookings',
            'totalRevenue',
            'averageRating',
            'popularServicesLabels',
            'popularServicesData',
            'busiestTherapistsLabels',
            'busiestTherapistsData',
            'aiInsight'
        ));
    }

    /**
     * Show the form for editing an existing booking.
     */
    public function editBooking(Booking $booking)
    {
        $branches = Branch::all();
        $services = Service::all();
        $therapists = Therapist::where('branch_id', $booking->branch_id)->get();

        return view('admin.edit-booking', compact('booking', 'branches', 'services', 'therapists'));
    }

    /**
     * Update an existing booking in storage.
     */
    public function updateBooking(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'client_name' => 'required|string|max:255',
            'client_phone' => 'required|string|max:20',
            'branch_id' => 'required|exists:branches,id',
            'therapist_id' => 'required|exists:therapists,id',
            'service_id' => 'required|exists:services,id',
            'booking_date' => 'required|date',
            'booking_time' => 'required',
            'status' => 'required|string|in:Confirmed,Completed',
        ]);

        $service = Service::find($validated['service_id']);
        $startTime = Carbon::parse($validated['booking_date'] . ' ' . $validated['booking_time']);
        $endTime = $startTime->copy()->addMinutes($service->duration);

        $booking->update([
            'client_name' => $validated['client_name'],
            'client_phone' => $validated['client_phone'],
            'branch_id' => $validated['branch_id'],
            'service_id' => $validated['service_id'],
            'therapist_id' => $validated['therapist_id'],
            'start_time' => $startTime,
            'end_time' => $endTime,
            'price' => $service->price,
            'status' => $validated['status'],
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Booking has been updated successfully.');
    }

    /**
     * Show a list of all therapists.
     */
    public function listTherapists(Request $request)
    {
        $query = Therapist::with('branch');
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'LIKE', '%' . $request->search . '%');
        }
        $sortBy = $request->get('sort_by', 'name');
        $sortOrder = $request->get('sort_order', 'asc');
        if ($sortBy == 'branch') {
            $query->join('branches', 'therapists.branch_id', '=', 'branches.id')
                  ->orderBy('branches.name', $sortOrder)
                  ->select('therapists.*');
        } else {
            $query->orderBy($sortBy, $sortOrder);
        }
        $therapists = $query->get();
        return view('admin.therapists', compact('therapists', 'sortBy', 'sortOrder'));
    }

    /**
     * Show the form for editing a therapist.
     */
    public function editTherapist(Therapist $therapist)
    {
        $branches = Branch::all();
        return view('admin.edit-therapist', compact('therapist', 'branches'));
    }

    /**
     * Update the specified therapist in storage.
     */
    public function updateTherapist(Request $request, Therapist $therapist)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'branch_id' => 'required|exists:branches,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        if ($request->hasFile('image')) {
            if ($therapist->image_url) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $therapist->image_url));
            }
            $path = $request->file('image')->store('therapists', 'public');
            $validated['image_url'] = Storage::url($path);
        }
        $therapist->update($validated);
        return redirect()->route('admin.therapists.index')->with('success', 'Therapist details updated successfully.');
    }

    /**
     * Show the form for creating a new therapist.
     */
    public function createTherapist()
    {
        $branches = Branch::all();
        return view('admin.create-therapist', compact('branches'));
    }

    /**
     * Store a newly created therapist in storage.
     */
    public function storeTherapist(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'branch_id' => 'required|exists:branches,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('therapists', 'public');
            $validated['image_url'] = Storage::url($path);
        } else {
            $validated['image_url'] = 'https://ui-avatars.com/api/?name=' . urlencode($validated['name']) . '&color=FFFFFF&background=059669&size=128';
        }
        Therapist::create($validated);
        return redirect()->route('admin.therapists.index')->with('success', 'New therapist added successfully.');
    }

    /**
     * Remove the specified therapist from storage.
     */
    public function destroyTherapist(Therapist $therapist)
    {
        if ($therapist->bookings()->exists()) {
            return redirect()->route('admin.therapists.index')
                             ->with('error', 'Cannot delete this therapist because they have existing bookings. Please reassign or cancel their appointments first.');
        }
        if ($therapist->image_url) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $therapist->image_url));
        }
        $therapist->delete();
        return redirect()->route('admin.therapists.index')->with('success', 'Therapist has been deleted.');
    }
}
