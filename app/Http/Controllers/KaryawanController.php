<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Karyawan;

class KaryawanController extends Controller
{
    public function detail($kode)
    {
        // return "hellow word";
        $karyawan = Karyawan::where('kode_karyawan', $kode)->first();
        return view('admin/karyawan.qrcode_detail', compact('karyawan'));
    }
}