<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Kota extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
    ];

    public function kendaraan()
    {
        return $this->hasMany(Kendaraan::class);
    }

    public function laporanperjalanan()
    {
        return $this->hasMany(Laporanperjalanan::class);
    }
}