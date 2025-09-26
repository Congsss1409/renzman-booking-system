<?php

use App\Http\Controllers\Api\BranchController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\TherapistController;
use App\Http\Controllers\Api\TimeSlotController;
use App\Http\Controllers\Api\BookingController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Branches
Route::get('/branches', [BranchController::class, 'index']);

// Services
Route::get('/services', [ServiceController::class, 'index']);

// Therapists
Route::get('/branches/{branch}/therapists', [TherapistController::class, 'available']);

// Time Slots
Route::get('/time-slots', [TimeSlotController::class, 'available']);

// Bookings
Route::post('/bookings', [BookingController::class, 'store']);