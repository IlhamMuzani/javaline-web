<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Detail_pemakaian extends Model
{
    use LogsActivity;
    use HasFactory;
    protected $fillable = [
        'pemakaian_peralatan_id',
        'kendaraan_id',
        'sparepart_id',
        'keterangan',
        'tanggal_awal',
        'jumlah',
    ];

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable('*');
    }
    
    public function Pemakaian_peralatan()
    {
        return $this->belongsTo(Pemakaian_peralatan::class);
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