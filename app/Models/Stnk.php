<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stnk extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'kode_stnk',
        'qrcode_stnk',
        'kendaraan_id',
        'jenis_kendaraan_id',
        'nama_pemilik',
        'alamat',
        'merek',
        'type',
        'model',
        'tahun_pembuatan',
        'no_rangka',
        'no_mesin',
        'warna',
        'warna_tnkb',
        'tahun_registrasi',
        'nomor_bpkb',
        'expired_stnk',
        'jumlah',
        'tanggal',
        'tanggal_awal',
        'tanggal_akhir',
        'status_stnk',
        'status_notif',
    ];

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable('*');
    }

    public static function getId()
    {
        return $getId = DB::table('stnks')->orderBy('id', 'DESC')->take(1)->get();
    }


    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class);
    }

    public function jenis_kendaraan()
    {
        return $this->belongsTo(Jenis_kendaraan::class);
    }

}