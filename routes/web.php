<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProgramReportController;
use App\Http\Controllers\FundRequestController;
use App\Http\Controllers\ProfileController;

use App\Http\Controllers\AdminUserController;
use App\Http\Middleware\AdminMiddleware;

Route::get('/', function () {
    return redirect()->route('login');
});

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/pending', [AuthController::class, 'showPending'])->name('pending');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    // Admin Routes
    Route::middleware(AdminMiddleware::class)->prefix('admin')->name('admin.')->group(function () {
        Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
        Route::get('/users/{id}/edit', [AdminUserController::class, 'edit'])->name('users.edit');
        Route::patch('/users/{id}', [AdminUserController::class, 'update'])->name('users.update');
        Route::post('/users/{id}/approve', [AdminUserController::class, 'approve'])->name('users.approve');
        Route::delete('/users/{id}', [AdminUserController::class, 'destroy'])->name('users.destroy');
    });

    // Program Reports
    Route::get('program-reports/print-all', 'App\Http\Controllers\ProgramReportController@printAll')->name('program-reports.print-all');
    Route::get('program-reports/{id}/print', 'App\Http\Controllers\ProgramReportController@print')->name('program-reports.print');
    Route::resource('program-reports', \App\Http\Controllers\ProgramReportController::class);

    // Fund Requests
    Route::resource('fund-requests', FundRequestController::class);
    Route::post('fund-requests/{id}/approve', [FundRequestController::class, 'approve'])->name('fund-requests.approve');
    Route::post('fund-requests/{id}/reject', [FundRequestController::class, 'reject'])->name('fund-requests.reject');
    
    // Boss Action
    Route::post('fund-requests/{id}/boss-action', [FundRequestController::class, 'bossAction'])->name('fund-requests.boss-action');

    // Notifications
    Route::post('notifications/mark-as-read', [App\Http\Controllers\DashboardController::class, 'markNotificationsAsRead'])->name('notifications.mark-as-read');
    Route::get('notifications/{id}/read', [App\Http\Controllers\DashboardController::class, 'markNotificationAsRead'])->name('notifications.read');

    // Profile Settings
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/photo', [ProfileController::class, 'destroyPhoto'])->name('profile.photo.destroy');
    Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password.update');
});
