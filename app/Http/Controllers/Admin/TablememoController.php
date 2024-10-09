<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Dompdf\Dompdf;
use App\Models\Divisi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Memo_ekspedisi;
use App\Models\Memotambahan;
use App\Models\Saldo;
use Illuminate\Support\Facades\Validator;

class TablememoController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        $memoEkspedisis = Memo_ekspedisi::where(function ($query) use ($today) {
            $query->whereDate('created_at', $today)
                ->orWhereDate('created_at', '<', $today);
        })
            ->whereIn('status', ['unpost', 'rilis']) // Mengambil status "unpost" dan "rilis" untuk Memo Ekspedisi
            ->orderBy('created_at', 'desc') // Mengurutkan hasil secara descending
            ->get();


        $memoTambahans = Memotambahan::where(function ($query) use ($today) {
            $query->whereDate('created_at', $today)
                ->orWhereDate('created_at', '<', $today);
        })
            ->where('status', 'unpost')
            ->orderBy('created_at', 'desc') // Menambahkan orderBy untuk mengurutkan hasil secara descending
            ->get();

        $memos = $memoEkspedisis->concat($memoTambahans);
        $saldoTerakhir = Saldo::latest()->first();

        return view('admin.tablememo.index', compact('memos', 'memoEkspedisis', 'memoTambahans', 'saldoTerakhir'));
    }

    // public function index()
    // {
    //     $today = Carbon::today();

    //     $memos = Memo_ekspedisi::where(function ($query) use ($today) {
    //         $query->whereDate('created_at', $today)
    //             ->orWhereDate('created_at', '<', $today);
    //     })
    //         ->where(['status' => 'unpost', 'kategori' => 'Memo Perjalanan'])
    //         ->orderBy('created_at', 'desc') // Menambahkan orderBy untuk mengurutkan hasil secara descending
    //         ->get();

    //     return view('admin.tablememo.index', compact('memos'));
    // }


    // public function memoborongs()
    // {
    //     $today = Carbon::today();

    //     $memos = Memo_ekspedisi::where(function ($query) use ($today) {
    //         $query->whereDate('created_at', $today)
    //             ->orWhereDate('created_at', '<', $today);
    //     })
    //         ->where(['status' => 'unpost', 'kategori' => 'Memo Borong'])
    //         ->orderBy('created_at', 'desc') // Menambahkan orderBy untuk mengurutkan hasil secara descending
    //         ->get();

    //     return view('admin.tablememo.memoborongs', compact('memos'));
    // }

    // public function memotambahans()
    // {
    //     $today = Carbon::today();

    //     $memos = Memotambahan::where(function ($query) use ($today) {
    //         $query->whereDate('created_at', $today)
    //             ->orWhereDate('created_at', '<', $today);
    //     })
    //         ->where('status', 'unpost')
    //         ->orderBy('created_at', 'desc') // Menambahkan orderBy untuk mengurutkan hasil secara descending
    //         ->get();

    //     return view('admin.tablememo.memotambahans', compact('memos'));
    // }

    public function create()
    {
        return view('admin.tablememo.create');
    }
}