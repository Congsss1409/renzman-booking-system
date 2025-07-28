<?php
// app/Models/Therapist.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Therapist extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'branch_id',
        'user_id', // Add user_id here
    ];

    /**
     * Get the branch that the therapist belongs to.
     */
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    /**
     * Get the user account associated with the therapist.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the bookings for the therapist.
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
