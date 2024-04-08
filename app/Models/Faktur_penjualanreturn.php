<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Faktur_penjualanreturn extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable =
    [
        'user_id',
        'admin',
        'nota_return_id',
        'kode_nota',
        'kode_penjualan',
        'qrcode_penjualan',
        'pelanggan_id',
        'kode_pelanggan',
        'nama_pelanggan',
        'telp_pelanggan',
        'alamat_pelanggan',
        'kendaraan_id',
        'no_kabin',
        'no_pol',
        'jenis_kendaraan',
        'kode_driver',
        'nama_driver',
        'telp',
        'keterangan',
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

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function getId()
    {
        return $getId = DB::table('faktur_penjualanreturns')->orderBy('id', 'DESC')->take(1)->get();
    }

    public function detail_penjualan()
    {
        return $this->hasMany(Detail_return::class);
    }
}