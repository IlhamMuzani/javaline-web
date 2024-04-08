<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Detail_pelunasandeposit extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'kategori',
        'pelunasan_deposit_id',
        'detail_gajikaryawan_id',
        'karyawan_id',
        'nama_lengkap',
        'kasbon_awal',
        'sisa_kasbon',
        'pelunasan_kasbon',
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

    public function pelunasan_deposit()
    {
        return $this->belongsTo(Pelunasan_deposit::class);
    }

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }

    public static function getId()
    {
        return $getId = DB::table('detail_pelunasandeposits')->orderBy('id', 'DESC')->take(1)->get();
    }
}
