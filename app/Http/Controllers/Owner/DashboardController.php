<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Lapangan;
use App\Models\Pemesanan;
use App\Models\Transaction;
use App\Models\Withdrawal;

class DashboardController extends Controller
{
    public function index()
    {
        $lapanganIds = Lapangan::where('user_id', auth()->id())->pluck('id');

        $totalPendapatanBersih = Transaction::whereHas('pemesanan', function ($q) use ($lapanganIds) {
            $q->whereIn('lapangan_id', $lapanganIds);
        })->where('status_pembayaran', 'paid')->sum('net_amount');

        $totalDitarik = Withdrawal::where('user_id', auth()->id())
            ->where('status', 'approved')
            ->sum('jumlah_penarikan');

        $totalPending = Withdrawal::where('user_id', auth()->id())
            ->where('status', 'pending')
            ->sum('jumlah_penarikan');

        $saldoTersedia = $totalPendapatanBersih - $totalDitarik - $totalPending;

        $riwayatBooking = Pemesanan::whereIn('lapangan_id', $lapanganIds)
            ->with(['lapangan', 'user', 'transaction'])
            ->latest()
            ->get();

        return view('owner.dashboard', compact(
            'totalPendapatanBersih',
            'totalPending',
            'saldoTersedia',
            'riwayatBooking'
        ));
    }
}
