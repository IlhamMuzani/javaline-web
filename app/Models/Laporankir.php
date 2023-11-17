<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Laporankir extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
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

    
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable('*');
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