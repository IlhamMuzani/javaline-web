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
        'kode_tagihan',
        'kategori',
        'qrcode_tagihan',
        'vendor_id',
        'kode_vendor',
        'nama_vendor',
        'alamat_vendor',
        'telp_vendor',
        'keterangan',
        'sub_total',
        'pph',
        'sisa',
        'grand_total',
        'gambar_bukti',
        'nomor_buktitagihan',
        'tanggal_nomortagihan',
        'tanggal',
        'tanggal_awal',
        'tanggal_akhir',
        'status',
        'status_pelunasan',
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

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
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