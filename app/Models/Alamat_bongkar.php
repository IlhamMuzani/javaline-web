<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Alamat_bongkar extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'kode_alamat',
        'pelanggan_id',
        'alamat',
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
        return $getId = DB::table('alamat_muats')->orderBy('id', 'DESC')->take(1)->get();
    }
}