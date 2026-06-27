<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Medicine;
use App\Models\DemandData;
use App\Models\EoqParameter;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // =====================
        // 1. USERS
        // =====================
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@rsph.co.id',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Apt. Wanda',
            'email' => 'apoteker@rsph.co.id',
            'password' => Hash::make('password'),
            'role' => 'apoteker',
        ]);

        // =====================
        // 2. MEDICINES (20 obat)
        // =====================
        $medicines = [
            ['kode_obat' => 'OBT001', 'nama_obat' => 'Amoxicillin 500mg', 'satuan' => 'Tablet', 'kategori' => 'C', 'harga_per_unit' => 1500, 'stok_aktual' => 320],
            ['kode_obat' => 'OBT002', 'nama_obat' => 'Paracetamol 500mg', 'satuan' => 'Tablet', 'kategori' => 'C', 'harga_per_unit' => 800, 'stok_aktual' => 450],
            ['kode_obat' => 'OBT003', 'nama_obat' => 'Omeprazole 20mg', 'satuan' => 'Kapsul', 'kategori' => 'C', 'harga_per_unit' => 3200, 'stok_aktual' => 180],
            ['kode_obat' => 'OBT004', 'nama_obat' => 'Metformin 500mg', 'satuan' => 'Tablet', 'kategori' => 'C', 'harga_per_unit' => 1200, 'stok_aktual' => 280],
            ['kode_obat' => 'OBT005', 'nama_obat' => 'Amlodipine 5mg', 'satuan' => 'Tablet', 'kategori' => 'C', 'harga_per_unit' => 2500, 'stok_aktual' => 200],
            ['kode_obat' => 'OBT006', 'nama_obat' => 'Ciprofloxacin 500mg', 'satuan' => 'Tablet', 'kategori' => 'C', 'harga_per_unit' => 4500, 'stok_aktual' => 150],
            ['kode_obat' => 'OBT007', 'nama_obat' => 'Ranitidine 150mg', 'satuan' => 'Tablet', 'kategori' => 'C', 'harga_per_unit' => 1800, 'stok_aktual' => 260],
            ['kode_obat' => 'OBT008', 'nama_obat' => 'Ceftriaxone 1g Inj', 'satuan' => 'Vial', 'kategori' => 'C', 'harga_per_unit' => 35000, 'stok_aktual' => 50],
            ['kode_obat' => 'OBT009', 'nama_obat' => 'NaCl 0.9% 500ml', 'satuan' => 'Botol', 'kategori' => 'C', 'harga_per_unit' => 12000, 'stok_aktual' => 120],
            ['kode_obat' => 'OBT010', 'nama_obat' => 'Dexamethasone 0.5mg', 'satuan' => 'Tablet', 'kategori' => 'C', 'harga_per_unit' => 900, 'stok_aktual' => 380],
            ['kode_obat' => 'OBT011', 'nama_obat' => 'Ketorolac 30mg Inj', 'satuan' => 'Ampul', 'kategori' => 'C', 'harga_per_unit' => 15000, 'stok_aktual' => 75],
            ['kode_obat' => 'OBT012', 'nama_obat' => 'Metronidazole 500mg', 'satuan' => 'Tablet', 'kategori' => 'C', 'harga_per_unit' => 2000, 'stok_aktual' => 220],
            ['kode_obat' => 'OBT013', 'nama_obat' => 'Lansoprazole 30mg', 'satuan' => 'Kapsul', 'kategori' => 'C', 'harga_per_unit' => 3500, 'stok_aktual' => 160],
            ['kode_obat' => 'OBT014', 'nama_obat' => 'Diazepam 5mg', 'satuan' => 'Tablet', 'kategori' => 'C', 'harga_per_unit' => 2800, 'stok_aktual' => 90],
            ['kode_obat' => 'OBT015', 'nama_obat' => 'Ondansetron 4mg Inj', 'satuan' => 'Ampul', 'kategori' => 'C', 'harga_per_unit' => 18000, 'stok_aktual' => 60],
            ['kode_obat' => 'OBT016', 'nama_obat' => 'Ringer Laktat 500ml', 'satuan' => 'Botol', 'kategori' => 'C', 'harga_per_unit' => 11500, 'stok_aktual' => 130],
            ['kode_obat' => 'OBT017', 'nama_obat' => 'Asam Mefenamat 500mg', 'satuan' => 'Tablet', 'kategori' => 'C', 'harga_per_unit' => 1000, 'stok_aktual' => 350],
            ['kode_obat' => 'OBT018', 'nama_obat' => 'Captopril 25mg', 'satuan' => 'Tablet', 'kategori' => 'C', 'harga_per_unit' => 1100, 'stok_aktual' => 300],
            ['kode_obat' => 'OBT019', 'nama_obat' => 'Salbutamol 2mg', 'satuan' => 'Tablet', 'kategori' => 'C', 'harga_per_unit' => 950, 'stok_aktual' => 270],
            ['kode_obat' => 'OBT020', 'nama_obat' => 'Vitamin B Complex', 'satuan' => 'Tablet', 'kategori' => 'C', 'harga_per_unit' => 600, 'stok_aktual' => 500],
        ];

        foreach ($medicines as $med) {
            Medicine::create($med);
        }

        // =====================
        // 3. DEMAND DATA (12 bulan)
        // =====================
        $periodes = [
            'Januari 2025', 'Februari 2025', 'Maret 2025', 'April 2025',
            'Mei 2025', 'Juni 2025', 'Juli 2025', 'Agustus 2025',
            'September 2025', 'Oktober 2025', 'November 2025', 'Desember 2025',
        ];

        // Rata-rata permintaan per bulan per obat (variasi realistis)
        $demandBase = [
            1 => 250, 2 => 400, 3 => 180, 4 => 200, 5 => 220,
            6 => 150, 7 => 190, 8 => 80,  9 => 300, 10 => 280,
            11 => 100, 12 => 170, 13 => 160, 14 => 60, 15 => 90,
            16 => 280, 17 => 320, 18 => 240, 19 => 180, 20 => 350,
        ];

        $allMedicines = Medicine::all();
        foreach ($allMedicines as $medicine) {
            $base = $demandBase[$medicine->id] ?? 150;
            foreach ($periodes as $periode) {
                // Variasi ±20%
                $variation = $base * (rand(80, 120) / 100);
                DemandData::create([
                    'medicine_id' => $medicine->id,
                    'periode' => $periode,
                    'jumlah_permintaan' => round($variation),
                ]);
            }
        }

        // =====================
        // 4. EOQ PARAMETERS
        // =====================
        $eoqParams = [
            // medicine_id => [D_tahunan, biaya_pesan, biaya_simpan, faktor_simpan, lead_time, Z]
            1  => [3000,  25000, 150,  0.10, 5, 1.65],
            2  => [4800,  20000, 80,   0.10, 3, 1.65],
            3  => [2160,  30000, 320,  0.10, 7, 1.65],
            4  => [2400,  25000, 120,  0.10, 5, 1.65],
            5  => [2640,  28000, 250,  0.10, 5, 1.65],
            6  => [1800,  35000, 450,  0.10, 7, 1.65],
            7  => [2280,  22000, 180,  0.10, 4, 1.65],
            8  => [960,   50000, 3500, 0.10, 10, 1.65],
            9  => [3600,  40000, 1200, 0.10, 5, 1.65],
            10 => [3360,  18000, 90,   0.10, 3, 1.65],
            11 => [1200,  45000, 1500, 0.10, 7, 1.65],
            12 => [2040,  25000, 200,  0.10, 5, 1.65],
            13 => [1920,  30000, 350,  0.10, 7, 1.65],
            14 => [720,   32000, 280,  0.10, 5, 1.65],
            15 => [1080,  48000, 1800, 0.10, 10, 1.65],
            16 => [3360,  38000, 1150, 0.10, 5, 1.65],
            17 => [3840,  20000, 100,  0.10, 3, 1.65],
            18 => [2880,  22000, 110,  0.10, 4, 1.65],
            19 => [2160,  20000, 95,   0.10, 4, 1.65],
            20 => [4200,  15000, 60,   0.10, 3, 1.65],
        ];

        foreach ($eoqParams as $medicineId => $params) {
            EoqParameter::create([
                'medicine_id' => $medicineId,
                'rata_rata_permintaan' => $params[0],
                'biaya_pesan' => $params[1],
                'biaya_simpan' => $params[2],
                'faktor_biaya_simpan' => $params[3],
                'lead_time' => $params[4],
                'service_level_z' => $params[5],
            ]);
        }
    }
}
