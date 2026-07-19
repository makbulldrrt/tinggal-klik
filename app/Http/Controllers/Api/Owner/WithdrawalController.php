<?php

namespace App\Http\Controllers\Api\Owner;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Withdrawal;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WithdrawalController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'amount'         => ['required', 'numeric', 'min:10000'],
            'bank_name'      => ['required', 'string', 'max:100'],
            'account_number' => ['required', 'string', 'max:50'],
        ]);

        $userId = auth()->id();

        $totalIncome = Transaction::whereHas('pemesanan.lapangan', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->where('status_pembayaran', 'paid')->sum('net_amount');

        $totalWithdrawn = Withdrawal::where('user_id', $userId)
            ->whereIn('status', ['pending', 'approved'])
            ->sum('jumlah_penarikan');

        $balance = $totalIncome - $totalWithdrawn;

        if ($validated['amount'] > $balance) {
            return response()->json(['message' => 'Saldo tidak mencukupi.'], 400);
        }

        $withdrawal = Withdrawal::create([
            'user_id'          => $userId,
            'jumlah_penarikan' => $validated['amount'],
            'bank_tujuan'      => $validated['bank_name'],
            'nomor_rekening'   => $validated['account_number'],
            'status'           => 'pending',
        ]);

        return response()->json($withdrawal, 201);
    }
}
