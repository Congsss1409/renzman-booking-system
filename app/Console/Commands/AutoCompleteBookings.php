<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class AutoCompleteBookings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookings:autocomplete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically complete bookings when their end time is reached';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = \Carbon\Carbon::now();
        $bookingsToComplete = \App\Models\Booking::whereIn('status', ['In Progress', 'Confirmed'])
            ->whereNotNull('end_time')
            ->where('end_time', '<=', $now)
            ->get();

        foreach ($bookingsToComplete as $booking) {
            $booking->update(['status' => 'Completed']);
            // Dispatch event to send feedback email
            \App\Events\BookingCompleted::dispatch($booking);
        }

        $this->info("Auto-completed {$bookingsToComplete->count()} bookings.");
    }
}
