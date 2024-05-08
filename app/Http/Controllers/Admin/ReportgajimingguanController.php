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

class ReportgajimingguanController extends Controller
{

    public function index(Request $request)
    {
        // Filter data berdasarkan karyawan_id pengguna yang login
        $inquery = Detail_gajikaryawan::get();

        return view('admin.report_slipgajimingguan.index', compact('inquery'));
    }

    public function show($id)
    {

        // Temukan detail gaji karyawan berdasarkan ID yang diberikan
        $cetakpdf = Detail_gajikaryawan::where('id', $id)->first();

        // Pastikan entitas ditemukan
        if (!$cetakpdf) {
            abort(404, 'Detail Gaji tidak ditemukan');
        }
        // Membuat PDF menggunakan view dan mengatur ukuran kertas
        $pdf = PDF::loadView('admin.report_slipgajimingguan.cetak_pdf', compact('cetakpdf'));
        $pdf->setPaper('letter', 'portrait');

        // Kembalikan PDF ke klien dengan nama file yang tepat
        return $pdf->stream($cetakpdf->karyawan->nama_lengkap . ' ' . 'Slip Gaji.pdf');
    }
}
