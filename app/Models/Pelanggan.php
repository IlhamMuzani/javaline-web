<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pelanggan extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'kode_pelanggan',
        'kelompok_pelanggan_id',
        'karyawan_id',
        'nama_pell',
        'nama_alias',
        'qrcode_pelanggan',
        'alamat',
        'npwp',
        'nama_person',
        'jabatan',
        'telp',
        'fax',
        'hp',
        'email',
        'gambar',
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

    public function detail_pelanggan()
    {
        return $this->hasMany(Detail_pelanggan::class);
    }

    public function kendaraan()
    {
        return $this->hasMany(Kendaraan::class);
    }

    public function laporanperjalanan()
    {
        return $this->hasMany(Laporanperjalanan::class);
    }

    public function tagihan_ekspedisi()
    {
        return $this->hasMany(Tagihan_ekspedisi::class);
    }

    public function alamat_muat()
    {
        return $this->hasMany(Alamat_muat::class);
    }

    public function alamat_bongkar()
    {
        return $this->hasMany(Alamat_bongkar::class);
    }

    public function pengambilan_do()
    {
        return $this->hasMany(Pengambilan_do::class);
    }

    public function spk()
    {
        return $this->hasMany(Spk::class);
    }

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }

    public function kelompok_pelanggans()
    {
        return $this->belongsTo(Kelompok_pelanggan::class);
    }

    public function user()
    {
        return $this->hasMany(User::class);
    }

    public static function getId()
    {
        return $getId = DB::table('pelanggans')->orderBy('id', 'DESC')->take(1)->get();
    }
}