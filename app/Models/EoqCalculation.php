<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EoqCalculation extends Model
{
    use HasFactory;

    protected $fillable = [
        'medicine_id',
        'eoq_parameter_id',
        'eoq_value',
        'frekuensi_pesan',
        'total_cost',
        'safety_stock',
        'reorder_point',
        'stok_minimum',
        'stok_maksimum',
        'status',
    ];

    protected $casts = [
        'eoq_value' => 'decimal:2',
        'frekuensi_pesan' => 'decimal:2',
        'total_cost' => 'decimal:2',
        'safety_stock' => 'decimal:2',
        'reorder_point' => 'decimal:2',
        'stok_minimum' => 'decimal:2',
        'stok_maksimum' => 'decimal:2',
    ];

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }

    public function eoqParameter()
    {
        return $this->belongsTo(EoqParameter::class);
    }
}
