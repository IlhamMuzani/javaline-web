<?php

namespace App\Http\Controllers\admin;

use Carbon\Carbon;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use App\Models\Tarif;
use App\Models\Vendor;
use Illuminate\Support\Facades\Validator;

class HargasewaController extends Controller
{
    public function index()
    {
        // if (auth()->check() && auth()->user()->menu['rute perjalanan']) {
        $harga_sewas = Tarif::where('pelanggan_id', null)->orderBy('created_at', 'DESC')->get();
        return view('admin/harga_sewa.index', compact('harga_sewas'));
        // } else {
        //     // tidak memiliki akses
        //     return back()->with('error', array('Anda tidak memiliki akses'));
        // }
    }

    public function create()
    {
        // if (auth()->check() && auth()->user()->menu['rute perjalanan']) {
        $vendors = Vendor::all();

        return view('admin/harga_sewa.create', compact('vendors'));
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
                'vendor_id' => 'required',
                'nama_tarif' => 'required',
                'nominal' => 'required',
            ],
            [
                'vendor_id.required' => 'Pilih Vendor',
                'nama_tarif.required' => 'Masukkan nama harga_sewa',
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
                // 'qrcode_rute' => 'https://javaline.id/harga_sewa/' . $kode,
                'tanggal_awal' => Carbon::now('Asia/Jakarta'),
            ],
        ));

        return redirect('admin/harga_sewa')->with('success', 'Berhasil menambahkan harga sewa');
    }


    public function kode()
    {
        // Ambil tarif terakhir yang kodenya dimulai dengan 'HS'
        $lastBarang = Tarif::where('kode_tarif', 'LIKE', 'HS%')->latest('id')->first();

        // Jika tidak ada tarif dalam database dengan awalan 'HS'
        if (!$lastBarang) {
            $num = 1;
        } else {
            // Ambil kode tarif terakhir
            $lastCode = $lastBarang->kode_tarif;

            // Ambil angka setelah awalan 'HS'
            $num = (int) substr($lastCode, 2) + 1;
        }

        // Format nomor dengan panjang 6 digit (misalnya, 000001)
        $formattedNum = sprintf("%06s", $num);

        // Tentukan awalan kode
        $prefix = 'HS';

        // Gabungkan awalan dengan nomor yang diformat untuk mendapatkan kode baru
        $newCode = $prefix . $formattedNum;

        return $newCode;
    }



    public function edit($id)
    {
        // if (auth()->check() && auth()->user()->menu['rute perjalanan']) {
        $harga_sewas = Tarif::where('id', $id)->first();
        $vendors = Vendor::all();

        return view('admin/harga_sewa.update', compact('vendors', 'harga_sewas'));
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
                'vendor_id' => 'required',
                'nama_tarif' => 'required',
                'nominal' => 'required',
            ],
            [
                'vendor_id.required' => 'Pilih nama vendor',
                'nama_tarif.required' => 'Masukkan nama harga sewa',
                'nominal.required' => 'Masukkan nominal',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $harga_sewas = Tarif::findOrFail($id);

        $harga_sewas->vendor_id = $request->vendor_id;
        $harga_sewas->nama_tarif = $request->nama_tarif;
        $harga_sewas->nominal = str_replace(',', '.', str_replace('.', '', $request->nominal));

        $harga_sewas->save();

        return redirect('admin/harga_sewa')->with('success', 'Berhasil memperbarui harga sewa');
    }

    public function destroy($id)
    {
        $harga_sewas = Tarif::find($id);
        $harga_sewas->delete();

        return redirect('admin/harga_sewa')->with('success', 'Berhasil menghapus harga sewa');
    }
}