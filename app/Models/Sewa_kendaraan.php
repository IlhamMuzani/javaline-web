<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sewa_kendaraan extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable =
    [
        'kode_sewa',
        'kategori',
        'qrcode_sewa',
        'admin',
        'pph',
        'pelanggan_id',
        'vendor_id',
        'rute_perjalanan_id',
        'nama_pelanggan',
        'nama_vendor',
        'nama_driver',
        'telp_driver',
        'nama_rute',
        'no_pol',
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

    public function rute_perjalanan()
    {
        return $this->belongsTo(Rute_perjalanan::class);
    }
    
    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function faktur_ekspedisi()
    {
        return $this->hasMany(Faktur_ekspedisi::class);
    }

    public static function getId()
    {
        return $getId = DB::table('sewa_kendaraan')->orderBy('id', 'DESC')->take(1)->get();
    }
}