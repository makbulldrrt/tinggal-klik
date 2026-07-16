<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Withdrawal;
use Illuminate\Http\Request;

class AdminTransactionController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');
        $type = $request->input('type');

        $totalRevenue = Transaction::whereIn('status_pembayaran', ['paid', 'lunas'])->sum('platform_fee');
        $totalOwner = User::where('role', 'owner')->count();
        $totalPelanggan = User::where('role', 'pelanggan')->count();
        $pendingWithdrawals = Withdrawal::where('status', 'pending')->count();

        $transactions = collect();
        if ($type !== 'penarikan') {
            $transactionsQuery = Transaction::with(['pemesanan.user', 'pemesanan.lapangan']);
            if ($search) {
                $transactionsQuery->where(function ($q) use ($search) {
                    $q->where('kode_transaksi', 'like', '%' . $search . '%')
                      ->orWhereHas('pemesanan.user', function ($uq) use ($search) {
                          $uq->where('name', 'like', '%' . $search . '%');
                      });
                });
            }
            if ($status) {
                $transactionsQuery->where('status_pembayaran', $status);
            }
            $transactions = $transactionsQuery->latest()->paginate(5, ['*'], 'page_tx')->withQueryString();
        }

        $withdrawals = collect();
        if ($type !== 'transaksi') {
            $withdrawalsQuery = Withdrawal::with('user');
            if ($search) {
                $withdrawalsQuery->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%');
                });
            }
            if ($status) {
                $withdrawalsQuery->where('status', $status);
            }
            $withdrawals = $withdrawalsQuery->latest()->paginate(5, ['*'], 'page_wd')->withQueryString();
        }

        return view('admin.transactions.index', compact(
            'totalRevenue',
            'totalOwner',
            'totalPelanggan',
            'pendingWithdrawals',
            'transactions',
            'withdrawals'
        ));
    }
}
