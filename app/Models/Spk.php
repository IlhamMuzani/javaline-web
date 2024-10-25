<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Spk extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable =
    [
        'admin',
        'kategori',
        'kode_spk',
        'qrcode_spk',
        'user_id',
        'pelanggan_id',
        'alamat_muat_id',
        'alamat_muat2_id',
        'alamat_muat3_id',
        'alamat_bongkar_id',
        'alamat_bongkar2_id',
        'alamat_bongkar3_id',
        'vendor_id',
        'kode_vendor',
        'nama_vendor',
        'telp_vendor',
        'alamat_vendor',
        'kode_pelanggan',
        'nama_pelanggan',
        'alamat_pelanggan',
        'telp_pelanggan',
        'rute_perjalanan_id',
        'kendaraan_id',
        'no_kabin',
        'no_pol',
        'golongan',
        'km_awal',
        'km_akhir',
        'kode_driver',
        'nama_driver',
        'telp',
        'kode_rute',
        'nama_rute',
        'saldo_deposit',
        'uang_jalan',
        'voucher',
        'status',
        'status_indikator',
        'status_spk',
        'tanggal',
        'tanggal_awal',

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

    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class);
    }

    public function memo_ekspedisi()
    {
        return $this->hasMany(Memo_ekspedisi::class);
    }

    public function faktur_ekspedisi()
    {
        return $this->hasMany(Faktur_ekspedisi::class);
    }

    public function pengambilan_do()
    {
        return $this->hasMany(Pengambilan_do::class);
    }

    public function rute_perjalanan()
    {
        return $this->belongsTo(Rute_perjalanan::class);
    }

    public function alamat_muat()
    {
        return $this->belongsTo(Alamat_muat::class, 'alamat_muat_id'); // foreign key untuk alamat pertama
    }

    public function alamat_muat2()
    {
        return $this->belongsTo(Alamat_muat::class, 'alamat_muat2_id'); // foreign key untuk alamat kedua
    }

    public function alamat_muat3()
    {
        return $this->belongsTo(Alamat_muat::class, 'alamat_muat3_id'); // foreign key untuk alamat ketiga
    }


    public function alamat_bongkar()
    {
        return $this->belongsTo(Alamat_bongkar::class, 'alamat_bongkar_id'); // foreign key untuk alamat pertama
    }

    public function alamat_bongkar2()
    {
        return $this->belongsTo(Alamat_bongkar::class, 'alamat_bongkar2_id'); // foreign key untuk alamat kedua
    }

    public function alamat_bongkar3()
    {
        return $this->belongsTo(Alamat_bongkar::class, 'alamat_bongkar3_id'); // foreign key untuk alamat ketiga
    }

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    public static function getId()
    {
        return $getId = DB::table('spks')->orderBy('id', 'DESC')->take(1)->get();
    }
}
