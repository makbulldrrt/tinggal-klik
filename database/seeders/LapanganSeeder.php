<?php

namespace Database\Seeders;

use App\Models\Lapangan;
use App\Models\User;
use Illuminate\Database\Seeder;

class LapanganSeeder extends Seeder
{
    public function run(): void
    {
        $owner1 = User::where('email', 'decky@tinggalklik.com')->first();
        $owner2 = User::where('email', 'mitra@tinggalklik.com')->first();

        $ownerId1 = $owner1 ? $owner1->id : null;
        $ownerId2 = $owner2 ? $owner2->id : null;

        $lapangan = [
            [
                'user_id'        => $ownerId1,
                'nama_lapangan'  => 'Lapangan Futsal Merdeka',
                'jenis_olahraga' => 'Futsal',
                'harga_per_jam'  => 100000,
                'deskripsi'      => 'Lapangan futsal indoor berstandar nasional dengan rumput sintetis berkualitas tinggi, pencahayaan LED, dan ruang ganti tersedia.',
                'lokasi'         => 'Sudirman, Jakarta Pusat',
                'status'         => 'Tersedia',
            ],
            [
                'user_id'        => $ownerId1,
                'nama_lapangan'  => 'Lapangan Badminton Sentosa',
                'jenis_olahraga' => 'Badminton',
                'harga_per_jam'  => 75000,
                'deskripsi'      => 'Lapangan badminton indoor dengan lantai kayu parket anti-slip, net standar BWF, dan sistem ventilasi yang baik.',
                'lokasi'         => 'Kelapa Gading, Jakarta Utara',
                'status'         => 'Tersedia',
            ],
            [
                'user_id'        => $ownerId2,
                'nama_lapangan'  => 'Lapangan Basket Hall Diponegoro',
                'jenis_olahraga' => 'Basket',
                'harga_per_jam'  => 120000,
                'deskripsi'      => 'Lapangan basket outdoor half-court dengan ring standar NBA, permukaan aspal halus, dan tersedia penerangan untuk malam hari.',
                'lokasi'         => 'Menteng, Jakarta Pusat',
                'status'         => 'Pemeliharaan',
            ],
            [
                'user_id'        => $ownerId2,
                'nama_lapangan'  => 'Tennis Court Bukit Mas',
                'jenis_olahraga' => 'Tennis',
                'harga_per_jam'  => 95000,
                'deskripsi'      => 'Lapangan tennis outdoor berkualitas tinggi dengan permukaan keras (hard court).',
                'lokasi'         => 'Dago, Bandung',
                'status'         => 'Tersedia',
            ],
        ];

        foreach ($lapangan as $item) {
            Lapangan::create($item);
        }
    }
}
