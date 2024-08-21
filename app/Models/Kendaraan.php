<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kendaraan extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'kode_kendaraan',
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
        'status_perjalanan',
        'nama_security',
        'gambar_barcodesolar',
        'gambar_stnk',
        'timer',
        'waktu',
        'kota_id',
    ];

    use SoftDeletes;
    protected $dates = ['deleted_at'];


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable('*');
    }

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
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function golongan()
    {
        return $this->belongsTo(Golongan::class);
    }

    public function divisi()
    {
        return $this->belongsTo(Divisi::class);
    }

    // Kendaraan.php (model)
    public function faktur_ekspedisi()
    {
        return $this->hasMany(Faktur_ekspedisi::class, 'kendaraan_id');
    }

    // Kendaraan.php (model)
    public function memo_ekspedisi()
    {
        return $this->hasMany(Memo_ekspedisi::class, 'kendaraan_id');
    }

    public function detail_pengeluaran()
    {
        return $this->hasMany(Detail_pengeluaran::class, 'kendaraan_id');
    }

    public function detail_inventories()
    {
        return $this->hasMany(Detail_inventory::class, 'kendaraan_id');
    }

    public function pengambilan_do()
    {
        return $this->hasMany(Pengambilan_do::class);
    }

    public static function getId()
    {
        return $getId = DB::table('kendaraans')->orderBy('id', 'DESC')->take(1)->get();
    }

    // Pada model Kendaraan, tambahkan metode berikut
    public static function boot()
    {
        parent::boot();

        self::updated(function ($kendaraan) {
            // Hitung jarak waktu di sini
            $waktuUpdate = now(); // Waktu update
            $waktuPerjalananIsi = $kendaraan->updated_at; // Waktu perjalanan isi sebelumnya
            $jarakWaktu = $waktuUpdate->diffInSeconds($waktuPerjalananIsi);
            // Lakukan sesuatu dengan $jarakWaktu
        });
    }
}