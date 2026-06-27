<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EoqParameter extends Model
{
    use HasFactory;

    protected $fillable = [
        'medicine_id',
        'rata_rata_permintaan',
        'biaya_pesan',
        'biaya_simpan',
        'faktor_biaya_simpan',
        'lead_time',
        'service_level_z',
    ];

    protected $casts = [
        'rata_rata_permintaan' => 'decimal:2',
        'biaya_pesan' => 'decimal:2',
        'biaya_simpan' => 'decimal:2',
        'faktor_biaya_simpan' => 'decimal:4',
        'service_level_z' => 'decimal:2',
    ];

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }

    public function eoqCalculations()
    {
        return $this->hasMany(EoqCalculation::class);
    }
}
