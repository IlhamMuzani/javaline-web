<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pengeluaran_ujs extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'user_id',
        'total_ujs_id',
        'kode_pengambilanujs',
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

    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class);
    }

    public function detail_pengeluaran()
    {
        return $this->hasMany(Detail_pengeluaran::class);
    }

    public function detail_tagihan()
    {
        return $this->hasMany(Detail_pengeluaran::class);
    }



    public static function getId()
    {
        return $getId = DB::table('pengeluaran_ujs')->orderBy('id', 'DESC')->take(1)->get();
    }

}