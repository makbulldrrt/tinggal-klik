<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LapanganController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\Catalog\CatalogLapanganController;
use App\Http\Controllers\Owner\DashboardController as OwnerDashboardController;
use App\Http\Controllers\Owner\LapanganController as OwnerLapanganController;
use App\Http\Controllers\Owner\WithdrawalController;
use App\Http\Controllers\PemesananController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MitraController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $lapangan = \App\Models\Lapangan::where('status', 'tersedia')->get();
    return view('dashboard', compact('lapangan'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/lapangan', [CatalogLapanganController::class, 'index'])
     ->name('lapangan.index');

Route::get('/lapangan/{id}', [CatalogLapanganController::class, 'show'])
     ->name('katalog.show');

Route::middleware(['auth', 'role:pelanggan'])->group(function () {
    Route::get('booking/create/{lapangan_id}', [PemesananController::class, 'create'])->name('booking.create');
    Route::post('booking/store', [PemesananController::class, 'store'])->name('booking.store');
});


Route::middleware('auth')->group(function () {
    Route::get('/mitra/register', [MitraController::class, 'showForm'])->name('mitra.register');
    Route::post('/mitra/submit', [MitraController::class, 'registerMitra'])->name('mitra.submit');
    Route::get('/booking/history', [PemesananController::class, 'index'])->name('booking.history');
    Route::get('/booking/invoice/{id}', [PemesananController::class, 'invoice'])->name('booking.invoice');
    Route::post('/ulasan/store', [App\Http\Controllers\UlasanController::class, 'store'])->name('ulasan.store');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('lapangan', LapanganController::class);
});

Route::middleware(['auth', 'role:owner'])->prefix('owner')->name('owner.')->group(function () {
    Route::get('dashboard', [OwnerDashboardController::class, 'index'])->name('dashboard');
    Route::resource('lapangan', OwnerLapanganController::class);
    Route::get('withdrawal/request', [WithdrawalController::class, 'create'])->name('withdrawal.create');
    Route::post('withdrawal/request', [WithdrawalController::class, 'store'])->name('withdrawal.store');
});

require __DIR__.'/auth.php';
