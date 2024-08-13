<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Alamat_muat extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'kode_alamat',
        'pelanggan_id',
        'telp',
        'latitude',
        'longitude',
        'alamat',
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


    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function spk()
    {
        return $this->hasMany(Spk::class);
    }

    public function pengambilan_do()
    {
        return $this->hasMany(Pengambilan_do::class);
    }
    
    public static function getId()
    {
        return $getId = DB::table('alamat_muats')->orderBy('id', 'DESC')->take(1)->get();
    }
}