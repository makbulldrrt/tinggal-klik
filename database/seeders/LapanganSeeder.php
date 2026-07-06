<?php

namespace Database\Seeders;

use App\Models\Lapangan;
use Illuminate\Database\Seeder;

class LapanganSeeder extends Seeder
{
    public function run(): void
    {
        $lapangan = [
            [
                'nama_lapangan'  => 'Lapangan Futsal A',
                'jenis_olahraga' => 'Futsal',
                'harga_per_jam'  => 100000,
                'deskripsi'      => 'Lapangan futsal indoor berstandar nasional dengan rumput sintetis berkualitas tinggi, pencahayaan LED, dan ruang ganti tersedia.',
                'status'         => 'tersedia',
            ],
            [
                'nama_lapangan'  => 'Lapangan Badminton B',
                'jenis_olahraga' => 'Badminton',
                'harga_per_jam'  => 75000,
                'deskripsi'      => 'Lapangan badminton indoor dengan lantai kayu parket anti-slip, net standar BWF, dan sistem ventilasi yang baik.',
                'status'         => 'tersedia',
            ],
            [
                'nama_lapangan'  => 'Lapangan Basket C',
                'jenis_olahraga' => 'Basket',
                'harga_per_jam'  => 120000,
                'deskripsi'      => 'Lapangan basket outdoor half-court dengan ring standar NBA, permukaan aspal halus, dan tersedia penerangan untuk malam hari.',
                'status'         => 'tersedia',
            ],
        ];

        foreach ($lapangan as $item) {
            Lapangan::create($item);
        }
    }
}
