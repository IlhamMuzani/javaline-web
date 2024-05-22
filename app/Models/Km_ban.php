<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Km_ban extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'umur_ban',
        'ban_id',
        'detail_ban_id',
        'kendaraan_id',
        'pemasangan_ban_id',
        'pelepasan_ban_id',
        'status',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable('*');
    }

    public function ban()
    {
        return $this->belongsTo(Ban::class);
    }

    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class);
    }

    public function pemasangan_ban()
    {
        return $this->belongsTo(Pemasangan_ban::class);
    }

    public function pelepasan_ban()
    {
        return $this->belongsTo(Pelepasan_ban::class);
    }


    public static function getId()
    {
        return $getId = DB::table('km_bans')->orderBy('id', 'DESC')->take(1)->get();
    }
}