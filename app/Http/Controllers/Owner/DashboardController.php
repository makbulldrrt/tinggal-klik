<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Lapangan;
use App\Models\Pemesanan;
use App\Models\Transaction;
use App\Models\Withdrawal;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
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

        $transaksi = Pemesanan::whereIn('lapangan_id', $lapanganIds)
            ->with(['lapangan', 'user', 'transaction'])
            ->when($request->search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->whereHas('user', function ($uq) use ($search) {
                        $uq->where('name', 'like', '%' . $search . '%');
                    })->orWhereHas('transaction', function ($tq) use ($search) {
                        $tq->where('kode_transaksi', 'like', '%' . $search . '%');
                    });
                });
            })
            ->when($request->bulan, function ($query, $bulan) {
                $query->whereMonth('tanggal_pesan', $bulan);
            })
            ->when($request->tahun, function ($query, $tahun) {
                $query->whereYear('tanggal_pesan', $tahun);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('owner.dashboard', compact(
            'totalPendapatanBersih',
            'totalPending',
            'saldoTersedia',
            'transaksi'
        ));
    }
}
