<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Dompdf\Dompdf;
use App\Models\Divisi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Memo_ekspedisi;
use App\Models\Memotambahan;
use App\Models\Potongan_penjualan;
use App\Models\Saldo;
use App\Models\Tagihan_ekspedisi;
use Illuminate\Support\Facades\Validator;

class TablepotonganController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        $inquery = Potongan_penjualan::whereDate('created_at', $today)
            ->orWhere(function ($query) use ($today) {
                $query->where('status', 'unpost')
                    ->whereDate('created_at', '<', $today);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.tablepotongan.index', compact('inquery'));
    }
}