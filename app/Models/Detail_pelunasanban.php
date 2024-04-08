<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Detail_pelunasanban extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'faktur_pelunasanban_id',
        'pembelian_ban_id',
        'kode_pembelian_ban',
        'tanggal_pembelian',
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
    public function faktur_pelunasanban()
    {
        return $this->belongsTo(Faktur_pelunasanban::class);
    }
    public function pembelian_ban()
    {
        return $this->belongsTo(Pembelian_ban::class);
    }

}