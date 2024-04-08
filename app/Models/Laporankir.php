<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Laporankir extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'user_id',
        'nokir_id',
        'kode_perpanjangan',
        'kategori',
        'masa_berlaku',
        'jumlah',
        'tanggal',
        'tanggal_awal',
        'tanggal_akhir',
        'status',
        'status_kir',
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
        return $getId = DB::table('laporankirs')->orderBy('id', 'DESC')->take(1)->get();
    }


    public function nokir()
    {
        return $this->belongsTo(Nokir::class);
    }

}