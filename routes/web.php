<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\LogsController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\MechanicController;
use App\Http\Controllers\SalespersonController;
use App\Http\Controllers\ServiceRecordController;
use App\Http\Controllers\ServiceTicketController;
use App\Http\Controllers\PartController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\UserManagementController;

// Root — redirect to login
Route::get('/', function () {
    return redirect()->route('login');
});

// Public routes — no login needed
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [UserController::class, 'login'])
        ->name('login');

    Route::post('/login', [UserController::class, 'store'])
        ->name('user.submit');

    Route::get('/forgot-password', [ForgotPasswordController::class, 'showForm'])
        ->name('password.request');

    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink'])
        ->name('password.email');

    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showForm'])
        ->name('password.reset');

    Route::post('/reset-password', [ResetPasswordController::class, 'reset'])
        ->name('password.update');
});

// Protected routes — must be logged in
Route::middleware(['auth'])->group(function () {

    // All roles
    Route::get('/home', [UserController::class, 'index'])->name('home');
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');

    // Admin only
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/logs', [LogsController::class, 'show'])->name('logs');
        Route::resource('users', UserManagementController::class);
    });

    // Admin and Salesperson
    Route::middleware(['role:admin,salesperson'])->group(function () {
        Route::resource('cars', CarController::class);
        Route::resource('customers', CustomerController::class);
        Route::resource('invoices', InvoiceController::class);
        Route::resource('salespersons', SalespersonController::class);
    });

    // Admin, Mechanic and Service Staff
    Route::middleware(['role:admin,mechanic,service_staff'])->group(function () {
        Route::resource('service-tickets', ServiceTicketController::class);
        Route::resource('service-records', ServiceRecordController::class);
        Route::resource('mechanics', MechanicController::class);
        Route::resource('parts', PartController::class);
    });
});
