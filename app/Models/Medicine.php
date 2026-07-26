<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_obat',
        'nama_obat',
        'kategori_obat',
        'satuan',
        'tingkat_pemakaian',
        'kategori',
        'harga_per_unit',
        'stok_aktual',
    ];

    protected $casts = [
        'harga_per_unit' => 'decimal:2',
    ];

    public function demandData()
    {
        return $this->hasMany(DemandData::class);
    }

    public function eoqParameters()
    {
        return $this->hasMany(EoqParameter::class);
    }

    public function latestEoqParameter()
    {
        return $this->hasOne(EoqParameter::class)->latestOfMany();
    }

    public function eoqCalculations()
    {
        return $this->hasMany(EoqCalculation::class);
    }

    public function latestEoqCalculation()
    {
        return $this->hasOne(EoqCalculation::class)->latestOfMany();
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
