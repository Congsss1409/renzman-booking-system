<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\TwoFactorController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\TherapistController;
use App\Http\Controllers\Admin\BranchController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- Public Routes ---
Route::get('/', [LandingPageController::class, 'index'])->name('landing');
Route::get('/services', [LandingPageController::class, 'services'])->name('services');
Route::get('/about', [LandingPageController::class, 'about'])->name('about');

// --- Auth Routes ---
Route::get('login', [LoginController::class, 'create'])->name('login');
Route::post('login', [LoginController::class, 'store'])->name('login.store');
Route::post('logout', [LoginController::class, 'destroy'])->name('logout');

// --- Client Booking & Feedback Routes ---
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
Route::get('/feedback/{token}', [FeedbackController::class, 'create'])->name('feedback.create');
Route::post('/feedback/{token}', [FeedbackController::class, 'store'])->name('feedback.store');
Route::get('/api/therapists/{therapist}/availability/{date}/{service}', [BookingController::class, 'getAvailability'])->name('api.therapists.availability');

// two-factor verification routes
Route::get('/2fa', [TwoFactorController::class, 'index'])->name('2fa.index');
Route::post('/2fa', [TwoFactorController::class, 'verify'])->name('2fa.verify');
Route::post('/2fa/resend', [TwoFactorController::class, 'resend'])->name('2fa.resend');

// --- Protected Admin Routes ---
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    // Revenue Export
    Route::get('/revenue/export/pdf', [\App\Http\Controllers\Admin\RevenueReportController::class, 'monthlyPdf'])->name('revenue.export.pdf');
    Route::get('/revenue/export/excel', [\App\Http\Controllers\Admin\RevenueExcelExportController::class, 'monthlyExcel'])->name('revenue.export.excel');
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');


    // Manual Booking Management
    Route::post('/bookings', [DashboardController::class, 'storeBooking'])->name('bookings.store');
    Route::post('/bookings/{booking}/cancel', [DashboardController::class, 'cancelBooking'])->name('bookings.cancel');
    Route::get('/branches/{branch}/therapists', [DashboardController::class, 'getTherapistsByBranch'])->name('branches.therapists');
    
    // Therapist Management
    Route::resource('therapists', TherapistController::class);

    // Service Management
    Route::resource('services', ServiceController::class);

    // Feedback Management
    Route::get('/feedback', [DashboardController::class, 'feedback'])->name('feedback');
    Route::post('/feedback/{booking}/toggle', [DashboardController::class, 'toggleFeedbackDisplay'])->name('feedback.toggle');

    // Branch Management
    Route::get('branches', [BranchController::class, 'index'])->name('branches.index');
    Route::get('branches/create', [BranchController::class, 'create'])->name('branches.create');
    Route::post('branches', [BranchController::class, 'store'])->name('branches.store');
    Route::get('branches/{branch}/edit', [BranchController::class, 'edit'])->name('branches.edit');
    Route::post('branches/{branch}', [BranchController::class, 'update'])->name('branches.update');
    Route::post('branches/{branch}/remove-image', [BranchController::class, 'removeImage'])->name('branches.remove-image');

    // User Management (Admins only)
    Route::middleware(\App\Http\Middleware\EnsureUserIsAdmin::class)->group(function () {
        Route::get('users', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
        Route::get('users/create', [\App\Http\Controllers\Admin\UserController::class, 'create'])->name('users.create');
        Route::post('users', [\App\Http\Controllers\Admin\UserController::class, 'store'])->name('users.store');
        Route::get('users/{user}/edit', [\App\Http\Controllers\Admin\UserController::class, 'edit'])->name('users.edit');
        Route::post('users/{user}', [\App\Http\Controllers\Admin\UserController::class, 'update'])->name('users.update');
        Route::post('users/{user}/delete', [\App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('users.destroy');
    });

    // Payroll Management
    Route::get('payrolls', [\App\Http\Controllers\PayrollController::class, 'index'])->name('payrolls.index');
    Route::get('payrolls/create', [\App\Http\Controllers\PayrollController::class, 'create'])->name('payrolls.create');
    Route::post('payrolls', [\App\Http\Controllers\PayrollController::class, 'store'])->name('payrolls.store');
    Route::get('payrolls/{payroll}', [\App\Http\Controllers\PayrollController::class, 'show'])->name('payrolls.show');
    Route::get('payrolls-export', [\App\Http\Controllers\PayrollController::class, 'exportCsv'])->name('payrolls.export');
    Route::get('payrolls/{payroll}/export-pdf', [\App\Http\Controllers\PayrollController::class, 'exportPdf'])->name('payrolls.export_pdf');
    Route::post('payrolls/{payroll}/items', [\App\Http\Controllers\PayrollController::class, 'addItem'])->name('payrolls.items.add');
    Route::post('payrolls/items/{item}/remove', [\App\Http\Controllers\PayrollController::class, 'removeItem'])->name('payrolls.items.remove');
    Route::post('payrolls/{payroll}/payments', [\App\Http\Controllers\PayrollController::class, 'addPayment'])->name('payrolls.payments.add');
    Route::post('payrolls/generate-from-bookings', [\App\Http\Controllers\PayrollController::class, 'generateFromBookings'])->name('payrolls.generate_from_bookings');
});

