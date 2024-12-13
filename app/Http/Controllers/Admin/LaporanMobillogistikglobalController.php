<?php

namespace App\Http\Controllers\Admin;

use App\Exports\LaporanlogistikExport;
use App\Exports\LogistikglobalExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use App\Models\Faktur_ekspedisi;
use App\Models\Kendaraan;

class LaporanMobillogistikglobalController extends Controller
{


    public function index(Request $request)
    {
        $kendaraans = Kendaraan::with(['faktur_ekspedisi', 'memo_ekspedisi', 'detail_pengeluaran', 'memo_asuransi'])->get();
        $kendaraans = $kendaraans->sort(function ($a, $b) {
            $numberA = (int) filter_var($a->no_kabin, FILTER_SANITIZE_NUMBER_INT);
            $numberB = (int) filter_var($b->no_kabin, FILTER_SANITIZE_NUMBER_INT);
            return $numberA - $numberB;
        });

        $kategoris = $request->kategoris;
        $status = $request->status;
        $created_at = $request->created_at;
        $tanggal_akhir = $request->tanggal_akhir;

        $inquery = Faktur_ekspedisi::orderBy('id', 'DESC');


        // if ($kategoris) {
        //     if ($kategoris == 'memo') {
        //         $inquery->where('kategoris', 'memo');
        //     } elseif ($kategoris == 'non memo') {
        //         $inquery->where('kategoris', 'non memo');
        //     } else {
        //         // Tidak ada filter tambahan untuk kategori selain 'memo' dan 'non memo'
        //     }
        // }

        if ($status == "posting") {
            $inquery->where('status', $status);
        } else {
            $inquery->where('status', 'posting');
        }

        if ($created_at && $tanggal_akhir) {
            $inquery->whereBetween('created_at', [$created_at, $tanggal_akhir]);
        }

        $faktur_ekspedisis = $inquery->get();

        // Additional logic if needed

        // $inquery = $inquery->get();

        // kondisi sebelum melakukan pencarian data masih kosong
        $hasSearch = $status || ($created_at && $tanggal_akhir);
        $inquery = $hasSearch ? $faktur_ekspedisis : collect();

        return view('admin.laporan_mobillogistikglobal.index', compact('inquery', 'kendaraans', 'created_at', 'tanggal_akhir', 'kategoris'));
    }

    // cara berbeda 
    // public function index(Request $request)
    // {
    //     // $kendaraans = Kendaraan::with(['detail_pengeluaran'])->get();
    //     $kategoris = $request->kategoris;
    //     $status = $request->status;
    //     $created_at = $request->created_at;
    //     $tanggal_akhir = $request->tanggal_akhir;

    //     $kendaraans = Kendaraan::with(['detail_pengeluaran' => function ($query) use ($created_at, $tanggal_akhir) {
    //         if ($created_at && $tanggal_akhir) {
    //             $query->whereBetween('created_at', [$created_at, $tanggal_akhir]);
    //         }
    //     }])->get();

    //     $kendaraan = $request->kendaraan_id;

    //     $inquery = Faktur_ekspedisi::orderBy('id', 'DESC');

    //     if ($kategoris) {
    //         if ($kategoris == 'memo') {
    //             $inquery->where('kategoris', 'memo');
    //         } elseif ($kategoris == 'non memo') {
    //             $inquery->where('kategoris', 'non memo');
    //         }
    //     }

    //     if ($status == "posting" || $status == "selesai") {
    //         $inquery->where('status', $status);
    //     } else {
    //         $inquery->whereIn('status', ['posting', 'selesai']);
    //     }

    //     if ($created_at && $tanggal_akhir) {
    //         $inquery->whereDate('created_at', '>=', $created_at)
    //             ->whereDate('created_at', '<=', $tanggal_akhir);
    //     }

    //     if ($kendaraan) {
    //         $inquery->where('kendaraan_id', $kendaraan);
    //     }

    //     $inquery = $inquery->get()->groupBy('kendaraan_id');

