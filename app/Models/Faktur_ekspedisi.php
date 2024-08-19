<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Faktur_ekspedisi extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable =
    [
        'user_id',
        'spk_id',
        'karyawan_id',
        'sewa_kendaraan_id',
        'kode_sewa',
        'kode_spk',
        'kode_faktur',
        'kategori',
        'kategoris',
        'pph',
        'qrcode_faktur',
        'kendaraan_id',
        'pelanggan_id',
        'vendor_id',
        'tarif_id',
        'kode_pelanggan',
        'nama_pelanggan',
        'alamat_pelanggan',
        'telp_pelanggan',
        'kode_vendor',
        'nama_vendor',
        'alamat_vendor',
        'telp_vendor',
        'kode_tarif',
        'nama_tarif',
        'nama_sopir',
        'telp_sopir',
        'telp_driver',
        'harga_tarif',
        'jumlah',
        'satuan',
        'total_tarif',
        'keterangan',
        'total_tarif2',
        'sisa',
        'biaya_tambahan',
        'grand_total',
        'tanggal_memo',
        'tanggal',
        'tanggal_awal',
        'tanggal_akhir',
        'status',
        'status_faktur',
        'status_pelunasan',
        'status_notif',
        'status_tagihan',
        'nama_rute',
        'kode_memo',
        'no_kabin',
        'no_pol',
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

    public function spk()
    {
        return $this->belongsTo(Spk::class);
    }

    public function sewa_kendaraan()
    {
        return $this->belongsTo(Sewa_kendaraan::class);
    }

    public function detail_tagihan()
    {
        return $this->hasMany(Detail_tagihan::class);
    }

    public function tarif()
    {
        return $this->belongsTo(Tarif::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class);
    }

    public function detail_faktur()
    {
        return $this->hasMany(Detail_faktur::class);
    }

    public function detail_tariftambahan()
    {
        return $this->hasMany(Detail_tariftambahan::class);
    }

    public function detail_pelunasan()
    {
        return $this->hasMany(Detail_pelunasan::class);
    }

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }

    public static function getId()
    {
        return $getId = DB::table('faktur_ekspedisis')->orderBy('id', 'DESC')->take(1)->get();
    }
}