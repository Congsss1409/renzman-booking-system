<?php
// routes/web.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\FeedbackController;

// --- Public Routes ---
Route::get('/', [LandingPageController::class, 'index'])->name('landing');

// --- Auth Routes ---
Route::get('login', [LoginController::class, 'create'])->name('login');
Route::post('login', [LoginController::class, 'store'])->name('login.store');
Route::post('logout', [LoginController::class, 'destroy'])->name('logout');

// --- Booking Routes ---
Route::prefix('booking')->name('booking.')->group(function () {
    // ... booking steps
    Route::get('/step-one', [BookingController::class, 'createStepOne'])->name('create.step-one');
    Route::post('/step-one', [BookingController::class, 'storeStepOne'])->name('store.step-one');
    Route::get('/step-two', [BookingController::class, 'createStepTwo'])->name('create.step-two');
    Route::post('/step-two', [BookingController::class, 'storeStepTwo'])->name('store.step-two');
    Route::get('/step-three', [BookingController::class, 'createStepThree'])->name('create.step-three');
    Route::post('/step-three', [BookingController::class, 'storeStepThree'])->name('store.step-three');
    Route::get('/step-four', [BookingController::class, 'createStepFour'])->name('create.step-four');
    Route::post('/step-four', [BookingController::class, 'storeStepFour'])->name('store.step-four');
    Route::get('/success', [BookingController::class, 'success'])->name('success');
});

// --- Feedback Routes ---
Route::get('/feedback/{token}', [FeedbackController::class, 'create'])->name('feedback.create');
Route::post('/feedback/{token}', [FeedbackController::class, 'store'])->name('feedback.store');
Route::get('/feedback/thanks', [FeedbackController::class, 'thanks'])->name('feedback.thanks');

// --- API Route for Availability ---
Route::get('/api/therapists/{therapist}/availability/{date}', [BookingController::class, 'getAvailability'])->name('api.therapists.availability');

// --- Protected Admin Routes ---
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::post('/bookings/{booking}/cancel', [AdminController::class, 'cancelBooking'])->name('bookings.cancel');
    Route::get('/bookings/create', [AdminController::class, 'createBooking'])->name('bookings.create');
    Route::post('/bookings', [AdminController::class, 'storeBooking'])->name('bookings.store');
    Route::get('/branches/{branch}/therapists', [AdminController::class, 'getTherapistsByBranch'])->name('branches.therapists');
    
    // New route for the feedback page
    Route::get('/feedback', [AdminController::class, 'feedback'])->name('feedback');
});
