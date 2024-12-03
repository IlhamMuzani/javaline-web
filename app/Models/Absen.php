<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Divisi extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'kode_absen',
        'user_id',
        'waktu',
        'gambar',
        'latitude',
        'longitude',
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


    public function user()
    {
        return $this->hasMany(User::class);
    }

    public static function getId()
    {
        return $getId = DB::table('divisis')->orderBy('id', 'DESC')->take(1)->get();
    }

}