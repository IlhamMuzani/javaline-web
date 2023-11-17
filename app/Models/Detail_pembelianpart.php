<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Detail_pembelianpart extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'kode_partdetail',
        'pembelian_part_id',
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
    
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable('*');
    }
    public function pembelian_part()
    {
        return $this->belongsTo(Pembelian_part::class);
    }

    public function detail_part()
    {
        return $this->hasMany(Detail_pemasanganpartdua::class);
    }


}