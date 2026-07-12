<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LapanganController;
use App\Http\Controllers\Catalog\CatalogLapanganController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $lapangan = \App\Models\Lapangan::where('status', 'tersedia')->get();
    return view('dashboard', compact('lapangan'));
})->middleware(['auth', 'verified'])->name('dashboard');

// ── PUBLIC CATALOG (Modul 2 — Mahdi / Backend support) ──────────────────────
// Handled by CatalogLapanganController@index.
// Supports: ?search=<name>, ?jenis=<sport|semua>, ?page=<n>
Route::get('/lapangan', [CatalogLapanganController::class, 'index'])
     ->name('lapangan.index');

// ── BOOKING PLACEHOLDER (Modul 3 — Decky will replace this closure) ──────────
// Uses route-model binding on the Lapangan model so Decky's controller
// can simply swap the closure for [BookingController::class, 'create'].
Route::get('/booking/create/{lapangan}', function (\App\Models\Lapangan $lapangan) {
    // TODO (Decky): Replace with → [BookingController::class, 'create']
    return response()->json([
        'message'        => 'Booking endpoint — under construction (Modul 3)',
        'lapangan_id'    => $lapangan->id,
        'nama_lapangan'  => $lapangan->nama_lapangan,
        'harga_per_jam'  => $lapangan->harga_per_jam,
    ]);
})->name('booking.create');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('lapangan', LapanganController::class);
});

require __DIR__.'/auth.php';
