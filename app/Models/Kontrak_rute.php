<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kontrak_rute extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable =
    [
        'kode_kontrak',
        'user_id',
        'pelanggan_id',
        'tanggal',
        'tanggal_awal',
        'tanggal_akhir',
        'qrcode_kontrak_rute',
        'status',
        'status_pelunasan',
        'status_notif',
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
        return $getId = DB::table('pembelian_bans')->orderBy('id', 'DESC')->take(1)->get();
    }

    public function merek()
    {
        return $this->belongsTo(Merek::class);
    }

    public function ukuran()
    {
        return $this->belongsTo(Ukuran::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function detail_ban()
    {
        return $this->hasMany(Ban::class);
    }
}