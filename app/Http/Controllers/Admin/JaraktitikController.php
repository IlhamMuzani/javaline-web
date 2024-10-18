<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Jarak_titik;
use Illuminate\Support\Facades\Validator;

class JaraktitikController extends Controller
{
    public function index()
    {
        $jarak_titiks = Jarak_titik::all();
        return view('admin/jarak_titik.index', compact('jarak_titiks'));
    }

    public function create()
    {
        return view('admin/jarak_titik.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'jarak' => 'required',
            ],
            [
                'jarak.required' => 'Masukkan lama penggantian bearing',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $kode = $this->kode();
        Jarak_titik::create(array_merge(
            $request->all(),
            [
                'kode_jarak' => $this->kode(),
                'jarak' => str_replace(',', '.', str_replace('.', '', $request->jarak)),
                'qrcode_jarak' => 'https://javaline.id/jarak_titik/' . $kode,

            ]
        ));

        return redirect('admin/jarak_titik')->with('success', 'Berhasil menambahkan lama penggantian bearing');
    }

    // public function kode()
    // {
    //     $lastBarang = Jarak_titik::latest()->first();
    //     if (!$lastBarang) {
    //         $num = 1;
    //     } else {
    //         $lastCode = $lastBarang->kode_jarak;
    //         $num = (int) substr($lastCode, strlen('JPB')) + 1;
    //     }
    //     $formattedNum = sprintf("%06s", $num);
    //     $prefix = 'JPB';
    //     $newCode = $prefix . $formattedNum;
    //     return $newCode;
    // }

    public function edit($id)
    {
        $jarak_titik = Jarak_titik::where('id', $id)->first();
        return view('admin/jarak_titik.update', compact('jarak_titik'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'jarak' => 'required',
            ],
            [
                'jarak.required' => 'Masukkan jarak titik',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $jarak_titik = Jarak_titik::find($id);
        $jarak_titik->jarak = str_replace(',', '.', str_replace('.', '', $request->jarak));
        $jarak_titik->save();
        return redirect('admin/jarak_titik')->with('success', 'Berhasil memperbarui jarak titik');
    }

    public function destroy($id)
    {
        $jarak_titik = Jarak_titik::find($id);
        $jarak_titik->delete();
        return redirect('admin/jarak_titik')->with('success', 'Berhasil menghapus jarak titik');
    }
}