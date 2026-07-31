<?php

namespace Database\Seeders;

use App\Models\Medicine;
use App\Models\DemandData;
use App\Models\EoqParameter;
use App\Services\EoqCalculationService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MedicineSeeder extends Seeder
{
    public function run(): void
    {
        // Disable foreign key checks for clean truncation/replacement
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Medicine::truncate();
        DemandData::truncate();
        EoqParameter::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 20 Master Medicines from User Data Table
        $medicinesData = [
            [
                'kode_obat' => 'NB00000378',
                'nama_obat' => 'Acarbose 100 mg Tab (Dexa)',
                'kategori_obat' => 'Antidiabetik',
                'satuan' => 'Strip',
                'tingkat_pemakaian' => 'Sangat Sering',
                'harga_per_unit' => 4200,
                'stok_aktual' => 120,
                'tanggal_kadaluarsa' => '2027-06-30',
                'total_pemakaian_tahunan' => 960,
            ],
            [
                'kode_obat' => 'NB00000377',
                'nama_obat' => 'Acarbose 50 mg Tab (Dexa)',
                'kategori_obat' => 'Antidiabetik',
                'satuan' => 'Strip',
                'tingkat_pemakaian' => 'Sering',
                'harga_per_unit' => 3150,
                'stok_aktual' => 95,
                'tanggal_kadaluarsa' => '2027-05-15',
                'total_pemakaian_tahunan' => 840,
            ],
            [
                'kode_obat' => 'NB00000379',
                'nama_obat' => 'Acetylsistein 200 mg Caps (Dexa)',
                'kategori_obat' => 'Mukolitik',
                'satuan' => 'Strip',
                'tingkat_pemakaian' => 'Sering',
                'harga_per_unit' => 1567,
                'stok_aktual' => 85,
                'tanggal_kadaluarsa' => '2026-11-20',
                'total_pemakaian_tahunan' => 1080,
            ],
            [
                'kode_obat' => 'NB00000627',
                'nama_obat' => 'ACRAN 50 mg/2 mL (Ranitidine)',
                'kategori_obat' => 'Antiulkus',
                'satuan' => 'Ampul',
                'tingkat_pemakaian' => 'Jarang',
                'harga_per_unit' => 37607,
                'stok_aktual' => 30,
                'tanggal_kadaluarsa' => '2026-08-10',
                'total_pemakaian_tahunan' => 360,
            ],
            [
                'kode_obat' => 'NB00000380',
                'nama_obat' => 'Acyclovir 200 mg Tab (Novel)',
                'kategori_obat' => 'Antivirus',
                'satuan' => 'Strip',
                'tingkat_pemakaian' => 'Sering',
                'harga_per_unit' => 2092,
                'stok_aktual' => 110,
                'tanggal_kadaluarsa' => '2027-03-25',
                'total_pemakaian_tahunan' => 1200,
            ],
            [
                'kode_obat' => 'NB00000381',
                'nama_obat' => 'Acyclovir 400 mg Tab (Novel)',
                'kategori_obat' => 'Antivirus',
                'satuan' => 'Strip',
                'tingkat_pemakaian' => 'Sering',
                'harga_per_unit' => 2944,
                'stok_aktual' => 80,
                'tanggal_kadaluarsa' => '2026-12-15',
                'total_pemakaian_tahunan' => 720,
            ],
            [
                'kode_obat' => 'B00008032',
                'nama_obat' => 'Acyclovir Cream 5% 5 g',
                'kategori_obat' => 'Antivirus Topikal',
                'satuan' => 'Tube',
                'tingkat_pemakaian' => 'Jarang',
                'harga_per_unit' => 3247,
                'stok_aktual' => 35,
                'tanggal_kadaluarsa' => '2026-09-05',
                'total_pemakaian_tahunan' => 180,
            ],
            [
                'kode_obat' => 'NB00000508',
                'nama_obat' => 'Adalat Oros 30',
                'kategori_obat' => 'Antihipertensi',
                'satuan' => 'Strip',
                'tingkat_pemakaian' => 'Sering',
                'harga_per_unit' => 13924,
                'stok_aktual' => 90,
                'tanggal_kadaluarsa' => '2027-01-18',
                'total_pemakaian_tahunan' => 960,
            ],
            [
                'kode_obat' => 'NB0205202',
                'nama_obat' => 'Albendazol Tablet',
                'kategori_obat' => 'Antelmintik',
                'satuan' => 'Strip',
                'tingkat_pemakaian' => 'Jarang',
                'harga_per_unit' => 1540,
                'stok_aktual' => 70,
                'tanggal_kadaluarsa' => '2026-10-12',
                'total_pemakaian_tahunan' => 600,
            ],
            [
                'kode_obat' => 'NB00000728',
                'nama_obat' => 'Aldisa Caps',
                'kategori_obat' => 'Suplemen',
                'satuan' => 'Strip',
                'tingkat_pemakaian' => 'Sering',
                'harga_per_unit' => 9713,
                'stok_aktual' => 75,
                'tanggal_kadaluarsa' => '2027-04-30',
                'total_pemakaian_tahunan' => 720,
            ],
            [
                'kode_obat' => 'NB00000174',
                'nama_obat' => 'Alkohol Swab',
                'kategori_obat' => 'Antiseptik',
                'satuan' => 'Lembar',
                'tingkat_pemakaian' => 'Sangat Sering',
                'harga_per_unit' => 571000,
                'stok_aktual' => 500,
                'tanggal_kadaluarsa' => '2028-12-31',
                'total_pemakaian_tahunan' => 7200,
            ],
            [
                'kode_obat' => 'NB00000509',
                'nama_obat' => 'Allenor Tab',
                'kategori_obat' => 'Antihistamin',
                'satuan' => 'Strip',
                'tingkat_pemakaian' => 'Sering',
                'harga_per_unit' => 588000,
                'stok_aktual' => 60,
                'tanggal_kadaluarsa' => '2027-02-14',
                'total_pemakaian_tahunan' => 540,
            ],
            [
                'kode_obat' => 'NB00000382',
                'nama_obat' => 'Allopurinol 100 mg Tab',
                'kategori_obat' => 'Antihiperurisemia',
                'satuan' => 'Strip',
                'tingkat_pemakaian' => 'Sangat Sering',
                'harga_per_unit' => 1214,
                'stok_aktual' => 140,
                'tanggal_kadaluarsa' => '2027-08-20',
                'total_pemakaian_tahunan' => 1440,
            ],
            [
                'kode_obat' => 'NB00000383',
                'nama_obat' => 'Allopurinol 300 mg Tab',
                'kategori_obat' => 'Antihiperurisemia',
                'satuan' => 'Strip',
                'tingkat_pemakaian' => 'Sering',
                'harga_per_unit' => 1512,
                'stok_aktual' => 100,
                'tanggal_kadaluarsa' => '2027-07-10',
                'total_pemakaian_tahunan' => 960,
            ],
            [
                'kode_obat' => 'NB00000739',
                'nama_obat' => 'Alprazolam 0,5 mg Tab',
                'kategori_obat' => 'Sedatif/Ansiolitik',
                'satuan' => 'Strip',
                'tingkat_pemakaian' => 'Jarang',
                'harga_per_unit' => 1617,
                'stok_aktual' => 55,
                'tanggal_kadaluarsa' => '2026-11-05',
                'total_pemakaian_tahunan' => 480,
            ],
            [
                'kode_obat' => 'B00008033',
                'nama_obat' => 'Ambroxol 30 mg Tab',
                'kategori_obat' => 'Mukolitik',
                'satuan' => 'Strip',
                'tingkat_pemakaian' => 'Sangat Sering',
                'harga_per_unit' => 932000,
                'stok_aktual' => 180,
                'tanggal_kadaluarsa' => '2027-09-15',
                'total_pemakaian_tahunan' => 1920,
            ],
            [
                'kode_obat' => 'B00008035',
                'nama_obat' => 'Ambroxol Sirup 60 mL (Novapharin)',
                'kategori_obat' => 'Mukolitik',
                'satuan' => 'Botol',
                'tingkat_pemakaian' => 'Sering',
                'harga_per_unit' => 20979,
                'stok_aktual' => 40,
                'tanggal_kadaluarsa' => '2026-12-20',
                'total_pemakaian_tahunan' => 300,
            ],
            [
                'kode_obat' => 'NB00000003',
                'nama_obat' => 'Ambroxol Sirup 60 mL (Promed)',
                'kategori_obat' => 'Mukolitik',
                'satuan' => 'Botol',
                'tingkat_pemakaian' => 'Sering',
                'harga_per_unit' => 7770,
                'stok_aktual' => 35,
                'tanggal_kadaluarsa' => '2026-10-28',
                'total_pemakaian_tahunan' => 240,
            ],
            [
                'kode_obat' => 'NB00000628',
                'nama_obat' => 'Amikasin 250 mg/2 mL',
                'kategori_obat' => 'Antibiotik',
                'satuan' => 'Ampul',
                'tingkat_pemakaian' => 'Jarang',
                'harga_per_unit' => 50400,
                'stok_aktual' => 25,
                'tanggal_kadaluarsa' => '2026-07-15',
                'total_pemakaian_tahunan' => 240,
            ],
            [
                'kode_obat' => 'NB00000630',
                'nama_obat' => 'Aminophylline 240 mg/10 mL',
                'kategori_obat' => 'Bronkodilator',
                'satuan' => 'Ampul',
                'tingkat_pemakaian' => 'Jarang',
                'harga_per_unit' => 40404,
                'stok_aktual' => 20,
                'tanggal_kadaluarsa' => '2026-08-30',
                'total_pemakaian_tahunan' => 180,
            ],
        ];

        $periodes = [
            'Januari 2025', 'Februari 2025', 'Maret 2025', 'April 2025',
            'Mei 2025', 'Juni 2025', 'Juli 2025', 'Agustus 2025',
            'September 2025', 'Oktober 2025', 'November 2025', 'Desember 2025',
        ];

        $eoqCalcService = new EoqCalculationService();

        foreach ($medicinesData as $data) {
            $annualTotal = $data['total_pemakaian_tahunan'];
            unset($data['total_pemakaian_tahunan']);

            // Create Medicine record
            $medicine = Medicine::create($data);

            // Distribute annual total into 12 monthly demand records so sum equals annualTotal exactly
            $monthlyBase = floor($annualTotal / 12);
            $remainder = $annualTotal - ($monthlyBase * 12);

            foreach ($periodes as $index => $periode) {
                // Add remainder to last month so the sum is exact
                $monthlyDemand = $monthlyBase + ($index === 11 ? $remainder : 0);

                DemandData::create([
                    'medicine_id' => $medicine->id,
                    'periode' => $periode,
                    'jumlah_permintaan' => $monthlyDemand,
                ]);
            }

            // Ordering Cost S
            $biayaPesan = match ($medicine->satuan) {
                'Ampul', 'Vial' => 35000,
                'Botol', 'Tube' => 25000,
                default => 20000,
            };

            // Holding Cost H (10% of unit price, minimum Rp 100)
            $faktorBiayaSimpan = 0.10;
            $biayaSimpan = max(round($medicine->harga_per_unit * $faktorBiayaSimpan, 2), 100);

            // Lead Time LT (3 - 7 days)
            $leadTime = match ($medicine->tingkat_pemakaian) {
                'Sangat Sering' => 3,
                'Sering' => 5,
                default => 7,
            };

            // Create EOQ Parameter with exact annual demand D
            $parameter = EoqParameter::create([
                'medicine_id' => $medicine->id,
                'rata_rata_permintaan' => $annualTotal,
                'biaya_pesan' => $biayaPesan,
                'biaya_simpan' => $biayaSimpan,
                'faktor_biaya_simpan' => $faktorBiayaSimpan,
                'lead_time' => $leadTime,
                'service_level_z' => 1.65,
            ]);

            // Calculate EOQ & Min-Max
            $eoqCalcService->calculate($medicine, $parameter);
        }
    }
}
