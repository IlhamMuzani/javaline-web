<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use App\Models\Total_kasbon;
use App\Models\Total_ujs;

class LaporansaldoKasbonController extends Controller
{
    public function index(Request $request)
    {
        // if (auth()->check() && auth()->user()->menu['laporan penerimaan kas kecil']) {

        $inquery = Total_kasbon::latest()->first();

        return view('admin.laporan_saldokasbon.index', compact('inquery'));
        // } else {
        //     tidak memiliki akses
        //     return back()->with('error', array('Anda tidak memiliki akses'));
        // }
    }

    public function print_saldokasbon(Request $request)
    {
        // if (auth()->check() && auth()->user()->menu['laporan penerimaan kas kecil']) {

        $inquery = Total_kasbon::latest()->first();

        $pdf = PDF::loadView('admin.laporan_saldokasbon.print', compact('inquery'));
        return $pdf->stream('Laporan_Saldo_UJS.pdf');
        // } else {
        //     // tidak memiliki akses
        //     return back()->with('error', array('Anda tidak memiliki akses'));
        // }
    }
}