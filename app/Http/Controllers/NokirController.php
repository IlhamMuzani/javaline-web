<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Nokir;


class NokirController extends Controller
{
    public function detail($kode)
    {
        // return "hellow word";
        $nokir = Nokir::where('kode_kir', $kode)->first();
        return view('admin/nokir.show', compact('nokir'));
    }
}