<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Branch;
use App\Models\Service;
use App\Models\Therapist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Mail\BookingCancelled;
use App\Mail\BookingConfirmed;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use App\Events\BookingCreated;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function dashboard()
    {
        $bookings = Booking::with(['service', 'therapist', 'branch'])
            ->orderBy('start_time', 'desc') 
            ->paginate(15); 
            
        return view('admin.dashboard', compact('bookings'));
    }

    /**
     * Cancel a booking.
     */
    public function cancelBooking(Booking $booking)
    {
        $booking->update(['status' => 'Cancelled']);
        
        Mail::to($booking->client_email)->send(new BookingCancelled($booking));

        return redirect()->route('admin.dashboard')->with('success', 'Booking cancelled successfully.');
    }

    /**
     * Show the form for creating a new booking.
     */
    public function createBooking()
    {
        $branches = Branch::all();
        $services = Service::all();
        // Therapists will be loaded dynamically via JavaScript
        return view('admin.create-booking', compact('branches', 'services'));
    }

    /**
     * Store a newly created booking in storage.
     */
    public function storeBooking(Request $request)
    {
        // *** FIX: Added full validation and creation logic ***
        $validated = $request->validate([
            'client_name' => 'required|string|max:255',
            'client_email' => 'required|email|max:255',
            'client_phone' => 'required|string|max:20',
            'branch_id' => 'required|exists:branches,id',
            'service_id' => 'required|exists:services,id',
            'therapist_id' => 'required|exists:therapists,id',
            'booking_date' => 'required|date|after_or_equal:today',
            'booking_time' => 'required',
        ]);

        $service = Service::find($validated['service_id']);
        $startTime = Carbon::parse($validated['booking_date'] . ' ' . $validated['booking_time']);
        $endTime = $startTime->copy()->addMinutes($service->duration);

        // Prevent double-booking
        $existingBooking = Booking::where('therapist_id', $validated['therapist_id'])
            ->where('status', '!=', 'Cancelled')
            ->where(function ($query) use ($startTime, $endTime) {
                $query->where(function ($q) use ($startTime, $endTime) {
                    $q->where('start_time', '<', $endTime)
                      ->where('end_time', '>', $startTime);
                });
            })->exists();

        if ($existingBooking) {
            throw ValidationException::withMessages([
                'booking_time' => 'This therapist is already booked for the selected date and time. Please choose another slot.',
            ]);
        }

        // Create the booking
        $booking = Booking::create([
            'client_name' => $validated['client_name'],
            'client_email' => $validated['client_email'],
            'client_phone' => $validated['client_phone'],
            'branch_id' => $validated['branch_id'],
            'service_id' => $validated['service_id'],
            'therapist_id' => $validated['therapist_id'],
            'start_time' => $startTime,
            'end_time' => $endTime,
            'price' => $service->price,
            'payment_method' => 'On-Site', // Default for admin bookings
            'payment_status' => 'Pending',  // Default for admin bookings
            'status' => 'Confirmed',
            'feedback_token' => \Illuminate\Support\Str::uuid(),
        ]);

        // Send confirmation email to the client
        Mail::to($booking->client_email)->send(new BookingConfirmed($booking));
        
        // Broadcast for real-time dashboard updates
        broadcast(new BookingCreated($booking))->toOthers();

        return redirect()->route('admin.dashboard')->with('success', 'Booking created successfully.');
    }

    /**
     * Show the form for editing the specified booking.
     */
    public function editBooking(Booking $booking)
    {
        $branches = Branch::all();
        $services = Service::all();
        $therapists = Therapist::all();
        return view('admin.edit-booking', compact('booking', 'branches', 'services', 'therapists'));
    }

    /**
     * Update the specified booking in storage.
     */
    public function updateBooking(Request $request, Booking $booking)
    {
        // Validation and booking update logic here...
        return redirect()->route('admin.dashboard')->with('success', 'Booking updated successfully.');
    }

    /**
     * Get therapists by branch for AJAX calls.
     */
    public function getTherapistsByBranch(Branch $branch)
    {
        return response()->json($branch->therapists);
    }

    /**
     * Display customer feedback.
     */
    public function feedback()
    {
        $feedbacks = Booking::whereNotNull('rating')->with('therapist', 'service', 'branch')->paginate(10);
        return view('admin.feedback', compact('feedbacks'));
    }

    /**
     * Display analytics.
     */
    public function analytics()
    {
        $totalBookings = Booking::count();
        $totalRevenue = Booking::where('status', '!=', 'Cancelled')->sum('price');
        $averageRating = Booking::whereNotNull('rating')->avg('rating');

        $bookingsPerMonth = Booking::select(
            DB::raw('count(id) as `count`'),
            DB::raw('DATE_FORMAT(start_time, "%Y-%m") as month_year')
        )
        ->where('start_time', '>', Carbon::now()->subYear())
        ->groupBy('month_year')
        ->orderBy('month_year', 'asc')
        ->get();
        
        $servicesBreakdown = Booking::with('service')
            ->select('service_id', DB::raw('count(*) as count'))
            ->whereNotNull('service_id')
            ->groupBy('service_id')
            ->orderBy('count', 'desc')
            ->get();

        $popularServicesLabels = $servicesBreakdown->map(function ($breakdown) {
            return $breakdown->service->name ?? 'Unknown Service';
        });
        $popularServicesData = $servicesBreakdown->pluck('count');

        $busiestTherapists = Booking::with('therapist')
            ->select('therapist_id', DB::raw('count(*) as count'))
            ->whereNotNull('therapist_id')
            ->groupBy('therapist_id')
            ->orderBy('count', 'desc')
            ->limit(10)
            ->get();
            
        $busiestTherapistsLabels = $busiestTherapists->map(function ($breakdown) {
            return $breakdown->therapist->name ?? 'Unknown Therapist';
        });
        $busiestTherapistsData = $busiestTherapists->pluck('count');

        return view('admin.analytics', compact(
            'totalBookings',
            'totalRevenue',
            'averageRating',
            'bookingsPerMonth',
            'popularServicesLabels',
            'popularServicesData',
            'busiestTherapistsLabels',
            'busiestTherapistsData'
        ));
    }

    /**
     * Display a listing of the therapists.
     */
    public function listTherapists(Request $request)
    {
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $validSortBys = ['name', 'branch'];
    
        if (!in_array($sortBy, $validSortBys)) {
            $sortBy = 'created_at';
        }
    
        $therapistsQuery = Therapist::with('branch');
    
        if ($sortBy === 'branch') {
            $therapistsQuery->join('branches', 'therapists.branch_id', '=', 'branches.id')
                            ->orderBy('branches.name', 'asc')
                            ->select('therapists.*');
        } else {
            $therapistsQuery->orderBy($sortBy, $sortOrder);
        }
    
        $therapists = $therapistsQuery->paginate(10);
    
        return view('admin.therapists', compact('therapists', 'sortBy', 'sortOrder'));
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

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('therapists', 'public');
        }

        Therapist::create([
            'name' => $validated['name'],
            'branch_id' => $validated['branch_id'],
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.therapists.index')->with('success', 'Therapist created successfully.');
    }

    /**
     * Show the form for editing the specified therapist.
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

        $imagePath = $therapist->image;
        if ($request->hasFile('image')) {
            if ($imagePath) {
                Storage::disk('public')->delete($imagePath);
            }
            $imagePath = $request->file('image')->store('therapists', 'public');
        }

        $therapist->update([
            'name' => $validated['name'],
            'branch_id' => $validated['branch_id'],
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.therapists.index')->with('success', 'Therapist updated successfully.');
    }

    /**
     * Remove the specified therapist from storage.
     */
    public function destroyTherapist(Therapist $therapist)
    {
        if (auth()->user()->role !== 'owner') {
            return redirect()->route('admin.therapists.index')->with('error', 'You do not have permission to delete therapists.');
        }

        if ($therapist->image) {
            Storage::disk('public')->delete($therapist->image);
        }

        $therapist->delete();

        return redirect()->route('admin.therapists.index')->with('success', 'Therapist deleted successfully.');
    }
}

