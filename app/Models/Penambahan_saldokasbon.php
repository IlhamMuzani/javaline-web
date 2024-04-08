<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Penambahan_saldokasbon extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable =
    [
        'kode_penerimaan',
        'total_kasbon_id',
        'qr_code_penerimaan',
        'nominal',
        'keterangan',
        'saldo_masuk',
        'sisa_kasbon',
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


    public static function getId()
    {
        return $getId = DB::table('penambahan_saldokasbons')->orderBy('id', 'DESC')->take(1)->get();
    }

}