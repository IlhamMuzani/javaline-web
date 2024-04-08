<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Detail_penjualan extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'faktur_penjualanreturn_id',
        'barang_id',
        'kode_barang',
        'nama_barang',
        'satuan',
        'harga_beli',
        'harga_jual',
        'jumlah',
        'diskon',
        'total',
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
    public function faktur_penjualanreturn()
    {
        return $this->belongsTo(Faktur_penjualan::class);
    }
}
