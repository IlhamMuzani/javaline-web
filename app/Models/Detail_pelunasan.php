<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Detail_pelunasan extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'faktur_pelunasan_id',
        'faktur_ekspedisi_id',
        'kode_faktur',
        'tanggal_faktur',
        'status',
        'total',
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
    public function faktur_pelunasan()
    {
        return $this->belongsTo(Faktur_pelunasan::class);
    }
    public function faktur_ekspedisi()
    {
        return $this->belongsTo(Faktur_ekspedisi::class);
    }

}