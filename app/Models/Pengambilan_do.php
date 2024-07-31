<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pengambilan_do extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'kode_pengambilan',
        'spk_id',
        'kendaraan_id',
        'rute_perjalanan_id',
        'alamat_muat_id',
        'alamat_bongkar_id',
        'status',
        'tanggal',
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


    public function spk_id()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    public function kendaraan_id()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function spk()
    {
        return $this->hasMany(Spk::class);
    }
    public static function getId()
    {
        return $getId = DB::table('alamat_muats')->orderBy('id', 'DESC')->take(1)->get();
    }
}