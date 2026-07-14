<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Mail\InvoiceMail;
use App\Models\Transaction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class WebhookController extends Controller
{
    public function handleMidtrans(Request $request): JsonResponse
    {
        $payload   = $request->all();
        $signature = hash('sha512', $payload['order_id'] . $payload['status_code'] . $payload['gross_amount'] . env('MIDTRANS_SERVER_KEY'));

        if ($signature !== $payload['signature_key']) {
            return response()->json(['status' => 'invalid signature'], 403);
        }

        $transaction = Transaction::where('kode_transaksi', $payload['order_id'])->firstOrFail();
        $pemesanan   = $transaction->pemesanan;

        switch ($payload['transaction_status']) {
            case 'capture':
            case 'settlement':
                $transaction->update(['status_pembayaran' => 'paid']);
                $pemesanan->update(['status_pembayaran'   => 'lunas']);

                $pemesanan->load(['lapangan', 'user', 'transaction']);
                $user = $pemesanan->user;

                try {
                    Mail::to($user->email)->send(new InvoiceMail($pemesanan));
                } catch (\Throwable $e) {
                    \Illuminate\Support\Facades\Log::error('InvoiceMail failed: ' . $e->getMessage());
                }
                break;

            case 'cancel':
            case 'deny':
            case 'expire':
                $transaction->update(['status_pembayaran' => 'failed']);
                $pemesanan->update(['status_pembayaran'   => 'batal']);
                break;
        }

        return response()->json(['status' => 'success']);
    }
}
