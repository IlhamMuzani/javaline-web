<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pemakaian_peralatan extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'user_id',
        'kode_pemakaian',
        'kendaraan_id',
        'tanggal_pemakaian',
        'tanggal_awal',
        'tanggal_akhir',
        'status',
        'status_notif',
    ];


    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable('*');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class);
    }

    public function detail_pemakaian()
    {
        return $this->hasMany(Detail_pemakaian::class);
    }

    public static function getId()
    {
        return $getId = DB::table('pemakaian_peralatans')->orderBy('id', 'DESC')->take(1)->get();
    }
}