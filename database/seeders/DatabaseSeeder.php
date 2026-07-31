<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // =====================
        // 1. USERS (3 Roles)
        // =====================
        User::firstOrCreate(
            ['username' => 'admin'],
            [
                'name' => 'Administrator',
                'email' => 'admin@rsph.co.id',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        User::firstOrCreate(
            ['username' => 'farmasi'],
            [
                'name' => 'Petugas Instalasi Farmasi',
                'email' => 'farmasi@rsph.co.id',
                'password' => Hash::make('password'),
                'role' => 'instalasi_farmasi',
            ]
        );

        User::firstOrCreate(
            ['username' => 'kepala'],
            [
                'name' => 'Kepala Instalasi Farmasi',
                'email' => 'kepala@rsph.co.id',
                'password' => Hash::make('password'),
                'role' => 'kepala_instalasi',
            ]
        );

        // =====================
        // 2. MEDICINES & CALCULATIONS SEEDER
        // =====================
        $this->call(MedicineSeeder::class);
    }
}
