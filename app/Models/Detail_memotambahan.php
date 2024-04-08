<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Detail_memotambahan extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'memotambahan_id',
        'qty',
        'satuans',
        'hargasatuan',
        'keterangan_tambahan',
        'nominal_tambahan',
        'tanggal_awal',
    ];

    use SoftDeletes;
    protected $dates = ['deleted_at'];

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