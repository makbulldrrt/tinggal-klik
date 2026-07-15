<?php

use App\Http\Controllers\WebhookController;
use App\Http\Controllers\Api\LapanganApiController;
use App\Http\Controllers\Api\UlasanApiController;
use Illuminate\Support\Facades\Route;

Route::post('/webhook/midtrans', [WebhookController::class, 'handleMidtrans']);

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
