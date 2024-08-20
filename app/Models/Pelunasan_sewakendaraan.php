<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pelunasan_sewakendaraan extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable =
    [
        'user_id',
        'invoice_sewakendaraan_id',
        'kode_tagihan',
        'kode_pelunasan',
        'qrcode_pelunasan',
        'kategori',
        'vendor_id',
        'kode_vendor',
        'nama_vendor',
        'alamat_vendor',
        'telp_vendor',
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

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function invoice_sewakendaraan()
    {
        return $this->belongsTo(Invoice_sewakendaraan::class);
    }

    public static function getId()
    {
        return $getId = DB::table('pelunasan_sewakendaraan')->orderBy('id', 'DESC')->take(1)->get();
    }

    public function detail_pelunasansewa()
    {
        return $this->hasMany(Detail_pelunasansewa::class);
    }

    public function detail_pelunasanpotongan()
    {
        return $this->hasMany(Detail_pelunasanpotongan::class);
    }
}