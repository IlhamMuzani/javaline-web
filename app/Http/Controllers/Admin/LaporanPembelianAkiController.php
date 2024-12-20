<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Pembelian_aki;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use App\Models\Detail_pembelianban;
use Carbon\Carbon;

class LaporanPembelianAkiController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->check() && auth()->user()->menu['laporan pembelian ban']) {

            $status = $request->status;
            $tanggal_awal = $request->tanggal_awal;
            $tanggal_akhir = $request->tanggal_akhir;

            $inquery = Pembelian_aki::query();

            if ($status) {
                $inquery->where('status', $status);
            }

            if ($tanggal_awal && $tanggal_akhir) {
                $inquery->whereBetween('tanggal_awal', [$tanggal_awal, $tanggal_akhir]);
            } elseif ($tanggal_awal) {
                $inquery->where('tanggal_awal', '>=', $tanggal_awal);
            } elseif ($tanggal_akhir) {
                $inquery->where('tanggal_awal', '<=', $tanggal_akhir);
            } else {
                // Jika tidak ada filter tanggal hari ini
                $inquery->whereDate('tanggal_awal', Carbon::today());
            }

            $inquery->orderBy('id', 'DESC');
            $inquery = $inquery->get();


            return view('admin.laporan_pembelianaki.index', compact('inquery'));
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }

    public function print_aki(Request $request)
    {
        if (auth()->check() && auth()->user()->menu['laporan pembelian ban']) {

            $status = $request->status;
            $tanggal_awal = $request->tanggal_awal;
            $tanggal_akhir = $request->tanggal_akhir;

            $query = Pembelian_aki::orderBy('id', 'DESC');

            if ($status == "posting") {
                $query->where('status', $status);
            } else {
                $query->where('status', 'posting');
            }

            if ($tanggal_awal && $tanggal_akhir) {
                $query->whereDate('tanggal_awal', '>=', $tanggal_awal)
                    ->whereDate('tanggal_awal', '<=', $tanggal_akhir);
            }

            $inquery = $query->orderBy('id', 'DESC')->with('aki')->get();

            $pdf = PDF::loadView('admin.laporan_pembelianaki.print', compact('inquery'));
            return $pdf->stream('Laporan_Pembelian_Aki.pdf');
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }
}
