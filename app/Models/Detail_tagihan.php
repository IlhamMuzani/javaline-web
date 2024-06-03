<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

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
        'no_do',
        'no_po',
        'tanggal_memo',
        'no_kabin',
        'no_pol',
        'jumlah',
        'satuan',
        'harga',
        'total',
        'nomor_buktifaktur',
        'tanggal_nomorfaktur',
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
    public function tagihan_ekspedisi()
    {
        return $this->belongsTo(Tagihan_ekspedisi::class);
    }

    public function faktur_ekspedisi()
    {
        return $this->belongsTo(Faktur_ekspedisi::class);
    }


}