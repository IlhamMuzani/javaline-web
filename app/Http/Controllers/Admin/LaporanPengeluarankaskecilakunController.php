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

        $inquery = Detail_pengeluaran::orderBy('id', 'DESC');

        if ($status == "posting") {
            $inquery->where('status', $status);
        } else {
            $inquery->where('status', 'posting');
        }

        if ($created_at && $tanggal_akhir) {
            $inquery->whereDate('created_at', '>=', $created_at)
                ->whereDate('created_at', '<=', $tanggal_akhir);

            // Exclude records with memotambahan_id outside the date filter
            $inquery->where(function ($query) use ($created_at, $tanggal_akhir) {
                $query->whereNull('memotambahan_id')
                    ->orWhereHas('memotambahan', function ($q) use ($created_at, $tanggal_akhir) {
                        $q->whereDate('created_at', '>=', $created_at)
                            ->whereDate('created_at', '<=', $tanggal_akhir);
                    });
            });
        }

        if ($barangakun_id) {
            $inquery->where('barangakun_id', $barangakun_id);
        }

        // Kondisi sebelum melakukan pencarian data masih kosong
        $hasSearch = $status || ($created_at && $tanggal_akhir) || $barangakun_id;
        $inquery = $hasSearch ? $inquery->get() : collect();

        return view('admin.laporan_pengeluarankaskecilakun.index', compact('inquery', 'barangakuns'));
    }

    public function print_pengeluarankaskecilakun(Request $request)
    {
        $barangakuns = Barang_akun::all();

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

            // Exclude records with memotambahan_id outside the date filter
            $query->where(function ($query) use ($created_at, $tanggal_akhir) {
                $query->whereNull('memotambahan_id')
                    ->orWhereHas('memotambahan', function ($q) use ($created_at, $tanggal_akhir) {
                        $q->whereDate('created_at', '>=', $created_at)
                            ->whereDate('created_at', '<=', $tanggal_akhir);
                    });
            });
        }

        if ($barangakun_id) {
            $query->where('barangakun_id', $barangakun_id);
        }

        $inquery = $query->get();

        $pdf = PDF::loadView('admin.laporan_pengeluarankaskecilakun.print', compact('inquery', 'barangakuns'));
        return $pdf->stream('Laporan_Pengeluaran_Kas_Kecil.pdf');
    }
}