<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Pembelian_ban;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use App\Models\Detail_pembelianban;
use App\Models\Detail_pengeluaran;
use App\Models\Pengeluaran_kaskecil;

class LaporanPengeluarankaskecilController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->status;
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;
        $created_at = $request->created_at;
        $end_at = $request->end_at;

        // Inisialisasi query
        $inquery = Pengeluaran_kaskecil::orderBy('id', 'DESC');

        // Filter berdasarkan status
        if ($status == "posting") {
            $inquery->where('status', $status);
        } else {
            $inquery->where('status', 'posting');
        }

        // Filter berdasarkan tanggal dan waktu (tanggal_awal dan tanggal_akhir)
        if ($tanggal_awal && $tanggal_akhir) {
            $inquery->where('tanggal_awal', '>=', $tanggal_awal)
                ->where('tanggal_awal', '<=', $tanggal_akhir);
        }

        // Filter berdasarkan waktu pembuatan (created_at dan end_at)
        if ($created_at && $end_at) {
            $inquery->where('created_at', '>=', $created_at)
                ->where('created_at', '<=', $end_at);
        }

        // Tentukan apakah pencarian dilakukan
        $hasSearch = $status || ($tanggal_awal && $tanggal_akhir) || ($created_at && $end_at);

        // Eksekusi query jika ada filter, jika tidak, return collection kosong
        $inquery = $hasSearch ? $inquery->get() : collect();

        return view('admin.laporan_pengeluarankaskecil.index', compact('inquery'));
    }


    public function print_pengeluarankaskecil(Request $request)
    {
        // if (auth()->check() && auth()->user()->menu['laporan penerimaan kas kecil']) {

        $status = $request->status;
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;

        $query = Pengeluaran_kaskecil::orderBy('id', 'DESC');

        if ($status == "posting") {
            $query->where('status', $status);
        } else {
            $query->where('status', 'posting');
        }

        if ($tanggal_awal && $tanggal_akhir) {
            $query->whereDate('tanggal_awal', '>=', $tanggal_awal)
                ->whereDate('tanggal_awal', '<=', $tanggal_akhir);
        }

        $inquery = $query->orderBy('id', 'DESC')->get();

        $pdf = PDF::loadView('admin.laporan_pengeluarankaskecil.print', compact('inquery'));
        return $pdf->stream('Laporan_Pengeluaran_Kas_Kecil.pdf');
        // } else {
        //     // tidak memiliki akses
        //     return back()->with('error', array('Anda tidak memiliki akses'));
        // }
    }
}
