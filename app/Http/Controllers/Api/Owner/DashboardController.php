<?php

namespace App\Http\Controllers\Api\Owner;

use App\Http\Controllers\Controller;
use App\Models\Lapangan;
use App\Models\Transaction;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    public function index(): JsonResponse
    {
        $userId = auth()->id();

        $totalLapangan = Lapangan::where('user_id', $userId)->count();

        $totalPendapatan = Transaction::whereHas('pemesanan.lapangan', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->where('status_pembayaran', 'paid')->sum('gross_amount');

        $latestTransactions = Transaction::whereHas('pemesanan.lapangan', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->with(['pemesanan.lapangan'])->latest()->take(5)->get();

        return response()->json([
            'total_pendapatan' => $totalPendapatan,
            'total_lapangan' => $totalLapangan,
            'recent_transactions' => $latestTransactions,
        ]);
    }
}
