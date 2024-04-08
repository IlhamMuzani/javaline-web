<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Faktur_pelunasan extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable =
    [
        'user_id',
        'tagihan_ekspedisi_id',
        'kode_tagihan',
        'kode_pelunasan',
        'qrcode_pelunasan',
        'kategori',
        'pelanggan_id',
        'kode_pelanggan',
        'nama_pelanggan',
        'alamat_pelanggan',
        'telp_pelanggan',
        'keterangan',
        'potongan',
        'saldo_masuk',
        'ongkos_bongkar',
        'kategoris',
        'nomor',
        'tanggal_transfer',
        'nominal',
        'keterangan',
        'potonganselisih',
        'totalpenjualan',
        'dp',
        'totalpembayaran',
        'selisih',
        'tanggal',
        'tanggal_awal',
        'tanggal_akhir',
        'status',
        'status_notif',
    ];



    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable('*');
    }

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function getId()
    {
        return $getId = DB::table('faktur_pelunasans')->orderBy('id', 'DESC')->take(1)->get();
    }

    public function detail_pelunasan()
    {
        return $this->hasMany(Detail_pelunasan::class);
    }

    public function detail_pelunasanreturn()
    {
        return $this->hasMany(Detail_pelunasanreturn::class);
    }

    public function detail_pelunasanpotongan()
    {
        return $this->hasMany(Detail_pelunasanpotongan::class);
    }
}