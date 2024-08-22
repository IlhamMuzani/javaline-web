<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vendor extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'kode_vendor',
        'nama_vendor',
        'nama_alias',
        'qrcode_vendor',
        'alamat',
        'npwp',
        'nama_person',
        'jabatan',
        'telp',
        'fax',
        'hp',
        'email',
        'nama_bank',
        'atas_nama',
        'norek',
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

    public function sewa_kendaraan()
    {
        return $this->hasMany(Sewa_kendaraan::class);
    }

    public function invoice_sewakendaraan()
    {
        return $this->hasMany(Invoice_sewakendaraan::class);
    }


    public static function getId()
    {
        return $getId = DB::table('vendors')->orderBy('id', 'DESC')->take(1)->get();
    }
}
