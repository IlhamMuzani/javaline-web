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


    public function index(Request $request)
    {
        $status = $request->status;
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;

        $penerimaans = Penerimaan_kaskecil::query();
        $pengeluarans = Pengeluaran_kaskecil::query();

        if ($status == "posting") {
            $penerimaans->where('status', $status);
            $pengeluarans->where('status', $status);
        } else {
            $penerimaans->where('status', 'posting');
            $pengeluarans->where('status', 'posting');
        }

        if ($tanggal_awal && $tanggal_akhir) {
            $penerimaans->whereDate('tanggal_awal', '>=', $tanggal_awal)
                ->whereDate('tanggal_awal', '<=', $tanggal_akhir);
            $pengeluarans->whereDate('tanggal_awal', '>=', $tanggal_awal)
                ->whereDate('tanggal_awal', '<=', $tanggal_akhir);
        }

        // Check if there is a search condition
        $hasSearch = $status || ($tanggal_awal && $tanggal_akhir);

        $tanggalAkhir = \Carbon\Carbon::parse($tanggal_awal, 'Asia/Jakarta');
        $tanggal_satu = $tanggalAkhir->startOfMonth();

        $tahun = $tanggal_satu->year;
        $bulan = $tanggal_satu->month;
        if ($bulan == 1) {
            $bulanSebelumnya = 12; // Bulan Desember tahun lalu
            $tahunSebelumnya = $tahun - 1;
        } else {
            $bulanSebelumnya = $bulan - 1;
            $tahunSebelumnya = $tahun;
        }

        $tanggalAwalBulanSebelumnya = \Carbon\Carbon::create($tahunSebelumnya, $bulanSebelumnya, 1);
        $tanggalAkhirBulanSebelumnya = $tanggalAwalBulanSebelumnya->copy()->endOfMonth();
        $sisa_saldo = Saldo::whereBetween('created_at', [$tanggalAwalBulanSebelumnya, $tanggalAkhirBulanSebelumnya])
            ->latest('created_at')
            ->first();
        $sisa_saldo_value = $sisa_saldo ? $sisa_saldo->sisa_saldo : 0;

        // Retrieve the results if search condition is met
        $data = $hasSearch ? $penerimaans->get() : collect();
        $datas = $hasSearch ? $pengeluarans->get() : collect();

        // Calculate the sum of 'nominal' values
        $Penerimaan = $data->sum('nominal');
        $Pengeluaran = $datas->sum('grand_total');

        $hasil = $sisa_saldo_value + $Penerimaan - $Pengeluaran;

        // Pass the results and total nominal to the view
        return view('admin.laporan_saldokaspengeluaran.index', compact('hasil', 'Penerimaan', 'Pengeluaran', 'sisa_saldo_value'));
    }



    // public function index(Request $request)
    // {
    //     $tanggal_akhir = $request->tanggal;

    //     // Validasi tanggal_akhir
    //     if (!$tanggal_akhir) {
    //         return view('admin.laporan_saldokaspengeluaran.index', ['saldos' => null]);
    //     }

    //     // Parse tanggal_akhir with the desired time zone (e.g., 'Asia/Jakarta')
    //     $tanggalAkhir = \Carbon\Carbon::parse($tanggal_akhir, 'Asia/Jakarta');

    //     // Get the first day of the month
    //     $tanggal_awal = $tanggalAkhir->startOfMonth();

    //     // Format the dates for better readability if needed
    //     $tanggal_awal = $tanggal_awal->format('Y-m-d');
    //     $tanggal_akhir = $tanggalAkhir->format('Y-m-d');


    //     // Hitung penerimaan dari tanggal awal sampai tanggal akhir
    //     $penerimaan = Penerimaan_kaskecil::where('status', 'posting')
    //     ->whereBetween('tanggal', [$tanggal_awal, $tanggal_akhir])
    //         ->sum('nominal');

    //     // Debug: Print the result to verify

    //     return $tanggal_awal . ' - ' . $tanggal_akhir . ' : ' . $penerimaan;
    // }



    // public function index(Request $request)
    // {

    //     $tanggal_akhir = $request->tanggal_awal;

    //     // Validasi tanggal_akhir
    //     if (!$tanggal_akhir) {
    //         return view('admin.laporan_saldokaspengeluaran.index', ['saldos' => null]);
    //     }

    //     // Parse tanggal_akhir with the desired time zone (e.g., 'Asia/Jakarta')
    //     $tanggalAkhir = \Carbon\Carbon::parse($tanggal_akhir, 'Asia/Jakarta');

    //     // Get the first day of the month
    //     $tanggal_awal = $tanggalAkhir->startOfMonth();

    //     // Format the dates for better readability if needed
    //     $tanggal_awal = $tanggal_awal->format('Y-m-d');
    //     $tanggal_akhir = $tanggalAkhir->format('Y-m-d');

    //     // Tentukan bulan dan tahun dari tanggal_akhir
    //     $tahun = $tanggalAkhir->year;
    //     $bulan = $tanggalAkhir->month;

    //     // Hitung bulan sebelumnya
    //     if ($bulan == 1) {
    //         $bulanSebelumnya = 12; // Bulan Desember tahun lalu
    //         $tahunSebelumnya = $tahun - 1;
    //     } else {
    //         $bulanSebelumnya = $bulan - 1;
    //         $tahunSebelumnya = $tahun;
    //     }

    //     // Tentukan tanggal awal dan akhir bulan sebelumnya
    //     $tanggalAwalBulanSebelumnya = \Carbon\Carbon::create($tahunSebelumnya, $bulanSebelumnya, 1);
    //     $tanggalAkhirBulanSebelumnya = $tanggalAwalBulanSebelumnya->copy()->endOfMonth();

    //     // Ambil saldo dari bulan sebelumnya
    //     $sisa_saldo = Saldo::whereBetween('tanggal_awal', [$tanggalAwalBulanSebelumnya, $tanggalAkhirBulanSebelumnya])
    //         ->latest('tanggal_awal')
    //         ->first();

    //     $sisa_saldo_value = $sisa_saldo ? $sisa_saldo->sisa_saldo : 0;

    //     // Hitung penerimaan dari tanggal 1 sampai dengan tanggal_akhir
    //     $penerimaan = Penerimaan_kaskecil::where('status', 'posting')
    //     ->whereBetween('tanggal_awal', [$tanggal_awal, $tanggal_akhir])
    //         ->sum('nominal');

    //     return $penerimaan;

    //     $pengeluaran = Pengeluaran_kaskecil::whereBetween('tanggal_awal', [$tanggal_awal, $tanggal_akhir])
    //     ->where('status', 'posting') // Replace 'posting' with the relevant status value
    //     ->sum('grand_total');

    //     // Hitung saldo akhir untuk tanggal yang diberikan
    //     $saldos = $penerimaan;
    //     return view('admin.laporan_saldokaspengeluaran.index', compact('saldos'));
    // }



    // public function index(Request $request)
    // {
    //     $tanggal_awal = $request->tanggal_awal;

    //     // Validate tanggal_awal
    //     if (!$tanggal_awal) {
    //         return view('admin.laporan_saldokaspengeluaran.index', ['saldos' => null]);
    //     }

    //     // Initialize previous day
    //     $previous_day = \Carbon\Carbon::parse($tanggal_awal)->subDay();
    //     $previous_saldo = 0;

    //     // Loop to find a valid saldo
    //     while (true) {
    //         // Get the latest saldo from the current previous day
    //         $previous_saldo_record = Saldo::whereDate('tanggal_awal', $previous_day->format('Y-m-d'))
    //             ->latest('tanggal_awal')
    //             ->first();

    //         if ($previous_saldo_record) {
    //             $previous_saldo = $previous_saldo_record->sisa_saldo;
    //             break; // Exit loop if a record is found
    //         }

    //         // Move to the previous day
    //         $previous_day->subDay();

    //         // Optionally set a limit to avoid infinite loops, for example:
    //         // if ($previous_day->lt('2020-01-01')) break; // Stop at a specific start date
    //     }

    //     // Calculate penerimaan and pengeluaran for the current date
    //     $penerimaan = Penerimaan_kaskecil::whereDate('tanggal_awal', $tanggal_awal)
    //         ->where('status', 'posting') // Ganti 'posted' dengan nilai status yang relevan
    //         ->sum('nominal');

    //     $pengeluaran = Pengeluaran_kaskecil::whereDate('tanggal_awal', $tanggal_awal)
    //         ->where('status', 'posting') // Ganti 'posted' dengan nilai status yang relevan
    //         ->sum('grand_total');

    //     // Calculate saldo
    //     $saldos = $penerimaan - $pengeluaran;

    //     return view('admin.laporan_saldokaspengeluaran.index', compact('saldos'));
    // }



    public function print_saldokas(Request $request)
    {
        // Ambil tanggal yang diminta dari request, jika tidak ada, gunakan tanggal hari ini
        $requested_date = $request->filled('tanggal_awal') ? Carbon::createFromFormat('Y-m-d', $request->tanggal_awal)->endOfDay() : now()->endOfDay();

        // Cari saldo terbaru sebelum atau pada tanggal yang diminta
        $saldo = Saldo::where('tanggal_awal', '<=', $requested_date)->latest()->first();

        // Jika tidak ada saldo untuk tanggal yang diminta, gunakan saldo terbaru secara keseluruhan
        $latest_saldo = Saldo::latest()->first();
        $saldos = $saldo ?: $latest_saldo;

        // Load PDF dengan view dan kirimkan data saldo dan tanggal yang diminta
        $pdf = PDF::loadView('admin.laporan_saldokaspengeluaran.print', compact('saldos', 'requested_date'));
        return $pdf->stream('Laporan_Saldo_Kas.pdf');
    }
}