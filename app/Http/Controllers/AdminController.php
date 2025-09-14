<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Branch;
use App\Models\Service;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingCancelled;
use App\Mail\BookingConfirmed;
use Illuminate\Support\Facades\Cache;
use App\Events\BookingCreated;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        $dashboardData = Cache::remember('admin_dashboard_data', now()->addMinutes(10), function () {
            // Data for Stat Cards
            $totalRevenue = Booking::where('status', '!=', 'Cancelled')->sum('price');
            $totalBookings = Booking::count();
            $todaysBookings = Booking::whereDate('start_time', Carbon::today())->count();
            $averageRating = Booking::whereNotNull('rating')->avg('rating');

            // Data for Charts
            $bookingsByMonth = Booking::select(DB::raw('count(id) as `count`'), DB::raw('DATE_FORMAT(start_time, "%Y-%m") as month_year'))
                ->where('start_time', '>', now()->subYear())
                ->groupBy('month_year')
                ->orderBy('month_year', 'asc')
                ->get();

            $servicesBreakdown = Booking::whereNotNull('service_id')->with('service')
                ->select('service_id', DB::raw('count(*) as count'))
                ->groupBy('service_id')
                ->orderBy('count', 'desc')
                ->take(5)
                ->get();

            $therapistsBreakdown = Booking::whereNotNull('therapist_id')->with('therapist')
                ->select('therapist_id', DB::raw('count(*) as count'))
                ->groupBy('therapist_id')
                ->orderBy('count', 'desc')
                ->take(5)
                ->get();

            return [
                'totalRevenue' => $totalRevenue,
                'totalBookings' => $totalBookings,
                'todaysBookings' => $todaysBookings,
                'averageRating' => $averageRating,
                'bookingsByMonthLabels' => $bookingsByMonth->pluck('month_year'),
                'bookingsByMonthData' => $bookingsByMonth->pluck('count'),
                'popularServicesLabels' => $servicesBreakdown->map(fn($item) => $item->service->name ?? 'Unknown'),
                'popularServicesData' => $servicesBreakdown->pluck('count'),
                'busiestTherapistsLabels' => $therapistsBreakdown->map(fn($item) => $item->therapist->name ?? 'Unknown'),
                'busiestTherapistsData' => $therapistsBreakdown->pluck('count'),
            ];
        });

        $bookings = Booking::with(['branch', 'service', 'therapist'])->latest('start_time')->paginate(5);

        $branches = Branch::all();
        $services = Service::all();

        return view('admin.dashboard', compact('bookings', 'branches', 'services', 'dashboardData'));
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
            'feedback_token' => Str::uuid(),
        ]);

        Mail::to($booking->client_email)->send(new BookingConfirmed($booking));
        Cache::forget('admin_dashboard_data');
        broadcast(new BookingCreated($booking));

        $request->session()->forget('show_modal');
        return redirect()->route('admin.dashboard')->with('success', 'Booking created successfully!');
    }

    public function cancelBooking(Booking $booking)
    {
        $booking->update(['status' => 'Cancelled']);
        Mail::to($booking->client_email)->send(new BookingCancelled($booking));
        Cache::forget('admin_dashboard_data');
        return redirect()->route('admin.dashboard')->with('success', 'Booking cancelled successfully.');
    }

    public function getTherapistsByBranch(Branch $branch)
    {
        return $branch->therapists()->orderBy('name')->get();
    }

    public function feedback()
    {
        $feedbacks = Booking::whereNotNull('rating')
            ->with(['service', 'therapist', 'branch'])
            ->latest('start_time')
            ->paginate(10);
        return view('admin.feedback', compact('feedbacks'));
    }

    public function toggleFeedbackDisplay(Booking $booking)
    {
        if ($booking->rating == 5 && !empty($booking->feedback)) {
            $booking->update(['show_on_landing' => !$booking->show_on_landing]);
            Cache::forget('landing_page_testimonials'); // Invalidate cache
            return back()->with('success', 'Testimonial display status updated.');
        }

        return back()->with('error', 'Only 5-star reviews with feedback can be featured.');
    }
}

