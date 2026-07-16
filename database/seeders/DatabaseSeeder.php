<?php

namespace Database\Seeders;

use App\Models\Lapangan;
use App\Models\Pemesanan;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Withdrawal;
use App\Models\Ulasan;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            LapanganSeeder::class,
        ]);

        $pelanggan1 = User::where('email', 'budi@tinggalklik.com')->first();
        $pelanggan2 = User::where('email', 'siti@tinggalklik.com')->first();
        $owner1 = User::where('email', 'decky@tinggalklik.com')->first();
        $owner2 = User::where('email', 'mitra@tinggalklik.com')->first();

        $lapanganFutsal = Lapangan::where('nama_lapangan', 'Lapangan Futsal Merdeka')->first();
        $lapanganBadminton = Lapangan::where('nama_lapangan', 'Lapangan Badminton Sentosa')->first();
        $lapanganTennis = Lapangan::where('nama_lapangan', 'Tennis Court Bukit Mas')->first();

        if ($pelanggan1 && $lapanganFutsal) {
            $p1 = Pemesanan::create([
                'user_id' => $pelanggan1->id,
                'lapangan_id' => $lapanganFutsal->id,
                'tanggal_pesan' => now()->toDateString(),
                'jam_mulai' => '14:00:00',
                'jam_selesai' => '16:00:00',
                'total_durasi' => 2,
                'total_harga' => $lapanganFutsal->harga_per_jam * 2,
            ]);

            Transaction::create([
                'pemesanan_id' => $p1->id,
                'kode_transaksi' => 'TRX-FUTSAL-1',
                'gross_amount' => $p1->total_harga,
                'platform_fee' => $p1->total_harga * 0.02,
                'net_amount' => $p1->total_harga * 0.98,
                'status_pembayaran' => 'paid',
            ]);

            Ulasan::create([
                'user_id' => $pelanggan1->id,
                'lapangan_id' => $lapanganFutsal->id,
                'rating' => 5,
                'komentar' => 'Tempatnya sangat bersih, pencahayaan lapangan futsalnya sangat bagus untuk main malam hari!',
            ]);
        }

        if ($pelanggan2 && $lapanganBadminton) {
            $p2 = Pemesanan::create([
                'user_id' => $pelanggan2->id,
                'lapangan_id' => $lapanganBadminton->id,
                'tanggal_pesan' => now()->addDay()->toDateString(),
                'jam_mulai' => '09:00:00',
                'jam_selesai' => '12:00:00',
                'total_durasi' => 3,
                'total_harga' => $lapanganBadminton->harga_per_jam * 3,
            ]);

            Transaction::create([
                'pemesanan_id' => $p2->id,
                'kode_transaksi' => 'TRX-BADMINTON-1',
                'gross_amount' => $p2->total_harga,
                'platform_fee' => $p2->total_harga * 0.02,
                'net_amount' => $p2->total_harga * 0.98,
                'status_pembayaran' => 'paid',
            ]);
        }

        if ($pelanggan1 && $lapanganTennis) {
            $p3 = Pemesanan::create([
                'user_id' => $pelanggan1->id,
                'lapangan_id' => $lapanganTennis->id,
                'tanggal_pesan' => now()->toDateString(),
                'jam_mulai' => '16:00:00',
                'jam_selesai' => '18:00:00',
                'total_durasi' => 2,
                'total_harga' => $lapanganTennis->harga_per_jam * 2,
            ]);

            Transaction::create([
                'pemesanan_id' => $p3->id,
                'kode_transaksi' => 'TRX-TENNIS-1',
                'gross_amount' => $p3->total_harga,
                'platform_fee' => $p3->total_harga * 0.02,
                'net_amount' => $p3->total_harga * 0.98,
                'status_pembayaran' => 'paid',
            ]);
        }

        if ($pelanggan2 && $lapanganFutsal) {
            $p4 = Pemesanan::create([
                'user_id' => $pelanggan2->id,
                'lapangan_id' => $lapanganFutsal->id,
                'tanggal_pesan' => now()->toDateString(),
                'jam_mulai' => '19:00:00',
                'jam_selesai' => '20:00:00',
                'total_durasi' => 1,
                'total_harga' => $lapanganFutsal->harga_per_jam * 1,
            ]);

            Transaction::create([
                'pemesanan_id' => $p4->id,
                'kode_transaksi' => 'TRX-FUTSAL-2',
                'gross_amount' => $p4->total_harga,
                'platform_fee' => $p4->total_harga * 0.02,
                'net_amount' => $p4->total_harga * 0.98,
                'status_pembayaran' => 'pending',
            ]);
        }

        if ($owner1) {
            Withdrawal::create([
                'user_id' => $owner1->id,
                'jumlah_penarikan' => 50000,
                'bank_tujuan' => 'BCA',
                'nomor_rekening' => '1111111111',
                'status' => 'pending',
            ]);

            Withdrawal::create([
                'user_id' => $owner1->id,
                'jumlah_penarikan' => 100000,
                'bank_tujuan' => 'BNI',
                'nomor_rekening' => '2222222222',
                'status' => 'approved',
            ]);
        }

        if ($owner2) {
            Withdrawal::create([
                'user_id' => $owner2->id,
                'jumlah_penarikan' => 75000,
                'bank_tujuan' => 'BRI',
                'nomor_rekening' => '3333333333',
                'status' => 'rejected',
            ]);

            Withdrawal::create([
                'user_id' => $owner2->id,
                'jumlah_penarikan' => 120000,
                'bank_tujuan' => 'Mandiri',
                'nomor_rekening' => '4444444444',
                'status' => 'pending',
            ]);
        }
    }
}
