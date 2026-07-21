<?php

namespace App\Http\Controllers\Api\Owner;

use App\Http\Controllers\Controller;
use App\Models\Lapangan;
use App\Models\Transaction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $request->validate([
            'start_date' => ['nullable', 'date_format:Y-m-d'],
            'end_date'   => ['nullable', 'date_format:Y-m-d', 'after_or_equal:start_date'],
        ]);

        $userId = auth()->id();

        $totalLapangan = Lapangan::where('user_id', $userId)->count();

        $totalPendapatan = Transaction::whereHas('pemesanan.lapangan', function ($query) use ($userId) {
            $query->where('lapangan.user_id', $userId);
        })->where('transactions.status_pembayaran', 'paid')->sum('transactions.gross_amount');

        $latestTransactions = Transaction::whereHas('pemesanan.lapangan', function ($query) use ($userId) {
            $query->where('lapangan.user_id', $userId);
        })
        ->when($request->start_date && $request->end_date, function ($query) use ($request) {
            $query->whereBetween('transactions.created_at', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59',
            ]);
        })
        ->with(['pemesanan.lapangan'])
        ->latest()
        ->take(5)
        ->get();

        $recentWithdrawals = \App\Models\Withdrawal::where('user_id', $userId)
        ->latest()
        ->take(5)
        ->get();

        return response()->json([
            'total_pendapatan'    => $totalPendapatan,
            'total_lapangan'      => $totalLapangan,
            'recent_transactions' => $latestTransactions,
            'recent_withdrawals'  => $recentWithdrawals,
        ]);
    }

    public function getAnalyticsData(Request $request): JsonResponse
    {
        $request->validate([
            'start_date' => ['nullable', 'date_format:Y-m-d'],
            'end_date'   => ['nullable', 'date_format:Y-m-d', 'after_or_equal:start_date'],
        ]);

        $userId = auth()->id();

        $analytics = Transaction::whereHas('pemesanan.lapangan', function ($query) use ($userId) {
            $query->where('lapangan.user_id', $userId);
        })
        ->where('transactions.status_pembayaran', 'paid')
        ->when($request->start_date && $request->end_date, function ($query) use ($request) {
            $query->whereBetween('transactions.created_at', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59',
            ]);
        })
        ->join('pemesanan', 'transactions.pemesanan_id', '=', 'pemesanan.id')
        ->join('lapangan', 'pemesanan.lapangan_id', '=', 'lapangan.id')
        ->selectRaw('lapangan.jenis_olahraga, COUNT(transactions.id) as total_bookings, SUM(transactions.gross_amount) as total_revenue')
        ->groupBy('lapangan.jenis_olahraga')
        ->get();

        $totalRevenueAll = $analytics->sum('total_revenue');

        $data = $analytics->map(function ($item) use ($totalRevenueAll) {
            $percentage = $totalRevenueAll > 0 ? round(($item->total_revenue / $totalRevenueAll) * 100, 2) : 0;
            return [
                'kategori'       => $item->jenis_olahraga,
                'total_bookings' => $item->total_bookings,
                'total_revenue'  => $item->total_revenue,
                'percentage'     => $percentage,
            ];
        });

        return response()->json($data);
    }
}
