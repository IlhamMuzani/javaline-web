<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Pembelian_ban;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use App\Models\Bukti_potongpajak;
use App\Models\Detail_pembelianban;
use App\Models\Pelanggan;
use App\Models\Penerimaan_kaskecil;
use App\Models\Tagihan_ekspedisi;

class LaporanBuktipotongpajakglobalController extends Controller
{
    public function index(Request $request)
    {
        $status_terpakai = $request->input('status_terpakai');
        $tanggal_awal = $request->input('tanggal_awal');
        $tanggal_akhir = $request->input('tanggal_akhir');
        $pelanggan_id = $request->input('pelanggan_id');

        $pelanggans = Pelanggan::whereHas('tagihan_ekspedisi', function ($query) {
            $query->where('kategori', 'PPH');
        })->get();

        $inquery = Tagihan_ekspedisi::orderBy('id', 'DESC');

        if ($status_terpakai) {
            $inquery->where('status_terpakai', $status_terpakai);
        }

        if ($tanggal_awal && $tanggal_akhir) {
            $inquery->whereDate('tanggal_awal', '>=', $tanggal_awal)
                ->whereDate('tanggal_awal', '<=', $tanggal_akhir);
        }

        if ($pelanggan_id) {
            $inquery->where('pelanggan_id', $pelanggan_id);
        }

        $inquery->whereIn('status', ['posting', 'elesai'])
            ->where('kategori', 'PPH');

        $hasSearch = $status_terpakai || ($tanggal_awal && $tanggal_akhir) || $pelanggan_id;
        $inquery = $hasSearch ? $inquery->get() : collect();

        return view('admin.laporan_buktipotongpajakglobal.index', compact('inquery', 'pelanggans'));
    }


    public function print_buktipotongpajakglobal(Request $request)
    {
        // if (auth()->check() && auth()->user()->menu['laporan penggantian oli']) {

        $status_terpakai = $request->status_terpakai;
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;
        $pelanggan_id = $request->pelanggan_id;

        $query = Tagihan_ekspedisi::orderBy('id', 'DESC');

        if ($status_terpakai == "digunakan") {
            $query->where('status_terpakai', $status_terpakai);
        } else {
            $query->where('status_terpakai', null);
        }

        if ($tanggal_awal && $tanggal_akhir) {
            $query->whereDate('tanggal_awal', '>=', $tanggal_awal)
                ->whereDate('tanggal_awal', '<=', $tanggal_akhir);
        }

        if ($pelanggan_id) {
            $query->where('pelanggan_id', $pelanggan_id);
        }

        $inquery = $query->orderBy('id', 'DESC')->get();

        $pdf = PDF::loadView('admin.laporan_buktipotongpajakglobal.print', compact('inquery'));
        return $pdf->stream('Laporan_bukti_potong_pajak.pdf');
    }
}
