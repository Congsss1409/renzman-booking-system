<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Therapist;
use App\Models\Branch;
use App\Models\Service;
use App\Mail\BookingCancelled;
use App\Mail\BookingConfirmed;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    /**
     * Get today's booking statistics
     */
    private function getTodaysStats()
    {
        $today = Carbon::today();
        
        return [
            'bookings' => Booking::whereDate('start_time', $today)->count(),
            'revenue' => Booking::whereDate('start_time', $today)->where('status', 'Completed')->sum('price'),
            'completed' => Booking::whereDate('start_time', $today)->where('status', 'Completed')->count(),
            'cancelled' => Booking::whereDate('start_time', $today)->where('status', 'Cancelled')->count(),
            'confirmed' => Booking::whereDate('start_time', $today)->where('status', 'Confirmed')->count(),
            'pending' => Booking::whereDate('start_time', $today)->where('status', 'Pending')->count(),
        ];
    }
    
    /**
     * Get total booking statistics
     */
    private function getTotalStats()
    {        
        return [
            'bookings' => Booking::count(),
            'revenue' => Booking::where('status', 'Completed')->sum('price'),
            'completed' => Booking::where('status', 'Completed')->count(),
            'cancelled' => Booking::where('status', 'Cancelled')->count(),
            'confirmed' => Booking::where('status', 'Confirmed')->count(),
            'pending' => Booking::where('status', 'Pending')->count(),
            'in_progress' => Booking::where('status', 'In Progress')->count(),
        ];
    }
    
    /**
     * Get booking statistics for a specific period
     */
    private function getPeriodStats($startDate, $endDate)
    {        
        return [
            'bookings' => Booking::whereBetween('start_time', [$startDate, $endDate])->count(),
            'revenue' => Booking::whereBetween('start_time', [$startDate, $endDate])->where('status', 'Completed')->sum('price'),
            'completed' => Booking::whereBetween('start_time', [$startDate, $endDate])->where('status', 'Completed')->count(),
            'cancelled' => Booking::whereBetween('start_time', [$startDate, $endDate])->where('status', 'Cancelled')->count(),
        ];
    }

    /**
     * Get booking status breakdown with percentages
     */
    private function getStatusBreakdown()
    {
        $totalBookings = Booking::count();
        
        if ($totalBookings == 0) {
            return [
                'pending' => ['count' => 0, 'percentage' => 0],
                'confirmed' => ['count' => 0, 'percentage' => 0],
                'in_progress' => ['count' => 0, 'percentage' => 0],
                'completed' => ['count' => 0, 'percentage' => 0],
                'cancelled' => ['count' => 0, 'percentage' => 0],
            ];
        }
        
        $statuses = ['Pending', 'Confirmed', 'In Progress', 'Completed', 'Cancelled'];
        $breakdown = [];
        
        foreach ($statuses as $status) {
            $count = Booking::where('status', $status)->count();
            $breakdown[strtolower(str_replace(' ', '_', $status))] = [
                'count' => $count,
                'percentage' => round(($count / $totalBookings) * 100, 1)
            ];
        }
        
        return $breakdown;
    }
    
    /**
     * Get hourly booking distribution for today
     */
    private function getTodayBookingDistribution()
    {
        $today = Carbon::today();
        $hours = [];
        
        for ($hour = 8; $hour <= 20; $hour++) {
            $startHour = $today->copy()->setHour($hour);
            $endHour = $today->copy()->setHour($hour + 1);
            
            $bookingCount = Booking::whereBetween('start_time', [$startHour, $endHour])->count();
            $hours[] = [
                'hour' => $hour . ':00',
                'bookings' => $bookingCount
            ];
        }
        
        return $hours;
    }
    
    /**
     * Get booking trends comparison
     */
    private function getBookingTrends()
    {
        $today = Carbon::today();
        $yesterday = Carbon::yesterday();
        $lastWeek = Carbon::today()->subWeek();
        $lastMonth = Carbon::today()->subMonth();
        
        return [
            'today_vs_yesterday' => [
                'today' => Booking::whereDate('start_time', $today)->count(),
                'yesterday' => Booking::whereDate('start_time', $yesterday)->count(),
            ],
            'this_week_vs_last_week' => [
                'this_week' => Booking::whereBetween('start_time', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count(),
                'last_week' => Booking::whereBetween('start_time', [$lastWeek->startOfWeek(), $lastWeek->endOfWeek()])->count(),
            ],
            'this_month_vs_last_month' => [
                'this_month' => Booking::whereBetween('start_time', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->count(),
                'last_month' => Booking::whereBetween('start_time', [$lastMonth->startOfMonth(), $lastMonth->endOfMonth()])->count(),
            ]
        ];
    }

    private function aggregateOverallMetrics(): array
    {
        $result = Booking::selectRaw(<<<SQL
                COUNT(*) as total_bookings,
                SUM(CASE WHEN status = 'Completed' THEN price ELSE 0 END) as total_revenue,
                SUM(CASE WHEN status = 'Completed' THEN price - COALESCE(cost, 0) ELSE 0 END) as total_profit,
                SUM(CASE WHEN status = 'Completed' THEN 1 ELSE 0 END) as completed_count,
                SUM(CASE WHEN status = 'Cancelled' THEN 1 ELSE 0 END) as cancelled_count,
                SUM(CASE WHEN status = 'Pending' THEN 1 ELSE 0 END) as pending_count,
                SUM(CASE WHEN status = 'Confirmed' THEN 1 ELSE 0 END) as confirmed_count,
                SUM(CASE WHEN status = 'In Progress' THEN 1 ELSE 0 END) as in_progress_count,
                AVG(rating) as average_rating
            SQL)->first();

        return [
            'total_bookings' => (int) ($result->total_bookings ?? 0),
            'total_revenue' => (float) ($result->total_revenue ?? 0),
            'total_profit' => (float) ($result->total_profit ?? 0),
            'completed_count' => (int) ($result->completed_count ?? 0),
            'cancelled_count' => (int) ($result->cancelled_count ?? 0),
            'pending_count' => (int) ($result->pending_count ?? 0),
            'confirmed_count' => (int) ($result->confirmed_count ?? 0),
            'in_progress_count' => (int) ($result->in_progress_count ?? 0),
            'average_rating' => $result && $result->average_rating !== null
                ? round((float) $result->average_rating, 2)
                : null,
        ];
    }

    private function aggregateRangeMetrics(Carbon $start, Carbon $end): array
    {
        $result = Booking::selectRaw(<<<SQL
                COUNT(*) as total,
                SUM(CASE WHEN status = 'Completed' THEN price ELSE 0 END) as revenue,
                SUM(CASE WHEN status = 'Completed' THEN 1 ELSE 0 END) as completed,
                SUM(CASE WHEN status = 'Cancelled' THEN 1 ELSE 0 END) as cancelled
            SQL)
            ->whereBetween('start_time', [$start, $end])
            ->first();

        return [
            'total' => (int) ($result->total ?? 0),
            'revenue' => (float) ($result->revenue ?? 0),
            'completed' => (int) ($result->completed ?? 0),
            'cancelled' => (int) ($result->cancelled ?? 0),
        ];
    }

    private function getCachedDashboardMetrics(): array
    {
        return Cache::remember('dashboard:metrics', now()->addSeconds(60), function () {
            $now = Carbon::now();

            return [
                'overall' => $this->aggregateOverallMetrics(),
                'today' => $this->aggregateRangeMetrics($now->copy()->startOfDay(), $now->copy()->endOfDay()),
                'week' => $this->aggregateRangeMetrics($now->copy()->startOfWeek(), $now->copy()->endOfWeek()),
                'month' => $this->aggregateRangeMetrics($now->copy()->startOfMonth(), $now->copy()->endOfMonth()),
            ];
        });
    }

    /**
     * Display the admin dashboard with statistics and booking management.
     */
    public function dashboard(Request $request)
    {
        // --- Dashboard Stats (always fresh) ---
        $topServices = Service::withCount(['bookings' => function ($query) {
            $query->where('status', '!=', 'Cancelled');
        }])->orderBy('bookings_count', 'desc')->take(5)->get();

        $topTherapists = Therapist::withCount(['bookings' => function ($query) {
            $query->where('status', '!=', 'Cancelled');
        }])->orderBy('bookings_count', 'desc')->with('branch')->take(5)->get();

            // Monthly revenue filter

        $month = $request->input('month', Carbon::now()->month);
        $year = $request->input('year', Carbon::now()->year);
        $monthlyRevenue = Booking::where('status', 'Completed')
            ->whereMonth('start_time', $month)
            ->whereYear('start_time', $year)
            ->sum('price');

        // Previous month/year calculation
        $prevMonth = $month - 1;
        $prevYear = $year;
        if ($prevMonth < 1) {
            $prevMonth = 12;
            $prevYear = $year - 1;
        }
        $prevMonthlyRevenue = Booking::where('status', 'Completed')
            ->whereMonth('start_time', $prevMonth)
            ->whereYear('start_time', $prevYear)
            ->sum('price');

        $metrics = $this->getCachedDashboardMetrics();
        $overall = $metrics['overall'];
        $todayMetrics = $metrics['today'];
        $weekMetrics = $metrics['week'];
        $monthMetrics = $metrics['month'];

        $totalRevenue = $overall['total_revenue'];
        $totalProfit = $overall['total_profit'];
        $totalCancellations = $overall['cancelled_count'];
        $totalCompleted = $overall['completed_count'];

        $todaysBookings = $todayMetrics['total'];
        $todaysRevenue = $todayMetrics['revenue'];
        $todaysCancellations = $todayMetrics['cancelled'];
        $todaysCompleted = $todayMetrics['completed'];

        $weeklyBookings = $weekMetrics['total'];
        $weeklyRevenue = $weekMetrics['revenue'];

        $currentMonthBookings = $monthMetrics['total'];
        $currentMonthRevenue = $monthMetrics['revenue'];

        $statusCounts = [
            'pending' => $overall['pending_count'],
            'confirmed' => $overall['confirmed_count'],
            'in_progress' => $overall['in_progress_count'],
            'completed' => $overall['completed_count'],
            'cancelled' => $overall['cancelled_count'],
        ];

        $stats = [
            'selectedMonth' => $month,
            'selectedYear' => $year,
            'monthlyRevenue' => $monthlyRevenue,
            'prevMonth' => $prevMonth,
            'prevYear' => $prevYear,
            'prevMonthlyRevenue' => $prevMonthlyRevenue,
            
            // Today's Statistics
            'todaysBookings' => $todaysBookings,
            'todaysRevenue' => $todaysRevenue,
            'todaysCancellations' => $todaysCancellations,
            'todaysCompleted' => $todaysCompleted,
            
            // Weekly Statistics
            'weeklyBookings' => $weeklyBookings,
            'weeklyRevenue' => $weeklyRevenue,
            
            // Monthly Statistics (current month)
            'currentMonthBookings' => $currentMonthBookings,
            'currentMonthRevenue' => $currentMonthRevenue,
            
            // Total Statistics
            'totalBookings' => $overall['total_bookings'],
            'totalRevenue' => $totalRevenue,
            'totalProfit' => $totalProfit,
            'totalCancellations' => $totalCancellations,
            'totalCompleted' => $totalCompleted,
            
            // Status Breakdown
            'statusCounts' => $statusCounts,
            'pendingBookings' => $statusCounts['pending'],
            'confirmedBookings' => $statusCounts['confirmed'],
            'inProgressBookings' => $statusCounts['in_progress'],
            'completedBookings' => $statusCounts['completed'],
            'cancelledBookings' => $statusCounts['cancelled'],
            
            // Additional Metrics
            'averageRating' => $overall['average_rating'],
            'completionRate' => $overall['total_bookings'] > 0
                ? round(($totalCompleted / $overall['total_bookings']) * 100, 1)
                : 0,
            'cancellationRate' => $overall['total_bookings'] > 0
                ? round(($totalCancellations / $overall['total_bookings']) * 100, 1)
                : 0,
            
            // Charts Data
            'topServices' => $topServices,
            'topServicesLabels' => $topServices->pluck('name'),
            'topServicesData' => $topServices->pluck('bookings_count'),
            'topTherapists' => $topTherapists,
        ];

        // --- All Bookings Query (this part is dynamic and not cached) ---
        $query = Booking::with(['service', 'therapist', 'branch']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('client_name', 'like', "%{$search}%")
                  ->orWhere('client_phone', 'like', "%{$search}%")
                  ->orWhereHas('therapist', fn($q) => $q->where('name', 'like', "%{$search}%"))
                  ->orWhereHas('service', fn($q) => $q->where('name', 'like', "%{$search}%"));
            });
        }

        // Sorting functionality
    $sortBy = $request->input('sort_by', 'start_time');
    $sortOrder = $request->input('sort_order', 'desc');
        $validSortColumns = ['client_name', 'start_time', 'status', 'created_at', 'updated_at'];
        if (in_array($sortBy, $validSortColumns)) {
            $query->orderBy($sortBy, $sortOrder);
        } else {
            // Default: newest to oldest by start_time
            $query->orderBy('start_time', 'desc');
        }

        $bookings = $query->paginate(15)->withQueryString();

        $branches = Branch::orderBy('name')->get();
        $services = Service::orderBy('name')->get();

        // Data for the date picker in the modal
        $manilaTime = Carbon::now('Asia/Manila');
        $todayForJs = [
            'year' => $manilaTime->year,
            'month' => $manilaTime->month - 1, // JS months are 0-indexed
            'day' => $manilaTime->day
        ];

        $viewData = array_merge($stats, [
            'bookings' => $bookings,
            'branches' => $branches,
            'services' => $services,
            'todayForJs' => $todayForJs,
        ]);

        return view('admin.dashboard', $viewData);
    }
    
    /**
     * Store a new booking and send a confirmation email.
     */
    public function storeBooking(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'client_name' => 'required|string|max:255',
            'client_phone' => 'required|digits:11',
            'client_email' => 'required|email|max:255',
            'branch_id' => 'required|exists:branches,id',
            'service_id' => 'required|exists:services,id',
            'therapist_id' => 'required|exists:therapists,id',
            'booking_date' => 'required|date',
            'booking_time' => 'required|string',
            'extended_session' => 'nullable|boolean',
        ], [
            'client_phone.required' => 'Phone number is required.',
            'client_phone.digits' => 'Phone number must be exactly 11 digits.',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.dashboard')
                ->withErrors($validator, 'bookingCreation')
                ->withInput();
        }

        $service = Service::find($request->service_id);
        $startTime = Carbon::parse($request->booking_date . ' ' . $request->booking_time, 'Asia/Manila');
        
        $isExtended = $request->boolean('extended_session');
        $durationInMinutes = $service->duration + ($isExtended ? 60 : 0);
        $endTime = $startTime->copy()->addMinutes($durationInMinutes);

        $extensionPrice = 500;
        $finalPrice = $service->price + ($isExtended ? $extensionPrice : 0);

        $booking = Booking::create([
            'client_name' => $request->client_name,
            'client_phone' => $request->client_phone,
            'client_email' => $request->client_email,
            'branch_id' => $request->branch_id,
            'service_id' => $request->service_id,
            'therapist_id' => $request->therapist_id,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'price' => $finalPrice,
            'status' => 'Confirmed',
        ]);

        // Send confirmation email if an email address is provided
        if ($booking->client_email) {
            try {
                Mail::to($booking->client_email)->send(new BookingConfirmed($booking));
                return redirect()->route('admin.dashboard')->with('success', 'Appointment created and confirmation email sent!');
            } catch (\Exception $e) {
                Log::error("Failed to send confirmation email for booking {$booking->id}: " . $e->getMessage());
                return redirect()->route('admin.dashboard')->with('success', 'Appointment created, but failed to send the email notification.');
            }
        }

        return redirect()->route('admin.dashboard')->with('success', 'Appointment created successfully!');
    }
    
    /**
     * Cancel a booking and send a notification email.
     */
    public function cancelBooking(Booking $booking)
    {
        $booking->update(['status' => 'Cancelled']);

        if ($booking->client_email) {
            try {
                Mail::to($booking->client_email)->send(new BookingCancelled($booking));
            } catch (\Exception $e) {
                Log::error("Failed to send cancellation email for booking {$booking->id}: " . $e->getMessage());
                return back()->with('success', 'Booking cancelled, but failed to send email notification.');
            }
        }

        return back()->with('success', 'Booking has been cancelled and a notification has been sent.');
    }

    /**
     * Get therapists for a specific branch (for AJAX in modal).
     */
    public function getTherapistsByBranch(Branch $branch)
    {
        $therapists = $branch->therapists()->orderBy('name')->get()->map(function ($therapist) {
            if ($therapist->image_url) {
                // If the image_url looks like an absolute URL, leave it as-is; otherwise prefix with storage asset
                if (preg_match('/^https?:\/\//', $therapist->image_url)) {
                    // absolute URL already
                    $therapist->image_url = $therapist->image_url;
                } else {
                    $therapist->image_url = asset('storage/' . ltrim($therapist->image_url, '/'));
                }
            }
            return $therapist;
        });
        return response()->json($therapists);
    }

    /**
     * Display the feedback management page.
     */
    public function feedback()
    {
        $feedbacks = Booking::whereNotNull('feedback')->with('therapist', 'service')->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.feedback', compact('feedbacks'));
    }

    /**
     * Toggle the display of feedback on the landing page.
     */
    public function toggleFeedbackDisplay(Booking $booking)
    {
        $booking->update(['show_on_landing' => !$booking->show_on_landing]);
        return back()->with('success', 'Feedback display status updated successfully.');
    }
}

