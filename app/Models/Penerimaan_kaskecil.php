<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Penerimaan_kaskecil extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable =
    [
        'kode_penerimaan',
        'saldo_id',
        'deposit_driver_id',
        'qr_code_penerimaan',
        'nominal',
        'keterangan',
        'saldo_masuk',
        'sisa_saldo',
        'sub_total',
        'jam',
        'tanggal',
        'tanggaljam',
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

    public function deposit_driver()
    {
        return $this->belongsTo(Deposit_driver::class);
    }


    public static function getId()
    {
        return $getId = DB::table('penerimaan_kaskecils')->orderBy('id', 'DESC')->take(1)->get();
    }
}