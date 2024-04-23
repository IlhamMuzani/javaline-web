<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Detail_cicilan extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable =
    [
        'detail_gajikaryawan_id',
        'kasbon_karyawan_id',
        'karyawan_id',
        'nominal_cicilan',
        'status',
        'status_cicilan',
    ];

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable('*');
    }

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }
    
    public static function getId()
    {
        return $getId = DB::table('detail_cicilans')->orderBy('id', 'DESC')->take(1)->get();
    }
}