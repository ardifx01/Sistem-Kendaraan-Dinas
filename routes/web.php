<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\VehicleController as AdminVehicleController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\OperatorController as AdminOperatorController;
use App\Http\Controllers\Operator\DashboardController as OperatorDashboardController;
use App\Http\Controllers\Operator\ServiceController;
use App\Http\Controllers\Operator\BorrowingController;
use App\Http\Controllers\Operator\PaymentController;

// Public routes
Route::get('/', [LandingController::class, 'index'])->name('landing');

// Authentication routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Password Reset Routes
Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');

// Protected routes
Route::middleware(['auth'])->group(function () {

    // Admin routes
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::middleware(['role:admin'])->group(function () {
            Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

            // Vehicle management
            Route::resource('vehicles', AdminVehicleController::class);

            // User management
            Route::resource('users', AdminUserController::class);
            Route::post('/users/{user}/reset-password', [AdminUserController::class, 'resetPassword'])->name('users.reset-password');
            Route::patch('/users/{user}/toggle-status', [AdminUserController::class, 'toggleStatus'])->name('users.toggle-status');

            // Operator management
            Route::resource('operators', AdminOperatorController::class);
        });
    });

    // Operator routes
    Route::middleware(['role:operator', 'active'])->prefix('operator')->name('operator.')->group(function () {
        Route::get('/dashboard', [OperatorDashboardController::class, 'index'])->name('dashboard');

        // Service management
        Route::resource('services', ServiceController::class);
        Route::get('/services/vehicles-by-status/{status?}', [ServiceController::class, 'vehiclesByStatus'])->name('services.vehicles-by-status');

        // Borrowing management
        Route::resource('borrowings', BorrowingController::class);

        // Payment management
        Route::resource('payments', PaymentController::class);
    });

    // Redirect based on role after login
    Route::get('/dashboard', function () {
        if (auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } elseif (auth()->user()->isOperator() && auth()->user()->is_active) {
            return redirect()->route('operator.dashboard');
        } else {
            auth()->logout();
            return redirect()->route('login')->with('error', 'Akun Anda tidak aktif.');
        }
    })->name('dashboard');
});