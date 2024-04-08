<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use App\Models\Faktur_ekspedisi;
use App\Models\Kendaraan;
use App\Models\Pengeluaran_kaskecil;

class LaporanMobillogistikglobalController extends Controller
{
    public function index(Request $request)
    {
        $kendaraans = Kendaraan::with(['faktur_ekspedisi', 'memo_ekspedisi', 'detail_pengeluaran'])->get();

        $status = $request->status;
        $created_at = $request->created_at;
        $tanggal_akhir = $request->tanggal_akhir;

        $inquery = Faktur_ekspedisi::orderBy('id', 'DESC');

        if ($status == "posting") {
            $inquery->where('status', $status);
        } else {
            $inquery->where('status', 'posting');
        }

        if ($created_at && $tanggal_akhir) {
            $inquery->whereBetween('created_at', [$created_at, $tanggal_akhir]);
        }

        $faktur_ekspedisis = $inquery->get();

        // Additional logic if needed

        // $inquery = $inquery->get();

        // kondisi sebelum melakukan pencarian data masih kosong
        $hasSearch = $status || ($created_at && $tanggal_akhir);
        $inquery = $hasSearch ? $faktur_ekspedisis : collect();

        return view('admin.laporan_mobillogistikglobal.index', compact('kendaraans', 'created_at', 'tanggal_akhir'));
    }

    // public function print_mobillogistikglobal(Request $request)
    // {
    //     // if (auth()->check() && auth()->user()->menu['laporan penerimaan kas kecil']) {

    //     $status = $request->status;
    //     $created_at = $request->created_at;
    //     $tanggal_akhir = $request->tanggal_akhir;
    //     $kendaraan = $request->kendaraan_id; // New variable to store kendaraan_id

    //     $kendaraans = Kendaraan::with(['faktur_ekspedisi', 'memo_ekspedisi'])
    //         ->withCount('memo_ekspedisi')
    //         ->get();

    //     $inquery = Faktur_ekspedisi::orderBy('id', 'DESC');

    //     if ($status == "posting") {
    //         $inquery->where('status', $status);
    //     } else {
    //         $inquery->where('status', 'posting');
    //     }

    //     if ($created_at && $tanggal_akhir) {
    //         $inquery->whereBetween('created_at', [$created_at, $tanggal_akhir]);
    //     }

    //     $faktur_ekspedisis = $inquery->get();

    //     $pdf = PDF::loadView('admin.laporan_mobillogistikglobal.print', compact('kendaraans', 'inquery'));
    //     return $pdf->stream('Laporan_mobil_logistik.pdf');
    //     // } else {
    //     //     // tidak memiliki akses
    //     //     return back()->with('error', array('Anda tidak memiliki akses'));
    //     // }
    // }

    public function print_mobillogistikglobal(Request $request)
    {
        $status = $request->status;
        $created_at = $request->created_at;
        $tanggal_akhir = $request->tanggal_akhir;
        $kendaraan = $request->kendaraan_id; // New variable to store kendaraan_id

        $kendaraans = Kendaraan::with(['faktur_ekspedisi', 'memo_ekspedisi'])
            ->withCount('memo_ekspedisi')
            ->get();

        $inquery = Faktur_ekspedisi::orderBy('id', 'DESC');

        if ($status == "posting") {
            $inquery->where('status', $status);
        } else {
            $inquery->where('status', 'posting');
        }

        if ($created_at && $tanggal_akhir) {
            $inquery->whereBetween('created_at', [$created_at, $tanggal_akhir]);
        }

        // Retrieve faktur_ekspedisis directly from the relationship
        $faktur_ekspedisis = $inquery->get();

        $pdf = PDF::loadView('admin.laporan_mobillogistikglobal.print', compact('inquery','kendaraans', 'faktur_ekspedisis'));
        return $pdf->stream('Laporan_mobil_logistik.pdf');
    }
}