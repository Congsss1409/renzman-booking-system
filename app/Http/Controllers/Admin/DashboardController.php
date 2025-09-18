<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Branch;
use App\Models\Service;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingConfirmed;
use App\Mail\BookingCancelled;
use App\Events\BookingCreated;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function dashboard(Request $request)
    {
        $dashboardData = Cache::remember('admin_dashboard_full_stats', now()->addMinutes(10), function () {
            // Stats for the main cards
            $totalBookings = Booking::count();
            $completedBookings = Booking::where('status', 'Completed')->orWhere(function ($query) {
                $query->where('status', 'Confirmed')->where('end_time', '<', now());
            })->count();
            $pendingBookings = Booking::where('status', 'Confirmed')->where('start_time', '>=', now())->count();
            $canceledBookings = Booking::where('status', 'Cancelled')->count();

            // Data for Income Chart (last 6 months)
            $incomeByMonth = Booking::select(
                DB::raw('SUM(price) as total'),
                DB::raw("DATE_FORMAT(start_time, '%b') as month")
            )
            ->where('status', '!=', 'Cancelled')
            ->where('start_time', '>=', Carbon::now()->subMonths(5)->startOfMonth())
            ->groupBy('month')
            ->orderBy('start_time')
            ->get();

            // Data for Booking Source Chart
            $bookingSources = Booking::select('payment_method', DB::raw('count(*) as count'))
                ->groupBy('payment_method')
                ->get();
            
            // Recent Bookings
            $recentBookings = Booking::with(['service', 'therapist', 'branch'])
                ->latest('start_time')
                ->take(5)
                ->get();

            // Top Therapists
            $topTherapists = \App\Models\Therapist::withCount(['bookings' => function ($query) {
                    $query->where('status', '!=', 'Cancelled');
                }])
                ->orderBy('bookings_count', 'desc')
                ->take(5)
                ->get();

            return [
                'totalBookings' => $totalBookings,
                'completedBookings' => $completedBookings,
                'pendingBookings' => $pendingBookings,
                'canceledBookings' => $canceledBookings,
                'incomeLabels' => $incomeByMonth->pluck('month'),
                'incomeData' => $incomeByMonth->pluck('total'),
                'sourceLabels' => $bookingSources->pluck('payment_method'),
                'sourceData' => $bookingSources->pluck('count'),
                'recentBookings' => $recentBookings,
                'topTherapists' => $topTherapists,
            ];
        });

        return view('admin.dashboard', $dashboardData);
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
     * Store a newly created booking in storage.
     */
    public function storeBooking(Request $request)
    {
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
            'feedback_token' => Str::uuid(),
        ]);

        Mail::to($booking->client_email)->send(new BookingConfirmed($booking));
        Cache::forget('admin_dashboard_full_stats');
        broadcast(new BookingCreated($booking));

        return redirect()->route('admin.dashboard')->with('success', 'Booking created successfully!');
    }

    /**
     * Cancel the specified booking.
     */
    public function cancelBooking(Booking $booking)
    {
        $booking->update(['status' => 'Cancelled']);
        Mail::to($booking->client_email)->send(new BookingCancelled($booking));
        Cache::forget('admin_dashboard_full_stats');
        return redirect()->route('admin.dashboard')->with('success', 'Booking cancelled successfully.');
    }

    /**
     * Get therapists for a specific branch (for AJAX calls).
     */
    public function getTherapistsByBranch(Branch $branch)
    {
        return $branch->therapists()->orderBy('name')->get();
    }

    /**
     * Display a listing of the feedback.
     */
    public function feedback()
    {
        $feedbacks = Booking::whereNotNull('rating')
            ->with(['service', 'therapist', 'branch'])
            ->latest('start_time')
            ->paginate(10);
        return view('admin.feedback', compact('feedbacks'));
    }

    /**
     * Toggle the display status of a testimonial.
     */
    public function toggleFeedbackDisplay(Booking $booking)
    {
        if ($booking->rating == 5 && !empty($booking->feedback)) {
            $booking->update(['show_on_landing' => !$booking->show_on_landing]);
            Cache::forget('landing_page_testimonials');
            return back()->with('success', 'Testimonial display status updated.');
        }

        return back()->with('error', 'Only 5-star reviews with feedback can be featured.');
    }
}