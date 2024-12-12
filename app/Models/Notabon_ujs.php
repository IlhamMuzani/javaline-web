<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notabon_ujs extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'kode_nota',
        'karyawan_id',
        'user_id',
        'admin',
        'kode_driver',
        'nama_driver',
        'nominal',
        'keterangan',
        'qrcode_nota',
        'status',
        'status_memo',
        'status_notif',
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


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }

    public static function getId()
    {
        return $getId = DB::table('notabon_ujs')->orderBy('id', 'DESC')->take(1)->get();
    }
}