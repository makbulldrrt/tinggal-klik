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
            $pemesanan = \App\Models\Pemesanan::create([
                'user_id' => $user->id,
                'lapangan_id' => $lapangan->id,
                'tanggal_pesan' => now()->toDateString(),
                'jam_mulai' => '10:00:00',
                'jam_selesai' => '12:00:00',
                'total_durasi' => 2,
                'total_harga' => $lapangan->harga_per_jam * 2,
                'status_pembayaran' => 'lunas',
            ]);

            \App\Models\Transaction::create([
                'pemesanan_id' => $pemesanan->id,
                'kode_transaksi' => 'TRX-' . time(),
                'gross_amount' => $pemesanan->total_harga,
                'platform_fee' => $pemesanan->total_harga * 0.02,
                'net_amount' => $pemesanan->total_harga - ($pemesanan->total_harga * 0.02),
                'status_pembayaran' => 'paid',
            ]);
        }
    }
}
