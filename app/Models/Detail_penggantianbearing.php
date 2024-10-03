<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Detail_penggantianbearing extends Model
{
    use LogsActivity;
    use HasFactory;
    protected $fillable = [
        'penggantian_bearing_id',
        'kendaraan_id',
        'sparepart_id',
        'kategori',
        'kode_barang',
        'nama_barang',
        'jumlah',
        'km_penggantian',
        'km_berikutnya',
        'spareparts_id',
        'kode_grease',
        'nama_grease',
        'jumlah_grease',
        'keterangan',
        'tanggal_awal',
    ];

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable('*');
    }
    
    public function Penggantian_bearing()
    {
        return $this->belongsTo(Penggantian_bearing::class);
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