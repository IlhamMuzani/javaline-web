<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kasbon_karyawan extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'karyawan_id',
        'kategori',
        'kode_kasbon',
        'kode_karyawan',
        'nama_karyawan',
        'nominal',
        'keterangan',
        'saldo_masuk',
        'saldo_keluar',
        'sisa_saldo',
        'sub_total',
        'nominal_cicilan',
        'nominal_lebih',
        'jumlah_cicilan',
        'grand_total',
        'tanggal',
        'tanggal_awal',
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


    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }

    public function detail_cicilan()
    {
        return $this->hasMany(Detail_cicilan::class);
    }

    public function pengeluaran_kaskecil()
    {
        return $this->hasMany(Pengeluaran_kaskecil::class);
    }

    public function detail_pengeluaran()
    {
        return $this->hasMany(Detail_pengeluaran::class);
    }

    public static function getId()
    {
        return $getId = DB::table('kasbon_karyawans')->orderBy('id', 'DESC')->take(1)->get();
    }
}