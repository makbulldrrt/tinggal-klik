<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Lapangan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class OwnerTestDataSeeder extends Seeder
{
    public function run(): void
    {
        Role::findOrCreate('owner');
        Role::findOrCreate('customer');

        $owner = User::updateOrCreate(
            ['email' => 'owner@tinggalklik.com'],
            [
                'name' => 'Owner Lapangan Utama',
                'role' => 'owner',
                'password' => Hash::make('password'),
            ]
        );

        $owner->assignRole('owner');

        Lapangan::where('user_id', 1)->update([
            'user_id' => $owner->id
        ]);
    }
}
