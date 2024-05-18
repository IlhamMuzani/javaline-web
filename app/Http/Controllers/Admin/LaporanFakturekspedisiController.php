<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Faktur_ekspedisi;
use App\Models\Memo_ekspedisi;
use App\Models\Penggantian_oli;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanFakturekspedisiController extends Controller

{
    public function index(Request $request)
    {
        // Mengambil parameter dari request
        $kategoris = $request->kategoris;
        $status_pelunasan = $request->status_pelunasan;
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;

        // Membuat query untuk model Faktur_ekspedisi yang diurutkan berdasarkan id secara ascending (ASC)
        $inquery = Faktur_ekspedisi::orderBy('id', 'ASC')
            ->whereIn('status', ['posting', 'selesai']);

        if ($kategoris) {
            if ($kategoris == 'memo') {
                $inquery->where('kategoris', 'memo');
            } elseif ($kategoris == 'non memo') {
                $inquery->where('kategoris', 'non memo');
            }
        }

        // Menerapkan filter berdasarkan status_pelunasan
        if ($status_pelunasan == null || $status_pelunasan == "aktif") {
            $inquery->where('status_pelunasan', $status_pelunasan);
        } else {
            $inquery->whereIn('status_pelunasan', [null, 'aktif']);
        }

        // Menerapkan filter berdasarkan rentang tanggal
        if ($tanggal_awal && $tanggal_akhir) {
            $inquery->whereDate('tanggal_awal', '>=', $tanggal_awal)
                ->whereDate('tanggal_awal', '<=', $tanggal_akhir);
        }

        // Melakukan eksekusi query dan menyimpan hasilnya dalam variabel $inquery
        $inquery = $inquery->get();

        // Mengecek apakah telah dilakukan pencarian
        $hasSearch = $status_pelunasan || ($tanggal_awal && $tanggal_akhir);

        // Jika telah dilakukan pencarian, simpan hasil query. Jika tidak, variabel $inquery diisi dengan koleksi kosong.
        $inquery = $hasSearch ? $inquery : collect();

        // Mengembalikan view 'admin.laporan_fakturekspedisi.index' dengan menyertakan data hasil query
        return view('admin.laporan_fakturekspedisi.index', compact('inquery'));
    }

    public function print_fakturekspedisi(Request $request)
    {
        // Mengambil parameter dari request
        $kategoris = $request->kategoris;
        $status_pelunasan = $request->status_pelunasan;
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;

        // Membuat query untuk model Faktur_ekspedisi yang diurutkan berdasarkan id secara descending
        $query = Faktur_ekspedisi::orderBy(
            'id',
            'ASC'
        )
            ->whereIn('status', ['posting', 'selesai']);

        if ($kategoris) {
            if ($kategoris == 'memo') {
                $query->where('kategoris', 'memo');
            } elseif ($kategoris == 'non memo') {
                $query->where('kategoris', 'non memo');
            }
        }

        // Menerapkan filter berdasarkan status_pelunasan
        if ($status_pelunasan == null || $status_pelunasan == "aktif") {
            $query->where('status_pelunasan', $status_pelunasan);
        } else {
            $query->whereIn('status_pelunasan', [null, 'aktif']);
        }

        // Menerapkan filter berdasarkan rentang tanggal
        if ($tanggal_awal && $tanggal_akhir) {
            $query->whereDate('tanggal_awal', '>=', $tanggal_awal)
                ->whereDate('tanggal_awal', '<=', $tanggal_akhir);
        }

        // Menjalankan query dan mengambil hasilnya
        $inquery = $query->get();

        // Membuat laporan PDF menggunakan data hasil query
        $pdf = PDF::loadView('admin.laporan_fakturekspedisi.print', compact('inquery'));

        // Mengembalikan laporan PDF sebagai respons stream
        return $pdf->stream('Laporan_Faktur_Ekspedisi.pdf');
    }
}