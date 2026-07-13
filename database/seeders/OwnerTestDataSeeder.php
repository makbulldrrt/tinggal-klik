<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Lapangan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class OwnerTestDataSeeder extends Seeder
{
    public function run(): void
    {
        $owner = User::create([
            'name' => 'Owner Lapangan Utama',
            'email' => 'owner@tinggalklik.com',
            'role' => 'owner',
            'password' => Hash::make('password'),
        ]);

        Lapangan::where('user_id', 1)->update([
            'user_id' => $owner->id
        ]);
    }
}
