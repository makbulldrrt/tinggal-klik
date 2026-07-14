<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Transaction;

class DashboardController extends Controller
{
    public function index()
    {
        $total_revenue = Booking::whereHas('transaction', function($q) {
            $q->where('status_pembayaran', 'paid');
        })->orWhere('status', 'success')->sum('total_harga');

        $total_bookings = Booking::count();

        $pending_bookings = Booking::where('status', 'pending')->count();

        $recent_bookings = Booking::with(['user', 'lapangan', 'transaction'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'total_revenue',
            'total_bookings',
            'pending_bookings',
            'recent_bookings'
        ));
    }
}
