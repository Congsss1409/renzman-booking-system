<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\Auth\LoginController;
// Corrected: Import all Admin controllers from the Admin subfolder
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\TherapistController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// --- Public Routes ---
Route::get('/', [LandingPageController::class, 'index'])->name('landing');
Route::get('/services', [LandingPageController::class, 'services'])->name('services');
Route::get('/about', [LandingPageController::class, 'about'])->name('about');

// --- Auth Routes ---
Route::get('login', [LoginController::class, 'create'])->name('login');
Route::post('login', [LoginController::class, 'store'])->name('login.store');
Route::post('logout', [LoginController::class, 'destroy'])->name('logout');

// --- Client Booking Routes ---
Route::prefix('booking')->name('booking.')->group(function () {
    Route::get('/step-one', [BookingController::class, 'createStepOne'])->name('create.step-one');
    Route::post('/step-one', [BookingController::class, 'storeStepOne'])->name('store.step-one');
    Route::get('/step-two', [BookingController::class, 'createStepTwo'])->name('create.step-two');
    Route::post('/step-two', [BookingController::class, 'storeStepTwo'])->name('store.step-two');
    Route::get('/step-three', [BookingController::class, 'createStepThree'])->name('create.step-three');
    Route::post('/step-three', [BookingController::class, 'storeStepThree'])->name('store.step-three');
    Route::get('/step-four', [BookingController::class, 'createStepFour'])->name('create.step-four');
    Route::post('/step-four', [BookingController::class, 'storeStepFour'])->name('store.step-four');
    Route::get('/step-five', [BookingController::class, 'createStepFive'])->name('create.step-five');
    Route::post('/step-five', [BookingController::class, 'storeStepFive'])->name('store.step-five');
    Route::get('/success', [BookingController::class, 'success'])->name('success');
});

// --- Feedback Routes ---
Route::get('/feedback/{token}', [FeedbackController::class, 'create'])->name('feedback.create');
Route::post('/feedback/{token}', [FeedbackController::class, 'store'])->name('feedback.store');

// --- API Route ---
Route::get('/api/therapists/{therapist}/availability/{date}/{service}', [BookingController::class, 'getAvailability'])->name('api.therapists.availability');

// --- Protected Admin Routes ---
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    // Corrected: Point to the new DashboardController
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    
    // --- Booking Management ---
    Route::get('/bookings/create', [DashboardController::class, 'createBooking'])->name('bookings.create');
    Route::post('/bookings', [DashboardController::class, 'storeBooking'])->name('bookings.store');
    Route::post('/bookings/{booking}/cancel', [DashboardController::class, 'cancelBooking'])->name('bookings.cancel');

    // --- Therapist Management ---
    Route::resource('therapists', TherapistController::class);

    // --- Service Management ---
    Route::resource('services', ServiceController::class);
    
    // --- Other Admin Routes ---
    Route::get('/branches/{branch}/therapists', [DashboardController::class, 'getTherapistsByBranch'])->name('branches.therapists');
    Route::get('/feedback', [DashboardController::class, 'feedback'])->name('feedback');
    Route::post('/feedback/{booking}/toggle', [DashboardController::class, 'toggleFeedbackDisplay'])->name('feedback.toggle');
});
