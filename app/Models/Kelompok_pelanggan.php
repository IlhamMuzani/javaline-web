<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kelompok_pelanggan extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'kode_kelompok',
        'nama',
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


    public function pelanggan()
    {
        return $this->hasMany(Pelanggan::class);
    }

    public static function getId()
    {
        return $getId = DB::table('kelompok_pelanggans')->orderBy('id', 'DESC')->take(1)->get();
    }
}