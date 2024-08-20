<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Detail_pelunasanpotongan extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'faktur_pelunasan_id',
        'pelunasan_sewakendaraan_id',
        'faktur_ekspedisi_id',
        'sewa_kendaraan_id',
        'potongan_penjualan_id',
        'kode_potonganlain',
        'tanggal_potongan',
        'keterangan_potonganlain',
        'status',
        'nominallain',
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
    public function faktur_pelunasan()
    {
        return $this->belongsTo(Faktur_pelunasan::class);
    }
    public function faktur_ekspedisi()
    {
        return $this->belongsTo(Faktur_ekspedisi::class);
    }
}