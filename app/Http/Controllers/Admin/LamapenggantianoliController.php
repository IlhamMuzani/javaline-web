<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Lama_penggantianoli;
use Illuminate\Support\Facades\Validator;

class LamapenggantianoliController extends Controller
{
    public function index()
    {
        $lama_penggantianolis = Lama_penggantianoli::all();
        return view('admin/lama_penggantianoli.index', compact('lama_penggantianolis'));
    }

    public function create()
    {
        return view('admin/lama_penggantianoli.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama' => 'required',
                'km_oli' => 'required',
            ],
            [
                'nama.required' => 'Masukkan nama oli',
                'km_oli.required' => 'Masukkan km oli',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $kode = $this->kode();
        Lama_penggantianoli::create(array_merge(
            $request->all(),
            [
                'kode_oli' => $this->kode(),
                'km_oli' => str_replace(',', '.', str_replace('.', '', $request->km_oli)),
                'qrcode_barangakun' => 'https://javaline.id/lama_penggantianoli/' . $kode,

            ]
        ));

        return redirect('admin/lama_penggantianoli')->with('success', 'Berhasil menambahkan lama penggantian oli');
    }

    public function kode()
    {
        $lastBarang = Lama_penggantianoli::latest()->first();
        if (!$lastBarang) {
            $num = 1;
        } else {
            $lastCode = $lastBarang->kode_oli;
            $num = (int) substr($lastCode, strlen('LMP')) + 1;
        }
        $formattedNum = sprintf("%06s", $num);
        $prefix = 'LMP';
        $newCode = $prefix . $formattedNum;
        return $newCode;
    }

    public function edit($id)
    {
        $lama_penggantianoli = Lama_penggantianoli::where('id', $id)->first();
        return view('admin/lama_penggantianoli.update', compact('lama_penggantianoli'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama' => 'required',
                'km_oli' => 'required',
            ],
            [
                'nama.required' => 'Masukkan nama oli',
                'km_oli.required' => 'Masukkan km oli',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $lama_penggantianoli = Lama_penggantianoli::find($id);
        $lama_penggantianoli->nama = $request->nama;
        $lama_penggantianoli->km_oli = str_replace(',', '.', str_replace('.', '', $request->km_oli));
        $lama_penggantianoli->save();
        return redirect('admin/lama_penggantianoli')->with('success', 'Berhasil memperbarui lama penggantian oli');
    }

    public function destroy($id)
    {
        $barangakun = Lama_penggantianoli::find($id);
        $barangakun->delete();
        return redirect('admin/lama_penggantianoli')->with('success', 'Berhasil menghapus lama penggantian oli');
    }
}