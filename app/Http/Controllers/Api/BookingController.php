<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Events\BookingCreated;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    /**
     * Store a new booking
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'service_id' => 'required|exists:services,id',
            'therapist_id' => 'required|exists:therapists,id',
            'booking_date' => 'required|date_format:Y-m-d',
            'booking_time' => 'required|date_format:H:i',
            'client_name' => 'required|string|max:255',
            'client_email' => 'nullable|email|max:255',
            'client_phone' => 'required|string|max:20',
            'extended_session' => 'boolean'
        ]);

        try {
            DB::beginTransaction();

            // Calculate end time based on service duration and extended session
            $startTime = Carbon::parse($validated['booking_time']);
            $endTime = $startTime->copy()->addHour(); // Base 1 hour
            if ($validated['extended_session'] ?? false) {
                $endTime->addHour(); // Add another hour for extended session
            }

            // Check if therapist is available
            $conflictingBooking = Booking::where('therapist_id', $validated['therapist_id'])
                ->whereDate('booking_date', $validated['booking_date'])
                ->where(function($query) use ($startTime, $endTime) {
                    $query->where(function($q) use ($startTime) {
                        $q->where('booking_time', '<=', $startTime->format('H:i'))
                          ->where('end_time', '>', $startTime->format('H:i'));
                    })->orWhere(function($q) use ($endTime) {
                        $q->where('booking_time', '<', $endTime->format('H:i'))
                          ->where('end_time', '>=', $endTime->format('H:i'));
                    });
                })
                ->exists();

            if ($conflictingBooking) {
                DB::rollBack();
                return response()->json([
                    'message' => 'The selected time slot is no longer available.'
                ], 422);
            }

            $booking = Booking::create([
                'branch_id' => $validated['branch_id'],
                'service_id' => $validated['service_id'],
                'therapist_id' => $validated['therapist_id'],
                'booking_date' => $validated['booking_date'],
                'booking_time' => $validated['booking_time'],
                'end_time' => $endTime->format('H:i'),
                'client_name' => $validated['client_name'],
                'client_email' => $validated['client_email'],
                'client_phone' => $validated['client_phone'],
                'extended_session' => $validated['extended_session'] ?? false,
                'status' => 'pending'
            ]);

            DB::commit();

            // Fire booking created event
            event(new BookingCreated($booking));

            return response()->json([
                'message' => 'Booking created successfully',
                'booking' => $booking
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'An error occurred while creating the booking.'
            ], 500);
        }
    }
}