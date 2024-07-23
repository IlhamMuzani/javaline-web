<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Detail_klaimperalatan extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'klaim_peralatan_id',
        'sparepart_id',
        'kode_partdetail',
        'nama_barang',
        'keterangan',
        'jumlah',
        'harga',
        'total',
        'tanggal_awal',
    ];


    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable('*');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function klaim_peralatan()
    {
        return $this->belongsTo(Klaim_peralatan::class);
    }

    public function sparepart()
    {
        return $this->belongsTo(Sparepart::class);
    }

    public function detail_inventory()
    {
        return $this->belongsTo(Detail_inventory::class);
    }

    public static function getId()
    {
        return $getId = DB::table('detail_klaimperalatans')->orderBy('id', 'DESC')->take(1)->get();
    }
}