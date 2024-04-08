<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Detail_memo extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'memo_ekspedisi_id',
        'biaya_id',
        'potongan_id',
        'kode_biaya',
        'nama_biaya',
        'nominal',
        'kode_potongan',
        'keterangan_potongan',
        'nominal_potongan',
        'tanggal_awal',
        'tanggal_akhir',
        'rute_id' ,
        'kode_rutes' ,
        'nama_rutes' ,
        'harga_rute' ,
        'jumlah',
        'satuan',
        'totalrute',
    ];

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable('*');
    }
    public function memo_ekpedisi()
    {
        return $this->belongsTo(Memo_ekspedisi::class);
    }


}