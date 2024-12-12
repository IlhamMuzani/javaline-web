<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pengeluaran_asuransi extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'user_id',
        'total_asuransi_id',
        'kode_pengambilanasuransi',
        'keterangan',
        'nominal',
        'saldo_masuk',
        'sisa_ujs',
        'grand_total',
        'qr_code_pengeluran',
        'status',
        'status_notif',
        'tanggal',
        'tanggaljam',
        'jam',
        'tanggal_awal',
        'tanggal_akhir',
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

    public static function getId()
    {
        return $getId = DB::table('pengeluaran_asuransis')->orderBy('id', 'DESC')->take(1)->get();
    }
}