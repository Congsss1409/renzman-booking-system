<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Booking;
use App\Models\Therapist;
use App\Events\TherapistStatusUpdated;
use Carbon\Carbon;

class UpdateTherapistLiveStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'therapists:update-live-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks for recently started or ended bookings and broadcasts therapist status changes.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking for therapist status changes...');
        $now = Carbon::now('Asia/Manila');

        // Find therapists whose bookings just started in the last minute
        $startingBookings = Booking::where('status', 'Confirmed')
            ->where('start_time', '<=', $now)
            ->where('start_time', '>', $now->copy()->subMinute())
            ->with('therapist') // Eager load therapist to prevent extra queries
            ->get();

        foreach ($startingBookings as $booking) {
            if ($booking->therapist) {
                $availableAt = Carbon::parse($booking->end_time)->format('h:i A');
                broadcast(new TherapistStatusUpdated($booking->therapist->id, 'In Session', $availableAt));
                $this->info("Broadcasted 'In Session' for Therapist #{$booking->therapist->id}");
            }
        }

        // Find therapists whose bookings just ended in the last minute
        $endingBookings = Booking::where('status', 'Confirmed')
            ->where('end_time', '<=', $now)
            ->where('end_time', '>', $now->copy()->subMinute())
            ->with('therapist') // Eager load therapist
            ->get();

        foreach ($endingBookings as $booking) {
             if ($booking->therapist) {
                broadcast(new TherapistStatusUpdated($booking->therapist->id, 'Available', null));
                $this->info("Broadcasted 'Available' for Therapist #{$booking->therapist->id}");
            }
        }
        
        $this->info('Status check complete.');
        return 0;
    }
}

