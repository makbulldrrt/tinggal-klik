<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Lapangan;
use App\Models\Pemesanan;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class PemesananController extends Controller
{
    public function create(int|string $lapangan_id): View
    {
        $lapangan = Lapangan::findOrFail($lapangan_id);

        return view('pemesanan.create', compact('lapangan'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'lapangan_id'   => ['required', 'exists:lapangan,id'],
            'tanggal_pesan' => ['required', 'date'],
            'jam_mulai'     => ['required', 'date_format:H:i'],
            'jam_selesai'   => ['required', 'date_format:H:i', 'after:jam_mulai'],
        ]);

        $jamMulai   = Carbon::createFromFormat('H:i', $validated['jam_mulai']);
        $jamSelesai = Carbon::createFromFormat('H:i', $validated['jam_selesai']);
        $diffMenit  = (int) $jamMulai->diffInMinutes($jamSelesai);

        if ($diffMenit % 60 !== 0) {
            throw ValidationException::withMessages([
                'jam_selesai' => 'Durasi harus kelipatan 1 jam penuh.',
            ]);
        }

        $totalDurasi = (int) ($diffMenit / 60);
        $lapangan    = Lapangan::findOrFail($validated['lapangan_id']);
        $totalHarga  = (int) ($totalDurasi * $lapangan->harga_per_jam);
        $platformFee = (int) ($totalHarga * 0.02);
        $netAmount   = $totalHarga - $platformFee;
        $kodeTransaksi = 'TRX-' . time() . '-U' . Auth::id();

        $redirectUrl = DB::transaction(function () use ($validated, $totalDurasi, $totalHarga, $platformFee, $netAmount, $kodeTransaksi) {
            $overlap = Pemesanan::where('lapangan_id', $validated['lapangan_id'])
                ->where('tanggal_pesan', $validated['tanggal_pesan'])
                ->where('status_pembayaran', '!=', 'batal')
                ->where(function ($query) use ($validated) {
                    $query->where('jam_mulai', '<', $validated['jam_selesai'])
                          ->where('jam_selesai', '>', $validated['jam_mulai']);
                })
                ->lockForUpdate()
                ->exists();

            if ($overlap) {
                throw ValidationException::withMessages([
                    'jam_mulai' => 'Jadwal sudah dibooking orang lain.',
                ]);
            }

            $pemesanan = Pemesanan::create([
                'user_id'           => Auth::id(),
                'lapangan_id'       => $validated['lapangan_id'],
                'tanggal_pesan'     => $validated['tanggal_pesan'],
                'jam_mulai'         => $validated['jam_mulai'],
                'jam_selesai'       => $validated['jam_selesai'],
                'total_durasi'      => $totalDurasi,
                'total_harga'       => $totalHarga,
                'status_pembayaran' => 'belum_bayar',
            ]);

            Transaction::create([
                'pemesanan_id'      => $pemesanan->id,
                'kode_transaksi'    => $kodeTransaksi,
                'gross_amount'      => $totalHarga,
                'platform_fee'      => $platformFee,
                'net_amount'        => $netAmount,
                'status_pembayaran' => 'unpaid',
            ]);

            $response = Http::withBasicAuth(env('MIDTRANS_SERVER_KEY'), '')
                ->post('https://app.sandbox.midtrans.com/snap/v1/transactions', [
                    'transaction_details' => [
                        'order_id'     => $kodeTransaksi,
                        'gross_amount' => $totalHarga,
                    ],
                    'customer_details' => [
                        'first_name' => Auth::user()->name,
                        'email'      => Auth::user()->email,
                    ],
                ]);

            return $response->json('redirect_url');
        });

        return redirect($redirectUrl);
    }
}
