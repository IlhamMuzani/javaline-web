<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Golongan extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_golongan',
        'nama_golongan',
        'qrcode_golongan',
        'tanggal_awal',
        'tanggal_akhir',
    ];

    public static function getId()
    {
        return $getId = DB::table('golongans')->orderBy('id', 'DESC')->take(1)->get();
    }

    public function kendaraan()
    {
        return $this->hasMany(Kendaraan::class);
    }
}