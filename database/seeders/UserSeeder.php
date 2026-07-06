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
