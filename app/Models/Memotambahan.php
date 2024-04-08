<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Memotambahan extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable =
    [
        'admin',
        'kode_tambahan',
        'memo_ekspedisi_id',
        'kategori',
        'no_memo',
        'nama_driver',
        'telp',
        'kendaraan_id',
        'no_kabin',
        'no_pol',
        'nama_rute',
        'grand_total',
        'status',
        'status_memo',
        'tanggal',
        'tanggal_awal',
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

    public function detail_memotambahan()
    {
        return $this->hasMany(Detail_memotambahan::class);
    }

    public function pengeluaran_kaskecil()
    {
        return $this->hasMany(Pengeluaran_kaskecil::class);
    }


    public function detail_faktur()
    {
        return $this->hasMany(Detail_faktur::class);
    }

    public static function getId()
    {
        return $getId = DB::table('memotambahans')->orderBy('id', 'DESC')->take(1)->get();
    }
}