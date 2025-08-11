<?php

use App\Http\Controllers\WatermarkController;
use App\Http\Controllers\CollageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\HomeController;
Illuminate\Support\Facades\Auth::routes();
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

Route::match(['get', 'post'], '/verify/otp', [LoginController::class, 'authenticateOTP'])
    ->name('verify.otp');

Route::get('register/otp', [UserController::class, 'registerOTP'])
    ->name('register.otp');

Route::post('registers/store', [UserController::class, 'register'])
    ->name('register.store');

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'web']], function () {
    Route::get('dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    /**
     * Profile
     */
    Route::group(['prefix' => 'profile'], function () {
        Route::get('', [ProfileController::class, 'edit'])
            ->name('profile.edit');

        Route::get('listings', [ProfileController::class, 'listings'])
            ->name('profile.listing');

        Route::post('', [ProfileController::class, 'update'])
            ->name('profile.update');

        Route::post('delete', [ProfileController::class, 'delete'])
            ->name('profile.listing.delete');

        Route::get('delete/{id}', [ProfileController::class, 'singleDelete'])
            ->name('profile.listing.delete.single');
    });

    /**
     * Profile
     */

    /**
     * Roles
     */
    Route::resource('roles', RoleController::class);

    Route::get('roles/all/view', [RoleController::class, 'view'])
        ->name('view.roles');
    /**
     * Roles
     */

    /**
     * User Functionalities
     */
    Route::resource('users', UserController::class);
});

Route::group(['prefix' => 'password'], function () {
    Route::get('reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');

    Route::post('email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

    Route::get('reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');

    Route::post('reset', [ResetPasswordController::class, 'reset']);

    Route::post('update', [ResetPasswordController::class, 'updatePassword'])->name('password.update');
});

Route::get('', [HomeController::class, function () {
    return redirect()->route('login');
}]);
