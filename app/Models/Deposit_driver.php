<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Deposit_driver extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'karyawan_id',
        'memo_ekspedisi_id',
        'kategori',
        'kode_deposit',
        'kode_sopir',
        'nama_sopir',
        'nominal',
        'keterangan',
        'saldo_masuk',
        'saldo_keluar',
        'sisa_saldo',
        'sub_total',
        'tanggal',
        'tanggal_awal',
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


    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }

    public static function getId()
    {
        return $getId = DB::table('deposit_drivers')->orderBy('id', 'DESC')->take(1)->get();
    }
}