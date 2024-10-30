<?php

namespace App\Http\Controllers\Pelanggan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Kendaraan;
use App\Models\Pelanggan;
use App\Models\Pengambilan_do;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use Carbon\Carbon;

class MonitoringsuratjalanController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user(); // Dapatkan pengguna yang sedang login
        $pelanggan = Pelanggan::where('id', $user->pelanggan_id)->first();

        // Query untuk mendapatkan data Pengambilan_do yang berelasi dengan spk milik pelanggan yang sedang login
        $spks = Pengambilan_do::with('kendaraan', 'spk') // Pastikan untuk memuat relasi spk juga
            ->whereHas('spk', function ($query) use ($pelanggan) {
                $query->where('pelanggan_id', $pelanggan->id); // Filter spk berdasarkan pelanggan yang login
            })
            ->whereNotNull('spk_id')
            ->where('status_suratjalan', 'belum pulang')
            ->whereNull('waktu_suratakhir') // Filter untuk waktu_suratakhir yang null
            ->orderBy('waktu_suratawal', 'ASC')
            ->get();

        // Perulangan untuk menghitung durasi di controller
        foreach ($spks as $spk) {
            if ($spk->waktu_suratawal) {
                $waktu_awal = Carbon::parse($spk->waktu_suratawal);
                $waktu_akhir = $spk->waktu_suratakhir ? Carbon::parse($spk->waktu_suratakhir) : Carbon::now();
                $durasi = $waktu_awal->diff($waktu_akhir);
                $spk->durasi_hari = $durasi->days;
                $spk->durasi_jam = $durasi->h;
                $spk->durasi_menit = $durasi->i;
                $spk->durasi_detik = $durasi->s;
            } else {
                $spk->durasi_hari = '-';
                $spk->durasi_jam = '-';
                $spk->durasi_menit = '-';
                $spk->durasi_detik = '-';
            }
        }

        // Kirim data ke Blade
        return view('pelanggan.monitoring_suratjalan.index', compact('spks'));
    }
}
