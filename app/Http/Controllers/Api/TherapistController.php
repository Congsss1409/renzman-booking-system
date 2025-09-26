<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Therapist;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TherapistController extends Controller
{
    /**
     * Get available therapists for a specific branch and date/time
     */
    public function available(Request $request, Branch $branch)
    {
        $request->validate([
            'date' => 'required|date_format:Y-m-d',
            'time' => 'required|date_format:H:i',
            'service_id' => 'required|exists:services,id'
        ]);

        $dateTime = Carbon::parse($request->date . ' ' . $request->time);

        // Get all therapists from the branch
        $therapists = Therapist::where('branch_id', $branch->id)
            ->where('status', 'active')
            ->with(['bookings' => function($query) use ($dateTime) {
                // Get bookings that might conflict with the requested time
                $query->whereDate('booking_date', $dateTime->toDateString())
                    ->where(function($q) use ($dateTime) {
                        $q->where(function($q) use ($dateTime) {
                            // Check if booking start time overlaps
                            $q->where('booking_time', '<=', $dateTime->format('H:i'))
                               ->where('end_time', '>', $dateTime->format('H:i'));
                        })->orWhere(function($q) use ($dateTime) {
                            // Check if booking end time overlaps
                            $q->where('booking_time', '<', $dateTime->copy()->addHour()->format('H:i'))
                               ->where('end_time', '>=', $dateTime->copy()->addHour()->format('H:i'));
                        });
                    });
            }])
            ->get();

        // Filter out therapists who already have bookings at the requested time
        $availableTherapists = $therapists->filter(function($therapist) {
            return $therapist->bookings->isEmpty();
        })->values();

        return response()->json($availableTherapists);
    }
}