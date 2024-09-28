<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Lama_bearing;
use Illuminate\Support\Facades\Validator;

class LamabearingController extends Controller
{
    public function index()
    {
        $jarak_kms = Lama_bearing::all();
        return view('admin/lama_bearing.index', compact('jarak_kms'));
    }

    public function create()
    {
        return view('admin/lama_bearing.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'batas' => 'required',
            ],
            [
                'batas.required' => 'Masukkan lama penggantian bearing',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $kode = $this->kode();
        Lama_bearing::create(array_merge(
            $request->all(),
            [
                'kode_jarak' => $this->kode(),
                'batas' => str_replace(',', '.', str_replace('.', '', $request->batas)),
                'qrcode_jarak' => 'https://javaline.id/lama_bearing/' . $kode,

            ]
        ));

        return redirect('admin/lama_bearing')->with('success', 'Berhasil menambahkan lama penggantian bearing');
    }

    public function kode()
    {
        $lastBarang = Lama_bearing::latest()->first();
        if (!$lastBarang) {
            $num = 1;
        } else {
            $lastCode = $lastBarang->kode_jarak;
            $num = (int) substr($lastCode, strlen('JPB')) + 1;
        }
        $formattedNum = sprintf("%06s", $num);
        $prefix = 'JPB';
        $newCode = $prefix . $formattedNum;
        return $newCode;
    }

    public function edit($id)
    {
        $lama_bearing = Lama_bearing::where('id', $id)->first();
        return view('admin/lama_bearing.update', compact('lama_bearing'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'batas' => 'required',
            ],
            [
                'batas.required' => 'Masukkan lama penggantian bearing',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $lama_bearing = Lama_bearing::find($id);
        $lama_bearing->batas = str_replace(',', '.', str_replace('.', '', $request->batas));
        $lama_bearing->save();
        return redirect('admin/lama_bearing')->with('success', 'Berhasil memperbarui lama penggantian bearing');
    }

    public function destroy($id)
    {
        $lama_bearing = Lama_bearing::find($id);
        $lama_bearing->delete();
        return redirect('admin/lama_bearing')->with('success', 'Berhasil menghapus lama penggantian bearing');
    }
}