    //     $hasSearch = $status || ($created_at && $tanggal_akhir) || $kendaraan;
    //     $inquery = $hasSearch ? $inquery : collect();

    //     $detail_fakturs = collect();
    //     $grandTotalSum = 0;
    //     $totalBiayaTambahan = 0;

    //     $grandTotalPerKendaraan = [];


    //     foreach ($inquery as $kendaraan_id => $fakturs) {
    //         $grandTotalPerKendaraan[$kendaraan_id] = 0;
    //         $grandOperasional[$kendaraan_id] = 0;
    //         $grandPerbaikan[$kendaraan_id] = 0;
    //         foreach ($fakturs as $faktur) {
    //             $details = Detail_faktur::where('faktur_ekspedisi_id', $faktur->id)->get();

    //             foreach ($details as $detail) {
    //                 $memoEkspedisi = Memo_ekspedisi::with('memotambahan')->find($detail->memo_ekspedisi_id);
    //                 $detail->memo_ekspedisi = $memoEkspedisi;
    //                 if ($memoEkspedisi) {
    //                     $grandTotalSum += $memoEkspedisi->hasil_jumlah;
    //                     $totalBiayaTambahan += $memoEkspedisi->memotambahan->sum('grand_total'); // Sum of biaya_tambahan from related memo_tambahan
    //                     $grandTotalPerKendaraan[$kendaraan_id] += $memoEkspedisi->hasil_jumlah + $memoEkspedisi->memotambahan->sum('grand_total');
    //                 }
    //             }
    //             $faktur->detail_fakturs = $details;
    //             $detail_fakturs = $detail_fakturs->merge($details);
    //         }
    //     }
    //     $totalGrandTotal = $grandTotalSum + $totalBiayaTambahan;

    //     return view('admin.laporan_mobillogistikglobal.index', compact('inquery', 'kendaraans', 'detail_fakturs', 'totalGrandTotal', 'grandTotalPerKendaraan'));
    // }

    public function print_mobillogistikglobal(Request $request)
    {
        $kategoris = $request->kategoris;
        $status = $request->status;
        $created_at = $request->created_at;
        $tanggal_akhir = $request->tanggal_akhir;
        $kendaraan = $request->kendaraan_id; // New variable to store kendaraan_id

        $kendaraans = Kendaraan::with(['faktur_ekspedisi', 'memo_ekspedisi'])
            ->withCount('memo_ekspedisi')
            ->get();

        $kendaraans = $kendaraans->sort(function ($a, $b) {
            $numberA = (int) filter_var($a->no_kabin, FILTER_SANITIZE_NUMBER_INT);
            $numberB = (int) filter_var($b->no_kabin, FILTER_SANITIZE_NUMBER_INT);
            return $numberA - $numberB;
        });

        $inquery = Faktur_ekspedisi::orderBy('id', 'DESC');



        if ($kategoris) {
            if ($kategoris == 'memo') {
                $inquery->where('kategoris', 'memo');
            } elseif ($kategoris == 'non memo') {
                $inquery->where('kategoris', 'non memo');
            }
        }

        if ($status == "posting") {
            $inquery->where('status', $status);
        } else {
            $inquery->where('status', 'posting');
        }

        if ($created_at && $tanggal_akhir) {
            $inquery->whereBetween('created_at', [$created_at, $tanggal_akhir]);
        }

        // Retrieve faktur_ekspedisis directly from the relationship
        $faktur_ekspedisis = $inquery->get();

        $pdf = PDF::loadView('admin.laporan_mobillogistikglobal.print', compact('inquery', 'kendaraans', 'faktur_ekspedisis', 'kategoris'));
        return $pdf->stream('Laporan_mobil_logistik.pdf');
    }

    public function rekapexportlaporanlogistik(Request $request)
    {
        $created_at = $request->input('created_at');
        $tanggal_akhir = $request->input('tanggal_akhir');
        $kategoris = $request->input('kategoris');

        return Excel::download(new LogistikglobalExport($created_at, $tanggal_akhir, $kategoris), 'logistik_global.xlsx');
    }
}