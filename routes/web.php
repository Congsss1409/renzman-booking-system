<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\Admin\PayrollController;

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
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // --- Booking Management (Simplified for Modal) ---
    Route::post('/bookings', [AdminController::class, 'storeBooking'])->name('bookings.store');
    Route::post('/bookings/{booking}/cancel', [AdminController::class, 'cancelBooking'])->name('bookings.cancel');

    // --- Therapist Management ---
    Route::get('/therapists', [AdminController::class, 'listTherapists'])->name('therapists.index');
    Route::get('/therapists/create', [AdminController::class, 'createTherapist'])->name('therapists.create');
    Route::post('/therapists', [AdminController::class, 'storeTherapist'])->name('therapists.store');
    Route::get('/therapists/{therapist}/edit', [AdminController::class, 'editTherapist'])->name('therapists.edit');
    Route::put('/therapists/{therapist}', [AdminController::class, 'updateTherapist'])->name('therapists.update');
    Route::delete('/therapists/{therapist}', [AdminController::class, 'destroyTherapist'])->name('therapists.destroy');
    
    // --- Other Admin Routes ---
    Route::get('/branches/{branch}/therapists', [AdminController::class, 'getTherapistsByBranch'])->name('branches.therapists');
    Route::get('/feedback', [AdminController::class, 'feedback'])->name('feedback');
    Route::get('/analytics', [AdminController::class, 'analytics'])->name('analytics');
    
    // --- Payroll Routes ---
    Route::get('/payroll', [PayrollController::class, 'index'])->name('payroll.index');
    Route::post('/payroll', [PayrollController::class, 'generate'])->name('payroll.generate');
});

