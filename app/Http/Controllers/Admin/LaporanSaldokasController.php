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

class LaporanSaldokasController extends Controller
{

    public function index(Request $request)
    {
        // Ambil status dari request, atau set default 'posting' jika tidak ada
        $status = $request->status ?? 'posting';
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;

        // Set default values for dates if not provided
        if (!$tanggal_awal) {
            $tanggal_awal = \Carbon\Carbon::now()->startOfMonth()->format('Y-m-d');
        }
        if (!$tanggal_akhir) {
            $tanggal_akhir = \Carbon\Carbon::now()->format('Y-m-d');
        }

        $penerimaans = Penerimaan_kaskecil::query();
        $pengeluarans = Pengeluaran_kaskecil::query();

        // Apply status filter
        $penerimaans->where('status', $status);
        $pengeluarans->where('status', $status);

        if ($tanggal_awal && $tanggal_akhir) {
            $penerimaans->whereDate('created_at', '>=', $tanggal_awal)
                ->whereDate('created_at', '<=', $tanggal_akhir);
            $pengeluarans->whereDate('created_at', '>=', $tanggal_awal)
                ->whereDate('created_at', '<=', $tanggal_akhir);
        }

        // Check if there is a search condition
        $hasSearch = $status || ($tanggal_awal && $tanggal_akhir);

        $tanggalAkhir = \Carbon\Carbon::parse($tanggal_awal, 'Asia/Jakarta');
        // Get the first day of the month
        $tanggal_awals = $tanggalAkhir->startOfMonth();

        // Format the dates for better readability if needed
        $tanggal_awals = $tanggal_awals->format('Y-m-d');
        $tanggal_akhirs = $tanggalAkhir->format('Y-m-d');

        // Tentukan bulan dan tahun dari tanggal_akhir
        $tahun = $tanggalAkhir->year;
        $bulan = $tanggalAkhir->month;

        // Hitung bulan sebelumnya
        if ($bulan == 1) {
            $bulanSebelumnya = 12; // Bulan Desember tahun lalu
            $tahunSebelumnya = $tahun - 1;
        } else {
            $bulanSebelumnya = $bulan - 1;
            $tahunSebelumnya = $tahun;
        }

        // Tentukan tanggal awal dan akhir bulan sebelumnya
        $tanggalAwalBulanSebelumnya = \Carbon\Carbon::create($tahunSebelumnya, $bulanSebelumnya, 1);
        $tanggalAkhirBulanSebelumnya = $tanggalAwalBulanSebelumnya->copy()->endOfMonth();

        // Ambil saldo dari bulan sebelumnya
        $sisa_saldo = Saldo::whereBetween('created_at', [$tanggalAwalBulanSebelumnya, $tanggalAkhirBulanSebelumnya])
            ->latest('created_at')
            ->first();

        $sisa_saldo_awal = $sisa_saldo ? $sisa_saldo->sisa_saldo : 0;

        // Retrieve the results if search condition is met
        $data = $hasSearch ? $penerimaans->get() : collect();
        $datas = $hasSearch ? $pengeluarans->get() : collect();

        // Calculate the sum of 'nominal' values
        $Penerimaan = $data->sum('nominal');
        $Pengeluaran = $datas->sum('grand_total');

        $hasil = $Penerimaan - $Pengeluaran + $sisa_saldo_awal;

        // Pass the results and total nominal to the view
        return view('admin.laporan_saldokas.index', compact('hasil', 'Penerimaan', 'Pengeluaran', 'sisa_saldo_awal'));
    }



    public function print_saldokas(Request $request)
    {
        $status = $request->status ?? 'posting';
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;

        // Set default values for dates if not provided
        if (!$tanggal_awal) {
            $tanggal_awal = \Carbon\Carbon::now()->startOfMonth()->format('Y-m-d');
        }
        if (!$tanggal_akhir) {
            $tanggal_akhir = \Carbon\Carbon::now()->format('Y-m-d');
        }

        $penerimaans = Penerimaan_kaskecil::query();
        $pengeluarans = Pengeluaran_kaskecil::query();

        // Apply status filter
        $penerimaans->where('status', $status);
        $pengeluarans->where('status', $status);

        if ($tanggal_awal && $tanggal_akhir) {
            $penerimaans->whereDate('created_at', '>=', $tanggal_awal)
                ->whereDate('created_at', '<=', $tanggal_akhir);
            $pengeluarans->whereDate('created_at', '>=', $tanggal_awal)
                ->whereDate('created_at', '<=', $tanggal_akhir);
        }

        // Check if there is a search condition
        $hasSearch = $status || ($tanggal_awal && $tanggal_akhir);

        $tanggalAkhir = \Carbon\Carbon::parse($tanggal_awal, 'Asia/Jakarta');
        // Get the first day of the month
        $tanggal_awals = $tanggalAkhir->startOfMonth();

        // Format the dates for better readability if needed
        $tanggal_awals = $tanggal_awals->format('Y-m-d');
        $tanggal_akhirs = $tanggalAkhir->format('Y-m-d');

        // Tentukan bulan dan tahun dari tanggal_akhir
        $tahun = $tanggalAkhir->year;
        $bulan = $tanggalAkhir->month;

        // Hitung bulan sebelumnya
        if ($bulan == 1) {
            $bulanSebelumnya = 12; // Bulan Desember tahun lalu
            $tahunSebelumnya = $tahun - 1;
        } else {
            $bulanSebelumnya = $bulan - 1;
            $tahunSebelumnya = $tahun;
        }

        // Tentukan tanggal awal dan akhir bulan sebelumnya
        $tanggalAwalBulanSebelumnya = \Carbon\Carbon::create($tahunSebelumnya, $bulanSebelumnya, 1);
        $tanggalAkhirBulanSebelumnya = $tanggalAwalBulanSebelumnya->copy()->endOfMonth();

        // Ambil saldo dari bulan sebelumnya
        $sisa_saldo = Saldo::whereBetween('created_at', [$tanggalAwalBulanSebelumnya, $tanggalAkhirBulanSebelumnya])
            ->latest('created_at')
            ->first();

        $sisa_saldo_awal = $sisa_saldo ? $sisa_saldo->sisa_saldo : 0;

        // Retrieve the results if search condition is met
        $data = $hasSearch ? $penerimaans->get() : collect();
        $datas = $hasSearch ? $pengeluarans->get() : collect();

        // Calculate the sum of 'nominal' values
        $Penerimaan = $data->sum('nominal');
        $Pengeluaran = $datas->sum('grand_total');

        $hasil = $Penerimaan - $Pengeluaran + $sisa_saldo_awal;

        // Load the PDF view with the required data
        $pdf = PDF::loadView('admin.laporan_saldokas.print', compact('hasil', 'tanggal_akhir'));

        return $pdf->stream('Laporan_Saldo_Kas.pdf');
    }
}