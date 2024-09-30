<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Kendaraan;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Sparepart;
use Illuminate\Http\Request;
use App\Models\Jenis_kendaraan;
use App\Models\Penggantian_oli;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Detail_penggantianoli;
use App\Models\Detail_penggantianpart;
use App\Models\Lama_penggantianoli;
use Illuminate\Support\Facades\Validator;

class PenggantianBearingController extends Controller
{
    public function index()
    {

        $kendaraans = Kendaraan::all();
        return view('admin.penggantian_bearing.index', compact('kendaraans'));
    }

    public function edit($id)
    {
        $kendaraan = Kendaraan::find($id);
        return view('admin.penggantian_bearing.update', compact('kendaraan'));
    }
}