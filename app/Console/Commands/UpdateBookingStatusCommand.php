<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Booking;
use Carbon\Carbon;

class UpdateBookingStatusCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookings:update-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update booking statuses based on current time (e.g., to In Progress or Completed)';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $now = Carbon::now('Asia/Manila');

        // 1. Update Confirmed bookings to 'In Progress' if the session has started but not ended
        Booking::where('status', 'Confirmed')
            ->where('start_time', '<=', $now)
            ->where('end_time', '>', $now)
            ->update(['status' => 'In Progress']);

        // 2. Update 'Confirmed' or 'In Progress' bookings to 'Completed' if the session end time is in the past
        $bookingsToComplete = Booking::whereIn('status', ['Confirmed', 'In Progress'])
            ->where('end_time', '<=', $now)
            ->get();
            
        foreach ($bookingsToComplete as $booking) {
            $booking->update(['status' => 'Completed']);
            // Dispatch event to send feedback email
            \App\Events\BookingCompleted::dispatch($booking);
        }

        $this->info('Booking statuses have been updated successfully.');
        return 0;
    }
}