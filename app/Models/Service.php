<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'price',
        'duration',
        'image_url', // Add the new image_url field here
    ];

    /**
     * Get the bookings for the service.
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
