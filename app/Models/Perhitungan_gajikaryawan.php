<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Perhitungan_gajikaryawan extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable =
    [
        'user_id',
        'kategori',
        'kode_gaji',
        'periode_awal',
        'periode_akhir',
        'keterangan',
        'total_gaji',
        'total_pelunasan',
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

    public function detail_gajikaryawan()
    {
        return $this->hasMany(Detail_gajikaryawan::class);
    }

    public function pengeluaran_kaskecil()
    {
        return $this->hasMany(Pengeluaran_kaskecil::class);
    }

    public function detail_pengeluaran()
    {
        return $this->hasMany(Detail_pengeluaran::class);
    }

    public function pelunasan_deposit()
    {
        return $this->hasMany(Pelunasan_deposit::class);
    }

    public static function getId()
    {
        return $getId = DB::table('perhitungan_gajikaryawans')->orderBy('id', 'DESC')->take(1)->get();
    }
}
