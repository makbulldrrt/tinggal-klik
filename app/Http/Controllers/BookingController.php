<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Lapangan;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class BookingController extends Controller
{
    /**
     * Tampilkan form untuk membuat booking baru.
     */
    public function create(Request $request): View
    {
        $lapanganId = $request->query('lapangan_id');
        
        $lapangan = Lapangan::findOrFail($lapanganId);

        return view('booking.create', compact('lapangan'));
    }

    /**
     * Simpan data booking ke database dengan mekanisme pencegahan double-booking.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'lapangan_id' => ['required', 'exists:lapangan,id'],
            'tanggal'     => ['required', 'date', 'after_or_equal:today'],
            'jam_mulai'   => ['required', 'date_format:H:i'],
            'jam_selesai' => ['required', 'date_format:H:i', 'after:jam_mulai'],
        ]);

        try {
            DB::beginTransaction();

            // Lock baris data lapangan yang akan di-booking (Pessimistic Locking)
            // Ini mencegah race condition di mana dua user memesan lapangan yang sama di waktu yang persis sama.
            $lapangan = Lapangan::lockForUpdate()->findOrFail($validated['lapangan_id']);

            // Cek apakah ada jadwal yang beririsan (Overlap)
            $isConflict = Booking::where('lapangan_id', $lapangan->id)
                ->where('tanggal', $validated['tanggal'])
                ->where('status', '!=', 'cancelled')
                ->where(function ($query) use ($validated) {
                    $query->where('jam_mulai', '<', $validated['jam_selesai'])
                          ->where('jam_selesai', '>', $validated['jam_mulai']);
                })
                ->exists();

            if ($isConflict) {
                // Lempar validation exception agar otomatis di-handle oleh Laravel (kembali dengan error message)
                throw ValidationException::withMessages([
                    'jam_mulai' => 'Maaf, slot waktu pada tanggal tersebut sudah dipesan.',
                ]);
            }

            // Hitung durasi (dalam jam, bisa desimal)
            $jamMulai = Carbon::createFromFormat('H:i', $validated['jam_mulai']);
            $jamSelesai = Carbon::createFromFormat('H:i', $validated['jam_selesai']);
            
            $durasiMenit = $jamMulai->diffInMinutes($jamSelesai);
            $durasiJam = $durasiMenit / 60;

            // Hitung total harga
            $totalHarga = $durasiJam * $lapangan->harga_per_jam;

            // Generate Kode Booking unik
            $kodeBooking = 'TK-' . date('Ymd') . '-' . strtoupper(Str::random(6));

            // Simpan Data Booking
            Booking::create([
                'kode_booking' => $kodeBooking,
                'user_id'      => auth()->id(),
                'lapangan_id'  => $lapangan->id,
                'tanggal'      => $validated['tanggal'],
                'jam_mulai'    => $validated['jam_mulai'],
                'jam_selesai'  => $validated['jam_selesai'],
                'total_harga'  => $totalHarga,
                'status'       => 'pending',
            ]);

            DB::commit();

            // Asumsikan ada rute 'booking.index' atau bisa disesuaikan dengan rute Anda
            // Kembalikan redirect back jika rute belum dibuat.
            return back()->with('success', 'Booking berhasil dibuat. Silakan selesaikan pembayaran.');

        } catch (ValidationException $e) {
            DB::rollBack();
            // Re-throw untuk ditangani validator Laravel
            throw $e;
        } catch (\Exception $e) {
            DB::rollBack();
            
            // Catat log error untuk keperluan debugging
            Log::error('Proses Booking Gagal: ' . $e->getMessage(), ['exception' => $e]);

            return back()->with('error', 'Terjadi kesalahan pada sistem kami. Gagal memproses booking Anda.')
                         ->withInput();
        }
    }
}
