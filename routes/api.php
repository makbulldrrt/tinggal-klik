<?php

use App\Http\Controllers\WebhookController;
use App\Http\Controllers\MidtransWebhookController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\LapanganApiController;
use App\Http\Controllers\Api\UlasanApiController;
use App\Http\Controllers\Customer\LapanganController as CustomerLapanganController;
use App\Http\Controllers\Customer\BookingController as CustomerBookingController;
use App\Http\Controllers\Api\Owner\LapanganController as OwnerLapanganController;
use App\Http\Controllers\Api\Owner\DashboardController;
use App\Http\Controllers\Api\Customer\ProfileController;
use App\Http\Controllers\Api\Customer\UlasanController;
use App\Http\Controllers\Api\Owner\WithdrawalController;
use Illuminate\Support\Facades\Route;

Route::post('/webhook/midtrans', [WebhookController::class, 'handleMidtrans']);
Route::post('/midtrans/notification', [MidtransWebhookController::class, 'handleNotification']);

Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/auth/logout', [AuthController::class, 'logout']);

    Route::middleware('role:pelanggan')->prefix('customer')->group(function () {
        Route::get('/lapangan', [CustomerLapanganController::class, 'index']);
        Route::get('/lapangan/{id}', [CustomerLapanganController::class, 'show']);
        Route::get('/lapangan/{id}/availability', [CustomerBookingController::class, 'getAvailability']);
        Route::post('/bookings', [CustomerBookingController::class, 'store']);
        Route::get('/bookings/history', [CustomerBookingController::class, 'index']);
        Route::get('/profile', [ProfileController::class, 'show']);
        Route::put('/profile', [ProfileController::class, 'update']);
        Route::post('/ulasan', [UlasanController::class, 'store']);
    });

    Route::middleware('role:owner')->prefix('owner')->group(function () {
        Route::apiResource('/lapangan', OwnerLapanganController::class);
        Route::get('/dashboard', [DashboardController::class, 'index']);
        Route::get('/dashboard/analytics', [DashboardController::class, 'getAnalyticsData']);
        Route::post('/withdrawal/request', [WithdrawalController::class, 'store']);
    });
});

Route::get('/lapangan', [\App\Http\Controllers\Api\LapanganApiController::class, 'index']);
Route::get('/lapangan/{id}', [\App\Http\Controllers\Api\LapanganApiController::class, 'show']);
Route::get('/ulasan', [\App\Http\Controllers\Api\UlasanApiController::class, 'index'])->withoutMiddleware(['auth:sanctum', 'role:owner']);

Route::middleware(['auth:sanctum', 'role:owner'])->group(function () {
    Route::apiResource('lapangan', LapanganApiController::class)->except(['index', 'show']);
    Route::post('ulasan', [UlasanApiController::class, 'store']);
    Route::get('ulasan/{ulasan}', [UlasanApiController::class, 'show']);
    Route::put('ulasan/{ulasan}', [UlasanApiController::class, 'update']);
    Route::delete('ulasan/{ulasan}', [UlasanApiController::class, 'destroy']);
});
