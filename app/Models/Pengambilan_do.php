<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pengambilan_do extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'kode_pengambilan',
        'user_id',
        'spk_id',
        'kendaraan_id',
        'km_awal',
        'km_akhir',
        'waktu_awal',
        'waktu_akhir',
        'rute_perjalanan_id',
        'alamat_muat_id',
        'alamat_bongkar_id',
        'status',
        'pengambilan_do',
        'gambar',
        'bukti',
        'latitude',
        'longitude',
        'tanggal',
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

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class);
    }

    public function spk()
    {
        return $this->belongsTo(Spk::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function rute_perjalanan()
    {
        return $this->belongsTo(Rute_perjalanan::class);
    }

    public function alamat_muat()
    {
        return $this->belongsTo(Alamat_muat::class);
    }

    public function alamat_bongkar()
    {
        return $this->belongsTo(Alamat_bongkar::class);
    }

    public static function getId()
    {
        return $getId = DB::table('pengambilan_dos')->orderBy('id', 'DESC')->take(1)->get();
    }
}