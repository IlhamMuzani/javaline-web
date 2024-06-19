<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Pembelian_ban;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use App\Models\Bukti_potongpajak;
use App\Models\Detail_pembelianban;
use App\Models\Penerimaan_kaskecil;
use App\Models\Tagihan_ekspedisi;

class LaporanBuktipotongpajakglobalController extends Controller
{
    public function index(Request $request)
    {
        $status_terpakai = $request->status_terpakai;
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;

        $inquery = Tagihan_ekspedisi::orderBy('id', 'DESC');

        // Filter berdasarkan status terpakai
        if ($status_terpakai == "digunakan") {
            $inquery->where('status_terpakai', $status_terpakai);
        } else {
            $inquery->where('status_terpakai', null);
        }

        // Filter berdasarkan tanggal
        if ($tanggal_awal && $tanggal_akhir) {
            $inquery->whereDate('tanggal_awal', '>=', $tanggal_awal)
                ->whereDate('tanggal_awal', '<=', $tanggal_akhir);
        }

        // Filter berdasarkan status yang diinginkan (posting atau selesai)
        $inquery->whereIn('status', ['posting', 'selesai']);
        $inquery->where('kategori', 'PPH');

        // Kondisi sebelum melakukan pencarian data masih kosong
        $hasSearch = $status_terpakai || ($tanggal_awal && $tanggal_akhir);
        $inquery = $hasSearch ? $inquery->get() : collect();

        return view('admin.laporan_buktipotongpajakglobal.index', compact('inquery'));
    }


    public function print_buktipotongpajakglobal(Request $request)
    {
        // if (auth()->check() && auth()->user()->menu['laporan penggantian oli']) {

        $status_terpakai = $request->status_terpakai;
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;

        $query = Tagihan_ekspedisi::orderBy('id', 'DESC');


        if ($status_terpakai == "digunakan") {
            $query->where(
                'status_terpakai',
                $status_terpakai
            );
        } else {
            $query->where('status_terpakai', null);
        }


        if ($tanggal_awal && $tanggal_akhir) {
            $query->whereDate('tanggal_awal', '>=', $tanggal_awal)
                ->whereDate('tanggal_awal', '<=', $tanggal_akhir);
        }
        $inquery = $query->orderBy('id', 'DESC')->get();

        $pdf = PDF::loadView('admin.laporan_buktipotongpajakglobal.print', compact('inquery'));
        return $pdf->stream('Laporan_bukti_potong_pajak.pdf');
    }
}