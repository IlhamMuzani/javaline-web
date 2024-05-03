<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Detail_tariftambahan extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable =
    [
        'faktur_ekspedisi_id',
        'kode_tambahan',
        'keterangan_tambahan',
        'qty_tambahan',
        'nominal_tambahan',
        'satuan_tambahan',
        'tanggal_awal',
    ];

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable('*');
    }

    public static function getId()
    {
        return $getId = DB::table('Detail_tariftambahans')->orderBy('id', 'DESC')->take(1)->get();
    }

}