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
    // public function index(Request $request)
    // {
    //     $barangakuns = Barang_akun::all();

    //     $status = $request->status;
    //     $created_at = $request->created_at;
    //     $tanggal_akhir = $request->tanggal_akhir;
    //     $akun = $request->barangakun_id; // New variable to store barangakun_id

    //     $inquery = Detail_pengeluaran::orderBy('id', 'DESC');

    //     if ($status == "posting") {
    //         $inquery->where('status', $status);
    //     } else {
    //         $inquery->where('status', 'posting');
    //     }

    //     if ($created_at && $tanggal_akhir) {
    //         $inquery->whereDate('created_at', '>=', $created_at)
    //             ->whereDate('created_at', '<=', $tanggal_akhir);
    //     }

    //     // Additional condition for barangakun_id
    //     if ($akun) {
    //         $inquery->where('barangakun_id', $akun);
    //     }

    //     // $inquery = $inquery->get();

    //     // kondisi sebelum melakukan pencarian data masih kosong
    //     $hasSearch = $status || ($created_at && $tanggal_akhir) || $akun;
    //     $inquery = $hasSearch ? $inquery->get() : collect();

    //     return view('admin.laporan_pengeluarankaskecilakun.index', compact('inquery', 'barangakuns'));
    // }

    public function index(Request $request)
    {
        // if (auth()->check() && auth()->user()->menu['laporan penerimaan kas kecil']) {
        $barangakuns = Barang_akun::all();

        $status = $request->status;
        $created_at = $request->created_at;
        $tanggal_akhir = $request->tanggal_akhir;

        // $akun = $request->barangakun_id;
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

        // $inquery = $inquery->get();

        // kondisi sebelum melakukan pencarian data masih kosong
        $hasSearch = $status || ($created_at && $tanggal_akhir);
        $inquery = $hasSearch ? $inquery->get() : collect();

        return view('admin.laporan_pengeluarankaskecilakun.index', compact('inquery', 'barangakuns'));
        // } else {
        //     tidak memiliki akses
        //     return back()->with('error', array('Anda tidak memiliki akses'));
        // }
    }

    public function print_pengeluarankaskecilakun(Request $request)
    {
        // Ambil semua detail pengeluaran
        $detail_pengeluaran = Detail_pengeluaran::with('barangAkun')->get();

        // Inisialisasi array kosong untuk menyimpan barangakun yang unik
        $barangakuns = [];

        // Loop melalui setiap detail pengeluaran
        foreach ($detail_pengeluaran as $detail) {
            // Jika barangakun belum ada dalam array, tambahkan
            if (!in_array($detail->barangAkun, $barangakuns)) {
                $barangakuns[] = $detail->barangAkun;
            }
        }

        // Urutkan daftar barang akun berdasarkan nama barang akun dalam urutan abjad
        $barangakuns = collect($barangakuns)->sortBy('nama_barangakun')->values()->all();

        // Sekarang $barangakuns berisi daftar barangakun yang unik dari detail pengeluaran, diurutkan berdasarkan nama barang akun

        $status = $request->status;
        $created_at = $request->created_at;
        $tanggal_akhir = $request->tanggal_akhir;

        $query = Detail_pengeluaran::orderBy('id', 'DESC');

        if ($status == "posting") {
            $query->where('status', $status);
        } else {
            $query->where('status', 'posting');
        }

        if (
            $created_at && $tanggal_akhir
        ) {
            $query->whereDate('created_at', '>=', $created_at)
                ->whereDate('created_at', '<=', $tanggal_akhir);
        }

        $inquery = $query->orderBy('id', 'DESC')->get();

        $pdf = PDF::loadView('admin.laporan_pengeluarankaskecilakun.print', compact('inquery', 'barangakuns'));
        return $pdf->stream('Laporan_Pengeluaran_Kas_Kecil.pdf');
    }
}
