<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Memotambahan extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable =
    [
        'kode_tambahan',
        'memo_id',
        'grand_total',
        'tanggal_awal',
    ];


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable('*');
    }

    public function memo()
    {
        return $this->belongsTo(Memo_ekspedisi::class);
    }


    public static function getId()
    {
        return $getId = DB::table('memotambahans')->orderBy('id', 'DESC')->take(1)->get();
    }

}