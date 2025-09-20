<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Therapist extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * This is a security feature to prevent unwanted data from being saved.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'image_url', // The name was changed from 'image' to 'image_url' for clarity
        'branch_id',
    ];

    /**
     * Defines the relationship that a Therapist belongs to one Branch.
     * This allows you to easily get a therapist's branch details, like: $therapist->branch->name
     */
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    /**
     * Defines the relationship that a Therapist can have many Bookings.
     * This allows you to get all bookings for a therapist, like: $therapist->bookings
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
