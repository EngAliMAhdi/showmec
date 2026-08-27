<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\WaitlistController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('me', [AuthController::class, 'me']);
    });
});

Route::get('workshop/seats', [RegistrationController::class, 'seatsOverview']);
Route::get('workshop/seats-left', [RegistrationController::class, 'seatsLeft']);
Route::post('registrations', [RegistrationController::class, 'store']);
Route::post('registrations/status', [RegistrationController::class, 'status']);
Route::post('registrations/cancel', [RegistrationController::class, 'cancel']);
Route::post('waitlist', [WaitlistController::class, 'store']);

Route::get('payment-orders/{token}', [PaymentController::class, 'show']);
Route::post('payments/webhook', [PaymentController::class, 'webhook']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('admin/access', [AdminController::class, 'access']);
    Route::post('admin/claim', [AdminController::class, 'claim']);

    Route::middleware('admin')->group(function () {
        Route::get('admin/registrations', [AdminController::class, 'registrations']);
        Route::post('admin/registrations/{id}/resend-invitation', [AdminController::class, 'resendInvitation']);
    });
});
