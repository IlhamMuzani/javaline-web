<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Pembelian_ban extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable =
    [
        'kode_pembelian_ban',
        'qr_pembelian_ban',
        'supplier_id',
        'no_seri',
        'kondisi_ban',
        'harga_ban',
        'tanggal',
        'tanggal_awal',
        'tanggal_akhir',
        'status',
        'status_notif',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable('*');
    }


    public static function getId()
    {
        return $getId = DB::table('pembelian_bans')->orderBy('id', 'DESC')->take(1)->get();
    }

    public function merek()
    {
        return $this->belongsTo(Merek::class);
    }

    public function ukuran()
    {
        return $this->belongsTo(Ukuran::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function detail_ban()
    {
        return $this->hasMany(Ban::class);
    }

}