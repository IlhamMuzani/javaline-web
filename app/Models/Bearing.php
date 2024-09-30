<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bearing extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'kendaraan_id',
        'bearing1a',
        'bearing1b',
        'bearing2a',
        'bearing2b',
        'bearing3a',
        'bearing3b',
        'bearing4a',
        'bearing4b',
        'bearing5a',
        'bearing5b',
        'bearing6a',
        'bearing6b',

        'status_bearing1a',
        'status_bearing1b',
        'status_bearing2a',
        'status_bearing2b',
        'status_bearing3a',
        'status_bearing3b',
        'status_bearing4a',
        'status_bearing4b',
        'status_bearing5a',
        'status_bearing5b',
        'status_bearing6a',
        'status_bearing6b',

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

    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class);
    }

    public static function getId()
    {
        return $getId = DB::table('lama_bearings')->orderBy('id', 'DESC')->take(1)->get();
    }
}
