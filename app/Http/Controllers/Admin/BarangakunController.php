<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Barang_akun;
use Illuminate\Support\Facades\Validator;

class BarangakunController extends Controller
{
    public function index()
    {
        $barangakuns = Barang_akun::all();
        return view('admin/barangakun.index', compact('barangakuns'));
    }

    public function create()
    {
        return view('admin/barangakun.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama_barangakun' => 'required',
            ],
            [
                'nama_barangakun.required' => 'Masukkan nama akun',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $kode = $this->kode();
        Barang_akun::create(array_merge(
            $request->all(),
            [
                'kode_barangakun' => $this->kode(),
                'qrcode_barangakun' => 'https://javaline.id/barang_akun/' . $kode,
                'tanggal_awal' => Carbon::now('Asia/Jakarta'),

            ]
        ));

        return redirect('admin/akun')->with('success', 'Berhasil menambahkan barangakun');
    }

    public function kode()
    {
        $lastBarang = Barang_akun::latest()->first();
        if (!$lastBarang) {
            $num = 1;
        } else {
            $lastCode = $lastBarang->kode_barangakun;
            $num = (int) substr($lastCode, strlen('KA')) + 1;
        }
        $formattedNum = sprintf("%06s", $num);
        $prefix = 'KA';
        $newCode = $prefix . $formattedNum;
        return $newCode;
    }

    public function edit($id)
    {
        $barangakun = Barang_akun::where('id', $id)->first();
        return view('admin/barangakun.update', compact('barangakun'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_barangakun' => 'required',
        ], [
            'nama_barangakun.required' => 'Nama akun tidak boleh Kosong',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $barangakun = Barang_akun::find($id);
        $barangakun->nama_barangakun = $request->nama_barangakun;
        $barangakun->tanggal_awal = Carbon::now('Asia/Jakarta');
        $barangakun->save();
        return redirect('admin/akun')->with('success', 'Berhasil memperbarui barangakun');
    }

    public function destroy($id)
    {
        $barangakun = Barang_akun::find($id);
        $barangakun->delete();
        return redirect('admin/akun')->with('success', 'Berhasil menghapus akun');
    }
}