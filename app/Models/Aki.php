<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Aki extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'kode_aki',
        'kendaraan_id',
        // 'supplier_id',
        'pemasangan_aki_id',
        'kategori',
        'km_terpakai',
        'pembelian_aki_id',
        'no_seri',
        'kondisi_aki',
        'merek_aki_id',
        'harga',
        'umur_aki',
        'qrcode_aki',
        'keterangan',
        'status',
        'status_aki',
        'status_pemasangan',
        'tanggal_awal',
        'tanggal_akhir',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable('*');
    }

    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class);
    }

    public function pemasangan_aki()
    {
        return $this->belongsTo(Pemasangan_ban::class);
    }

    public function pembelian_aki()
    {
        return $this->belongsTo(Pembelian_ban::class);
    }

    public function merek_aki()
    {
        return $this->belongsTo(Merek::class);
    }

    public static function getId()
    {
        return $getId = DB::table('akis')->orderBy('id', 'DESC')->take(1)->get();
    }
}