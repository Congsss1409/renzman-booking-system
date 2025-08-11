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
        'image_url', // Add this
        'branch_id',
    ];

    /**
     * Get the branch that the therapist belongs to.
     */
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    /**
     * Get the bookings for the therapist.
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
