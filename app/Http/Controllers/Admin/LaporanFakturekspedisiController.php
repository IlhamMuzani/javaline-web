<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Faktur_ekspedisi;
use App\Models\Karyawan;
use App\Models\Memo_ekspedisi;
use App\Models\Pelanggan;
use App\Models\Penggantian_oli;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanFakturekspedisiController extends Controller

{
    public function index(Request $request)
    {
        $kategoris = $request->kategoris;
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;
        $pelanggan_id = $request->input('pelanggan_id');
        $karyawan_id = $request->input('karyawan_id');

        $pelanggans = Pelanggan::get();
        $karyawans = Karyawan::select('id', 'kode_karyawan', 'nama_lengkap')
            ->where('departemen_id', '4')
            ->orderBy('nama_lengkap')
            ->get();

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
        // if ($status_pelunasan == null || $status_pelunasan == "aktif") {
        //     $inquery->where('status_pelunasan', $status_pelunasan);
        // } else {
        //     $inquery->whereIn('status_pelunasan', [null, 'aktif']);
        // }

        if ($tanggal_awal && $tanggal_akhir) {
            $inquery->whereDate('tanggal_awal', '>=', $tanggal_awal)
                ->whereDate('tanggal_awal', '<=', $tanggal_akhir);
        }

        if ($pelanggan_id) {
            $inquery->where('pelanggan_id', $pelanggan_id);
        }

        if ($karyawan_id) {
            $inquery->where('karyawan_id', $karyawan_id);
        }
        $inquery = $inquery->get();
        // $hasSearch = $status_pelunasan || ($tanggal_awal && $tanggal_akhir);
        $hasSearch = ($tanggal_awal && $tanggal_akhir) || $pelanggan_id || $karyawan_id;
        $inquery = $hasSearch ? $inquery : collect();

        return view('admin.laporan_fakturekspedisi.index', compact('inquery', 'pelanggans', 'karyawans'));
    }

    public function print_fakturekspedisi(Request $request)
    {
        // Mengambil parameter dari request
        $kategoris = $request->kategoris;
        $status_pelunasan = $request->status_pelunasan;
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;
        $pelanggan_id = $request->input('pelanggan_id');
        $karyawan_id = $request->input('karyawan_id');

        $pelanggans = Pelanggan::where('id', $pelanggan_id)->first();
        $karyawan_id = Karyawan::where('id', $karyawan_id)->first();
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

        // // Menerapkan filter berdasarkan status_pelunasan
        // if ($status_pelunasan == null || $status_pelunasan == "aktif") {
        //     $query->where('status_pelunasan', $status_pelunasan);
        // } else {
        //     $query->whereIn('status_pelunasan', [null, 'aktif']);
        // }

        if ($pelanggan_id) {
            $query->where('pelanggan_id', $pelanggan_id);
        }

        if ($karyawan_id) {
            $query->where('karyawan_id', $karyawan_id);
        }


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