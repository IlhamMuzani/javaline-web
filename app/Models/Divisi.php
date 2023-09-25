<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Divisi extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_divisi',
        'nama_divisi',
        'qrcode_divisi',
        'tanggal_awal',
        'tanggal_akhir',
    ];

    public function kendaraan()
    {
        return $this->hasMany(Kendaraan::class);
    }

    public static function getId()
    {
        return $getId = DB::table('divisis')->orderBy('id', 'DESC')->take(1)->get();
    }

}