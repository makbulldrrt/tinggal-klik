<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Lapangan;
use App\Models\Pemesanan;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class PemesananController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();

        if ($user->role === 'owner') {
            $lapanganIds = Lapangan::where('user_id', $user->id)->pluck('id');

            $pemesanans = Pemesanan::with(['lapangan', 'user', 'transaction'])
                ->whereIn('lapangan_id', $lapanganIds)
                ->latest()
                ->get();
        } else {
            $pemesanans = Pemesanan::with(['lapangan', 'transaction'])
                ->where('user_id', $user->id)
                ->latest()
                ->get();
        }

        return view('pemesanan.history', compact('pemesanans', 'user'));
    }

    public function invoice(int $id): View
    {
        $user = Auth::user();
        $pemesanan = Pemesanan::with(['lapangan.owner', 'user', 'transaction'])->findOrFail($id);

        if ($user->role === 'pelanggan' && $pemesanan->user_id !== $user->id) {
            abort(403);
        }

        if ($user->role === 'owner' && $pemesanan->lapangan->user_id !== $user->id) {
            abort(403);
        }

        return view('pemesanan.invoice', compact('pemesanan'));
    }

    public function create(int|string $lapangan_id): View
    {
        $lapangan = Lapangan::findOrFail($lapangan_id);

        return view('pemesanan.create', compact('lapangan'));
    }

    public function getAvailability(int $id, Request $request): JsonResponse
    {
        $tanggal = $request->query('tanggal');

        $bookings = Pemesanan::where('lapangan_id', $id)
            ->where('tanggal_pesan', $tanggal)
            ->where('status_pembayaran', '!=', 'batal')
            ->get(['jam_mulai', 'jam_selesai']);

        $booked = [];
        foreach ($bookings as $b) {
            $start = (int) substr($b->jam_mulai, 0, 2);
            $end   = (int) substr($b->jam_selesai, 0, 2);
            for ($h = $start; $h < $end; $h++) {
                $booked[] = str_pad($h, 2, '0', STR_PAD_LEFT) . ':00';
            }
        }

        return response()->json(array_values(array_unique($booked)));
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
