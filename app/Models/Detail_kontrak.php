<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

use Illuminate\Database\Eloquent\SoftDeletes;
class Detail_kontrak extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'kontrak_rute_id',
        'nama_tarif',
        'kode_tarif',
        'nominal',
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
    public function kontrak_rute()
    {
        return $this->belongsTo(Kontrak_rute::class);
    }

}