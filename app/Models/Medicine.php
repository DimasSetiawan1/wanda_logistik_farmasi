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
        'tanggal_kadaluarsa',
    ];

    protected $casts = [
        'harga_per_unit' => 'decimal:2',
        'tanggal_kadaluarsa' => 'date',
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

    /**
     * Check if medicine is expired
     */
    public function isExpired(): bool
    {
        return $this->tanggal_kadaluarsa && $this->tanggal_kadaluarsa->isPast();
    }

    /**
     * Check if medicine is near expiration (within 30 days)
     */
    public function isNearExpired(): bool
    {
        return $this->tanggal_kadaluarsa && !$this->isExpired() && $this->tanggal_kadaluarsa->diffInDays(now()) <= 30;
    }
}
