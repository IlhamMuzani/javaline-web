<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Detail_faktur extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'faktur_ekspedisi_id',
        'memo_ekspedisi_id',
        'kendaraan_id',
        'no_kabin',
        'kode_memo',
        'kode_driver',
        'nama_driver',
        'telp_driver',
        'nama_rute',
        'kategori_memo',
        'tanggal_awal',
        'tanggal_akhir',
    ];
    
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable('*');
    }
    public function faktur_ekspedisi()
    {
        return $this->belongsTo(Faktur_ekspedisi::class);
    }

    public function memo_ekpedisi()
    {
        return $this->belongsTo(Memo_ekspedisi::class);
    }

}