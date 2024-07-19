<?php

namespace App\Http\Controllers\admin;

use Carbon\Carbon;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
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
        $pelanggans = Pelanggan::all();

        return view('admin/tarif.create', compact('pelanggans'));
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
                'pelanggan_id' => 'required',
                'nama_tarif' => 'required',
                'nominal' => 'required',
            ],
            [
                'pelanggan_id.required' => 'Pilih nama pelanggan',
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
                'nominal' =>str_replace(',', '.', str_replace('.', '', $request->nominal)),
                // 'qrcode_rute' => 'https://javaline.id/tarif/' . $kode,
                'tanggal_awal' => Carbon::now('Asia/Jakarta'),
            ],
        ));

        return redirect('admin/tarif')->with('success', 'Berhasil menambahkan tarif');
    }


    public function kode()
    {
        // Dapatkan kode barang terakhir
        $lastBarang = Tarif::latest()->first();
        // Jika tidak ada barang dalam database
        if (!$lastBarang) {
            $num = 1;
        } else {
            // Dapatkan nomor dari kode barang terakhir dan tambahkan 1
            $lastCode = $lastBarang->kode_tarif;
            // Ambil angka setelah huruf dengan membuang karakter awalan
            $num = (int) substr($lastCode, strlen('TF')) + 1;
        }
        // Format nomor dengan panjang 6 digit (mis. 000001)
        $formattedNum = sprintf("%06s", $num);
        // Kode awalan
        $prefix = 'TF';
        // Gabungkan kode awalan dengan nomor yang diformat
        $newCode = $prefix . $formattedNum;
        return $newCode;
    }

    public function edit($id)
    {
        // if (auth()->check() && auth()->user()->menu['rute perjalanan']) {
        $tarifs = Tarif::where('id', $id)->first();
        $pelanggans = Pelanggan::all();

        return view('admin/tarif.update', compact('tarifs', 'pelanggans'));
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
                'pelanggan_id' => 'required',
                'nama_tarif' => 'required',
                'nominal' => 'required',
            ],
            [
                'pelanggan_id.required' => 'Pilih nama pelanggan',
                'nama_tarif.required' => 'Masukkan nama tarif',
                'nominal.required' => 'Masukkan nominal',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $tarifs = Tarif::findOrFail($id);

        $tarifs->pelanggan_id = $request->pelanggan_id;
        $tarifs->nama_tarif = $request->nama_tarif;
        $tarifs->nominal = str_replace(',', '.', str_replace('.', '', $request->nominal));

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