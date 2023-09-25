<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Supplier extends Model
{
    use HasFactory;
    protected $fillable = [
        'kode_supplier',
        'nama_supp',
        'qrcode_supplier',
        'alamat',
        'nama_person',
        'jabatan',
        'telp',
        'fax',
        'hp',
        'email',
        'npwp',
        'nama_bank',
        'atas_nama',
        'norek',
        'tanggal_awal',
        'tanggal_akhir',
    ];

    public static function getId()
    {
        return $getId = DB::table('suppliers')->orderBy('id', 'DESC')->take(1)->get();
    }

    public function pembelian_ban()
    {
        return $this->hasMany(Pembelian_ban::class);
    }

    public function pembelian_part()
    {
        return $this->hasMany(Pembelian_part::class);
    }

}