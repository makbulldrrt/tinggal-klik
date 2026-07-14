<?php

use App\Http\Controllers\WebhookController;
use App\Http\Controllers\Api\LapanganApiController;
use App\Http\Controllers\Api\UlasanApiController;
use Illuminate\Support\Facades\Route;

Route::post('/webhook/midtrans', [WebhookController::class, 'handleMidtrans']);

Route::get('/lapangan', [\App\Http\Controllers\Api\LapanganApiController::class, 'index']);
Route::get('/lapangan/{id}', [\App\Http\Controllers\Api\LapanganApiController::class, 'show']);
Route::get('/ulasan', [\App\Http\Controllers\Api\UlasanApiController::class, 'index']);

Route::middleware(['auth:sanctum', 'role:owner'])->group(function () {
    Route::apiResource('lapangan', LapanganApiController::class)->except(['index', 'show']);
    Route::apiResource('ulasan', UlasanApiController::class)->except(['index']);
});
