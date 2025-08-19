<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\VehicleController as AdminVehicleController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
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

// Protected routes
Route::middleware(['auth'])->group(function () {

    // Admin routes
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Vehicle management
        Route::resource('vehicles', AdminVehicleController::class);

        // User management
        Route::resource('users', AdminUserController::class);
        Route::post('/users/{user}/reset-password', [AdminUserController::class, 'resetPassword'])->name('users.reset-password');
        Route::patch('/users/{user}/toggle-status', [AdminUserController::class, 'toggleStatus'])->name('users.toggle-status');
    });

    // Operator routes
    Route::middleware(['role:operator', 'active'])->prefix('operator')->name('operator.')->group(function () {
        Route::get('/dashboard', [OperatorDashboardController::class, 'index'])->name('dashboard');

        // Service management
        Route::resource('services', ServiceController::class);

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
