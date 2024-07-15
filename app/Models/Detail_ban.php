<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Detail_ban extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'ban_id',
        'kode_ban',
        'kendaraan_id',
        // 'supplier_id',
        'kategori',
        'pemasangan_ban_id',
        'km_terpakai',
        'pelepasan_ban_id',
        'pembelian_ban_id',
        'no_seri',
        'ukuran_id',
        'km_umur',
        'kondisi_ban',
        'merek_id',
        'typeban_id',
        'harga',
        'umur_ban',
        'km_pemasangan',
        'jumlah_km',
        'km_pelepasan',
        'target_km_ban',
        'posisi_ban',
        'qrcode_ban',
        'keterangan',
        'status',
        'status_pelepasan',
        'status_pemasangan',
        'tanggal_awal',
        'tanggal_akhir',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable('*');
    }

    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class);
    }

    public function pemasangan_ban()
    {
        return $this->belongsTo(Pemasangan_ban::class);
    }

    public function pelepasan_ban()
    {
        return $this->belongsTo(Pelepasan_ban::class);
    }

    public function pembelian_ban()
    {
        return $this->belongsTo(Pembelian_ban::class);
    }

    public function merek()
    {
        return $this->belongsTo(Merek::class);
    }

    public function typeban()
    {
        return $this->belongsTo(Typeban::class);
    }

    public function ukuran()
    {
        return $this->belongsTo(Ukuran::class);
    }

    public function deposit_driver()
    {
        return $this->hasMany(Deposit_driver::class);
    }

    public function ban()
    {
        return $this->belongsTo(Ban::class);
    }



    public static function getId()
    {
        return $getId = DB::table('detail_bans')->orderBy('id', 'DESC')->take(1)->get();
    }
}