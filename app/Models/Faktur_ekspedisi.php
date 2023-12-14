<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Faktur_ekspedisi extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable =
    [
        'user_id',
        'kode_faktur',
        'kategori',
        'pph',
        'qrcode_faktur',
        'pelanggan_id',
        'tarif_id',
        'kode_pelanggan',
        'nama_pelanggan',
        'alamat_pelanggan',
        'telp_pelanggan',
        'kode_tarif',
        'nama_tarif',
        'harga_tarif',
        'jumlah',
        'satuan',
        'total_tarif',
        'total_tarif2',
        'sisa',
        'biaya_tambahan',
        'grand_total',
        'tanggal',
        'tanggal_awal',
        'tanggal_akhir',
        'status',
        'status_notif',
    ];


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable('*');
    }

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    public function tarif()
    {
        return $this->belongsTo(Tarif::class);
    }

    public static function getId()
    {
        return $getId = DB::table('faktur_ekspedisis')->orderBy('id', 'DESC')->take(1)->get();
    }

    public function detail_faktur()
    {
        return $this->hasMany(Detail_faktur::class);
    }

    public function detail_tariftambahan()
    {
        return $this->hasMany(Detail_tariftambahan::class);
    }
}