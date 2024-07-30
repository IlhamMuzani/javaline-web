<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faktur_ekspedisi;
use App\Models\Nota_return;
use App\Models\Pelanggan;
use App\Models\Potongan_penjualan;

class FakturpelunasanperfakturController extends Controller
{
    public function index()
    {
        $pelanggans = Pelanggan::all();
        $fakturs = Faktur_ekspedisi::where('status_pelunasan', null)
            ->whereIn('status', ['posting', 'selesai'])
            ->get();
        $returns = Nota_return::all();
        $potonganlains = Potongan_penjualan::where('status', 'posting')->get();

        return view('admin.faktur_pelunasanperfaktur.index', compact('potonganlains', 'pelanggans', 'fakturs', 'returns'));
    }

}