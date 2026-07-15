<?php

namespace Database\Seeders;

use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Support User (Admin)
        User::create([
            'nama' => 'Admin Support',
            'email' => 'support@skk.co.id',
            'password' => Hash::make('password123'),
            'role' => UserRole::SUPPORT->value,
            'instansi_id' => null,
            'is_verified' => true,
        ]);

        // Pelapor User (Mitra)
        User::create([
            'nama' => 'PIC Koperasi Sejahtera',
            'email' => 'pic@koperasi.com',
            'password' => Hash::make('password123'),
            'role' => UserRole::PELAPOR->value,
            'instansi_id' => 1, // Asumsi ID 1 adalah Koperasi Kredit Sejahtera dari MasterDataSeeder
            'is_verified' => true,
        ]);
    }
}
