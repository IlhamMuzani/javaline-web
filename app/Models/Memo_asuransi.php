<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Memo_asuransi extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable =
    [
        'admin',
        'spk_id',
        'kode_memo',
        'kategori',
        'kendaraan_id',
        'user_id',
        'rute_perjalanan_id',
        'tarif_asuransi_id',
        'kode_tarif',
        'nama_tarif',
        'persen',
        'nominal_tarif',
        'hasil_tarif',
        'keterangan',
        'qrcode_memo',
        'tanggal',
        'tanggal_awal',
        'tanggal_akhir',
        'status'
    ];


    use SoftDeletes;
    protected $dates = ['deleted_at'];


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable('*');
    }

    public function spk()
    {
        return $this->belongsTo(Spk::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class);
    }

    public function rute_perjalanan()
    {
        return $this->belongsTo(Rute_perjalanan::class);
    }

    public function tarif_asuransi()
    {
        return $this->belongsTo(Tarif_asuransi::class);
    }

    public function pengeluaran_kaskecil()
    {
        return $this->hasMany(Pengeluaran_kaskecil::class);
    }

    public function detail_pengeluaran()
    {
        return $this->hasMany(Detail_pengeluaran::class);
    }

    public static function getId()
    {
        return $getId = DB::table('memo_asuransis')->orderBy('id', 'DESC')->take(1)->get();
    }
}