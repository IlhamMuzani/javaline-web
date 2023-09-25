<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use App\Models\Pelanggan;

class PelangganController extends Controller
{
    public function detail($kode)
    {
        // return "hellow word";
        $pelanggan = Pelanggan::where('kode_pelanggan', $kode)->first();
        return view('admin/pelanggan.qrcode_detail', compact('pelanggan'));
    }
}