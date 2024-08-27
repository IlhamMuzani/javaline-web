<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Jarak_km;
use Illuminate\Support\Facades\Validator;

class JarakkmController extends Controller
{
    public function index()
    {
        $jarak_kms = Jarak_km::all();
        return view('admin/jarak_km.index', compact('jarak_kms'));
    }

    public function create()
    {
        return view('admin/jarak_km.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'batas' => 'required',
            ],
            [
                'batas.required' => 'Masukkan jarak km',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $kode = $this->kode();
        Jarak_km::create(array_merge(
            $request->all(),
            [
                'kode_jarak' => $this->kode(),
                'batas' => str_replace(',', '.', str_replace('.', '', $request->batas)),
                'qrcode_jarak' => 'https://javaline.id/jarak_km/' . $kode,

            ]
        ));

        return redirect('admin/jarak_km')->with('success', 'Berhasil menambahkan jarak km');
    }

    public function kode()
    {
        $lastBarang = Jarak_km::latest()->first();
        if (!$lastBarang) {
            $num = 1;
        } else {
            $lastCode = $lastBarang->kode_jarak;
            $num = (int) substr($lastCode, strlen('JKM')) + 1;
        }
        $formattedNum = sprintf("%06s", $num);
        $prefix = 'JKM';
        $newCode = $prefix . $formattedNum;
        return $newCode;
    }

    public function edit($id)
    {
        $jarak_km = Jarak_km::where('id', $id)->first();
        return view('admin/jarak_km.update', compact('jarak_km'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'batas' => 'required',
            ],
            [
                'batas.required' => 'Masukkan jarak km',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $jarak_km = Jarak_km::find($id);
        $jarak_km->batas = str_replace(',', '.', str_replace('.', '', $request->batas));
        $jarak_km->save();
        return redirect('admin/jarak_km')->with('success', 'Berhasil memperbarui jarak km');
    }

    public function destroy($id)
    {
        $jarak_km = Jarak_km::find($id);
        $jarak_km->delete();
        return redirect('admin/jarak_km')->with('success', 'Berhasil menghapus jarak km');
    }
}