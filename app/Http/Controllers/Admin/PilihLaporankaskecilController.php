<?php

namespace App\Http\Controllers\admin;

use Carbon\Carbon;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PilihLaporankaskecilController extends Controller
{
    public function index()
    {
        return view('admin/pilih_laporankaskecil.index');
        
    }
}