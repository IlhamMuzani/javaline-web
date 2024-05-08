<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Pembelian_ban;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use App\Models\Detail_gajikaryawan;
use App\Models\Detail_pembelianban;
use App\Models\Perhot;
use App\Models\Perhitungan_gajikaryawan;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Auth;

class ReportgajibulananController extends Controller
{

    public function index(Request $request)
    {
        // Dapatkan pengguna yang sedang login
        $user = Auth::user();

        // Pastikan pengguna memiliki karyawan_id yang terkait
        if (!$user->karyawan_id) {
            abort(404, 'Tidak ditemukan karyawan terkait');
        }

        // Filter data berdasarkan karyawan_id pengguna yang login
        $inquery = Detail_gajikaryawan::where('karyawan_id', $user->karyawan_id)->get();

        return view('admin.report_slipgajibulanan.index', compact('inquery'));
    }

    public function show($id)
    {
        // Dapatkan pengguna yang sedang login
        $user = Auth::user();

        // Temukan detail gaji karyawan berdasarkan ID yang diberikan
        $cetakpdf = Detail_gajikaryawan::where('id', $id)->first();

        // Pastikan entitas ditemukan
        if (!$cetakpdf) {
            abort(404, 'Detail Gaji tidak ditemukan');
        }

        // Pastikan karyawan_id pada detail_gajikaryawan cocok dengan karyawan_id pengguna yang login
        if ($cetakpdf->karyawan_id !== $user->karyawan_id) {
            abort(403, 'Anda tidak memiliki izin untuk mengakses slip gaji ini');
        }

        // Membuat PDF menggunakan view dan mengatur ukuran kertas
        $pdf = PDF::loadView('admin.report_slipgajibulanan.cetak_pdf', compact('cetakpdf'));
        $pdf->setPaper('letter', 'portrait');

        // Kembalikan PDF ke klien dengan nama file yang tepat
        return $pdf->stream($cetakpdf->karyawan->nama_lengkap . ' ' . 'Slip Gaji.pdf');
    }

}