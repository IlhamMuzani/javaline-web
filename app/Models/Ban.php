<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Ban extends Model
{
    use HasFactory;
    protected $fillable = [
        'kode_ban',
        'kendaraan_id',
        // 'supplier_id',
        'pemasangan_ban_id',
        'pelepasan_ban_id',
        'pembelian_ban_id',
        'no_seri',
        'ukuran_id',
        'kondisi_ban',
        'merek_id',
        'typeban_id',
        'harga',
        'umur_ban',
        'km_pemasangan',
        'km_pelepasan',
        'target_km_ban',
        'posisi_ban',
        'qrcode_ban',
        'keterangan',
        'status',
        'tanggal_awal',
        'tanggal_akhir',
    ];

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

    public static function getId()
    {
        return $getId = DB::table('bans')->orderBy('id', 'DESC')->take(1)->get();
    }

}