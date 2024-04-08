<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Barang_akun extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'kode_barangakun',
        'nama_barangakun',
        'qrcode_barangakun',
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


    public static function getId()
    {
        return $getId = DB::table('barang_akuns')->orderBy('id', 'DESC')->take(1)->get();
    }
}