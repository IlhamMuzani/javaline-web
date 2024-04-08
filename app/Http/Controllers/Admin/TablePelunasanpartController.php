<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Dompdf\Dompdf;
use App\Models\Divisi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Faktur_ekspedisi;
use App\Models\Faktur_pelunasan;
use App\Models\Faktur_pelunasanpart;
use App\Models\Memo_ekspedisi;
use App\Models\Memotambahan;
use App\Models\Pembelian_part;
use App\Models\Pengeluaran_kaskecil;
use Illuminate\Support\Facades\Validator;

class TablePelunasanpartController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        $inquery = Faktur_pelunasanpart::whereDate('created_at', $today)
            ->orWhere(function ($query) use ($today) {
                $query->where('status', 'unpost')
                ->whereDate('created_at', '<', $today);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.tablepelunasanpart.index', compact('inquery'));
    }
}