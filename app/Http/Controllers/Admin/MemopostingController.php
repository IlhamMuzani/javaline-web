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

class MemopostingController extends Controller
{
    public function index(Request $request)
    {
        $inquery = Memotambahan::whereDate('updated_at', today()) // Filter berdasarkan tanggal pembaruan hari ini
            ->where('status', 'posting') // Filter berdasarkan status posting
            ->get();

        return view('admin.memoposting.index', compact('inquery'));
    }
}