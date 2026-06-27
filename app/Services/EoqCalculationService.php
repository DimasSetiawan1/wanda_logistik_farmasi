<?php

namespace App\Services;

use App\Models\Medicine;
use App\Models\EoqParameter;
use App\Models\EoqCalculation;

class EoqCalculationService
{
    /**
     * Jumlah hari kerja dalam setahun (untuk konversi tahunan ke harian)
     */
    const WORKING_DAYS_PER_YEAR = 300;

    /**
     * Hitung EOQ dan Min-Max untuk satu obat
     */
    public function calculate(Medicine $medicine, EoqParameter $parameter): EoqCalculation
    {
        $D = $parameter->rata_rata_permintaan; // Rata-rata permintaan per tahun
        $S = $parameter->biaya_pesan;           // Biaya pesan per order
        $H = $parameter->biaya_simpan;          // Biaya simpan per unit per tahun
        $P = $medicine->harga_per_unit;          // Harga per unit
        $I = $parameter->faktor_biaya_simpan;    // Faktor biaya simpan
        $LT = $parameter->lead_time;            // Lead time dalam hari
        $Z = $parameter->service_level_z;        // Service level Z

        // Jika H tidak diset, hitung dari I * P
        if ($H <= 0 && $I > 0) {
            $H = $I * $P;
        }

        // FASE 1: EOQ
        // EOQ* = sqrt(2 * D * S / H)
        $eoqValue = ($H > 0) ? sqrt((2 * $D * $S) / $H) : 0;

        // Frekuensi pesan: F = D / EOQ*
        $frekuensi = ($eoqValue > 0) ? $D / $eoqValue : 0;

        // Total Cost: TC = (D/EOQ* * S) + (EOQ*/2 * H) + (D * P)
        $totalCost = 0;
        if ($eoqValue > 0) {
            $totalCost = (($D / $eoqValue) * $S) + (($eoqValue / 2) * $H) + ($D * $P);
        }

        // FASE 2: MIN-MAX STOCK
        // d = rata-rata permintaan per hari
        $d = $D / self::WORKING_DAYS_PER_YEAR;

        // Safety Stock: SS = Z * d * sqrt(LT)
        $safetyStock = $Z * $d * sqrt($LT);

        // Reorder Point: ROP = (d * LT) + SS
        $reorderPoint = ($d * $LT) + $safetyStock;

        // Stok Minimum: Min = SS + (d * LT)
        $stokMinimum = $safetyStock + ($d * $LT);

        // Stok Maksimum: Max = Min + EOQ*
        $stokMaksimum = $stokMinimum + $eoqValue;

        // Tentukan status berdasarkan stok aktual
        $stokAktual = $medicine->stok_aktual;
        $status = 'normal';
        if ($stokAktual <= $stokMinimum) {
            $status = 'perlu_pesan';
        } elseif ($stokAktual >= $stokMaksimum) {
            $status = 'overstock';
        }

        // Simpan hasil perhitungan
        $calculation = EoqCalculation::updateOrCreate(
            [
                'medicine_id' => $medicine->id,
                'eoq_parameter_id' => $parameter->id,
            ],
            [
                'eoq_value' => round($eoqValue, 2),
                'frekuensi_pesan' => round($frekuensi, 2),
                'total_cost' => round($totalCost, 2),
                'safety_stock' => round($safetyStock, 2),
                'reorder_point' => round($reorderPoint, 2),
                'stok_minimum' => round($stokMinimum, 2),
                'stok_maksimum' => round($stokMaksimum, 2),
                'status' => $status,
            ]
        );

        return $calculation;
    }

    /**
     * Hitung EOQ & Min-Max untuk semua obat yang memiliki parameter
     */
    public function calculateAll(): array
    {
        $results = [];
        $medicines = Medicine::with('latestEoqParameter')->get();

        foreach ($medicines as $medicine) {
            $parameter = $medicine->latestEoqParameter;
            if ($parameter) {
                $results[] = $this->calculate($medicine, $parameter);
            }
        }

        return $results;
    }

    /**
     * Update status monitoring berdasarkan stok aktual terbaru
     */
    public function updateMonitoringStatus(): void
    {
        $calculations = EoqCalculation::with('medicine')->get();

        foreach ($calculations as $calc) {
            $stokAktual = $calc->medicine->stok_aktual;
            $status = 'normal';

            if ($stokAktual <= $calc->stok_minimum) {
                $status = 'perlu_pesan';
            } elseif ($stokAktual >= $calc->stok_maksimum) {
                $status = 'overstock';
            }

            if ($calc->status !== $status) {
                $calc->update(['status' => $status]);
            }
        }
    }
}
