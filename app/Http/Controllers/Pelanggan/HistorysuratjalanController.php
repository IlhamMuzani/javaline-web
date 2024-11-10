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

        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;

        if (!$tanggal_awal && !$tanggal_akhir) {
            $spks = collect();
        } else {
            $spks = Pengambilan_do::where('userpelanggan_id', $user->id)
                ->with('kendaraan', 'spk')
                ->where('status', 'selesai');

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
