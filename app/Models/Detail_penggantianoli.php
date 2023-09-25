<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detail_penggantianoli extends Model
{
    use HasFactory;
    protected $fillable = [
        'penggantian_oli_id',
        'kategori',
        'sparepart_id',
        'km_penggantian',
        'km_berikutnya',
        'jumlah',
    ];

    public function detail_penggantian()
    {
        return $this->belongsTo(Penggantian_oli::class);
    }


    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class);
    }

    public function sparepart()
    {
        return $this->belongsTo(Sparepart::class);
    }
}