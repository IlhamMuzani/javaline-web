<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Detail_invoice extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'invoice_sewakendaraan_id',
        'sewa_kendaraan_id',
        'kode_sewa',
        'nama_rute',
        'no_memo',
        'no_do',
        'no_po',
        'tanggal_memo',
        'no_kabin',
        'no_pol',
        'jumlah',
        'satuan',
        'harga',
        'total',
        'gambar_buktifaktur',
        'nomor_buktifaktur',
        'tanggal_nomorfaktur',
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
    public function invoice_sewakendaraan()
    {
        return $this->belongsTo(Invoice_sewakendaraan::class);
    }

    public function sewa_kendaraan()
    {
        return $this->belongsTo(Sewa_kendaraan::class);
    }


}