<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Memo_ekspedisi;
use App\Models\Penggantian_oli;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanMemotambahanController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->status;
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;

        $inquery = Memo_ekspedisi::orderBy('id', 'DESC');

        // Menambahkan filter berdasarkan kategori "Memo Perjalanan"
        $inquery->where('kategori', 'Memo Tambahan');

        if ($status == "posting") {
            $inquery->where('status', $status);
        } else {
            $inquery->where('status', 'posting');
        }

        if ($tanggal_awal && $tanggal_akhir) {
            $inquery->whereDate('tanggal_awal', '>=', $tanggal_awal)
                ->whereDate('tanggal_awal', '<=', $tanggal_akhir);
        }

        // Kondisi sebelum melakukan pencarian data masih kosong
        $hasSearch = $status || ($tanggal_awal && $tanggal_akhir);
        $inquery = $hasSearch ? $inquery->get() : collect();

        return view('admin.laporan_memotambahan.index', compact('inquery'));
    }



    public function print_memotambahan(Request $request)
    {
        // if (auth()->check() && auth()->user()->menu['laporan penggantian oli']) {

        $status = $request->status;
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;

        $query = Memo_ekspedisi::orderBy('id', 'DESC');
        $query->where('kategori', 'Memo Tambahan');


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

        $pdf = PDF::loadView('admin.laporan_memotambahan.print', compact('inquery'));
        return $pdf->stream('Laporan_Memo_Tambahan.pdf');
        // } else {
        //     // tidak memiliki akses
        //     return back()->with('error', array('Anda tidak memiliki akses'));
        // }
    }
}