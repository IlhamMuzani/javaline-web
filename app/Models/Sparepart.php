<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sparepart extends Model
{
    use HasFactory;
    protected $fillable = [
        'kode_partdetail',
        'pembelian_part_id',
        'qrcode_barang',
        'kategori',
        'nama_barang',
        'jumlah',
        'satuan',
        'harga',
        'keterangan',
        'status',
        'tanggal_awal',
        'tanggal_akhir',
    ];

    public function pembelian_part()
    {
        return $this->belongsTo(Pembelian_part::class);
    }
    
    public static function getId()
    {
        return $getId = DB::table('spareparts')->orderBy('id', 'DESC')->take(1)->get();
    }
}