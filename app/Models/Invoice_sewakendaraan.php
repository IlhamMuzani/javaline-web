<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice_sewakendaraan extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable =
    [
        'user_id',
        'kode_invoice',
        'kategori',
        'qrcode_invoice',
        'pelanggan_id',
        'kode_pelanggan',
        'nama_pelanggan',
        'alamat_pelanggan',
        'telp_pelanggan',
        'keterangan',
        'sub_total',
        'pph',
        'sisa',
        'grand_total',
        'gambar_bukti',
        'nomor_buktiinvoice',
        'tanggal_nomorinvoice',
        'tanggal',
        'tanggal_awal',
        'tanggal_akhir',
        'status',
        'status_terpakai',
        'periode_awal',
        'periode_akhir',
        'status_notif',
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function detail_invoice()
    {
        return $this->hasMany(Detail_invoice::class);
    }
    
    public static function getId()
    {
        return $getId = DB::table('invoice_sewakendaraans')->orderBy('id', 'DESC')->take(1)->get();
    }
}