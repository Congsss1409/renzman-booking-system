<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Branch;
use App\Models\Service;
use App\Models\Therapist;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingCancelled;
use App\Mail\BookingConfirmed;
use Illuminate\Support\Facades\Cache;
use App\Events\BookingCreated;
use Illuminate\Support\Str; // Import the Str facade

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        $sortBy = $request->query('sort_by', 'start_time');
        $sortOrder = $request->query('sort_order', 'desc');
        $validSorts = ['client_name', 'service_name', 'therapist_name', 'branch_name', 'start_time', 'status'];
        
        if (!in_array($sortBy, $validSorts)) {
            $sortBy = 'start_time';
        }

        $query = Booking::with(['branch', 'service', 'therapist']);

        switch ($sortBy) {
            case 'service_name':
                $query->join('services', 'bookings.service_id', '=', 'services.id')->orderBy('services.name', $sortOrder);
                break;
            case 'therapist_name':
                $query->join('therapists', 'bookings.therapist_id', '=', 'therapists.id')->orderBy('therapists.name', $sortOrder);
                break;
            case 'branch_name':
                $query->join('branches', 'bookings.branch_id', '=', 'branches.id')->orderBy('branches.name', $sortOrder);
                break;
            default:
                $query->orderBy($sortBy, $sortOrder);
        }

        $bookings = $query->select('bookings.*')->paginate(15);
        
        $branches = Branch::all();
        $services = Service::all();

        return view('admin.dashboard', compact('bookings', 'sortBy', 'sortOrder', 'branches', 'services'));
    }

    public function storeBooking(Request $request)
    {
        $request->session()->flash('show_modal', true);

        $validated = $request->validate([
            'client_name' => 'required|string|max:255',
            'client_email' => 'required|email|max:255',
            'client_phone' => 'required|string|max:20',
            'branch_id' => 'required|exists:branches,id',
            'service_id' => 'required|exists:services,id',
            'therapist_id' => 'required|exists:therapists,id',
            'booking_date' => 'required|date',
            'booking_time' => 'required',
        ]);

        $service = Service::find($validated['service_id']);
        $startTime = Carbon::parse($validated['booking_date'] . ' ' . $validated['booking_time'], 'Asia/Manila');
        $endTime = $startTime->copy()->addMinutes($service->duration);

        $conflictingBooking = Booking::where('therapist_id', $validated['therapist_id'])
            ->where('start_time', '<', $endTime)
            ->where('end_time', '>', $startTime)
            ->where('status', '!=', 'Cancelled')
            ->exists();

        if ($conflictingBooking) {
            return back()->withInput()->withErrors(['booking_time' => 'This time slot is already booked for the selected therapist.']);
        }

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
            'status' => 'Confirmed',
            'payment_status' => 'Pending',
            'payment_method' => 'On-Site',
            'feedback_token' => Str::uuid(), // *** FIX: Generate the missing feedback token ***
        ]);

        Mail::to($booking->client_email)->send(new BookingConfirmed($booking));
        Cache::forget('admin_dashboard_bookings_page_1');
        broadcast(new BookingCreated($booking));

        $request->session()->forget('show_modal');
        return redirect()->route('admin.dashboard')->with('success', 'Booking created successfully!');
    }

    public function cancelBooking(Booking $booking)
    {
        $booking->update(['status' => 'Cancelled']);
        Mail::to($booking->client_email)->send(new BookingCancelled($booking));
        Cache::flush();
        return redirect()->route('admin.dashboard')->with('success', 'Booking cancelled successfully.');
    }

    // --- Therapist Management ---

    public function listTherapists(Request $request)
    {
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');

        $query = Therapist::with('branch');

        if ($sortBy == 'name') {
            $query->orderBy('name', $sortOrder);
        } elseif ($sortBy == 'branch') {
            $query->join('branches', 'therapists.branch_id', '=', 'branches.id')
                  ->orderBy('branches.name', $sortOrder)
                  ->select('therapists.*');
        } else {
            $query->orderBy($sortBy, $sortOrder);
        }

        $therapists = $query->paginate(10);
        return view('admin.therapists', compact('therapists', 'sortBy', 'sortOrder'));
    }

    public function createTherapist()
    {
        $branches = Branch::all();
        return view('admin.create-therapist', compact('branches'));
    }

    public function storeTherapist(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'branch_id' => 'required|exists:branches,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('therapists', 'public');
        }

        Therapist::create([
            'name' => $validated['name'],
            'branch_id' => $validated['branch_id'],
            'image' => $imagePath
        ]);

        return redirect()->route('admin.therapists.index')->with('success', 'Therapist created successfully.');
    }

    public function editTherapist(Therapist $therapist)
    {
        $branches = Branch::all();
        return view('admin.edit-therapist', compact('therapist', 'branches'));
    }

    public function updateTherapist(Request $request, Therapist $therapist)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'branch_id' => 'required|exists:branches,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $imagePath = $therapist->image;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('therapists', 'public');
        }

        $therapist->update([
            'name' => $validated['name'],
            'branch_id' => $validated['branch_id'],
            'image' => $imagePath
        ]);

        return redirect()->route('admin.therapists.index')->with('success', 'Therapist updated successfully.');
    }

    public function destroyTherapist(Therapist $therapist)
    {
        $therapist->delete();
        return redirect()->route('admin.therapists.index')->with('success', 'Therapist deleted successfully.');
    }

    public function getTherapistsByBranch(Branch $branch)
    {
        return $branch->therapists()->orderBy('name')->get();
    }

    // --- Other Admin Functions ---

    public function feedback()
    {
        $feedbacks = Booking::whereNotNull('rating')
            ->with(['service', 'therapist', 'branch'])
            ->latest('start_time')
            ->paginate(10);
        return view('admin.feedback', compact('feedbacks'));
    }

    public function analytics()
    {
        $analyticsData = Cache::remember('admin_analytics_data', now()->addMinutes(10), function () {
            $totalBookings = Booking::count();
            $totalRevenue = Booking::where('status', '!=', 'Cancelled')->sum('price');
            $averageRating = Booking::whereNotNull('rating')->avg('rating');
            $bookingsByMonth = Booking::select(DB::raw('count(id) as `count`'), DB::raw('DATE_FORMAT(start_time, "%Y-%m") as month_year'))->where('start_time', '>', now()->subYear())->groupBy('month_year')->orderBy('month_year', 'asc')->get();
            $servicesBreakdown = Booking::whereNotNull('service_id')->with('service')->select('service_id', DB::raw('count(*) as count'))->groupBy('service_id')->orderBy('count', 'desc')->get();
            $therapistsBreakdown = Booking::whereNotNull('therapist_id')->with('therapist')->select('therapist_id', DB::raw('count(*) as count'))->groupBy('therapist_id')->orderBy('count', 'desc')->get();
            
            return [
                'totalBookings' => $totalBookings,
                'totalRevenue' => $totalRevenue,
                'averageRating' => $averageRating,
                'bookingsByMonthLabels' => $bookingsByMonth->pluck('month_year'),
                'bookingsByMonthData' => $bookingsByMonth->pluck('count'),
                'popularServicesLabels' => $servicesBreakdown->map(fn($item) => $item->service->name ?? 'Unknown'),
                'popularServicesData' => $servicesBreakdown->pluck('count'),
                'busiestTherapistsLabels' => $therapistsBreakdown->map(fn($item) => $item->therapist->name ?? 'Unknown'),
                'busiestTherapistsData' => $therapistsBreakdown->pluck('count'),
            ];
        });
        return view('admin.analytics', $analyticsData);
    }
}

