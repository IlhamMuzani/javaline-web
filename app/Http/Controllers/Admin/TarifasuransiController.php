<?php

namespace App\Http\Controllers\admin;

use Carbon\Carbon;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use App\Models\Tarif_asuransi;
use App\Models\Vendor;
use Illuminate\Support\Facades\Validator;

class TarifasuransiController extends Controller
{
    public function index()
    {
        // if (auth()->check() && auth()->user()->menu['rute perjalanan']) {
        $tarifs = Tarif_asuransi::get();
        return view('admin/tarif_asuransi.index', compact('tarifs'));
        // } else {
        //     // tidak memiliki akses
        //     return back()->with('error', array('Anda tidak memiliki akses'));
        // }
    }

    public function create()
    {
        // if (auth()->check() && auth()->user()->menu['rute perjalanan']) {

        return view('admin/tarif_asuransi.create');
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
                'persen' => 'required',
            ],
            [
                'nama_tarif.required' => 'Masukkan nama tarif asuransi',
                'persen.required' => 'Masukkan tarif asuransi',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $kode = $this->kode();

        Tarif_asuransi::create(array_merge(
            $request->all(),
            [
                'kode_tarif' => $this->kode(),
                'nama_tarif' => $request->nama_tarif,
                'persen' => str_replace(',', '.', str_replace('.', '', $request->persen)),
                // 'qrcode_rute' => 'https://javaline.id/tarif_asuransi/' . $kode,
                'tanggal_awal' => Carbon::now('Asia/Jakarta'),
            ],
        ));

        return redirect('admin/tarif-asuransi')->with('success', 'Berhasil menambahkan tarif asuransi');
    }


    public function kode()
    {
        // Ambil tarif_asuransi terakhir yang kodenya dimulai dengan 'HS'
        $lastBarang = Tarif_asuransi::where('kode_tarif', 'LIKE', 'TA%')->latest('id')->first();

        // Jika tidak ada tarif_asuransi dalam database dengan awalan 'HS'
        if (!$lastBarang) {
            $num = 1;
        } else {
            // Ambil kode tarif_asuransi terakhir
            $lastCode = $lastBarang->kode_tarif;

            // Ambil angka setelah awalan 'TF'
            $num = (int) substr($lastCode, 2) + 1;
        }

        // Format nomor dengan panjang 6 digit (misalnya, 000001)
        $formattedNum = sprintf("%06s", $num);

        // Tentukan awalan kode
        $prefix = 'TA';

        // Gabungkan awalan dengan nomor yang diformat untuk mendapatkan kode baru
        $newCode = $prefix . $formattedNum;

        return $newCode;
    }

    public function edit($id)
    {
        // if (auth()->check() && auth()->user()->menu['rute perjalanan']) {
        $tarifs = Tarif_asuransi::where('id', $id)->first();


        return view('admin/tarif_asuransi.update', compact('tarifs'));
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
                'persen' => 'required',
            ],
            [
                'nama_tarif.required' => 'Masukkan nama tarif asuransi',
                'persen.required' => 'Masukkan tarif asuransi',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $tarifs = Tarif_asuransi::findOrFail($id);

        $tarifs->nama_tarif = $request->nama_tarif;
        $tarifs->persen = str_replace(',', '.', str_replace('.', '', $request->persen));

        $tarifs->save();

        return redirect('admin/tarif-asuransi')->with('success', 'Berhasil memperbarui tarif asuransi');
    }

    public function destroy($id)
    {
        $tarifs = Tarif_asuransi::find($id);
        $tarifs->delete();

        return redirect('admin/tarif-asuransi')->with('success', 'Berhasil menghapus tarif asuransi');
    }
}