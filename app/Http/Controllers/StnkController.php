<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Kendaraan;
use App\Models\Stnk;

class StnkController extends Controller
{
    public function detail($kode)
    {
        // return "hellow word";
        $stnk = Stnk::where('kode_stnk', $kode)->first();
        return view('admin.stnk.qrcode_detail', compact('stnk'));
    }
}