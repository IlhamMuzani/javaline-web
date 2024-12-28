<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pengambilan_do extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'kode_pengambilan',
        'user_id',
        'spk_id',
        'kendaraan_id',
        'pelanggan_id',
        'userpelanggan_id',
        'userpenerima_id',
        'km_awal',
        'km_akhir',
        'waktu_awal',
        'waktu_akhir',
        'keterangan_akses',
        'start_waktuditerima',
        'rute_perjalanan_id',
        'alamat_muat_id',
        'alamat_muat2_id',
        'alamat_muat3_id',
        'alamat_bongkar_id',
        'alamat_bongkar2_id',
        'alamat_bongkar3_id',
        'status',
        'pengambilan_do',
        'gambar',
        'gambar2',
        'gambar3',
        'bukti',
        'bukti2',
        'bukti3',
        'latitude',
        'longitude',
        'no_resi',
        'waktu_suratawal',
        'waktu_suratakhir',
        'hasil_lamawaktu',
        'status_suratjalan',
        'status_penerimaansj',
        'penerima_sj',
        'akses_spk',
        'waktu_upload_mt',
        'waktu_upload_bk',
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

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class);
    }

    public function spk()
    {
        return $this->belongsTo(Spk::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function rute_perjalanan()
    {
        return $this->belongsTo(Rute_perjalanan::class);
    }

    public function alamat_muat()
    {
        return $this->belongsTo(Alamat_muat::class, 'alamat_muat_id'); // foreign key untuk alamat pertama
    }

    public function alamat_muat2()
    {
        return $this->belongsTo(Alamat_muat::class, 'alamat_muat2_id'); // foreign key untuk alamat kedua
    }

    public function alamat_muat3()
    {
        return $this->belongsTo(Alamat_muat::class, 'alamat_muat3_id'); // foreign key untuk alamat ketiga
    }

    public function alamat_bongkar()
    {
        return $this->belongsTo(Alamat_bongkar::class, 'alamat_bongkar_id'); // foreign key untuk alamat pertama
    }

    public function alamat_bongkar2()
    {
        return $this->belongsTo(Alamat_bongkar::class, 'alamat_bongkar2_id'); // foreign key untuk alamat kedua
    }

    public function alamat_bongkar3()
    {
        return $this->belongsTo(Alamat_bongkar::class, 'alamat_bongkar3_id'); // foreign key untuk alamat ketiga
    }

    public function timer_suratjalan()
    {
        return $this->hasMany(Timer_suratjalan::class);
    }

    public function userpelanggan()
    {
        return $this->belongsTo(User::class, 'userpelanggan_id'); // foreign key untuk alamat kedua
    }

    public function userpenerima()
    {
        return $this->belongsTo(User::class, 'userpenerima_id'); // foreign key untuk alamat kedua
    }

    public static function getId()
    {
        return $getId = DB::table('pengambilan_dos')->orderBy('id', 'DESC')->take(1)->get();
    }
}
