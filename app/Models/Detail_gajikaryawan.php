<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Detail_gajikaryawan extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'kode_gajikaryawan',
        'perhitungan_gajikaryawan_id',
        'karyawan_id',
        'kategori',
        'kode_karyawan',
        'nama_lengkap',
        'gaji',
        'gaji_perhari',
        'hari_efektif',
        'hasil_hk',
        'uang_makan',
        'uang_hadir',
        'hari_kerja',
        'lembur',
        'hasil_lembur',
        'storing',
        'hasil_storing',
        'gaji_kotor',
        'kurangtigapuluh',
        'lebihtigapuluh',
        'hasilkurang',
        'hasillebih',
        'pelunasan_kasbon',
        'absen',
        'hasil_absen',
        'tdk_berangkat',
        'hasiltdk_berangkat',
        'tgl_merah',
        'hasiltgl_merah',
        'gaji_bersih',
        'gajinol_pelunasan',
        'bpjs',
        'potongan_bpjs',
        'potongan_ke',
        'lainya',
        'status',
        'kasbon_awal',
        'sisa_kasbon',
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

    public function perhitungan_gajikaryawan()
    {
        return $this->belongsTo(Perhitungan_gajikaryawan::class);
    }

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }

    public static function getId()
    {
        return $getId = DB::table('detail_gajikaryawans')->orderBy('id', 'DESC')->take(1)->get();
    }
}