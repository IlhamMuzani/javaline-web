<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rute_perjalanan extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable =
    [
        'provinsi',
        'kode_rute',
        'nama_rute',
        'qrcode_rute',
        'provinsi',
        'kategori',
        'harga',
        'golongan1',
        'golongan2',
        'golongan3',
        'golongan4',
        'golongan5',
        'golongan6',
        'golongan7',
        'golongan8',
        'golongan9',
        'golongan10',
        'keterangan',
        'tanggal_awal',
    ];

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable('*');
    }

    public function pengambilan_do()
    {
        return $this->hasMany(Pengambilan_do::class);
    }

    public static function getId()
    {
        return $getId = DB::table('rute_perjalanans')->orderBy('id', 'DESC')->take(1)->get();
    }
}