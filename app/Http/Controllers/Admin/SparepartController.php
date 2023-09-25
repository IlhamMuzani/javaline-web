<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Sparepart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class SparepartController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->check() && auth()->user()->menu['part']) {

            // $sparepart = Sparepart::all();
            $kategori = $request->kategori;

            $inquery = Sparepart::query();

            if ($kategori) {
                $inquery->where('kategori', $kategori);
            }

            $inquery->orderBy('id', 'DESC');
            $sparepart = $inquery->get();

            return view('admin/sparepart.index', compact('sparepart'));
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }

    public function create()
    {
        if (auth()->check() && auth()->user()->menu['part']) {

            return view('admin/sparepart.create');
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'kategori' => 'required',
                'nama_barang' => 'required',
                'keterangan' => 'required',
                'harga' => 'required',
                'jumlah' => 'required',
                'satuan' => 'required',
            ],
            [
                'kategori.required' => 'Pilih kategori',
                'nama_barang.required' => 'Masukkan nama barang',
                'keterangan.required' => 'Masukkan keterangan',
                'harga_jual.required' => 'Masukkan harga jual',
                'jumlah.required' => 'Masukkan stok',
                'satuan.required' => 'Masukkan satuan',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }
        
        $kode = '';
        if ($request->kategori === 'oli') {
            $kode = $this->kodeoli();
        } elseif ($request->kategori === 'mesin') {
            $kode = $this->kodemesin();
        } elseif ($request->kategori === 'body') {
            $kode = $this->kodebody();
        } elseif ($request->kategori === 'sasis') {
            $kode = $this->kodesasis();
        }
        Sparepart::create(array_merge(
            $request->all(),
            [
                'kode_partdetail' => $kode,
                // 'qrcode_barang' => 'http://192.168.1.46/javaline/barang/' . $kode
                'qrcode_barang' => 'https:///javaline.id/barang/' . $kode,
                'tanggal_awal' => Carbon::now('Asia/Jakarta'),

            ],
        ));

        return redirect('admin/sparepart')->with('success', 'Berhasil menambahkan part');
    }

    public function kodeoli()
    {
        $part = Sparepart::all();
        if ($part->isEmpty()) {
            $num = "000001";
        } else {
            $id = Sparepart::getId();
            foreach ($id as $value);
            $idlm = $value->id;
            $idbr = $idlm + 1;
            $num = sprintf("%06s", $idbr);
        }

        $data = 'SO';
        $kode_part = $data . $num;
        return $kode_part;
    }

    public function kodebody()
    {
        $part = Sparepart::all();
        if ($part->isEmpty()) {
            $num = "000001";
        } else {
            $id = Sparepart::getId();
            foreach ($id as $value);
            $idlm = $value->id;
            $idbr = $idlm + 1;
            $num = sprintf("%06s", $idbr);
        }

        $data = 'SB';
        $kode_part = $data . $num;
        return $kode_part;
    }

    public function kodemesin()
    {
        $part = Sparepart::all();
        if ($part->isEmpty()) {
            $num = "000001";
        } else {
            $id = Sparepart::getId();
            foreach ($id as $value);
            $idlm = $value->id;
            $idbr = $idlm + 1;
            $num = sprintf("%06s", $idbr);
        }

        $data = 'SM';
        $kode_part = $data . $num;
        return $kode_part;
    }

    public function kodesasis()
    {
        $part = Sparepart::all();
        if ($part->isEmpty()) {
            $num = "000001";
        } else {
            $id = Sparepart::getId();
            foreach ($id as $value);
            $idlm = $value->id;
            $idbr = $idlm + 1;
            $num = sprintf("%06s", $idbr);
        }

        $data = 'SS';
        $kode_part = $data . $num;
        return $kode_part;
    }

    
    public function edit($id)
    {
        $part = Sparepart::where('id', $id)->first();

        return view('admin/sparepart/update', compact('part'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'kategori' => 'required',
                'nama_barang' => 'required',
                'keterangan' => 'required',
                'harga' => 'required',
                'jumlah' => 'required',
                'satuan' => 'required',
            ],
            [
                'kategori.required' => 'Pilih kategori',
                'nama_barang.required' => 'Masukkan nama barang',
                'keterangan.required' => 'Masukkan keterangan',
                'harga.required' => 'Masukkan harga',
                'jumlah.required' => 'Masukkan stok',
                'satuan.required' => 'Masukkan satuan',
            ]
        );

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return back()->withInput()->with('error', $errors);
        }

        $part = Sparepart::findOrFail($id);

        Sparepart::where('id', $part->id)->update(
            [
                'kategori' => $request->kategori,
                'nama_barang' => $request->nama_barang,
                'keterangan' => $request->keterangan,
                'harga' => $request->harga,
                'jumlah' => $request->jumlah,
                'satuan' => $request->satuan,
                'tanggal_awal' => Carbon::now('Asia/Jakarta'),
            ]
        );
        return redirect('admin/sparepart')->with('success', 'Berhasil memperbarui part');
    }

    public function destroy($id)
    {
        $part = Sparepart::find($id);
        $part->delete();

        return redirect('admin/sparepart')->with('success', 'Berhasil menghapus Sparepart');
    }
}