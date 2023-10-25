<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Penggantian_oli extends Model
{
    use HasFactory;
    use LogsActivity;


    protected $fillable = [
        'kode_penggantianoli',
        'kendaraan_id',
        'tanggal_penggantian',
        'tanggal_awal',
        'tanggal_akhir',
        'status',
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

    public function detail_oli()
    {
        return $this->hasMany(Detail_penggantianoli::class);
    }

    public static function getId()
    {
        return $getId = DB::table('penggantian_olis')->orderBy('id', 'DESC')->take(1)->get();
    }
}