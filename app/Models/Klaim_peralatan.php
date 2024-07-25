<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Klaim_peralatan extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'user_id',
        'karyawan_id',
        'kode_klaim',
        'penerimaan_kaskecil_id',
        'deposit_driver_id',
        'kendaraan_id',
        'karyawan_id',
        'keterangan',
        'qr_codeklaim',
        'sisa_harga',
        'harga_klaim',
        'sisa_saldo',
        'grand_total',
        'tanggal',
        'tanggal_klaim',
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }

    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class);
    }

    public function deposit_driver()
    {
        return $this->belongsTo(Deposit_driver::class);
    }

    public function detail_klaimperalatan()
    {
        return $this->hasMany(Detail_klaimperalatan::class);
    }

    public static function getId()
    {
        return $getId = DB::table('klaim_peralatans')->orderBy('id', 'DESC')->take(1)->get();
    }
}