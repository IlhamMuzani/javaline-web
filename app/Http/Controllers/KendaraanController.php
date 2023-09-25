<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Kendaraan;

class KendaraanController extends Controller
{
    public function detail($kode)
    {
        // return "hellow word";
        $kendaraan = Kendaraan::where('kode_kendaraan', $kode)->first();
        return view('admin/kendaraan.qrcode_detail', compact('kendaraan'));
    }
}