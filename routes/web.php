<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use Illuminate\Support\Facades\Auth;

Auth::routes();


Route::match(['get', 'post'], '/verify/otp', [LoginController::class, 'authenticateOTP'])
    ->name('verify.otp');

// Registration
Route::get('register/otp', [UserController::class, 'registerOTP'])
    ->name('register.otp');

Route::post('registers/store', [UserController::class, 'register'])
    ->name('register.store');
Route::get('/verify-email/{code}', [UserController::class, 'verifyEmail'])->name('verify.email');

// Admin Routes
Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'web']], function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/export-pdf', [DashboardController::class, 'exportPdf'])->name('dashboard.exportPdf');


    // Profile Routes
    Route::group(['prefix' => 'profile'], function () {
        Route::get('', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::get('listings', [ProfileController::class, 'listings'])->name('profile.listing');
        Route::post('', [ProfileController::class, 'update'])->name('profile.update');
        Route::post('delete', [ProfileController::class, 'delete'])->name('profile.listing.delete');
        Route::get('delete/{id}', [ProfileController::class, 'singleDelete'])->name('profile.listing.delete.single');
    });
    Route::post('users/{user}/status', [UserController::class, 'updateStatus'])->name('users.updateStatus');

    Route::resource('users', UserController::class);
});

// Password Reset
Route::group(['prefix' => 'password'], function () {
    Route::get('reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('reset', [ResetPasswordController::class, 'reset']);
    Route::post('update', [ResetPasswordController::class, 'updatePassword'])->name('password.update');
});

// Redirect root to login
Route::get('/', function () {
    return redirect()->route('login');
});
