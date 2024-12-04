<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Absen;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanabsenController extends Controller

{
    public function index(Request $request)
    {

        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;
        $karyawan_id = $request->input('karyawan_id');

        $karyawans = Karyawan::select(
            'id',
            'kode_karyawan',
            'nama_lengkap'
        )
            ->whereIn('departemen_id', [1, 4, 5])
            ->orderBy('nama_lengkap')
            ->get();

        $inquery = Absen::orderBy('id', 'DESC');


        if ($tanggal_awal && $tanggal_akhir) {
            $inquery->whereDate('tanggal_awal', '>=', $tanggal_awal)
                ->whereDate('tanggal_awal', '<=', $tanggal_akhir);
        }
        if ($karyawan_id) {
            $inquery->where('karyawan_id', $karyawan_id);
        }

        $hasSearch = ($tanggal_awal && $tanggal_akhir) || $karyawan_id;
        $inquery = $hasSearch ? $inquery->get() : collect();

        return view('admin.laporan_absen.index', compact('inquery', 'karyawans'));
    }


    public function print_absen(Request $request)
    {

        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;
        $karyawan_id_input = $request->input('karyawan_id'); // Mengganti nama variabel agar tidak terjadi konflik
        // Mengambil karyawan berdasarkan karyawan_id_input (optional)
        $query = Absen::orderBy('id', 'DESC');

        if ($karyawan_id_input) {
            $query->where('karyawan_id', $karyawan_id_input);
        }

        // Filter berdasarkan tanggal
        if ($tanggal_awal && $tanggal_akhir) {
            $query->whereDate('tanggal_awal', '>=', $tanggal_awal)
                ->whereDate('tanggal_awal', '<=', $tanggal_akhir);
        }

        // Menjalankan query dan mengambil hasilnya
        $inquery = $query->get();

        $pdf = PDF::loadView('admin.laporan_absen.print', compact('inquery'));
        return $pdf->stream('Laporan_absen.pdf');
    }
}