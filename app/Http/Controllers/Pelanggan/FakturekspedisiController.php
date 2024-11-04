<?php

namespace App\Http\Controllers\Pelanggan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Faktur_ekspedisi;
use App\Models\Kendaraan;
use App\Models\Pelanggan;
use App\Models\Pengambilan_do;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use Carbon\Carbon;

class FakturekspedisiController extends Controller
{
    public function index(Request $request)
    {
        // Mendapatkan user yang sedang login
        $user = auth()->user();
        // Mendapatkan pelanggan yang sedang login berdasarkan pelanggan_id dari user
        $pelanggan = Pelanggan::where('id', $user->pelanggan_id)->first();

        // Mengambil parameter filter dari request
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;

        // Query faktur ekspedisi dengan filter status posting atau selesai dan pelanggan yang sedang login
        $inquery = Faktur_ekspedisi::where('pelanggan_id', $pelanggan->id) // Filter berdasarkan pelanggan yang login
            ->whereIn('status', ['posting', 'selesai'])
            ->orderByRaw("CASE WHEN status_pelunasan = 'aktif' THEN 1 ELSE 0 END") // Posisikan 'aktif' di bawah
            ->orderBy('id', 'ASC'); // Urutkan berdasarkan ID

        // Filter berdasarkan tanggal awal dan tanggal akhir jika disediakan
        if ($tanggal_awal && $tanggal_akhir) {
            $inquery->whereDate('tanggal_awal', '>=', $tanggal_awal)
                ->whereDate('tanggal_awal', '<=', $tanggal_akhir);
        }

        // Eksekusi query dan ambil hasilnya
        $inquery = $inquery->get();
        $hasSearch = ($tanggal_awal && $tanggal_akhir);

        // Hanya tampilkan hasil query jika ada filter tanggal, atau semua data jika filter kosong
        $inquery = $hasSearch ? $inquery : collect();

        return view('pelanggan.faktur_ekspedisi.index', compact('inquery'));
    }
}
