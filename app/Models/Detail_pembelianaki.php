<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Detail_pembelianaki extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'kode_akidetail',
        'pembelian_aki_id',
        'sparepart_id',
        'qrcode_barang',
        'kategori',
        'nama_barang',
        'jumlah',
        'satuan',
        'hargasatuan',
        'harga',
        'keterangan',
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
    public function pembelian_aki()
    {
        return $this->belongsTo(Pembelian_aki::class);
    }
}
