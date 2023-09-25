<?php

namespace App\Http\Controllers;

use App\Models\Ban;
use App\Http\Controllers\Controller;

class BanController extends Controller
{
    public function detail($kode)
    {
        // return "hellow word";
        $ban = Ban::where('kode_ban', $kode)->first();
        return view('admin/ban.qrcode_detail', compact('ban'));
    }
}
