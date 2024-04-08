<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ukuran extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'kode_ukuran_ban',
        'ukuran',
        'qrcode_ukuran',
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


    public static function getId()
    {
        return $getId = DB::table('ukurans')->orderBy('id', 'DESC')->take(1)->get();
    }

    public function merek_ban()
    {
        return $this->belongsTo(Merek_ban::class);
    }

    public function ban()
    {
        return $this->hasMany(Ban::class);
    }

    public function nokir()
    {
        return $this->hasMany(Nokir::class);
    }
}