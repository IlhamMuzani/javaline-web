<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'karyawan_id',
        'pelanggan_id',
        'detail_pelanggan_id',
        'kode_user',
        'qrcode_user',
        'password',
        'cek_hapus',
        'menu',
        'fitur',
        'level',
        'tanggal_awal',
        'tanggal_akhir',
    ];

    // use SoftDeletes;
    // protected $dates = ['deleted_at'];


    // use SoftDeletes;
    // protected $dates = ['deleted_at'];


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable();
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function getId()
    {
        return $getId = DB::table('users')->orderBy('id', 'DESC')->take(1)->get();
    }


    protected function menu(): Attribute
    {
        return Attribute::make(
            get: fn($value) => json_decode($value, true),
            set: fn($value) => json_encode($value),
        );
    }

    protected function fitur(): Attribute
    {
        return Attribute::make(
            get: fn($value) => json_decode($value, true),
            set: fn($value) => json_encode($value),
        );
    }


    public function isAdmin()
    {
        if ($this->level == 'admin') {
            return true;
        }
        return false;
    }

    public function isDriver()
    {
        if ($this->level == 'driver') {
            return true;
        }
        return false;
    }

    public function isPelanggan()
    {
        if ($this->level == 'pelanggan') {
            return true;
        }
        return false;
    }

    // public function isPelanggan()
    // {
    //     if ($this->level == 'pelanggan') {
    //         return true;
    //     }
    //     return false;
    // }

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    public function detail_pelanggan()
    {
        return $this->belongsTo(Detail_pelanggan::class);
    }

    public function spk()
    {
        return $this->belongsTo(User::class);
    }

    public function kendaraan(): HasOne
    {
        return $this->hasOne(Kendaraan::class, 'user_id');
    }

    public function pengambilan_do(): HasOne
    {
        return $this->hasOne(Pengambilan_do::class, 'user_id');
    }

    // public function latestpengambilan_do()
    // {
    //     return $this->hasOne(Pengambilan_do::class)
    //         ->whereIn('status', ['tunggu bongkar', 'loading muat', 'posting', 'selesai'])
    //         ->orderByRaw("FIELD(status, 'tunggu bongkar', 'loading muat', 'posting', 'selesai')")
    //         ->latest();
    // }

    public function latestpengambilan_do()
    {
        return $this->hasOne(Pengambilan_do::class)
            ->whereNotIn('status', ['unpost']) // Mengecualikan status 'unpost'
            ->whereIn('status', ['tunggu bongkar', 'loading muat', 'posting', 'selesai'])
            ->orderByRaw("FIELD(status, 'tunggu bongkar', 'loading muat', 'posting', 'selesai')")
            ->latest();
    }

    public function timer_suratjalan()
    {
        return $this->hasMany(Timer_suratjalan::class);
    }


    // public function latestpengambilan_do()
    // {
    //     return $this->hasOne(Pengambilan_do::class)->latest();

    // }

}