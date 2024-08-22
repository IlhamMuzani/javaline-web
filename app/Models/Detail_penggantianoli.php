<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Detail_penggantianoli extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'penggantian_oli_id',
        'lama_penggantianoli_id',
        'kategori',
        'sparepart_id',
        'km_penggantian',
        'km_berikutnya',
        'jumlah',
    ];

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable('*');
    }


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

    public function lama_penggantianoli()
    {
        return $this->belongsTo(Lama_penggantianoli::class);
    }
}