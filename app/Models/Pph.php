<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pph extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable =
    [
        'pelanggan_id',
        'kode_pelanggan',
        'nama_pelanggan',
        'faktur_ekspedisi_id',
        'kode_faktur',
        'pph',
        'tanggal',
        'tanggal_awal',
        'tanggal_akhir',
        'status',
    ];

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable('*');
    }

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    public function faktur_ekspedisi()
    {
        return $this->belongsTo(Faktur_ekspedisi::class);
    }

    public static function getId()
    {
        return $getId = DB::table('pphs')->orderBy('id', 'DESC')->take(1)->get();
    }
}