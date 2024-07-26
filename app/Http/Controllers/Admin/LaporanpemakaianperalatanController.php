<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Kendaraan;
use App\Models\Pemakaian_peralatan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanpemakaianperalatanController extends Controller

{
    public function index(Request $request)
    {
        $kendaraans = Kendaraan::get();

        $status = $request->status;
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;
        $kendaraan = $request->kendaraan_id;

        $inquery = Pemakaian_peralatan::orderBy('id', 'DESC');

        if ($status == "posting") {
            $inquery->where('status', $status);
        } else {
            $inquery->where('status', 'posting');
        }

        if ($tanggal_awal && $tanggal_akhir) {
            $inquery->whereDate('tanggal_awal', '>=', $tanggal_awal)
                ->whereDate('tanggal_awal', '<=', $tanggal_akhir);
        }

        if ($kendaraan) {
            $inquery->where('kendaraan_id', $kendaraan);
        }


        // $inquery = $inquery->get();

        // kondisi sebelum melakukan pencarian data masih kosong
        $hasSearch = $status || ($tanggal_awal && $tanggal_akhir) || $kendaraan;
        $inquery = $hasSearch ? $inquery->get() : collect();

        return view('admin.laporan_pemakaianperalatan.index', compact('inquery', 'kendaraans'));
    }

    public function print_pemakaianperalatan(Request $request)
    {

        $kendaraans = Kendaraan::get();
        $status = $request->status;
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;
        $kendaraan = $request->kendaraan_id;

        $query = Pemakaian_peralatan::orderBy('id', 'DESC');

        if ($status == "posting") {
            $query->where('status', $status);
        } else {
            $query->where('status', 'posting');
        }

        if ($kendaraan) {
            $query->where('kendaraan_id', $kendaraan);
        }

        if ($tanggal_awal && $tanggal_akhir) {
            $query->whereDate('tanggal_awal', '>=', $tanggal_awal)
                ->whereDate('tanggal_awal', '<=', $tanggal_akhir);
        }

        $inquery = $query->orderBy('id', 'DESC')->with('detail_pemakaian')->get();


        $pdf = PDF::loadView('admin.laporan_pemakaianperalatan.print', compact('inquery'));
        return $pdf->stream('Laporan_Pemakain_Peralatan.pdf');
    }
}