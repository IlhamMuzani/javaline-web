<?php

namespace App\Http\Controllers\admin;

use Carbon\Carbon;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tarif;
use Illuminate\Support\Facades\Validator;

class TarifController extends Controller
{
    public function index()
    {
        // if (auth()->check() && auth()->user()->menu['rute perjalanan']) {
        $tarifs = Tarif::all();
        return view('admin/tarif.index', compact('tarifs'));
        // } else {
        //     // tidak memiliki akses
        //     return back()->with('error', array('Anda tidak memiliki akses'));
        // }
    }

    public function create()
    {
        // if (auth()->check() && auth()->user()->menu['rute perjalanan']) {

        return view('admin/tarif.create');
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
                'nama_tarif' => 'required',
                'nominal' => 'required',
            ],
            [
                'nama_tarif.required' => 'Masukkan nama tarif',
                'nominal.required' => 'Masukkan nominal',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $kode = $this->kode();

        Tarif::create(array_merge(
            $request->all(),
            [
                'kode_tarif' => $this->kode(),
                // 'qrcode_rute' => 'https://javaline.id/rute_perjalanan/' . $kode,
                'tanggal_awal' => Carbon::now('Asia/Jakarta'),
            ],
        ));

        return redirect('admin/tarif')->with('success', 'Berhasil menambahkan tarif');
    }


    public function kode()
    {
        $type = Tarif::all();
        if ($type->isEmpty()) {
            $num = "000001";
        } else {
            $id = Tarif::getId();
            foreach ($id as $value);
            $idlm = $value->id;
            $idbr = $idlm + 1;
            $num = sprintf("%06s", $idbr);
        }

        $data = 'TF';
        $kode_type = $data . $num;
        return $kode_type;
    }

    public function edit($id)
    {
        // if (auth()->check() && auth()->user()->menu['rute perjalanan']) {
        $tarifs = Tarif::where('id', $id)->first();

        return view('admin/tarif.update', compact('tarifs'));
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
                'nama_tarif' => 'required',
                'nominal' => 'required',
            ],
            [
                'nama_tarif.required' => 'Masukkan nama tarif',
                'nominal.required' => 'Masukkan nominal',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $tarifs = Tarif::findOrFail($id);

        $tarifs->nama_tarif = $request->nama_tarif;
        $tarifs->nominal = $request->nominal;

        $tarifs->save();

        return redirect('admin/tarif')->with('success', 'Berhasil memperbarui tarif');
    }

    public function destroy($id)
    {
        $tarifs = Tarif::find($id);
        $tarifs->delete();

        return redirect('admin/tarif')->with('success', 'Berhasil menghapus tarif');
    }
}