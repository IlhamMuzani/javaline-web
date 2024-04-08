<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

use Illuminate\Database\Eloquent\SoftDeletes;
class Detail_nota extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'nota_return_id',
        'barang_id',
        'kode_barang',
        'nama_barang',
        'jumlah',
        'satuan',
        'harga',
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
    public function return_ekspedisi()
    {
        return $this->belongsTo(Nota_return::class);
    }

}