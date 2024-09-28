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
        'bearing1',
        'bearing2',
        'bearing3',
        'bearing4',
        'bearing5',
        'bearing6',
        'bearing7',
        'bearing8',
        'bearing9',
        'bearing10',
        'bearing11',
        'bearing12',
        'bearing13',
        'bearing14',
        'bearing15',
        'bearing16',
        'bearing17',
        'bearing18',
        'bearing19',
        'bearing20',
        'bearing21',
        'bearing22',
        'status_bearing1',
        'status_bearing2',
        'status_bearing3',
        'status_bearing4',
        'status_bearing5',
        'status_bearing6',
        'status_bearing7',
        'status_bearing8',
        'status_bearing9',
        'status_bearing10',
        'status_bearing11',
        'status_bearing12',
        'status_bearing13',
        'status_bearing14',
        'status_bearing15',
        'status_bearing16',
        'status_bearing17',
        'status_bearing18',
        'status_bearing19',
        'status_bearing20',
        'status_bearing21',
        'status_bearing22',
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