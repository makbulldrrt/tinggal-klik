<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name'              => 'Admin TinggalKlik',
            'email'             => 'admin@tinggalklik.com',
            'role'              => 'admin',
            'password'          => Hash::make('admin123'),
            'email_verified_at' => now(),
        ]);

        User::create([
            'name'              => 'decky apip',
            'email'             => 'decky@tinggalklik.com',
            'role'              => 'owner',
            'nama_bisnis'       => 'Decky Sport Center',
            'password'          => Hash::make('password123'),
            'email_verified_at' => now(),
        ]);

        User::create([
            'name'              => 'Mitra Futsal Sejahtera',
            'email'             => 'mitra@tinggalklik.com',
            'role'              => 'owner',
            'nama_bisnis'       => 'Arena Futsal Merdeka',
            'password'          => Hash::make('password123'),
            'email_verified_at' => now(),
        ]);

        User::create([
            'name'              => 'Budi Santoso',
            'email'             => 'budi@tinggalklik.com',
            'role'              => 'pelanggan',
            'password'          => Hash::make('password123'),
            'email_verified_at' => now(),
        ]);

        User::create([
            'name'              => 'Siti Rahayu',
            'email'             => 'siti@tinggalklik.com',
            'role'              => 'pelanggan',
            'password'          => Hash::make('password123'),
            'email_verified_at' => now(),
        ]);
    }
}
