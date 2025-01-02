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
        // Ambil kode memo terakhir yang sesuai format 'FK%' dan kategori 'Memo Perjalanan'
        $lastBarang = Tarif_asuransi::where('kode_tarif', 'like', 'FK%')
            ->orderBy('id', 'desc')
            ->first();

        // Inisialisasi nomor urut
        $num = 1;

        // Jika ada kode terakhir, proses untuk mendapatkan nomor urut
        if ($lastBarang) {
            $lastCode = $lastBarang->kode_tarif;

            // Pastikan kode terakhir sesuai dengan format FK[YYYYMMDD][NNNN]C
            if (preg_match('/^FK(\d{6})(\d{4})C$/', $lastCode, $matches)) {
                $lastDate = $matches[1]; // Bagian tanggal: ymd (contoh: 241125)
                $lastMonth = substr($lastDate, 2, 2); // Ambil bulan dari tanggal (contoh: 11)
                $currentMonth = date('m'); // Bulan saat ini

                if ($lastMonth === $currentMonth) {
                    // Jika bulan sama, tambahkan nomor urut
                    $lastNum = (int)$matches[2]; // Bagian nomor urut (contoh: 0001)
                    $num = $lastNum + 1;
                }
            }
        }

        // Formatkan nomor urut menjadi 4 digit
        $formattedNum = sprintf("%04s", $num);

        // Buat kode baru dengan tambahan huruf C di belakang
        $prefix = 'FK';
        $kodeMemo = $prefix . date('ymd') . $formattedNum . 'C'; // Format akhir kode memo

        return $kodeMemo;
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
