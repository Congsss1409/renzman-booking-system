<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str; // Import the Str class for UUID generation

class Booking extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'client_name',
        'client_email',
        'client_phone',
        'branch_id',
        'service_id',
        'therapist_id',
        'start_time',
        'end_time',
        'price',
        'downpayment_amount',
        'remaining_balance',
        'payment_method',
        'payment_status',
        'status',
        'feedback_token',
        'rating',
        'feedback',
        'show_on_landing',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'show_on_landing' => 'boolean',
    ];

    /**
     * Boot the model.
     *
     * This method is called when the model is bootstrapped.
     * We use it to automatically generate a feedback_token when a new booking is being created.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($booking) {
            if (empty($booking->feedback_token)) {
                $booking->feedback_token = (string) Str::uuid();
            }
        });
    }

    /**
     * Get the service associated with the booking.
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * Get the therapist associated with the booking.
     */
    public function therapist()
    {
        return $this->belongsTo(Therapist::class);
    }

    /**
     * Get the branch associated with the booking.
     */
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
