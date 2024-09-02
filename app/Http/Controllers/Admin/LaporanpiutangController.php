<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Memo_ekspedisi;
use App\Models\Pelanggan;
use App\Models\Penggantian_oli;
use App\Models\Tagihan_ekspedisi;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Features\Placeholder;

class LaporanpiutangController extends Controller
{
    public function index(Request $request)
    {
        $pelanggan_id = $request->input('pelanggan_id');

        // Ambil data pelanggan jika diperlukan
        $pelanggans = Pelanggan::all();

        // Bangun query awal dengan filter status 'selesai'
        $inquery = Tagihan_ekspedisi::whereDoesntHave('detail_tagihan', function ($query) {
            $query->whereHas('faktur_ekspedisi', function ($query) {
                $query->whereNotNull('status_pelunasan');
            });
        })->orWhereHas('detail_tagihan', function ($query) {
            $query->whereHas('faktur_ekspedisi', function ($query) {
                $query->whereNull('status_pelunasan');
            });
        })->get();



        // Kembalikan hasil ke view
        return view('admin.laporan_piutang.index', compact('inquery', 'pelanggans'));
    }


    public function print_tagihanekspedisi(Request $request)
    {
        // if (auth()->check() && auth()->user()->menu['laporan penggantian oli']) {

        $status = $request->status;
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;

        $query = Tagihan_ekspedisi::orderBy('id', 'DESC');


        if (
            $status == "posting" || $status == "selesai"
        ) {
            $query->where('status', $status);
        } else {
            $query->whereIn('status', ['posting', 'selesai']);
        }

        if ($tanggal_awal && $tanggal_akhir) {
            $query->whereDate('tanggal_awal', '>=', $tanggal_awal)
                ->whereDate('tanggal_awal', '<=', $tanggal_akhir);
        }
        $inquery = $query->orderBy('id', 'DESC')->get();

        $pdf = PDF::loadView('admin.laporan_piutang.print', compact('inquery'));
        return $pdf->stream('Laporan_piutang.pdf');
        // } else {
        //     // tidak memiliki akses
        //     return back()->with('error', array('Anda tidak memiliki akses'));
        // }
    }
}