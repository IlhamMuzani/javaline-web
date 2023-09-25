<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Merek extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_merek',
        'nama_merek',
        'qrcode_merek',
        'kendaraan_id',
        'tanggal_awal',
        'tanggal_akhir',
    ];

    public function ban()
    {
        return $this->hasMany(Ban::class);
    }

    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class);
    }

    public static function getId()
    {
        return $getId = DB::table('mereks')->orderBy('id', 'DESC')->take(1)->get();
    }
}