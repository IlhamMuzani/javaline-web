<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Timer_suratjalan extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'pengambilan_do_id',
        'kategori',
        'user_id',
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

    public function pengambilan_do()
    {
        return $this->belongsTo(Pengambilan_do::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function getId()
    {
        return $getId = DB::table('timers')->orderBy('id', 'DESC')->take(1)->get();
    }
}