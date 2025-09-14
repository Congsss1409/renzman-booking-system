<?php

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
        'downpayment_amount',
        'remaining_balance',
        'payment_method',
        'payment_status',
        'status',
        'feedback_token',
        'rating',
        'feedback',
        'show_on_landing', // This field is required to be fillable
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'show_on_landing' => 'boolean', // Casting to boolean is good practice
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function therapist()
    {
        return $this->belongsTo(Therapist::class);
    }
}
