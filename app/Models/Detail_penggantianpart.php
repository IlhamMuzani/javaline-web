<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Detail_penggantianpart extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'penggantians_oli_id',
        'kategori2',
        'spareparts_id',
        'km_penggantian2',
        'km_berikutnya2',
        'jumlah2',
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

    public function spareparts()
    {
        return $this->belongsTo(Sparepart::class);
    }
}