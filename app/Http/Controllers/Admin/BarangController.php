<?php

namespace App\Http\Controllers\admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Barang;
use Illuminate\Support\Facades\Validator;

class BarangController extends Controller
{
    public function index()
    {
        $barangs = Barang::all();
        return view('admin/barang.index', compact('barangs'));
    }

    public function create()
    {
        return view('admin/barang.create');
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
                'jumlah' => '0',
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
        $barangs = Barang::where('id', $id)->first();
        return view('admin/barang.update', compact('barangs'));
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