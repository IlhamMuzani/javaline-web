<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Pelepasan_ban extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'kendaraan_id',
        'status',
        'tanggal',
        'tanggal_awal',
        'tanggal_akhir',
        'kode_pelepasan',
        'status_notif',
    ];
    
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable('*');
    }


    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class);
    }

    public function ban()
    {
        return $this->belongsTo(Ban::class);
    }

    public function pelepasan_ban()
    {
        return $this->hasMany(Pelepasanban::class);
    }

    public function detail_ban()
    {
        return $this->hasMany(Ban::class);
    }

    public static function getId()
    {
        return $getId = DB::table('pelepasan_bans')->orderBy('id', 'DESC')->take(1)->get();
    }
}