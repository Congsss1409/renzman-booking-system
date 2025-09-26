<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TimeSlotController extends Controller
{
    /**
     * Get available time slots for a specific date, branch, and service
     */
    public function available(Request $request)
    {
        $request->validate([
            'date' => 'required|date_format:Y-m-d',
            'branch_id' => 'required|exists:branches,id',
            'service_id' => 'required|exists:services,id',
            'therapist_id' => 'nullable|exists:therapists,id'
        ]);

        $date = Carbon::parse($request->date);
        $branch = Branch::findOrFail($request->branch_id);
        $service = Service::findOrFail($request->service_id);

        // Business hours
        $openingTime = Carbon::parse('08:00');
        $closingTime = Carbon::parse('21:00');

        $slots = [];
        $currentTime = $openingTime->copy();

        while ($currentTime <= $closingTime) {
            // Skip if the time is in the past
            if ($date->isToday() && $currentTime->isPast()) {
                $currentTime->addHour();
                continue;
            }

            // Check if there's at least one available therapist for this time slot
            $hasAvailableTherapist = true;
            if ($request->therapist_id) {
                $hasAvailableTherapist = !$branch->bookings()
                    ->where('therapist_id', $request->therapist_id)
                    ->whereDate('booking_date', $date)
                    ->where(function($query) use ($currentTime) {
                        $query->where(function($q) use ($currentTime) {
                            $q->where('booking_time', '<=', $currentTime->format('H:i'))
                              ->where('end_time', '>', $currentTime->format('H:i'));
                        })->orWhere(function($q) use ($currentTime) {
                            $q->where('booking_time', '<', $currentTime->copy()->addHour()->format('H:i'))
                              ->where('end_time', '>=', $currentTime->copy()->addHour()->format('H:i'));
                        });
                    })
                    ->exists();
            }

            if ($hasAvailableTherapist) {
                $slots[] = $currentTime->format('H:i');
            }

            $currentTime->addHour();
        }

        return response()->json($slots);
    }
}