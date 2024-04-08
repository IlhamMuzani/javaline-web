<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Nokir extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'kendaraan_id',
        'ukuran_ban',
        'jenis_kendaraan',
        'kode_kir',
        'qrcode_kir',
        'nama_pemilik',
        'alamat',
        'nomor_uji_kendaraan',
        'nomor_sertifikat_kendaraan',
        'tanggal_sertifikat',
        'nopol',
        'no_rangka',
        'no_mesin',
        // 'gambar_logo',
        'gambar_depan',
        'gambar_belakang',
        'gambar_kanan',
        'gambar_kiri',
        'merek_kendaraan',
        'tahun_kendaraan',
        'bahan_bakar',
        'isi_silinder',
        'daya_motor',
        'konfigurasi_sumbu',
        'berat_kosongkendaraan',
        'panjang',
        'lebar',
        'tinggi',
        'julur_depan',
        'julur_belakang',
        'sumbu_1_2',
        'sumbu_2_3',
        'sumbu_3_4',
        'dimensi_bakmuatan',
        'jbb',
        'jbi',
        'daya_angkutorang',
        'kelas_jalan',
        'rem_utama',
        'lampu_utama',
        'emisi',
        'keterangan',
        'masa_berlaku',
        'nama_petugas_penguji',
        'nrp_petugas_penguji',
        'nama_kepala_dinas',
        'pangkat_kepala_dinas',
        'nip_kepala_dinas',
        'unit_pelaksanaan_teknis',
        'nama_direktur',
        'pangkat_direktur',
        'nip_direktur',
        'kategori',
        'jumlah',
        'status_kir',
        'status_notif',
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


    public static function getId()
    {
        return $getId = DB::table('nokirs')->orderBy('id', 'DESC')->take(1)->get();
    }


    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class);
    }

    public function jenis_kendaraan()
    {
        return $this->belongsTo(Jenis_kendaraan::class);
    }

    public function ukuranban()
    {
        return $this->belongsTo(Ukuran::class);
    }
}