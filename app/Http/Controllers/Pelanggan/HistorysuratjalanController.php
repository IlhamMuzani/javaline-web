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

        $user = auth()->user(); // Pastikan untuk mendapatkan pengguna yang sedang login
        $pelanggan = Pelanggan::where('id', $user->pelanggan_id)->first();

        $status = $request->status;
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;

        $spks = Pengambilan_do::with('kendaraan', 'spk') // Pastikan untuk memuat relasi spk juga
            ->whereHas('spk', function ($query) use ($pelanggan) {
                $query->where('pelanggan_id', $pelanggan->id); // Filter spk berdasarkan pelanggan yang login
            });

        if ($status) {
            $spks->where('status', $status);
        }

        if ($tanggal_awal && $tanggal_akhir) {
            $spks->whereBetween('tanggal_awal', [$tanggal_awal, $tanggal_akhir]);
        } elseif ($tanggal_awal) {
            $spks->where('tanggal_awal', '>=', $tanggal_awal);
        } elseif ($tanggal_akhir) {
            $spks->where('tanggal_awal', '<=', $tanggal_akhir);
        } else {
            // Jika tidak ada filter tanggal hari ini
            $spks->whereDate('tanggal_awal', Carbon::today());
        }

        $spks->orderBy('id', 'DESC');
        $spks = $spks->get();

        return view('pelanggan.history_suratjalan.index', compact('spks'));
    }
}
