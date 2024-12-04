<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Lokasi;
use Illuminate\Support\Facades\Validator;

class JarakabsenController extends Controller
{
    public function index()
    {
        $jarak_absens = Lokasi::all();
        return view('admin/jarak_absen.index', compact('jarak_absens'));
    }

    public function create()
    {
        return view('admin/jarak_absen.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'radius' => 'required',
            ],
            [
                'radius.required' => 'Masukkan jarak km',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $kode = $this->kode();
        Lokasi::create(array_merge(
            $request->all(),
            [
                'kode_jarak' => $this->kode(),
                'radius' => str_replace(',', '.', str_replace('.', '', $request->radius)),
                'qrcode_jarak' => 'https://javaline.id/jarak-absen/' . $kode,

            ]
        ));

        return redirect('admin/jarak-absen')->with('success', 'Berhasil menambahkan jarak Absen');
    }

    public function kode()
    {
        $lastBarang = Lokasi::latest()->first();
        if (!$lastBarang) {
            $num = 1;
        } else {
            $lastCode = $lastBarang->kode_jarak;
            $num = (int) substr($lastCode, strlen('JRA')) + 1;
        }
        $formattedNum = sprintf("%06s", $num);
        $prefix = 'JR';
        $newCode = $prefix . $formattedNum;
        return $newCode;
    }

    public function edit($id)
    {
        $jarak_absen = Lokasi::where('id', $id)->first();
        return view('admin/jarak_absen.update', compact('jarak_absen'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'radius' => 'required',
            ],
            [
                'radius.required' => 'Masukkan jarak km',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $jarak_absen = Lokasi::find($id);
        $jarak_absen->radius = str_replace(',', '.', str_replace('.', '', $request->radius));
        $jarak_absen->save();
        return redirect('admin/jarak-absen')->with('success', 'Berhasil memperbarui jarak absen');
    }

    public function destroy($id)
    {
        $jarak_absen = Lokasi::find($id);
        $jarak_absen->delete();
        return redirect('admin/jarak-absen')->with('success', 'Berhasil menghapus jarak absen');
    }
}