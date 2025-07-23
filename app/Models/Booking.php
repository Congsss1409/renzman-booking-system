<?php
// app/Models/Booking.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'status',
        'feedback_token', // Add this
        'rating',         // Add this
        'feedback',       // Add this
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    /**
     * Get the branch for the booking.
     */
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    /**
     * Get the service for the booking.
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * Get the therapist for the booking.
     */
    public function therapist()
    {
        return $this->belongsTo(Therapist::class);
    }
}
