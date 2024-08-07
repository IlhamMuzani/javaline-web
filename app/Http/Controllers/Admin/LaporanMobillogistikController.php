<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use App\Models\Detail_pengeluaran;
use App\Models\Faktur_ekspedisi;
use App\Models\Kendaraan;
use App\Models\Pengeluaran_kaskecil;

class LaporanMobillogistikController extends Controller
{
    public function index(Request $request)
    {
        $kendaraans = Kendaraan::with(['detail_pengeluaran'])->get();

        // Ambil parameter dari request
        $kategoris = $request->kategoris;
        $status = $request->status;
        $created_at = $request->created_at;
        $tanggal_akhir = $request->tanggal_akhir;
        $kendaraan = $request->kendaraan_id; // Variabel baru untuk menyimpan kendaraan_id

        // Kueri untuk Faktur_ekspedisi
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

        // Kondisi tambahan untuk kendaraan_id
        if ($kendaraan) {
            $inquery->where('kendaraan_id', $kendaraan);
        }

        // Ambil data dari kueri
        $hasSearch = $status || ($created_at && $tanggal_akhir) || $kendaraan;
        $inquery = $hasSearch ? $inquery->get() : collect();

        // Hitung total nominal berdasarkan kendaraan dan tanggal
        $detail_pengeluaranperbaikans = Detail_pengeluaran::where('kendaraan_id', $kendaraan);
        $detail_pengeluaranoperasional = Detail_pengeluaran::where('kendaraan_id', $kendaraan);

        if ($created_at && $tanggal_akhir) {
            $detail_pengeluaranperbaikans->where('kode_akun', 'KA000015')
                ->whereDate('created_at', '>=', $created_at)
                ->whereDate('created_at', '<=', $tanggal_akhir);

            $detail_pengeluaranoperasional->where('kode_akun', 'KA000029')
                ->whereDate('created_at', '>=', $created_at)
                ->whereDate('created_at', '<=', $tanggal_akhir);
        }

        $totalNominalPerbaikan = $created_at && $tanggal_akhir ? $detail_pengeluaranperbaikans->sum('nominal') : 0;
        $totalNominalOperasional = $created_at && $tanggal_akhir ? $detail_pengeluaranoperasional->sum('nominal') : 0;

        // Kirim data ke view
        return view('admin.laporan_mobillogistik.index', compact('totalNominalPerbaikan', 'totalNominalOperasional', 'inquery', 'kendaraans', 'kendaraan'));
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

        // Hitung total nominal berdasarkan kendaraan dan tanggal
        $detail_pengeluaranperbaikans = Detail_pengeluaran::where('kendaraan_id', $kendaraan);
        $detail_pengeluaranoperasional = Detail_pengeluaran::where('kendaraan_id', $kendaraan);

        if ($created_at && $tanggal_akhir) {
            $detail_pengeluaranperbaikans->where('kode_akun', 'KA000015')->whereDate(
                'created_at',
                '>=',
                $created_at
            )
                ->whereDate('created_at', '<=', $tanggal_akhir);

            $detail_pengeluaranoperasional->where('kode_akun', 'KA000029')->whereDate('created_at', '>=', $created_at)
                ->whereDate('created_at', '<=', $tanggal_akhir);
        }

        $totalNominalPerbaikan = $created_at && $tanggal_akhir ? $detail_pengeluaranperbaikans->sum('nominal') : 0;
        $totalNominalOperasional = $created_at && $tanggal_akhir ? $detail_pengeluaranoperasional->sum('nominal') : 0;

        $pdf = PDF::loadView('admin.laporan_mobillogistik.print', compact('totalNominalPerbaikan', 'totalNominalOperasional', 'inquery', 'kendaraans'));
        return $pdf->stream('Laporan_Pengeluaran_Kas_Kecil.pdf');
        // } else {
        //     // tidak memiliki akses
        //     return back()->with('error', array('Anda tidak memiliki akses'));
        // }
    }
}
