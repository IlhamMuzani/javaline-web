<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Detail_bukti extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'bukti_potongpajak_id',
        'tagihan_ekspedisi_id',
        'kode_tagihan',
        'tanggal',
        'nama_pelanggan',
        'pph',
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
    public function tagihan_ekspedisi()
    {
        return $this->belongsTo(Tagihan_ekspedisi::class);
    }

    public function bukti_potongpajak()
    {
        return $this->belongsTo(Bukti_potongpajak::class);
    }
}