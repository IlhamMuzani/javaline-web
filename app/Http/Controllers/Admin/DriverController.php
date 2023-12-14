<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Departemen;
use App\Models\Karyawan;
use App\Models\User;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class DriverController extends Controller
{
    public function index()
    {
        // if (auth()->check() && auth()->user()->menu['karyawan']) {
        $drivers = Karyawan::where('departemen_id', '2')->get();
        return view('admin.driver.index', compact('drivers'));
        // } else {
        //     // tidak memiliki akses
        //     return back()->with('error', array('Anda tidak memiliki akses'));
        // }
    }

    public function show($id)
    {
        // if (auth()->check() && auth()->user()->menu['karyawan']) {

            $karyawan = Karyawan::where('id', $id)->first();
            return view('admin/karyawan.show', compact('karyawan'));
        // } else {
        //     // tidak memiliki akses
        //     return back()->with('error', array('Anda tidak memiliki akses'));
        // }
    }

    public function edit($id)
    {
        // if (auth()->check() && auth()->user()->menu['karyawan']) {

            $drivers = Karyawan::where('id', $id)->first();
            return view('admin/driver.update', compact('drivers'));
        // } else {
        //     // tidak memiliki akses
        //     return back()->with('error', array('Anda tidak memiliki akses'));
        // }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'tabungan' => 'required',
            ],
            [
                'tabungan.required' => 'Masukkan deposit Driver',

            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $karyawan = Karyawan::findOrFail($id);

        $karyawan->tabungan = $request->tabungan;
        $karyawan->save();

        return redirect('admin/driver')->with('success', 'Berhasil mengubah deposit');
    }
}