<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\ServerBag;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Pemasangan_ban extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'kendaraan_id',
        'status',
        'tanggal',
        'tanggal_awal',
        'tanggal_akhir',
        'kode_pemasangan',
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

    public function ban1()
    {
        return $this->belongsTo(Ban::class);
    }

    public function detail_ban()
    {
        return $this->hasMany(Ban::class);
    }
    
    public static function getId()
    {
        return $getId = DB::table('pemasangan_bans')->orderBy('id', 'DESC')->take(1)->get();
    }
}