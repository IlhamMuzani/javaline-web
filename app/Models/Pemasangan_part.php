<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Pemasangan_part extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'user_id',
        'kode_pemasanganpart',
        'kendaraan_id',
        'tanggal_pemasangan',
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class);
    }

    public function detail_part()
    {
        return $this->hasMany(Detail_pemasanganpart::class);
    }

    public static function getId()
    {
        return $getId = DB::table('pemasangan_parts')->orderBy('id', 'DESC')->take(1)->get();
    }
}