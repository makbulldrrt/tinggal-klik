<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            LapanganSeeder::class,
        ]);

        $user = \App\Models\User::first();
        $lapangan = \App\Models\Lapangan::first();

        if ($user && $lapangan) {
            $booking = \App\Models\Booking::create([
                'user_id' => $user->id,
                'lapangan_id' => $lapangan->id,
                'tanggal_main' => now()->toDateString(),
                'jam_mulai' => '10:00:00',
                'durasi' => 2,
                'total_harga' => $lapangan->harga_per_jam * 2,
                'status' => 'success',
            ]);

            \App\Models\Transaction::create([
                'booking_id' => $booking->id,
                'kode_transaksi' => 'TRX-' . time(),
                'status_pembayaran' => 'paid',
            ]);
        }
    }
}
