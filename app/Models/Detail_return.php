<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Detail_return extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'return_ekspedisi_id',
        'barang_id',
        'kode_barang',
        'nama_barang',
        'jumlah',
        'satuan',
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
    public function return_ekspedisi()
    {
        return $this->belongsTo(Return_ekspedisi::class);
    }

}