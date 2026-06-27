<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DemandData extends Model
{
    use HasFactory;

    protected $table = 'demand_data';

    protected $fillable = [
        'medicine_id',
        'periode',
        'jumlah_permintaan',
    ];

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }
}
