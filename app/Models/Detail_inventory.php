<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Detail_inventory extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'pemakaian_peralatan_id',
        'detail_pemakaian_id',
        'kendaraan_id',
        'sparepart_id',
        'kode_barang',
        'nama_barang',
        'jumlah',
        'keterangan',
        'harga',
        'status',
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

    public function sparepart()
    {
        return $this->belongsTo(Sparepart::class);
    }

    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class);
    }

    public static function getId()
    {
        return $getId = DB::table('detail_inventories')->orderBy('id', 'DESC')->take(1)->get();
    }
}