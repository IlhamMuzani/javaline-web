<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Pembelian_ban;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use App\Models\Detail_pembelianban;
use App\Models\Saldo;
use App\Models\Total_asuransi;

class LaporanSaldoasuransiController extends Controller
{
    public function index(Request $request)
    {
        // if (auth()->check() && auth()->user()->menu['laporan penerimaan kas kecil']) {

        $inquery = Total_asuransi::latest()->first();

        return view('admin.laporan_saldoasuransi.index', compact('inquery'));
        // } else {
        //     tidak memiliki akses
        //     return back()->with('error', array('Anda tidak memiliki akses'));
        // }
    }

    public function print_saldoasuransi(Request $request)
    {
        // if (auth()->check() && auth()->user()->menu['laporan penerimaan kas kecil']) {

        $inquery = Total_asuransi::latest()->first();

        $pdf = PDF::loadView('admin.laporan_saldoasuransi.print', compact('inquery'));
        return $pdf->stream('Laporan_Saldo_Asuransi.pdf');
        // } else {
        //     // tidak memiliki akses
        //     return back()->with('error', array('Anda tidak memiliki akses'));
        // }
    }
}