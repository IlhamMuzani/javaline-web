<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Detail_pemasanganaki extends Model
{
    use LogsActivity;
    use HasFactory;
    protected $fillable = [
        'pemasangan_aki_id',
        'aki_id',
        'kode_aki',
        'merek',
        'keterangan',
        'jumlah',
    ];

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable('*');
    }
    
    public function pemasangan_aki()
    {
        return $this->belongsTo(Pemasangan_aki::class);
    }


    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class);
    }

    public function aki()
    {
        return $this->belongsTo(Aki::class);
    }
}