<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Dompdf\Dompdf;
use App\Models\Divisi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Faktur_ekspedisi;
use App\Models\Memo_ekspedisi;
use App\Models\Memotambahan;
use Illuminate\Support\Facades\Validator;

class TablefakturController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        $inquery = Faktur_ekspedisi::whereDate('created_at', $today)
            ->orWhere(function ($query) use ($today) {
                $query->where('status', 'unpost')
                ->whereDate('created_at', '<', $today);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.tablefaktur.index', compact('inquery'));
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