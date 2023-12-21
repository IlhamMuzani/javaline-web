<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Detail_tagihan extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'tagihan_ekspedisi_id',
        'faktur_ekspedisi_id',
        'kode_faktur',
        'nama_rute',
        'no_memo',
        'tanggal_memo',
        'no_kabin',
        'no_pol',
        'jumlah',
        'satuan',
        'harga',
        'total',
        'tanggal_awal',
        'tanggal_akhir',
    ];
    
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable('*');
    }
    public function tagihan_ekspedisi()
    {
        return $this->belongsTo(Tagihan_ekspedisi::class);
    }

}