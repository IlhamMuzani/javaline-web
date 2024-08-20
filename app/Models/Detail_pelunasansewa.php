<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Detail_pelunasansewa extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'pelunasan_sewakendaraan_id',
        'sewa_kendaraan_id',
        'kode_faktur',
        'tanggal_faktur',
        'status',
        'nota_return_id',
        'kode_return',
        'tanggal_return',
        'total_return',
        'total',
        'tanggal_awal',
        'tanggal_akhir',
    ];

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable('*');
    }
    public function pelunasan_sewakendaraan()
    {
        return $this->belongsTo(Pelunasan_sewakendaraan::class);
    }
    public function sewa_kendaraan()
    {
        return $this->belongsTo(Sewa_kendaraan::class);
    }

}