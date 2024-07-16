<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Detail_pelunasan;
use App\Models\Detail_pelunasanpotongan;
use App\Models\Detail_pelunasanreturn;
use App\Models\Detail_return;
use App\Models\Faktur_ekspedisi;
use App\Models\Faktur_pelunasan;
use App\Models\Faktur_penjualanreturn;
use App\Models\Nota_return;
use App\Models\Pelanggan;
use App\Models\Potongan_penjualan;
use App\Models\Return_ekspedisi;
use App\Models\Tagihan_ekspedisi;
use App\Models\Tarif;
use Illuminate\Support\Facades\Validator;

class FakturpelunasanperfakturController extends Controller
{
    public function index()
    {
        $pelanggans = Pelanggan::all();
        $fakturs = Faktur_ekspedisi::where(['status_pelunasan' => null, 'status' => 'posting'])->get();
        $returns = Nota_return::all();

        return view('admin.faktur_pelunasanperfaktur.index', compact('pelanggans', 'fakturs', 'returns'));
    }

}