<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Lapangan;
use App\Models\Transaction;
use App\Models\Withdrawal;
use Illuminate\Http\Request;

class WithdrawalController extends Controller
{
    private function getSaldoTersedia(): int
    {
        $lapanganIds = Lapangan::where('user_id', auth()->id())->pluck('id');

        $totalPendapatanBersih = Transaction::where('status_pembayaran', 'paid')
            ->whereHas('pemesanan', function ($q) use ($lapanganIds) {
                $q->whereIn('lapangan_id', $lapanganIds);
            })
            ->sum('net_amount');

        $totalDitarik = Withdrawal::where('user_id', auth()->id())
            ->where('status', 'approved')
            ->sum('jumlah_penarikan');

        $totalPending = Withdrawal::where('user_id', auth()->id())
            ->where('status', 'pending')
            ->sum('jumlah_penarikan');

        return (int) ($totalPendapatanBersih - $totalDitarik - $totalPending);
    }

    public function create()
    {
        $lapanganIds = Lapangan::where('user_id', auth()->id())->pluck('id');

        $totalPendapatanBersih = (int) Transaction::where('status_pembayaran', 'paid')
            ->whereHas('pemesanan', function ($q) use ($lapanganIds) {
                $q->whereIn('lapangan_id', $lapanganIds);
            })
            ->sum('net_amount');

        $totalDitarik = (int) Withdrawal::where('user_id', auth()->id())
            ->where('status', 'approved')
            ->sum('jumlah_penarikan');

        $totalPending = (int) Withdrawal::where('user_id', auth()->id())
            ->where('status', 'pending')
            ->sum('jumlah_penarikan');

        $saldoTersedia = $totalPendapatanBersih - $totalDitarik - $totalPending;

        return view('owner.withdrawal.create', compact('totalPendapatanBersih', 'totalPending', 'saldoTersedia'));
    }

    public function store(Request $request)
    {
        $saldoTersedia = $this->getSaldoTersedia();

        $request->validate([
            'jumlah_penarikan' => [
                'required',
                'integer',
                'min:10000',
                function ($attribute, $value, $fail) use ($saldoTersedia) {
                    if ($value > $saldoTersedia) {
                        $fail('Jumlah penarikan melebihi saldo tersedia (Rp ' . number_format($saldoTersedia, 0, ',', '.') . ').');
                    }
                },
            ],
            'bank_tujuan'      => 'required|string|max:100',
            'nomor_rekening'   => 'required|string|max:50',
        ]);

        Withdrawal::create([
            'user_id'          => auth()->id(),
            'jumlah_penarikan' => $request->jumlah_penarikan,
            'bank_tujuan'      => $request->bank_tujuan,
            'nomor_rekening'   => $request->nomor_rekening,
            'status'           => 'pending',
        ]);

        return redirect()->route('owner.dashboard')->with('success', 'Permintaan penarikan dana berhasil diajukan dan sedang diproses.');
    }
}
