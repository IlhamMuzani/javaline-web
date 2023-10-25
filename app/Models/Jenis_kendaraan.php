<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Jenis_kendaraan extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'kode_jenis_kendaraan',
        'nama_jenis_kendaraan',
        'qrcode_jenis',
        'panjang',
        'lebar',
        'tinggi',
        'total_ban',
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
        return $this->hasMany(Kendaraan::class);
    }

    public static function getId()
    {
        return $getId = DB::table('jenis_kendaraans')->orderBy('id', 'DESC')->take(1)->get();
    }


}