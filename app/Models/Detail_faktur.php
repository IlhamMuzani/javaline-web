<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Detail_faktur extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'faktur_ekspedisi_id',
        'memo_ekspedisi_id',
        'memotambahan_id',
        'kendaraan_id',
        'no_kabin',
        'no_pol',
        'kode_memo',
        'kode_driver',
        'nama_driver',
        'telp_driver',
        'nama_rute',
        'kategori_memo',
        'tanggal_memo',
        'kode_memotambahan',
        'nama_rutetambahan',
        'kode_drivertambahan',
        'nama_drivertambahan',
        'tanggal_memotambahan',
        'kode_memotambahans',
        'kode_drivertambahans',
        'nama_rutetambahans',
        'nama_drivertambahans',
        'tanggal_memotambahans',
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
    public function faktur_ekspedisi()
    {
        return $this->belongsTo(Faktur_ekspedisi::class);
    }

    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class);
    }

    public function memo_ekspedisi()
    {
        return $this->belongsTo(Memo_ekspedisi::class);
    }

    public function memotambahan()
    {
        return $this->belongsTo(Memotambahan::class);
    }
}
