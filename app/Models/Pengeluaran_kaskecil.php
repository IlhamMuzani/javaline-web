<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pengeluaran_kaskecil extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'user_id',
        'perhitungan_gajikaryawan_id',
        'memo_ekspedisi_id',
        'memo_asuransi_id',
        'memotambahan_id',
        'notabon_ujs_id',
        'laporankir_id',
        'laporanstnk_id',
        'kasbon_karyawan_id',
        'kode_pengeluaran',
        'keterangan',
        'grand_total',
        'kendaraan_id',
        'qrcode_pengeluaran',
        'status',
        'status_notif',
        'tanggal',
        'jam',
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function laporankir()
    {
        return $this->belongsTo(Laporankir::class);
    }

    public function laporanstnk()
    {
        return $this->belongsTo(Laporanstnk::class);
    }

    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class);
    }

    public function kasbon_karyawan()
    {
        return $this->belongsTo(Kasbon_karyawan::class);
    }

    public function detail_pengeluaran()
    {
        return $this->hasMany(Detail_pengeluaran::class);
    }

    public function detail_tagihan()
    {
        return $this->hasMany(Detail_pengeluaran::class);
    }



    public static function getId()
    {
        return $getId = DB::table('pengeluaran_kaskecils')->orderBy('id', 'DESC')->take(1)->get();
    }

}