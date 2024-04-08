<?php

namespace App\Http\Controllers\admin;

use Carbon\Carbon;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Barang;
use Illuminate\Support\Facades\Validator;

class BarangController extends Controller
{
    public function index()
    {
        // if (auth()->check() && auth()->user()->menu['rute perjalanan']) {
        $barangs = Barang::all();
        return view('admin/barang.index', compact('barangs'));
        // } else {
        //     // tidak memiliki akses
        //     return back()->with('error', array('Anda tidak memiliki akses'));
        // }
    }

    public function create()
    {
        // if (auth()->check() && auth()->user()->menu['rute perjalanan']) {

        return view('admin/barang.create');
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
                'nama_barang' => 'required',
                'harga_beli' => 'required',
            ],
            [
                'nama_barang.required' => 'Masukkan nama barang',
                'harga_beli.required' => 'Masukkan harga beli',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $kode = $this->kode();

        Barang::create(array_merge(
            $request->all(),
            [
                'kode_barang' => $this->kode(),
                // 'qrcode_rute' => 'https://javaline.id/barang/' . $kode,
                'tanggal_awal' => Carbon::now('Asia/Jakarta'),
            ],
        ));

        return redirect('admin/barang')->with('success', 'Berhasil menambahkan barang');
    }


    public function kode()
    {
        $lastBarang = Barang::latest()->first();
        if (!$lastBarang) {
            $num = 1;
        } else {
            $lastCode = $lastBarang->kode_barang;
            $num = (int) substr($lastCode, strlen('BB')) + 1;
        }
        $formattedNum = sprintf("%06s", $num);
        $prefix = 'BB';
        $newCode = $prefix . $formattedNum;
        return $newCode;
    }

    public function edit($id)
    {
        // if (auth()->check() && auth()->user()->menu['rute perjalanan']) {
        $barangs = Barang::where('id', $id)->first();

        return view('admin/barang.update', compact('barangs'));
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
                'nama_barang' => 'required',
                'harga_beli' => 'required',
            ],
            [
                'nama_barang.required' => 'Masukkan nama barang',
                'harga_beli.required' => 'Masukkan harga beli',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $barang = Barang::findOrFail($id);

        $barang->nama_barang = $request->nama_barang;
        $barang->harga_beli = $request->harga_beli;
        $barang->harga_jual = $request->harga_jual;
        $barang->jumlah = $request->jumlah;

        $barang->save();

        return redirect('admin/barang')->with('success', 'Berhasil memperbarui barang');
    }

    public function destroy($id)
    {
        $barang = Barang::find($id);
        $barang->delete();

        return redirect('admin/barang')->with('success', 'Berhasil menghapus barang');
    }
}
