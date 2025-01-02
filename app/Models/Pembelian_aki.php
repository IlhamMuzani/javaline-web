<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pembelian_aki extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable =
    [
        'kode_pembelianaki',
        'qrcode_pembelianaki',
        'user_id',
        'supplier_id',
        'tanggal',
        'tanggal_awal',
        'tanggal_akhir',
        'status',
        'status_pelunasan',
        'grand_total',
        'qty_akibekas',
        'harga_akibekas',
        'total_akibekas',
        'total_harga',
        'status_notif',

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

    public static function getId()
    {
        return $getId = DB::table('pembelian_akis')->orderBy('id', 'DESC')->take(1)->get();
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function aki()
    {
        return $this->hasMany(Aki::class);
    }
}