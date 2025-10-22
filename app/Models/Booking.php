<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

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
        'verification_code', // Add this line
        'verification_expires_at', // Add this line
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
        'verification_expires_at' => 'datetime', // Add this line
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($booking) {
            if (empty($booking->feedback_token)) {
                $booking->feedback_token = (string) Str::uuid();
            }
        });

        static::created(function () {
            static::flagDashboardRefresh();
        });

        static::updated(function () {
            static::flagDashboardRefresh();
        });

        static::deleted(function () {
            static::flagDashboardRefresh();
        });
    }

    protected static function flagDashboardRefresh(): void
    {
        Cache::forget('dashboard:metrics');
        Cache::put('dashboard:last-update', [
            'id' => (string) Str::uuid(),
            'timestamp' => now()->toIso8601String(),
        ], now()->addDay());
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