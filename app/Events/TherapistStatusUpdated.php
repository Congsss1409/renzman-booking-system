<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TherapistStatusUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $therapistId;
    public $status;
    public $availableAt;

    /**
     * Create a new event instance.
     *
     * @param int $therapistId The ID of the therapist whose status changed.
     * @param string $status The new status ('Available' or 'In Session').
     * @param string|null $availableAt The time the therapist will be available next, if applicable.
     */
    public function __construct($therapistId, $status, $availableAt)
    {
        $this->therapistId = $therapistId;
        $this->status = $status;
        $this->availableAt = $availableAt;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * This will be a public channel that anyone viewing the booking page can listen to.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('therapist-status-updates'),
        ];
    }
}

