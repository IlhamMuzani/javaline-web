<?php

namespace App\Http\Controllers\admin;

use Carbon\Carbon;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Kelompok_pelanggan;
use App\Models\Pelanggan;
use App\Models\Vendor;
use Illuminate\Support\Facades\Validator;

class KelompokpelangganController extends Controller
{
    public function index()
    {
        $kelompok_pelanggans = Kelompok_pelanggan::all();
        return view('admin.kelompok_pelanggan.index', compact('kelompok_pelanggans'));
    }

    public function create()
    {

        return view('admin.kelompok_pelanggan.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama' => 'required',
            ],
            [
                'nama.required' => 'Masukkan nama kelompok',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $kode = $this->kode();

        Kelompok_pelanggan::create(array_merge(
            $request->all(),
            [
                'kode_kelompok' => $this->kode(),
                'tanggal_awal' => Carbon::now('Asia/Jakarta'),
                'nama' => $request->nama,
            ],
        ));

        return redirect('admin/kelompok_pelanggan')->with('success', 'Berhasil menambahkan tujuan muat');
    }

    public function kode()
    {
        $lastBarang = Kelompok_pelanggan::latest()->first();
        if (!$lastBarang) {
            $num = 1;
        } else {
            $lastCode = $lastBarang->kode_kelompok;
            $num = (int) substr($lastCode, strlen('KPP')) + 1;
        }
        $formattedNum = sprintf("%06s", $num);
        $prefix = 'KPP';
        $newCode = $prefix . $formattedNum;
        return $newCode;
    }

    public function edit($id)
    {
        $kelompok_pelanggans = Kelompok_pelanggan::where('id', $id)->first();
        return view('admin/kelompok_pelanggan.update', compact('kelompok_pelanggans'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama' => 'required',
            ],
            [
                'nama.required' => 'Masukkan nama kelompok',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $kelompok_pelanggans = Kelompok_pelanggan::findOrFail($id);
        $kelompok_pelanggans->nama = $request->nama;

        $kelompok_pelanggans->save();

        return redirect('admin/kelompok_pelanggan')->with('success', 'Berhasil memperbarui nama kelompok');
    }

    public function destroy($id)
    {
        $kelompok_pelanggans = Kelompok_pelanggan::find($id);
        $kelompok_pelanggans->delete();

        return redirect('admin/kelompok_pelanggan')->with('success', 'Berhasil menghapus nama kelompok');
    }
}