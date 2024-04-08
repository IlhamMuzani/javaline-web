<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Pembelian_ban;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use App\Models\Detail_pembelianban;
use App\Models\Saldo;
use Carbon\Carbon;

class LaporanSaldokasController extends Controller
{
    public function index(Request $request)
    {
        $requested_date = $request->filled('created_at') ? $request->created_at : now()->format('Y-m-d');
        $requested_datetime = Carbon::createFromFormat('Y-m-d', $requested_date)->endOfDay(); // Jam 23:59:59 pada tanggal yang diminta

        $latest_saldo = Saldo::latest('created_at')->first();
        $saldo = Saldo::where('created_at', '<=', $requested_datetime)->latest('created_at')->first();

        // Jika tidak ada saldo untuk tanggal yang diminta, gunakan saldo terbaru
        $saldos = $saldo ? $saldo : $latest_saldo;

        return view('admin.laporan_saldokas.index', compact('saldos'));
    }

    public function print_saldokas(Request $request)
    {
        // Ambil tanggal yang diminta dari request, jika tidak ada, gunakan tanggal hari ini
        $requested_date = $request->filled('created_at') ? Carbon::createFromFormat('Y-m-d', $request->created_at)->endOfDay() : now()->endOfDay();

        // Cari saldo terbaru sebelum atau pada tanggal yang diminta
        $saldo = Saldo::where('created_at', '<=', $requested_date)->latest()->first();

        // Jika tidak ada saldo untuk tanggal yang diminta, gunakan saldo terbaru secara keseluruhan
        $latest_saldo = Saldo::latest()->first();
        $saldos = $saldo ?: $latest_saldo;

        // Load PDF dengan view dan kirimkan data saldo dan tanggal yang diminta
        $pdf = PDF::loadView('admin.laporan_saldokas.print', compact('saldos', 'requested_date'));
        return $pdf->stream('Laporan_Saldo_Kas.pdf');
    }
}