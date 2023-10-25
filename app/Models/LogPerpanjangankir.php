<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class LogPerpanjangankir extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'user_id',
        'nokir_id',
        'tanggal_perpanjang',
        'jumlah_pembayaran',
        'tanggal',
        'tanggal_awal',
        'tanggal_akhir',
        'status',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable('*');
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function nokir()
    {
        return $this->belongsTo(Nokir::class);
    }
}