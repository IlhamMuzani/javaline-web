<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pelunasan_hutangkw extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable =
    [
        'user_id',
        'karyawan_id',
        'kategori',
        'kode_deposit',
        'kode_karyawan',
        'nama_karyawan',
        'nominal',
        'keterangan',
        'saldo_masuk',
        'saldo_keluar',
        'sisa_saldo',
        'sub_total',
        'periode_awal',
        'periode_akhir',
        'grand_total',
        'tanggal',
        'tanggal_awal',
        'tanggal_akhir',
        'qr_code_perhitungan',
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

    public static function getId()
    {
        return $getId = DB::table('pelunasan_hutangkws')->orderBy('id', 'DESC')->take(1)->get();
    }
}