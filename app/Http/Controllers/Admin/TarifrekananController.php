<?php

namespace App\Http\Controllers\admin;

use Carbon\Carbon;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Vendor;
use App\Models\Tarif;
use Illuminate\Support\Facades\Validator;

class TarifrekananController extends Controller
{
    public function index()
    {
        // if (auth()->check() && auth()->user()->menu['rute perjalanan']) {
        $tarifs = Tarif::where('pelanggan_id', null)->orderBy('created_at', 'DESC')->get();
        return view('admin/tarif_rekanan.index', compact('tarifs'));
        // } else {
        //     // tidak memiliki akses
        //     return back()->with('error', array('Anda tidak memiliki akses'));
        // }
    }

    public function create()
    {
        // if (auth()->check() && auth()->user()->menu['rute perjalanan']) {
        $vendors = Vendor::all();

        return view('admin/tarif_rekanan.create', compact('vendors'));
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
                'vendor_id.required' => 'Pilih nama rekanan',
                'nama_tarif.required' => 'Masukkan nama tarif rekanan',
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
                // 'qrcode_rute' => 'https://javaline.id/tarif_rekanan/' . $kode,
                'tanggal_awal' => Carbon::now('Asia/Jakarta'),
            ],
        ));

        return redirect('admin/tarif_rekanan')->with('success', 'Berhasil menambahkan tarif rekanan');
    }


    public function kode()
    {
        // Ambil tarif_rekanan terakhir yang kodenya dimulai dengan 'HS'
        $lastBarang = Tarif::where('kode_tarif', 'LIKE', 'TF%')->latest('id')->first();

        // Jika tidak ada tarif_rekanan dalam database dengan awalan 'HS'
        if (!$lastBarang) {
            $num = 1;
        } else {
            // Ambil kode tarif_rekanan terakhir
            $lastCode = $lastBarang->kode_tarif;

            // Ambil angka setelah awalan 'TF'
            $num = (int) substr($lastCode, 2) + 1;
        }

        // Format nomor dengan panjang 6 digit (misalnya, 000001)
        $formattedNum = sprintf("%06s", $num);

        // Tentukan awalan kode
        $prefix = 'TF';

        // Gabungkan awalan dengan nomor yang diformat untuk mendapatkan kode baru
        $newCode = $prefix . $formattedNum;

        return $newCode;
    }

    public function edit($id)
    {
        // if (auth()->check() && auth()->user()->menu['rute perjalanan']) {
        $tarifs = Tarif::where('id', $id)->first();
        $vendors = Vendor::all();


        return view('admin/tarif_rekanan.update', compact('tarifs', 'vendors'));
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
                'vendor_id.required' => 'Pilih nama rekanan',
                'nama_tarif.required' => 'Masukkan nama tarif rekanan',
                'nominal.required' => 'Masukkan nominal',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $tarifs = Tarif::findOrFail($id);

        $tarifs->vendor_id = $request->vendor_id;
        $tarifs->vendor_id = $request->vendor_id;
        $tarifs->nama_tarif = $request->nama_tarif;
        $tarifs->nominal = str_replace(',', '.', str_replace('.', '', $request->nominal));

        $tarifs->save();

        return redirect('admin/tarif_rekanan')->with('success', 'Berhasil memperbarui tarif rekanan');
    }

    public function destroy($id)
    {
        $tarifs = Tarif::find($id);
        $tarifs->delete();

        return redirect('admin/tarif_rekanan')->with('success', 'Berhasil menghapus tarif rekanan');
    }
}