<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Memo_ekspedisi;
use App\Models\Pelanggan;
use App\Models\Penggantian_oli;
use App\Models\Tagihan_ekspedisi;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Features\Placeholder;

class LaporanpiutangController extends Controller
{
    public function index(Request $request)
    {

        $today = \Carbon\Carbon::now(); // Mengambil tanggal hari ini
        if ($today->isSaturday()) {
            $mondayLastWeek = $today->subDays(6); // Mengambil hari Senin dari minggu lalu
        } else {
            $mondayLastWeek = $today->previous(\Carbon\Carbon::MONDAY); // Mengambil hari Senin dari minggu ini atau minggu lalu
        }

        $mondayLastWeekDate = $mondayLastWeek->format('Y-m-d');

        $mondayLastWeekDate = $mondayLastWeek->format('Y-m-d');

        $senin_kemarins = Tagihan_ekspedisi::whereDate('created_at', $mondayLastWeekDate)->get();

        
        $pelanggan_id = $request->input('pelanggan_id');

        // Ambil semua pelanggan untuk dropdown
        $pelanggans = Pelanggan::all();

        // Query dasar untuk mengambil data
        $inquery = Tagihan_ekspedisi::query();

        // Tambahkan kondisi where berdasarkan pelanggan_id
        if ($pelanggan_id) {
            $inquery->where('pelanggan_id', $pelanggan_id);
        }

        // Tambahkan kondisi where terkait detail tagihan
        $inquery->where(function ($query) {
            $query->whereDoesntHave('detail_tagihan', function ($query) {
                $query->whereHas('faktur_ekspedisi', function ($query) {
                    $query->whereNotNull('status_pelunasan');
                });
            })->orWhereHas('detail_tagihan', function ($query) {
                $query->whereHas('faktur_ekspedisi', function ($query) {
                    $query->whereNull('status_pelunasan');
                });
            });
        });
        // Jalankan query dan ambil hasilnya
        $inquery = $inquery->get();

        // Kembalikan hasil ke view
        return view('admin.laporan_piutang.index', compact('inquery', 'pelanggans', 'senin_kemarins'));
    }

    public function print_piutang(Request $request)
    {
        // if (auth()->check() && auth()->user()->menu['laporan penggantian oli']) {

        $pelanggan_id = $request->input('pelanggan_id');

        // Query dasar untuk mengambil data
        $inquery = Tagihan_ekspedisi::query();

        if ($pelanggan_id) {
            $inquery->where('pelanggan_id', $pelanggan_id);
        }

        $inquery->where(function ($query) {
            $query->whereDoesntHave('detail_tagihan', function ($query) {
                $query->whereHas('faktur_ekspedisi', function ($query) {
                    $query->whereNotNull('status_pelunasan');
                });
            })->orWhereHas('detail_tagihan', function ($query) {
                $query->whereHas('faktur_ekspedisi', function ($query) {
                    $query->whereNull('status_pelunasan');
                });
            });
        });

        $inquery = $inquery->whereIn('status', ['posting', 'selesai'])
            ->orderBy('id', 'DESC')
            ->get();

        $pdf = PDF::loadView('admin.laporan_piutang.print', compact('inquery'));
        return $pdf->stream('Laporan_piutang.pdf');
        // } else {
        //     // tidak memiliki akses
        //     return back()->with('error', array('Anda tidak memiliki akses'));
        // }
    }
}