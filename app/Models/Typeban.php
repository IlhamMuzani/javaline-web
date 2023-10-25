<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Typeban extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'kode_type',
        'nama_type',
        'qrcode_type',
        'kendaraan_id',
        'tanggal_awal',
        'tanggal_akhir',
    ];


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable('*');
    }


    public function ban()
    {
        return $this->hasMany(Ban::class);
    }

    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class);
    }

    public static function getId()
    {
        return $getId = DB::table('typebans')->orderBy('id', 'DESC')->take(1)->get();
    }
}