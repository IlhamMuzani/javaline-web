<?php

namespace App\Http\Controllers\admin;

use Carbon\Carbon;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Biaya_tambahan;
use Illuminate\Support\Facades\Validator;

class BiayatambahanController extends Controller
{
    public function index()
    {
        $biayatambahans = Biaya_tambahan::all();
        return view('admin/biaya_tambahan.index', compact('biayatambahans'));
    }

    public function create()
    {
        return view('admin/biaya_tambahan.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama_biaya' => 'required',
                'nominal' => 'required',
            ],
            [
                'nama_biaya.required' => 'Masukkan nama biaya',
                'nominal.required' => 'Masukkan nominal',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }
        $kode = $this->kode();
        Biaya_tambahan::create(array_merge(
            $request->all(),
            [
                'kode_biaya' => $this->kode(),
                'tanggal_awal' => Carbon::now('Asia/Jakarta'),
            ],
        ));
        return redirect('admin/biaya_tambahan')->with('success', 'Berhasil menambahkan biaya tambahan');
    }

    public function kode()
    {
        $lastBarang = Biaya_tambahan::latest()->first();
        if (!$lastBarang) {
            $num = 1;
        } else {
            $lastCode = $lastBarang->kode_biaya;
            $num = (int) substr($lastCode, strlen('BT')) + 1;
        }
        $formattedNum = sprintf("%06s", $num);
        $prefix = 'BT';
        $newCode = $prefix . $formattedNum;
        return $newCode;
    }

    public function edit($id)
    {
        $biayatambahan = Biaya_tambahan::where('id', $id)->first();
        return view('admin/biaya_tambahan.update', compact('biayatambahan'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama_biaya' => 'required',
                'nominal' => 'required',
            ],
            [
                'nama_biaya.required' => 'Masukkan nama biaya tambahan',
                'nominal.required' => 'Masukkan nominal',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }
        $biayatambahan = Biaya_tambahan::findOrFail($id);
        $biayatambahan->nama_biaya = $request->nama_biaya;
        $biayatambahan->nominal = $request->nominal;
        $biayatambahan->save();
        return redirect('admin/biaya_tambahan')->with('success', 'Berhasil memperbarui biaya tambahan');
    }

    public function destroy($id)
    {
        $biayatambahan = Biaya_tambahan::find($id);
        $biayatambahan->delete();

        return redirect('admin/biaya_tambahan')->with('success', 'Berhasil menghapus biaya tambahan');
    }
}