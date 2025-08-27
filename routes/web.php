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
use App\Http\Controllers\Admin\BorrowingController as AdminBorrowingController;
use App\Http\Controllers\Operator\DashboardController as OperatorDashboardController;
use App\Http\Controllers\Operator\ServiceController;
use App\Http\Controllers\Operator\BorrowingController;
use App\Http\Controllers\Operator\CheckoutController;

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

// OTP routes

// Protected routes
Route::middleware(['auth'])->group(function () {

    // Admin routes
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::middleware(['role:admin'])->group(function () {
            Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

            // Vehicle management
            Route::resource('vehicles', AdminVehicleController::class);
            // Admin: add service record for a specific vehicle
            Route::get('/vehicles/{vehicle}/services/create', [AdminVehicleController::class, 'createService'])->name('vehicles.services.create');
            Route::post('/vehicles/{vehicle}/services', [AdminVehicleController::class, 'storeService'])->name('vehicles.services.store');
            // Admin: view a single service record (admin controller)
            Route::get('/services/{service}', [\App\Http\Controllers\Admin\ServiceController::class, 'show'])->name('services.show');
            // Admin: download service record as PDF
            Route::get('/services/{service}/download', [\App\Http\Controllers\Admin\ServiceController::class, 'download'])->name('services.download');
            Route::get('/vehicles/export/pdf', [AdminVehicleController::class, 'exportPdf'])->name('vehicles.export.pdf');
            Route::get('/vehicles/{vehicle}/export/pdf', [AdminVehicleController::class, 'exportSinglePdf'])->name('vehicles.export.single.pdf');

            // User management
            Route::resource('users', AdminUserController::class);
            Route::post('/users/{user}/reset-password', [AdminUserController::class, 'resetPassword'])->name('users.reset-password');
            Route::patch('/users/{user}/toggle-status', [AdminUserController::class, 'toggleStatus'])->name('users.toggle-status');

            // Operator management
            Route::resource('operators', AdminOperatorController::class);

            // Borrowings management
            Route::resource('borrowings', AdminBorrowingController::class)->only(['index', 'show', 'destroy']);
            Route::post('/borrowings/{borrowing}/approve', [AdminBorrowingController::class, 'approve'])->name('borrowings.approve');
            Route::post('/borrowings/{borrowing}/reject', [AdminBorrowingController::class, 'reject'])->name('borrowings.reject');
            Route::post('/borrowings/{borrowing}/approve-return', [AdminBorrowingController::class, 'approveReturn'])->name('borrowings.approve-return');
            Route::get('/borrowings-awaiting-return', [AdminBorrowingController::class, 'awaitingReturn'])->name('borrowings.awaiting-return');

            // History borrowings
            Route::get('/borrowings-history', [AdminBorrowingController::class, 'history'])->name('borrowings.history');
            Route::get('/borrowings-history/export-pdf', [AdminBorrowingController::class, 'exportHistoryPdf'])->name('borrowings.history.export-pdf');
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
        Route::get('/borrowings/{borrowing}/print', [BorrowingController::class, 'print'])->name('borrowings.print');

        // Checkout/Checkin management
        Route::post('/borrowings/{borrowing}/checkout', [CheckoutController::class, 'checkout'])->name('borrowings.checkout');
        Route::post('/borrowings/{borrowing}/checkin', [CheckoutController::class, 'checkin'])->name('borrowings.checkin');
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
