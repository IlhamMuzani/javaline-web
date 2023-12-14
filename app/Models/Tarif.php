<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Tarif extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable =
    [
        'kode_tarif',
        'nama_tarif',
        'nominal',
        'tanggal_awal',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable('*');
    }

    public static function getId()
    {
        return $getId = DB::table('tarifs')->orderBy('id', 'DESC')->take(1)->get();
    }

}