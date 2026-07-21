<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Pemesanan;
use App\Models\Transaction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function getAvailability($lapangan_id, Request $request): JsonResponse
    {
        $request->validate([
            'tanggal' => ['required', 'date'],
        ]);

        $pemesanan = Pemesanan::where('lapangan_id', $lapangan_id)
            ->where('tanggal_pesan', $request->input('tanggal'))
            ->whereIn('status_pembayaran', ['lunas', 'belum_bayar'])
            ->get();

        $jamTerisi = [];
        foreach ($pemesanan as $p) {
            $start = Carbon::parse($p->jam_mulai);
            $durasi = (int) $p->total_durasi;
            for ($i = 0; $i < $durasi; $i++) {
                $jamTerisi[] = $start->copy()->addHours($i)->format('H:i');
            }
        }

        return response()->json(array_values(array_unique($jamTerisi)));
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'lapangan_id' => 'required',
            'tanggal_main' => 'required',
            'jam_mulai' => 'required',
            'durasi' => 'required',
            'total_harga' => 'required',
        ]);

        $jamMulai = Carbon::parse($request->input('jam_mulai'));
        $jamSelesai = $jamMulai->copy()->addHours($request->input('durasi'))->format('H:i');

        $pemesanan = Pemesanan::create([
            'user_id' => auth()->id(),
            'lapangan_id' => $request->input('lapangan_id'),
            'tanggal_pesan' => $request->input('tanggal_main'),
            'jam_mulai' => $request->input('jam_mulai'),
            'total_durasi' => $request->input('durasi'),
            'total_harga' => $request->input('total_harga'),
            'status_pembayaran' => 'belum_bayar',
            'jam_selesai' => $jamSelesai,
        ]);

        $kodeTransaksi = 'TRX-' . time() . '-U' . auth()->id();
        $totalHarga = $request->input('total_harga');

        $serverKey = env('MIDTRANS_SERVER_KEY') ?: config('services.midtrans.server_key');
        $authHeader = 'Basic ' . base64_encode($serverKey . ':');

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => $authHeader,
        ])->post('https://app.sandbox.midtrans.com/snap/v1/transactions', [
            'transaction_details' => [
                'order_id' => $kodeTransaksi,
                'gross_amount' => (int) $totalHarga,
            ],
            'customer_details' => [
                'first_name' => auth()->user()->name,
                'email' => auth()->user()->email,
            ],
            'callbacks' => [
                'finish' => url('/booking/history'),
            ],
        ]);

        $snapToken = null;
        $snapUrl = null;

        if ($response->successful()) {
            $resData = $response->json();
            $snapToken = $resData['token'] ?? null;
            $snapUrl = $resData['redirect_url'] ?? null;
        }

        $platformFee = $totalHarga * 0.02;
        $netAmount = $totalHarga - $platformFee;

        Transaction::create([
            'pemesanan_id' => $pemesanan->id,
            'kode_transaksi' => $kodeTransaksi,
            'gross_amount' => $totalHarga,
            'platform_fee' => $platformFee,
            'net_amount' => $netAmount,
            'status_pembayaran' => 'unpaid',
            'snap_token' => $snapToken,
            'snap_url' => $snapUrl,
        ]);

        return response()->json([
            'pemesanan' => $pemesanan,
            'snap_token' => $snapToken,
            'snap_url' => $snapUrl,
        ]);
    }

    public function index(): JsonResponse
    {
        $pemesanan = Pemesanan::where('user_id', auth()->id())
            ->with('lapangan')
            ->latest()
            ->get();

        return response()->json($pemesanan);
    }
}
