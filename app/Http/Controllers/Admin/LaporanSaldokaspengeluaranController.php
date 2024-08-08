<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Pembelian_ban;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use App\Models\Detail_pembelianban;
use App\Models\Penerimaan_kaskecil;
use App\Models\Pengeluaran_kaskecil;
use App\Models\Saldo;
use Carbon\Carbon;

class LaporanSaldokaspengeluaranController extends Controller
{
    // public function index(Request $request)
    // {
    //     $tanggal_awal = $request->tanggal_awal;

    //     // Validasi tanggal_awal
    //     if (!$tanggal_awal) {
    //         return view('admin.laporan_saldokaspengeluaran.index', ['saldos' => null]);
    //     }

    //     $sisa_saldo = Saldo::whereDate('created_at', '<=', $tanggal_awal)
    //         ->latest('created_at')
    //         ->first();

    //     $sisa_saldo_value = $sisa_saldo ? $sisa_saldo->sisa_saldo : 0;

    //     $penerimaan = Penerimaan_kaskecil::whereDate('tanggal_awal', $tanggal_awal)
    //         ->sum('nominal');

    //     $pengeluaran = Pengeluaran_kaskecil::whereDate('tanggal_awal', $tanggal_awal)
    //         ->where('status', 'posting') // Ganti 'posted' dengan nilai status yang relevan
    //         ->sum('grand_total');

    //     // Hitung saldo akhir untuk tanggal yang diberikan
    //     $saldos = $sisa_saldo_value - $pengeluaran;

    //     return view('admin.laporan_saldokaspengeluaran.index', compact('saldos'));
    // }


    public function index(Request $request)
    {
        $tanggal_awal = $request->tanggal_awal;

        // Validate tanggal_awal
        if (!$tanggal_awal) {
            return view('admin.laporan_saldokaspengeluaran.index', ['saldos' => null]);
        }

        // Initialize previous day
        $previous_day = \Carbon\Carbon::parse($tanggal_awal)->subDay();
        $previous_saldo = 0;

        // Loop to find a valid saldo
        while (true) {
            // Get the latest saldo from the current previous day
            $previous_saldo_record = Saldo::whereDate('created_at', $previous_day->format('Y-m-d'))
                ->latest('created_at')
                ->first();

            if ($previous_saldo_record) {
                $previous_saldo = $previous_saldo_record->sisa_saldo;
                break; // Exit loop if a record is found
            }

            // Move to the previous day
            $previous_day->subDay();

            // Optionally set a limit to avoid infinite loops, for example:
            // if ($previous_day->lt('2020-01-01')) break; // Stop at a specific start date
        }

        // Calculate penerimaan and pengeluaran for the current date
        $penerimaan = Penerimaan_kaskecil::whereDate('tanggal_awal', $tanggal_awal)
            ->where('status', 'posting') // Ganti 'posted' dengan nilai status yang relevan
            ->sum('nominal');

        $pengeluaran = Pengeluaran_kaskecil::whereDate('tanggal_awal', $tanggal_awal)
            ->where('status', 'posting') // Ganti 'posted' dengan nilai status yang relevan
            ->sum('grand_total');

        // Calculate saldo
        $saldos = $penerimaan - $pengeluaran;

        return view('admin.laporan_saldokaspengeluaran.index', compact('saldos'));
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
        $pdf = PDF::loadView('admin.laporan_saldokaspengeluaran.print', compact('saldos', 'requested_date'));
        return $pdf->stream('Laporan_Saldo_Kas.pdf');
    }
}