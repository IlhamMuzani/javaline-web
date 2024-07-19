<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tarif extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable =
    [
        'pelanggan_id',
        'vendor_id',
        'kode_tarif',
        'nama_tarif',
        'nominal',
        'tanggal_awal',
    ];

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable('*');
    }

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }


    public static function getId()
    {
        return $getId = DB::table('tarifs')->orderBy('id', 'DESC')->take(1)->get();
    }
}