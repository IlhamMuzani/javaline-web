<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Departemen extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'qrcode_departemen',
        'tanggal_awal',
        'tanggal_akhir',
    ];

    public function karyawan()
    {
        return $this->hasMany(Karyawan::class);
    }

    public static function getId()
    {
        return $getId = DB::table('departemens')->orderBy('id', 'DESC')->take(1)->get();
    }

}