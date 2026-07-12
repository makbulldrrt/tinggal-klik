<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LapanganController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $lapangan = \App\Models\Lapangan::where('status', 'tersedia')->get();
    return view('dashboard', compact('lapangan'));
})->middleware(['auth', 'verified'])->name('dashboard');

// Rute untuk melihat Katalog Lapangan & Booking (Testing Lokal)
Route::get('/lapangan', function () {
    $query = \App\Models\Lapangan::query();
    
    // Filter Pencarian Nama
    if (request('search')) {
        $query->where('nama_lapangan', 'like', '%' . request('search') . '%');
    }
    
    // Filter Kategori Olahraga
    if (request('jenis') && request('jenis') !== 'semua') {
        $query->where('jenis_olahraga', request('jenis'));
    }
    
    $courts = $query->paginate(6);
    return view('lapangan.index', compact('courts'));
})->name('lapangan.index');

// Rute Dummy Booking untuk menghindari error RouteNotFound
Route::get('/booking/create/{lapangan_id}', function ($lapangan_id) {
    return "Halaman Booking untuk Lapangan ID: " . $lapangan_id;
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
