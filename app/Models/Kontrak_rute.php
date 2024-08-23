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
        'keterangan',
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

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    public static function getId()
    {
        return $getId = DB::table('kontrak_rutes')->orderBy('id', 'DESC')->take(1)->get();
    }

    public function detail_kontrak()
    {
        return $this->hasMany(Detail_kontrak::class);
    }
}