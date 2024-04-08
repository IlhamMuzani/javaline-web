<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pelunasan_deposit extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable =
    [
        'user_id',
        'kategori',
        'perhitungan_gajikaryawan_id',
        'kode_pelunasan',
        'periode_awal',
        'periode_akhir',
        'keterangan',
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

    public function perhitungan_gajikaryawan()
    {
        return $this->belongsTo(Perhitungan_gajikaryawan::class);
    }

    public function detail_pelunasandeposit()
    {
        return $this->hasMany(Detail_pelunasandeposit::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function getId()
    {
        return $getId = DB::table('pelunasan_deposits')->orderBy('id', 'DESC')->take(1)->get();
    }
}