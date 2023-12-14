<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Detail_memotambahan extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'memotambahan_id',
        'keterangan_tambahan',
        'nominal_tambahan',
        'tanggal_awal',
    ];
    
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable('*');
    }
    public function memo_ekpedisi()
    {
        return $this->belongsTo(Memotambahan::class);
    }


}