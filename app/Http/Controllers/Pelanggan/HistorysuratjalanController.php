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

class HistorysuratjalanController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $pelanggan = Pelanggan::where('id', $user->pelanggan_id)->first();

        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;

        // Jika tidak ada filter tanggal, kembalikan data kosong
        if (!$tanggal_awal && !$tanggal_akhir) {
            $spks = collect(); // Data kosong
        } else {
            $spks = Pengambilan_do::with('kendaraan', 'spk')
                ->whereHas('spk', function ($query) use ($pelanggan) {
                    $query->where('pelanggan_id', $pelanggan->id);
                })
                ->where('status', 'selesai'); // Hanya tampilkan yang berstatus selesai

            if ($tanggal_awal && $tanggal_akhir) {
                $spks->whereBetween('tanggal_awal', [$tanggal_awal, $tanggal_akhir]);
            } elseif ($tanggal_awal) {
                $spks->where('tanggal_awal', '>=', $tanggal_awal);
            } elseif ($tanggal_akhir) {
                $spks->where('tanggal_awal', '<=', $tanggal_akhir);
            }

            $spks->orderBy('id', 'DESC');
            $spks = $spks->get();
        }

        return view('pelanggan.history_suratjalan.index', compact('spks'));
    }
}
