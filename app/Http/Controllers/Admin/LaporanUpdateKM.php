<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Pembelian_ban;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use App\Models\Detail_pembelianban;
use App\Models\Kendaraan;

class LaporanUpdateKM extends Controller
{
    public function index(Request $request)
    {
        if (auth()->check() && auth()->user()->menu['laporan update km']) {

            $status_post = $request->status_post;
            $tanggal_awal = $request->tanggal_awal;
            $tanggal_akhir = $request->tanggal_akhir;

            $inquery = Kendaraan::orderBy('tanggal', 'DESC');

            if ($status_post == "posting") {
                $inquery->where('status_post', $status_post);
            } else {
                $inquery->where('status_post', 'posting');
            }

            if ($tanggal_awal && $tanggal_akhir) {
                $inquery->whereDate('tanggal', '>=', $tanggal_awal)
                    ->whereDate('tanggal', '<=', $tanggal_akhir);
            }

            // $inquery = $inquery->get();

            // kondisi sebelum melakukan pencarian data masih kosong
            $hasSearch = $status_post || ($tanggal_awal && $tanggal_akhir);
            $inquery = $hasSearch ? $inquery->get() : collect();

            return view('admin.laporan_updatekm.index', compact('inquery'));
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }
    public function print_updatekm(Request $request)
    {
        if (auth()->check() && auth()->user()->menu['laporan update km']) {

            $query = Kendaraan::query();

            $status_post = $request->status_post;
            $tanggal_awal = $request->input('tanggal_awal');
            $tanggal_akhir = $request->input('tanggal_akhir');

            if ($status_post == "posting") {
                $query->where('status_post', $status_post);
            } else {
                $query->where('status_post', 'posting');
            }

            if ($tanggal_awal && $tanggal_akhir) {
                $query->whereDate('tanggal', '>=', $tanggal_awal)
                    ->whereDate('tanggal', '<=', $tanggal_akhir);
            } elseif ($tanggal_awal) {
                $query->whereDate('tanggal', '>=', $tanggal_awal);
            }

            $inquery = $query->orderBy('id', 'DESC')->get();

            $pdf = Pdf::loadview('admin.laporan_updatekm.print', compact('inquery'));
            return $pdf->stream('Laporan Update KM');
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }
}
