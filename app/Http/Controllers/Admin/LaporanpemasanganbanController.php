<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Pemasangan_ban;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanpemasanganbanController extends Controller

{
    public function index(Request $request)
    {
        if (auth()->check() && auth()->user()->menu['laporan pemasangan ban']) {

            $status = $request->status;
            $tanggal_awal = $request->tanggal_awal;
            $tanggal_akhir = $request->tanggal_akhir;

            $inquery = Pemasangan_ban::orderBy('id', 'DESC');

            if ($status == "posting") {
                $inquery->where('status', $status);
            } else {
                $inquery->where('status', 'posting');
            }

            if ($tanggal_awal && $tanggal_akhir) {
                $inquery->whereDate('tanggal_awal', '>=', $tanggal_awal)
                    ->whereDate('tanggal_awal', '<=', $tanggal_akhir);
            }

            // $inquery = $inquery->get();

            // kondisi sebelum melakukan pencarian data masih kosong
            $hasSearch = $status || ($tanggal_awal && $tanggal_akhir);
            $inquery = $hasSearch ? $inquery->get() : collect();

            return view('admin.laporan_pemasanganban.index', compact('inquery'));
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }


    public function print_pemasanganban(Request $request)
    {
        if (auth()->check() && auth()->user()->menu['laporan pemasangan ban']) {

            $status = $request->status;
            $tanggal_awal = $request->tanggal_awal;
            $tanggal_akhir = $request->tanggal_akhir;

            $query = Pemasangan_ban::orderBy('id', 'DESC');

            if ($status == "posting") {
                $query->where('status', $status);
            } else {
                $query->where('status', 'posting');
            }

            if ($tanggal_awal && $tanggal_akhir) {
                $query->whereDate('tanggal_awal', '>=', $tanggal_awal)
                    ->whereDate('tanggal_awal', '<=', $tanggal_akhir);
            }

            $inquery = $query->orderBy('id', 'DESC')->with('detail_ban')->get();


            $pdf = PDF::loadView('admin.laporan_pemasanganban.print', compact('inquery'));
            return $pdf->stream('Laporan_Pemasangan_Ban.pdf');
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }
}
