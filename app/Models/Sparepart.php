<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sparepart extends Model
{
    use HasFactory;
    use LogsActivity;

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

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable('*');
    }


    public function pembelian_part()
    {
        return $this->belongsTo(Pembelian_part::class);
    }
    
    public static function getId()
    {
        return $getId = DB::table('spareparts')->orderBy('id', 'DESC')->take(1)->get();
    }
}