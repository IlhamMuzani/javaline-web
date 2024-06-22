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

    public static function getId()
    {
        return $getId = DB::table('pelanggans')->orderBy('id', 'DESC')->take(1)->get();
    }

}