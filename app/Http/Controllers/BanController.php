<?php

namespace App\Http\Controllers;

use App\Models\Ban;
use App\Http\Controllers\Controller;
use App\Models\Kendaraan;

class BanController extends Controller
{
    public function detail($kode)
    {
        // return "hello world";
        $ban = Ban::where('kode_ban', $kode)->first();
        return view('admin/ban.qrcode_detail', compact('ban'));

        // if ($ban) {
        //     $kendaraan = Kendaraan::where('id', $ban->kendaraan_id)->first();

        //     if ($kendaraan) {
        //         $ban->update([
        //             'umur_ban' => $kendaraan->km - $ban->km_pemasangan
        //         ]);
        //     } else {
        //         // Handle the case where $kendaraan is null
        //         return redirect()->back()->with('error', 'Kendaraan not found.');
        //     }
        // } else {
        //     // Handle the case where $ban is null
        //     return redirect()->back()->with('error', 'Ban not found.');
        // }
    }
}
