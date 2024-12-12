<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Detail_notabon extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable =
    [
        'memo_ekspedisi_id',
        'notabon_ujs_id',
        'kode_nota',
        'nama_drivernota',
        'nominal_nota',
    ];

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable('*');
    }

    public function memo_ekspedisi()
    {
        return $this->belongsTo(Memo_ekspedisi::class);
    }

    public static function getId()
    {
        return $getId = DB::table('detail_notabons')->orderBy('id', 'DESC')->take(1)->get();
    }
}