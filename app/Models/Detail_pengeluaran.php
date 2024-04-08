<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Detail_pengeluaran extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'pengeluaran_kaskecil_id',
        'perhitungan_gajikaryawan_id',
        'memo_ekspedisi_id',
        'memotambahan_id',
        'detail_memotambahan_id',
        'laporankir_id',
        'laporanstnk_id',
        'kasbon_karyawan_id',
        'barangakun_id',
        'kode_detailakun',
        'kendaraan_id',
        'kode_akun',
        'nama_akun',
        'qty',
        'satuans',
        'hargasatuan',
        'nominal',
        'keterangan',
        'status',
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
    public function return_ekspedisi()
    {
        return $this->belongsTo(Detail_pengeluaran::class);
    }

    public function pengeluaran_kaskecil()
    {
        return $this->belongsTo(Pengeluaran_kaskecil::class);
    }
    public function barangakun()
    {
        return $this->belongsTo(Barang_akun::class);
    }

    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class);
    }
    
    public static function getId()
    {
        return $getId = DB::table('detail_pengeluarans')->orderBy('id', 'DESC')->take(1)->get();
    }


}