<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Klaim_ban extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable =
    [
        'kode_klaimban',
        'penerimaan_kaskecil_id',
        'deposit_driver_id',
        'kendaraan_id',
        'karyawan_id',
        'ban_id',
        'keterangan',
        'qr_codeklaim',
        'harga_ban',
        'harga_klaim',
        'km_terpakai',
        'target_km',
        'km_pemasangan',
        'km_pelepasan',
        'grand_total',
        'tanggal',
        'tanggal_awal',
        'tanggal_akhir',
        'status',
        'status_notif',
    ];

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable('*');
    }

    public function penerimaan_kaskecil()
    {
        return $this->belongsTo(Penerimaan_kaskecil::class);
    }

    public function deposit_driver()
    {
        return $this->belongsTo(Deposit_driver::class);
    }

    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class);
    }

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }

    public function ban()
    {
        return $this->belongsTo(Ban::class);
    }


    public static function getId()
    {
        return $getId = DB::table('klaim_bans')->orderBy('id', 'DESC')->take(1)->get();
    }
}