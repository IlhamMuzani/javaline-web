<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Penggantian_bearing extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'user_id',
        'kode_penggantian',
        'kendaraan_id',
        'km_penggantian',
        'km_berikutnya',
        'tanggal_penggantian',
        'tromol1',
        'tromol2',
        'tromol3',
        'tromol4',
        'tromol5',
        'tromol6',
        'tromol7',
        'tromol8',
        'tromol9',
        'tromol10',
        'tromol11',
        'tromol12',
        'tanggal_awal',
        'tanggal_akhir',
        'status',
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

    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class);
    }

    public function detail_penggantianbearing()
    {
        return $this->hasMany(Detail_penggantianbearing::class);
    }

    public static function getId()
    {
        return $getId = DB::table('penggantian_bearings')->orderBy('id', 'DESC')->take(1)->get();
    }
}