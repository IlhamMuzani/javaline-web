<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Timer extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'kendaraan_id',
        'user_id',
        'status_awal',
        'status_akhir',
        'timer_awal',
        'timer_akhir',
        'tanggal',
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
        return $getId = DB::table('timers')->orderBy('id', 'DESC')->take(1)->get();
    }
}