<?php

namespace App\Http\Controllers\admin;

use Carbon\Carbon;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Alamat_muat;
use Illuminate\Support\Facades\Validator;

class AlamatmuatController extends Controller
{
    public function index()
    {
        $alamatmuats = Alamat_muat::all();
        return view('admin.alamat_muat.index', compact('alamatmuats'));
    }

    public function create()
    {
        return view('admin.alamat_muat.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama_perusahaan' => 'required',
                'alamat' => 'required',
            ],
            [
                'nama_perusahaan.required' => 'Masukkan nama_perusahaan',
                'alamat.required' => 'Masukkan alamat',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $kode = $this->kode();

        Alamat_muat::create(array_merge(
            $request->all(),
            [
                'kode_alamat' => $this->kode(),
                'tanggal_awal' => Carbon::now('Asia/Jakarta'),
            ],
        ));

        return redirect('admin/alamat_muat')->with('success', 'Berhasil menambahkan biaya tambahan');
    }

    public function kode()
    {
        $lastBarang = Alamat_muat::latest()->first();
        if (!$lastBarang) {
            $num = 1;
        } else {
            $lastCode = $lastBarang->kode_potongan;
            $num = (int) substr($lastCode, strlen('PM')) + 1;
        }
        $formattedNum = sprintf("%06s", $num);
        $prefix = 'AAM';
        $newCode = $prefix . $formattedNum;
        return $newCode;
    }

    public function edit($id)
    {
        $alamatmuats = Alamat_muat::where('id', $id)->first();

        return view('admin/alamat_muat.update', compact('alamatmuats'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama_perusahaan' => 'required',
                'alamat' => 'required',
            ],
            [
                'nama_perusahaan.required' => 'Masukkan nama_perusahaan',
                'alamat.required' => 'Masukkan alamat',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $alamatmuats = Alamat_muat::findOrFail($id);

        $alamatmuats->nama_perusahaan = $request->nama_perusahaan;
        $alamatmuats->alamat = $request->alamat;

        $alamatmuats->save();

        return redirect('admin/alamat_muat')->with('success', 'Berhasil memperbarui potongan memo');
    }

    public function destroy($id)
    {
        $alamatmuats = Alamat_muat::find($id);
        $alamatmuats->delete();

        return redirect('admin/alamat_muat')->with('success', 'Berhasil menghapus potongan memo');
    }
}