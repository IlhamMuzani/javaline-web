<?php

namespace App\Http\Controllers\admin;

use Carbon\Carbon;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Potongan_memo;
use Illuminate\Support\Facades\Validator;

class PotonganmemoController extends Controller
{
    public function index()
    {
        // if (auth()->check() && auth()->user()->menu['rute perjalanan']) {
        $potonganmemos = Potongan_memo::all();
        return view('admin/potongan_memo.index', compact('potonganmemos'));
        // } else {
        //     // tidak memiliki akses
        //     return back()->with('error', array('Anda tidak memiliki akses'));
        // }
    }

    public function create()
    {
        // if (auth()->check() && auth()->user()->menu['rute perjalanan']) {

        return view('admin/potongan_memo.create');
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
                'keterangan' => 'required',
                'nominal' => 'required',
            ],
            [
                'keterangan.required' => 'Masukkan keterangan',
                'nominal.required' => 'Masukkan nominal',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $kode = $this->kode();

        Potongan_memo::create(array_merge(
            $request->all(),
            [
                'kode_potongan' => $this->kode(),
                // 'qrcode_rute' => 'https://javaline.id/rute_perjalanan/' . $kode,
                'tanggal_awal' => Carbon::now('Asia/Jakarta'),
            ],
        ));

        return redirect('admin/potongan_memo')->with('success', 'Berhasil menambahkan biaya tambahan');
    }


    // public function kode()
    // {
    //     $type = Potongan_memo::all();
    //     if ($type->isEmpty()) {
    //         $num = "000001";
    //     } else {
    //         $id = Potongan_memo::getId();
    //         foreach ($id as $value);
    //         $idlm = $value->id;
    //         $idbr = $idlm + 1;
    //         $num = sprintf("%06s", $idbr);
    //     }

    //     $data = 'PM';
    //     $kode_type = $data . $num;
    //     return $kode_type;
    // }

    public function kode()
    {
        $lastBarang = Potongan_memo::latest()->first();
        if (!$lastBarang) {
            $num = 1;
        } else {
            $lastCode = $lastBarang->kode_potongan;
            $num = (int) substr($lastCode, strlen('PM')) + 1;
        }
        $formattedNum = sprintf("%06s", $num);
        $prefix = 'PM';
        $newCode = $prefix . $formattedNum;
        return $newCode;
    }

    public function edit($id)
    {
        // if (auth()->check() && auth()->user()->menu['rute perjalanan']) {
        $potonganmemos = Potongan_memo::where('id', $id)->first();

        return view('admin/potongan_memo.update', compact('potonganmemos'));
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
                'keterangan' => 'required',
                'nominal' => 'required',
            ],
            [
                'keterangan.required' => 'Masukkan keterangan',
                'nominal.required' => 'Masukkan nominal',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $potonganmemos = Potongan_memo::findOrFail($id);

        $potonganmemos->keterangan = $request->keterangan;
        $potonganmemos->nominal = $request->nominal;

        $potonganmemos->save();

        return redirect('admin/potongan_memo')->with('success', 'Berhasil memperbarui potongan memo');
    }

    public function destroy($id)
    {
        $potonganmemos = Potongan_memo::find($id);
        $potonganmemos->delete();

        return redirect('admin/potongan_memo')->with('success', 'Berhasil menghapus potongan memo');
    }
}