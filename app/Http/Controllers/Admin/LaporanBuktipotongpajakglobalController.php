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
        $status = $request->input('status');
        $status_terpakai = $request->input('status_terpakai');
        $tanggal_awal = $request->input('tanggal_awal');
        $tanggal_akhir = $request->input('tanggal_akhir');
        $pelanggan_id = $request->input('pelanggan_id');

        $pelanggans = Pelanggan::whereHas('tagihan_ekspedisi', function ($query) {
            $query->where('kategori', 'PPH');
        })->get();

        $inquery = Tagihan_ekspedisi::whereNotIn('status', ['unpost'])->orderBy('id', 'DESC');

        if ($status) {
            $inquery->where('status', $status);
        }

        if ($status_terpakai) {
            $inquery->where('status_terpakai', $status_terpakai);
        } else {
            $inquery->whereNull('status_terpakai');
        }

        if ($tanggal_awal && $tanggal_akhir) {
            $inquery->whereDate('tanggal_awal', '>=', $tanggal_awal)
                ->whereDate('tanggal_awal', '<=', $tanggal_akhir);
        }

        if ($pelanggan_id) {
            $inquery->where('pelanggan_id', $pelanggan_id);
        }

        $inquery->where(['kategori' => 'PPH']);

        $hasSearch = $status || $status_terpakai || ($tanggal_awal && $tanggal_akhir) || $pelanggan_id;
        $inquery = $hasSearch ? $inquery->get() : collect();

        return view('admin.laporan_buktipotongpajakglobal.index', compact('inquery', 'pelanggans'));
    }


    public function print_buktipotongpajakglobal(Request $request)
    {
        $status = $request->input('status');
        $status_terpakai = $request->input('status_terpakai');
        $tanggal_awal = $request->input('tanggal_awal');
        $tanggal_akhir = $request->input('tanggal_akhir');
        $pelanggan_id = $request->input('pelanggan_id');
        
        $pelanggans = Pelanggan::where('id', $pelanggan_id)->first();
        $query = Tagihan_ekspedisi::whereNotIn('status', ['unpost'])->orderBy('id', 'DESC');

        if ($status) {
            $query->where('status', $status);
        }

        if ($status_terpakai) {
            $query->where('status_terpakai', $status_terpakai);
        } else {
            $query->whereNull('status_terpakai');
        }

        if ($tanggal_awal && $tanggal_akhir) {
            $query->whereDate('tanggal_awal', '>=', $tanggal_awal)
                ->whereDate('tanggal_awal', '<=', $tanggal_akhir);
        }

        if ($pelanggan_id) {
            $query->where('pelanggan_id', $pelanggan_id);
        }

        $query->where(['kategori' => 'PPH'])->orderBy('id', 'DESC');

        $inquery = $query->get();

        $pdf = PDF::loadView('admin.laporan_buktipotongpajakglobal.print', compact('inquery', 'pelanggans'));
        return $pdf->stream('Laporan_bukti_potong_pajak.pdf');
    }
}