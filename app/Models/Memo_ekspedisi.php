<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Memo_ekspedisi extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable =
    [
        'memotambahan_id',
        'admin',
        'kode_memo',
        'kategori',
        'qrcode_memo',
        'kendaraan_id',
        'no_kabin',
        'no_pol',
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
        'hasil_jumlah',
        'totalrute',
        'uang_jalan',
        'uang_jalans',
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

        // 'biaya_id',
        // 'potongan_memo_id',
        // 'kode_biaya',
        // 'nama_biaya',
        // 'nominal',
        // 'kode_potongan',
        // 'keterangan_potongan',
        // 'nominal_potongan',
        'rute_id',
        'kode_rutes',
        'nama_rutes',
        'harga_rute',
        'jumlah',
        'satuan',
        'totalrute',
        'status_memo',
    ];


    use SoftDeletes;
    protected $dates = ['deleted_at'];



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

    public function detail_faktur()
    {
        return $this->hasMany(Detail_faktur::class);
    }

    public function memotambahan()
    {
        return $this->hasMany(Memotambahan::class);
    }

    public static function getId()
    {
        return $getId = DB::table('memo_ekspedisis')->orderBy('id', 'DESC')->take(1)->get();
    }

    public function detail_memo()
    {
        return $this->hasMany(Detail_memo::class);
    }
    public function deposit_driver()
    {
        return $this->hasMany(Deposit_driver::class);
    }

    public function pengeluaran_kaskecil()
    {
        return $this->hasMany(Pengeluaran_kaskecil::class);
    }

    public function uangjaminan()
    {
        return $this->hasMany(Uangjaminan::class);
    }

    public function detail_pengeluaran()
    {
        return $this->hasMany(Detail_pengeluaran::class);
    }

    public function detail_tambahan()
    {
        return $this->hasMany(Detail_tambahan::class);
    }

    public function detail_potongan()
    {
        return $this->hasMany(Detail_potongan::class);
    }
}