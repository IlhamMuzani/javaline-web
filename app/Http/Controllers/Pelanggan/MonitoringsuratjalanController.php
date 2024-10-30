<?php

namespace App\Http\Controllers\Pelanggan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Kendaraan;
use App\Models\Pengambilan_do;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use Carbon\Carbon;

class MonitoringsuratjalanController extends Controller
{
    public function index(Request $request)
    {
        // Mendapatkan input dari select divisi
        $divisi = $request->input('divisi');

        // Query dasar untuk mendapatkan data dengan status_suratjalan 'belum pulang'
        $spks = Pengambilan_do::with('kendaraan')
            ->whereNotNull('spk_id')
            ->where('status_suratjalan', 'belum pulang')
            ->whereNull('waktu_suratakhir'); // Filter untuk waktu_suratakhir yang null

        // Filter berdasarkan nomor kabin kendaraan jika divisi dipilih
        if (!empty($divisi) && $divisi != 'All') {
            $spks->whereHas('kendaraan', function ($query) use ($divisi) {
                $query->where('no_kabin', 'LIKE', $divisi . '%');
            });
        }

        // Mengurutkan berdasarkan id secara descending
        $spks = $spks->orderBy('waktu_suratawal', 'ASC')->get();

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