<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Detail_pelunasanpart extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'faktur_pelunasanpart_id',
        'pembelian_part_id',
        'kode_pembelianpart',
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
    public function faktur_pelunasanpart()
    {
        return $this->belongsTo(Faktur_pelunasanpart::class);
    }
    public function pembelian_part()
    {
        return $this->belongsTo(Pembelian_part::class);
    }
}