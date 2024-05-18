<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use App\Models\Faktur_ekspedisi;
use App\Models\Kendaraan;
use App\Models\Pengeluaran_kaskecil;

class LaporanMobillogistikController extends Controller
{
    public function index(Request $request)
    {
        $kendaraans = Kendaraan::with(['detail_pengeluaran'])->get();
        // foreach ($kendaraans as $kendaraan) {
        //     $totalNominal = $kendaraan->detail_pengeluaran->sum('nominal');
        //     // Lakukan sesuatu dengan $totalNominal, seperti menyimpannya dalam array atau memasukkannya ke dalam data yang dikirim ke tampilan.
        // }
        $kategoris = $request->kategoris;
        $status = $request->status;
        $created_at = $request->created_at;
        $tanggal_akhir = $request->tanggal_akhir;
        $kendaraan = $request->kendaraan_id; // New variable to store kendaraan_id

        $inquery = Faktur_ekspedisi::orderBy('id', 'DESC');

        if ($kategoris) {
            if ($kategoris == 'memo') {
                $inquery->where('kategoris', 'memo');
            } elseif ($kategoris == 'non memo') {
                $inquery->where('kategoris', 'non memo');
            }
        }

        if ($status == "posting" || $status == "selesai") {
            $inquery->where('status', $status);
        } else {
            $inquery->whereIn('status', ['posting', 'selesai']);
        }

        if ($created_at && $tanggal_akhir) {
            $inquery->whereDate('created_at', '>=', $created_at)
                ->whereDate('created_at', '<=', $tanggal_akhir);
        }

        // Additional condition for kendaraan_id
        if ($kendaraan) {
            $inquery->where('kendaraan_id', $kendaraan);
        }

        // $inquery = $inquery->get();

        // kondisi sebelum melakukan pencarian data masih kosong
        $hasSearch = $status || ($created_at && $tanggal_akhir) || $kendaraan;
        $inquery = $hasSearch ? $inquery->get() : collect();

        return view('admin.laporan_mobillogistik.index', compact('inquery', 'kendaraans'));
    }

    public function print_mobillogistik(Request $request)
    {
        // if (auth()->check() && auth()->user()->menu['laporan penerimaan kas kecil']) {
        $kendaraans = Kendaraan::with(['detail_pengeluaran'])->get();

        $kategoris = $request->kategoris;
        $status = $request->status;
        $created_at = $request->created_at;
        $tanggal_akhir = $request->tanggal_akhir;
        $kendaraan = $request->kendaraan_id; // New variable to store kendaraan_id
        $query = Faktur_ekspedisi::orderBy('id', 'DESC');

        if ($kategoris) {
            if ($kategoris == 'memo') {
                $query->where('kategoris', 'memo');
            } elseif ($kategoris == 'non memo') {
                $query->where('kategoris', 'non memo');
            }
        }

        if ($status == "posting" || $status == "selesai") {
            $query->where('status', $status);
        } else {
            $query->whereIn('status', ['posting', 'selesai']);
        }

        if ($created_at && $tanggal_akhir) {
            $query->whereDate('created_at', '>=', $created_at)
                ->whereDate('created_at', '<=', $tanggal_akhir);
        }

        // Additional condition for kendaraan_id
        if ($kendaraan) {
            $query->where('kendaraan_id', $kendaraan);
        }

        $inquery = $query->orderBy('id', 'DESC')->get();

        $pdf = PDF::loadView('admin.laporan_mobillogistik.print', compact('inquery', 'kendaraans'));
        return $pdf->stream('Laporan_Pengeluaran_Kas_Kecil.pdf');
        // } else {
        //     // tidak memiliki akses
        //     return back()->with('error', array('Anda tidak memiliki akses'));
        // }
    }
}