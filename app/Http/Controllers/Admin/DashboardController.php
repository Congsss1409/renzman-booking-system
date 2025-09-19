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
     * Display the admin dashboard with statistics and booking management.
     */
    public function dashboard(Request $request)
    {
        // --- Dashboard Stats (can be cached for performance) ---
        $stats = Cache::remember('admin_dashboard_stats', now()->addMinutes(5), function () {
            return [
                'todaysBookings' => Booking::whereDate('start_time', Carbon::today())->count(),
                'totalBookings' => Booking::count(),
                'totalRevenue' => Booking::where('status', '!=', 'Cancelled')->sum('price'),
                'averageRating' => Booking::whereNotNull('rating')->avg('rating'),
                'sourceLabels' => Booking::select('payment_method', DB::raw('count(*) as count'))->whereNotNull('payment_method')->groupBy('payment_method')->get()->pluck('payment_method'),
                'sourceData' => Booking::select('payment_method', DB::raw('count(*) as count'))->whereNotNull('payment_method')->groupBy('payment_method')->get()->pluck('count'),
                'topTherapists' => Therapist::withCount(['bookings' => function ($query) {
                    $query->where('status', '!=', 'Cancelled');
                }])->orderBy('bookings_count', 'desc')->with('branch')->take(5)->get(),
            ];
        });

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
        }

        $bookings = $query->paginate(10)->withQueryString();

        $branches = Branch::orderBy('name')->get();
        $services = Service::orderBy('name')->get();

        $viewData = array_merge($stats, [
            'bookings' => $bookings,
            'branches' => $branches,
            'services' => $services,
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
            'client_phone' => 'required|string|max:20',
            'client_email' => 'nullable|email|max:255',
            'branch_id' => 'required|exists:branches,id',
            'service_id' => 'required|exists:services,id',
            'therapist_id' => 'required|exists:therapists,id',
            'start_time' => ['required', 'date', function ($attribute, $value, $fail) {
                $now = Carbon::now('Asia/Manila');
                $bookingTime = Carbon::parse($value, 'Asia/Manila');
                $mallOpen = $bookingTime->copy()->setTime(8, 0); // 8:00 AM
                $mallClose = $bookingTime->copy()->setTime(21, 0); // 9:00 PM

                if ($bookingTime->isPast()) {
                    $fail('Booking time must be in the future.');
                    return;
                }
                if ($bookingTime->lt($mallOpen) || $bookingTime->gt($mallClose)) {
                    $fail('Booking must be within mall hours (8:00 AM - 9:00 PM).');
                    return;
                }
                if ($bookingTime->isToday() && $bookingTime->diffInMinutes($now) < 30) {
                     $fail('Bookings for today must be made at least 30 minutes in advance.');
                }
            }],
            'payment_method' => 'required|string|in:On-Site,GCash,Maya',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.dashboard')
                ->withErrors($validator, 'bookingCreation')
                ->withInput();
        }

        $service = Service::find($request->service_id);
        $startTime = Carbon::parse($request->start_time);
        $endTime = $startTime->copy()->addMinutes($service->duration);

        $booking = Booking::create([
            'client_name' => $request->client_name,
            'client_phone' => $request->client_phone,
            'client_email' => $request->client_email,
            'branch_id' => $request->branch_id,
            'service_id' => $request->service_id,
            'therapist_id' => $request->therapist_id,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'price' => $service->price,
            'status' => 'Confirmed',
            'payment_method' => $request->payment_method,
            'payment_status' => 'Pending',
            'downpayment_amount' => 0,
            'remaining_balance' => $service->price,
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
        return response()->json($branch->therapists()->orderBy('name')->get());
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

