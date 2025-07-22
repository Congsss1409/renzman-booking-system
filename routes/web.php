<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\LandingPageController; // <-- ADD THIS LINE

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// --- NEW LANDING PAGE ROUTE ---
// This now points the homepage to our new controller
Route::get('/', [LandingPageController::class, 'index'])->name('landing');


// --- BOOKING PROCESS ROUTES ---
// This group remains the same, but is no longer the homepage.
Route::prefix('book')->name('booking.')->group(function () {

    // Step 1: Show Location Selection Form
    Route::get('/step-1', [BookingController::class, 'showStepOne'])->name('stepOne');
    Route::post('/step-1', [BookingController::class, 'processStepOne'])->name('processStepOne');

    // Step 2: Show Service Selection Form
    Route::get('/step-2', [BookingController::class, 'showStepTwo'])->name('stepTwo');
    Route::post('/step-2', [BookingController::class, 'processStepTwo'])->name('processStepTwo');

    // Step 3: Show Date & Time Selection Form
    Route::get('/step-3', [BookingController::class, 'showStepThree'])->name('stepThree');
    Route::post('/step-3', [BookingController::class, 'processStepThree'])->name('processStepThree');

    // Step 4: Show Confirmation Page
    Route::get('/step-4', [BookingController::class, 'showStepFour'])->name('stepFour');
    Route::post('/step-4', [BookingController::class, 'storeBooking'])->name('store');

    // Step 5: Show Success Page
    Route::get('/success', [BookingController::class, 'showSuccess'])->name('success');

});
