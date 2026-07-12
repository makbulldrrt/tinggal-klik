<?php

namespace Database\Seeders;

use App\Models\Lapangan;
use App\Models\User;
use Illuminate\Database\Seeder;

class LapanganSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil user pertama (Admin) sebagai owner/vendor dummy
        $owner = User::first();
        $ownerId = $owner ? $owner->id : null;

        $lapangan = [
            [
                'user_id'        => $ownerId,
                'nama_lapangan'  => 'Lapangan Futsal Merdeka',
                'jenis_olahraga' => 'Futsal',
                'harga_per_jam'  => 100000,
                'deskripsi'      => 'Lapangan futsal indoor berstandar nasional dengan rumput sintetis berkualitas tinggi, pencahayaan LED, dan ruang ganti tersedia.',
                'lokasi'         => 'Sudirman, Jakarta Pusat',
                'status'         => 'tersedia',
            ],
            [
                'user_id'        => $ownerId,
                'nama_lapangan'  => 'Lapangan Badminton Sentosa',
                'jenis_olahraga' => 'Badminton',
                'harga_per_jam'  => 75000,
                'deskripsi'      => 'Lapangan badminton indoor dengan lantai kayu parket anti-slip, net standar BWF, dan sistem ventilasi yang baik.',
                'lokasi'         => 'Kelapa Gading, Jakarta Utara',
                'status'         => 'tersedia',
            ],
            [
                'user_id'        => $ownerId,
                'nama_lapangan'  => 'Lapangan Basket Hall Diponegoro',
                'jenis_olahraga' => 'Basket',
                'harga_per_jam'  => 120000,
                'deskripsi'      => 'Lapangan basket outdoor half-court dengan ring standar NBA, permukaan aspal halus, dan tersedia penerangan untuk malam hari.',
                'lokasi'         => 'Menteng, Jakarta Pusat',
                'status'         => 'pemeliharaan',
            ],
            [
                'user_id'        => $ownerId,
                'nama_lapangan'  => 'Tennis Court Bukit Mas',
                'jenis_olahraga' => 'Tennis',
                'harga_per_jam'  => 95000,
                'deskripsi'      => 'Lapangan tennis outdoor berkualitas tinggi dengan permukaan keras (hard court).',
                'lokasi'         => 'Dago, Bandung',
                'status'         => 'tersedia',
            ],
            [
                'user_id'        => $ownerId,
                'nama_lapangan'  => 'Voli Pantai Ancol',
                'jenis_olahraga' => 'Voli',
                'harga_per_jam'  => 60000,
                'deskripsi'      => 'Lapangan voli pantai dengan pasir putih lembut di kawasan pantai Ancol.',
                'lokasi'         => 'Ancol, Jakarta Utara',
                'status'         => 'tersedia',
            ],
        ];

        foreach ($lapangan as $item) {
            Lapangan::create($item);
        }
    }
}
