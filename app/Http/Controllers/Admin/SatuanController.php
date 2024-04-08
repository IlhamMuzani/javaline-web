<?php

namespace App\Http\Controllers\admin;

use Carbon\Carbon;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Satuan;
use Illuminate\Support\Facades\Validator;

class SatuanController extends Controller
{
    public function index()
    {
        // if (auth()->check() && auth()->user()->menu['rute perjalanan']) {
        $satuans = Satuan::all();
        return view('admin/satuan.index', compact('satuans'));
        // } else {
        //     // tidak memiliki akses
        //     return back()->with('error', array('Anda tidak memiliki akses'));
        // }
    }

    public function create()
    {
        // if (auth()->check() && auth()->user()->menu['rute perjalanan']) {

        return view('admin/satuan.create');
        // } else {
        //     // tidak memiliki akses
        //     return back()->with('error', array('Anda tidak memiliki akses'));
        // }
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'kode_satuan' => 'required',
                'nama_satuan' => 'required',
                'nominal' => 'required',
            ],
            [
                'kode_satuan.required' => 'Masukkan kode satuan',
                'nama_satuan.required' => 'Masukkan nama satuan',
                'nominal.required' => 'Masukkan nominal',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        Satuan::create(array_merge(
            $request->all(),
            [
                // 'qrcode_rute' => 'https://javaline.id/rute_perjalanan/' . $kode,
                'tanggal_awal' => Carbon::now('Asia/Jakarta'),
            ],
        ));

        return redirect('admin/satuan')->with('success', 'Berhasil menambahkan biaya tambahan');
    }


    public function edit($id)
    {
        // if (auth()->check() && auth()->user()->menu['rute perjalanan']) {
        $satuans = Satuan::where('id', $id)->first();

        return view('admin/satuan.update', compact('satuans'));
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
                'kode_satuan' => 'required',
                'nama_satuan' => 'required',
                'nominal' => 'required',
            ],
            [
                'kode_satuan.required' => 'Masukkan kode',
                'nama_satuan.required' => 'Masukkan nama satuan',
                'nominal.required' => 'Masukkan nominal',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $satuans = Satuan::findOrFail($id);

        $satuans->kode_satuan = $request->kode_satuan;
        $satuans->nama_satuan = $request->nama_satuan;
        $satuans->nominal = $request->nominal;

        $satuans->save();

        return redirect('admin/satuan')->with('success', 'Berhasil memperbarui satuan');
    }

    public function destroy($id)
    {
        $satuans = Satuan::find($id);
        $satuans->delete();

        return redirect('admin/satuan')->with('success', 'Berhasil menghapus satuan');
    }
}