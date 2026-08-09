<?php

namespace App\Services;

use App\Models\Medicine;
use Illuminate\Support\Collection;

class AbcAnalysisService
{
    /**
     * Lakukan Analisis ABC terhadap semua obat
     * Klasifikasi berdasarkan nilai pakai (jumlah × harga)
     *
     * @return Collection
     */
    public function analyze(): Collection
    {
        $medicines = Medicine::with('demandData')->get();

        // Hitung nilai pakai per obat
        $analysisData = $medicines->map(function ($medicine) {
            $totalPermintaan = $medicine->demandData->sum('jumlah_permintaan');
            $nilaiPakai = $totalPermintaan * $medicine->harga_per_unit;

            return [
                'medicine' => $medicine,
                'total_permintaan' => $totalPermintaan,
                'harga_per_unit' => $medicine->harga_per_unit,
                'nilai_pakai' => $nilaiPakai,
            ];
        });

        // Sort descending berdasarkan nilai pakai
        $analysisData = $analysisData->sortByDesc('nilai_pakai')->values();

        // Hitung total keseluruhan
        $totalNilaiPakai = $analysisData->sum('nilai_pakai');

        if ($totalNilaiPakai == 0) {
            return $analysisData;
        }

        // Hitung kumulatif persentase dan klasifikasi
        $kumulatif = 0;
        $analysisData = $analysisData->map(function ($item) use ($totalNilaiPakai, &$kumulatif) {
            $persentase = ($item['nilai_pakai'] / $totalNilaiPakai) * 100;
            $kumulatif += $persentase;

            // Klasifikasi ABC
            if ($kumulatif <= 70) {
                $kategori = 'A';
            } elseif ($kumulatif <= 90) {
                $kategori = 'B';
            } else {
                $kategori = 'C';
            }

            $item['persentase'] = round($persentase, 2);
            $item['kumulatif'] = round($kumulatif, 2);
            $item['kategori_abc'] = $kategori;

            // Update kategori di database
            $item['medicine']->update(['kategori' => $kategori]);

            return $item;
        });

        return $analysisData;
    }

    /**
     * Hitung ringkasan per kategori
     */
    public function getSummary(): array
    {
        $medicines = Medicine::all();
        $total = $medicines->count();

        return [
            'A' => [
                'count' => $medicines->where('kategori', 'A')->count(),
                'percentage' => $total > 0 ? round(($medicines->where('kategori', 'A')->count() / $total) * 100, 1) : 0,
                'description' => 'Nilai Persediaan Tinggi — Kontrol ketat, pemesanan terukur',
            ],
            'B' => [
                'count' => $medicines->where('kategori', 'B')->count(),
                'percentage' => $total > 0 ? round(($medicines->where('kategori', 'B')->count() / $total) * 100, 1) : 0,
                'description' => 'Nilai Persediaan Sedang — Kontrol moderat',
            ],
            'C' => [
                'count' => $medicines->where('kategori', 'C')->count(),
                'percentage' => $total > 0 ? round(($medicines->where('kategori', 'C')->count() / $total) * 100, 1) : 0,
                'description' => 'Nilai Persediaan Rendah — Kontrol sederhana',
            ],
        ];
    }
}
