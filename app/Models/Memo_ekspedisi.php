<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Memo_ekspedisi extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable =
    [
        'memotambahan_id',
        'kode_memo',
        'kategori',
        'qrcode_memo',
        'kendaraan_id',
        'no_kabin',
        'golongan',
        'km_awal',
        'user_id',
        'kode_driver',
        'nama_driver',
        'telp',
        'saldo_deposit',
        'rute_perjalanan_id',
        'kode_rute',
        'nama_rute',
        'harga_rute',
        'jumlah',
        'satuan',
        'totalrute',
        'uang_jalan',
        'pelanggan_id',
        'kode_pelanggan',
        'nama_pelanggan',
        'alamat_pelanggan',
        'telp_pelanggan',
        'uang_jaminan',
        'biaya_tambahan',
        'potongan_memo',
        'deposit_driver',
        'pphs',
        'total_borongs',
        'uang_jaminans',
        'deposit_drivers',
        'totals',
        'keterangan',
        'sisa_saldo',
        'sub_total',
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class);
    }

    public function rute()
    {
        return $this->belongsTo(Rute_perjalanan::class);
    }

    public function memotambahan()
    {
        return $this->belongsTo(Memotambahan::class);
    }

    public static function getId()
    {
        return $getId = DB::table('memo_ekspedisis')->orderBy('id', 'DESC')->take(1)->get();
    }

    public function detail_memo()
    {
        return $this->hasMany(Detail_memo::class);
    }
}