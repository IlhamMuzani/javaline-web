<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Laporanperjalanan extends Model
{
    use HasFactory;
    protected $fillable = [
        'kode_kendaraan',
        'kendaraan_id',
        'user_id',
        'pelanggan_id',
        'no_kabin',
        'no_pol',
        'no_rangka',
        'no_mesin',
        'warna',
        'km',
        'km_olimesin',
        'km_oligardan',
        'km_olitransmisi',
        'expired_kir',
        'expired_stnk',
        'jenis_kendaraan_id',
        'golongan_id',
        'divisi_id',
        'status',
        'qrcode_kendaraan',
        'status_pemasangan',
        'status_pelepasan',
        'kode_pemasangan',
        'kode_pelepasan',
        'tanggal',
        'tanggal_awal',
        'tanggal_akhir',
        'tanggal_awalperjalanan',
        'tanggal_akhirperjalanan',
        'tanggal_awalwaktuperjalanan',
        'tanggal_akhirwaktuperjalanan',
        'status_post',
        'status_notif',
        'status_olimesin',
        'status_oligardan',
        'status_olitransmisi',
        'status_notifkm',
        'timer',
        'kota_id',
    ];

    public function ban()
    {
        return $this->hasMany(Ban::class);
    }

    public function merek()
    {
        return $this->hasMany(Merek::class);
    }

    public function stnk()
    {
        return $this->hasMany(Stnk::class);
    }

    public function pemasangan_part()
    {
        return $this->hasMany(Pemasangan_part::class);
    }

    public function jenis_kendaraan()
    {
        return $this->belongsTo(Jenis_kendaraan::class);
    }

    public function kota()
    {
        return $this->belongsTo(Kota::class);
    }

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function golongan()
    {
        return $this->belongsTo(Golongan::class);
    }

    public function divisi()
    {
        return $this->belongsTo(Divisi::class);
    }

}