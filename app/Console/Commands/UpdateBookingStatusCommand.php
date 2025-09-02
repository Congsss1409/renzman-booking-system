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
    protected $description = 'Finds confirmed bookings that have ended and updates their status to "Completed"';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Running booking status update task...');

        // Get the current time in the application's timezone (Asia/Manila)
        $now = Carbon::now();

        // Find all bookings that are still marked as 'Confirmed' but their end_time has passed.
        $bookingsToUpdate = Booking::where('status', 'Confirmed')
                                   ->where('end_time', '<', $now)
                                   ->get();

        if ($bookingsToUpdate->isEmpty()) {
            $this->info('No bookings found that need updating.');
            return 0; // Command was successful, but there was nothing to do.
        }

        $count = $bookingsToUpdate->count();
        $this->info("Found {$count} bookings to mark as completed.");

        foreach ($bookingsToUpdate as $booking) {
            $booking->status = 'Completed';
            $booking->save();
            $this->line("Updated Booking ID #{$booking->id} to Completed.");
        }

        $this->info('Booking status update task finished successfully.');
        return 0; // Command was successful.
    }
}