<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Nota_return extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable =
    [
        'user_id',
        'return_ekspedisi_id',
        'kode_return',
        'admin',
        'kode_nota',
        'qrcode_nota',
        'pelanggan_id',
        'kode_pelanggan',
        'nama_pelanggan',
        'telp_pelanggan',
        'alamat_pelanggan',
        'kendaraan_id',
        'no_kabin',
        'no_pol',
        'jenis_kendaraan',
        'sopir_id',
        'kode_driver',
        'nama_driver',
        'telp',
        'grand_total',
        'tanggal',
        'tanggal_awal',
        'tanggal_akhir',
        'status',
        'status_return',
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
        return $getId = DB::table('nota_returns')->orderBy('id', 'DESC')->take(1)->get();
    }

    public function detail_nota()
    {
        return $this->hasMany(Detail_nota::class);
    }
}