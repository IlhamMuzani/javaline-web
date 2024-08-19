<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Harga_sewa extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable =
    [
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

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function sewa_kendaraan()
    {
        return $this->hasMany(Sewa_kendaraan::class);
    }

    public static function getId()
    {
        return $getId = DB::table('harga_sewas')->orderBy('id', 'DESC')->take(1)->get();
    }
}