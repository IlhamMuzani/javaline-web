<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Karyawan extends Model
{
    use HasFactory;
    protected $fillable = [
        'kode_karyawan',
        'departemen_id',
        'qrcode_karyawan',
        'no_ktp',
        'no_sim',
        'nama_lengkap',
        'nama_kecil',
        'gender',
        'tanggal_lahir',
        'tanggal_gabung',
        'tanggal_keluar',
        'telp',
        'jabatan',
        'alamat',
        'gambar',
        'pembayaran',
        'gaji',
        'status',
        'tanggal_awal',
        'tanggal_akhir',
    ];

    public static function getId()
    {
        return $getId = DB::table('karyawans')->orderBy('id', 'DESC')->take(1)->get();
    }

    public function departemen()
    {
        return $this->belongsTo(Departemen::class);
    }

    public function user()
    {
        return $this->hasMany(User::class);
    }
}