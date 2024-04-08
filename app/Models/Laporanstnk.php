<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Laporanstnk extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'stnk_id',
        'user_id',
        'kode_perpanjangan',
        'expired_stnk',
        'jumlah',
        'tanggal',
        'tanggal_awal',
        'tanggal_akhir',
        'status',
        'status_stnk',
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
        return $getId = DB::table('laporanstnks')->orderBy('id', 'DESC')->take(1)->get();
    }


    public function stnk()
    {
        return $this->belongsTo(Stnk::class);
    }
}