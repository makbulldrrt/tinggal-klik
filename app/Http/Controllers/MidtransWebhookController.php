<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MidtransWebhookController extends Controller
{
    public function handleNotification(Request $request): JsonResponse
    {
        $orderId = $request->input('order_id');
        $transactionStatus = $request->input('transaction_status');

        $transaction = Transaction::with('pemesanan')->where('kode_transaksi', $orderId)->first();

        if ($transaction) {
            if ($transactionStatus == 'settlement') {
                $transaction->update(['status_pembayaran' => 'paid']);
                if ($transaction->pemesanan) {
                    $transaction->pemesanan->update(['status_pembayaran' => 'lunas']);
                }
            } elseif (in_array($transactionStatus, ['expire', 'cancel', 'deny'])) {
                $transaction->update(['status_pembayaran' => 'unpaid']);
                if ($transaction->pemesanan) {
                    $transaction->pemesanan->update(['status_pembayaran' => 'batal']);
                }
            }
        }

        return response()->json(['status' => 'success'], 200);
    }
}
