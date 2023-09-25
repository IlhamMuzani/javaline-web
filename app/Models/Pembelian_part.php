<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pembelian_part extends Model
{
    use HasFactory;
    protected $fillable =
    [
        'kode_pembelianpart',
        'qrcode_pembelianpart',
        'supplier_id',
        'tanggal',
        'tanggal_awal',
        'tanggal_akhir',
        'status',
        'status_notif',

    ];

    public static function getId()
    {
        return $getId = DB::table('pembelian_parts')->orderBy('id', 'DESC')->take(1)->get();
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function detail_part()
    {
        return $this->hasMany(Detail_pembelianpart::class);
    }
}