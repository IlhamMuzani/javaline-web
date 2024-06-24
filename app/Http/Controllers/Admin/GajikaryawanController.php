<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Departemen;
use App\Models\Karyawan;
use App\Models\User;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RekapExport;

class GajikaryawanController extends Controller
{
    public function index()
    {
        $gajis = Karyawan::select('id','kode_karyawan', 'nama_lengkap', 'kasbon', 'bayar_kasbon', 'gaji', 'departemen_id')
            ->whereNotIn('departemen_id', [2])
            ->orderBy('nama_lengkap')
            ->get();

        return view('admin.gaji_karyawan.index', compact('gajis'));
    }
    
    public function show($id)
    {

        $karyawan = Karyawan::where('id', $id)->first();
        return view('admin/gaji_karyawan.show', compact('karyawan'));
    }

    public function edit($id)
    {
        $gajis = Karyawan::where('id', $id)->first();
        return view('admin/gaji_karyawan.update', compact('gajis'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'gaji' => 'required',
            ],
            [
                'gaji.required' => 'Masukkan gaji karyawan',

            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $karyawan = Karyawan::findOrFail($id);
        $karyawan->kasbon = $request->kasbon ? str_replace('.', '', $request->kasbon) : null;
        $karyawan->bpjs = $request->bpjs ? str_replace('.', '', $request->bpjs) : null;
        $karyawan->gaji = $request->gaji ? str_replace('.', '', $request->gaji) : null;
        $karyawan->save();

        return redirect('admin/gaji_karyawan')->with('success', 'Berhasil mengubah gaji karyawan');
    }
}