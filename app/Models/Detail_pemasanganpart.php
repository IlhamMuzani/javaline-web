<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Detail_pemasanganpart extends Model
{
    use LogsActivity;
    use HasFactory;
    protected $fillable = [
        'pemasangan_part_id',
        'sparepart_id',
        'keterangan',
        'jumlah',
    ];
    
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable('*');
    }
    
    public function detail_pemasanganpart()
    {
        return $this->belongsTo(Pemasangan_part::class);
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