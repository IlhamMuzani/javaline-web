<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tagihan_ekspedisi extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable =
    [
        'user_id',
        'kode_tagihan',
        'kategori',
        'qrcode_tagihan',
        'pelanggan_id',
        'kode_pelanggan',
        'nama_pelanggan',
        'alamat_pelanggan',
        'telp_pelanggan',
        'keterangan',
        'sub_total',
        'pph',
        'sisa',
        'hasil_feeall',
        'hasil_potonganfee',
        'grand_total',
        'no_resi',
        'gambar_bukti',
        'nomor_buktitagihan',
        'tanggal_nomortagihan',
        'tanggal',
        'tanggal_awal',
        'tanggal_akhir',
        'status',
        'status_terpakai',
        'periode_awal',
        'periode_akhir',
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
        return $getId = DB::table('tagihan_ekspedisis')->orderBy('id', 'DESC')->take(1)->get();
    }

    public function detail_tagihan()
    {
        return $this->hasMany(Detail_tagihan::class);
    }

    public function detail_bukti()
    {
        return $this->hasMany(Detail_bukti::class);
    }

    public function faktur_pelunasan()
    {
        return $this->hasMany(Faktur_pelunasan::class);
    }
}