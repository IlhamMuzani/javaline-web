<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogPerpanjangankir extends Model
{
    use HasFactory;

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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function nokir()
    {
        return $this->belongsTo(Nokir::class);
    }
}