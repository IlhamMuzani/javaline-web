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
use App\Models\Pengeluaran_kaskecil;
use Illuminate\Support\Facades\Validator;

class TablepengeluaranController extends Controller
{
    public function index(Request $request)
    {
        $inquery = Pengeluaran_kaskecil::query();

        // Apply the conditions for filtering
        $inquery->where(['memo_ekspedisi_id' => null, 'memotambahan_id' => null]);
        $inquery->whereDate('tanggal_awal', Carbon::today());

        // Order the results by id in descending order
        $inquery->orderBy('id', 'DESC');

        // Get the results
        $inquery = $inquery->get();

        return view('admin.tablepengeluaran.index', compact('inquery'));
    }
}
