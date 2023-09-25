<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Golongan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Dompdf\Dompdf;

class GolonganController extends Controller
{
    public function detail($kode)
    {
        return "hellow word";
        $golongans = Golongan::where('kode_golongan', $kode)->first();
        return view('admin/golongan.detail', compact('golongans'));
    }
}