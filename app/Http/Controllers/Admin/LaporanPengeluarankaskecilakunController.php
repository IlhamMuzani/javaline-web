<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Pembelian_ban;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use App\Models\Barang_akun;
use App\Models\Detail_pembelianban;
use App\Models\Detail_pengeluaran;
use App\Models\Pengeluaran_kaskecil;

class LaporanPengeluarankaskecilakunController extends Controller
{
    public function index(Request $request)
    {
        $barangakuns = Barang_akun::all();

        $status = $request->status;
        $created_at = $request->created_at;
        $tanggal_akhir = $request->tanggal_akhir;
        $barangakun_id = $request->barangakun_id; // Tambahkan ini

        $add_at = $request->add_at;
        $end_at = $request->end_at;

        $inquery = Detail_pengeluaran::orderBy('id', 'DESC');

        if ($status == "posting") {
            $inquery->where('status', $status);
        } else {
            $inquery->where('status', 'posting');
        }

        if ($created_at && $tanggal_akhir) {
            $inquery->whereDate('created_at', '>=', $created_at)
                ->whereDate('created_at', '<=', $tanggal_akhir);
        }

        // Filter berdasarkan waktu pembuatan (created_at dan end_at)
        if ($add_at && $end_at) {
            $inquery->where('created_at', '>=', $add_at)
                ->where('created_at', '<=', $end_at);
        }

        // Tambahkan kondisi untuk memfilter berdasarkan barangakun_id jika ada
        if ($barangakun_id) {
            $inquery->where('barangakun_id', $barangakun_id);
        }

        // Kondisi sebelum melakukan pencarian data masih kosong
        $hasSearch = $status || ($created_at && $tanggal_akhir) || $barangakun_id
            || ($add_at && $end_at);
        $inquery = $hasSearch ? $inquery->get() : collect();

        return view('admin.laporan_pengeluarankaskecilakun.index', compact('inquery', 'barangakuns'));
    }


    public function print_pengeluarankaskecilakun(Request $request)
    {
        $detail_pengeluaran = Detail_pengeluaran::with('barangAkun')->get();

        $barangakuns = [];
        foreach ($detail_pengeluaran as $detail) {
            if (!in_array($detail->barangAkun, $barangakuns)) {
                $barangakuns[] = $detail->barangAkun;
            }
        }
        $barangakuns = collect($barangakuns)->sortBy('nama_barangakun')->values()->all();

        $status = $request->status;
        $created_at = $request->created_at;
        $tanggal_akhir = $request->tanggal_akhir;
        $barangakun_id = $request->barangakun_id; // Tambahkan ini

        $query = Detail_pengeluaran::orderBy('id', 'DESC');

        if ($status == "posting") {
            $query->where('status', $status);
        } else {
            $query->where('status', 'posting');
        }

        if ($created_at && $tanggal_akhir) {
            $query->whereDate('created_at', '>=', $created_at)
                ->whereDate('created_at', '<=', $tanggal_akhir);
        }

        // Tambahkan kondisi untuk memfilter berdasarkan barangakun_id jika ada
        if ($barangakun_id) {
            $query->where('barangakun_id', $barangakun_id);
        }

        $inquery = $query->orderBy('id', 'DESC')->get();

        $pdf = PDF::loadView('admin.laporan_pengeluarankaskecilakun.print', compact('inquery', 'barangakuns'));
        return $pdf->stream('Laporan_Pengeluaran_Kas_Kecil.pdf');
    }
}