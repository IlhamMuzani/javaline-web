<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Barang_akun;
use Illuminate\Support\Facades\Validator;

class BarangakunController extends Controller
{
    public function index()
    {
        // if (auth()->check() && auth()->user()->menu['akun']) {

        $barangakuns = Barang_akun::all();
        return view('admin/barangakun.index', compact('barangakuns'));

        // } else {
        //     // tidak memiliki akses
        //     return back()->with('error', array('Anda tidak memiliki akses'));
        // }
    }

    public function create()
    {
        // if (auth()->check() && auth()->user()->menu['akun']) {

        return view('admin/barangakun.create');
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
                'nama_barangakun' => 'required',
            ],
            [
                'nama_barangakun.required' => 'Masukkan nama akun',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $kode = $this->kode();

        Barang_akun::create(array_merge(
            $request->all(),
            [
                'kode_barangakun' => $this->kode(),
                'qrcode_barangakun' => 'https://javaline.id/barang_akun/' . $kode,
                'tanggal_awal' => Carbon::now('Asia/Jakarta'),

            ]
        ));

        return redirect('admin/akun')->with('success', 'Berhasil menambahkan barangakun');
    }

    public function kode()
    {
        // Dapatkan kode barang terakhir
        $lastBarang = Barang_akun::latest()->first();
        // Jika tidak ada barang dalam database
        if (!$lastBarang) {
            $num = 1;
        } else {
            // Dapatkan nomor dari kode barang terakhir dan tambahkan 1
            $lastCode = $lastBarang->kode_barangakun;
            // Ambil angka setelah huruf dengan membuang karakter awalan
            $num = (int) substr($lastCode, strlen('KA')) + 1;
        }
        // Format nomor dengan panjang 6 digit (mis. 000001)
        $formattedNum = sprintf("%06s", $num);
        // Kode awalan
        $prefix = 'KA';
        // Gabungkan kode awalan dengan nomor yang diformat
        $newCode = $prefix . $formattedNum;
        return $newCode;
    }

    public function edit($id)
    {

        // if (auth()->check() && auth()->user()->menu['akun']) {

        $barangakun = Barang_akun::where('id', $id)->first();
        return view('admin/barangakun.update', compact('barangakun'));

        // } else {
        //     // tidak memiliki akses
        //     return back()->with('error', array('Anda tidak memiliki akses'));
        // }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_barangakun' => 'required',
        ], [
            'nama_barangakun.required' => 'Nama akun tidak boleh Kosong',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $barangakun = Barang_akun::find($id);

        $barangakun->nama_barangakun = $request->nama_barangakun;
        $barangakun->tanggal_awal = Carbon::now('Asia/Jakarta');

        $barangakun->save();

        return redirect('admin/akun')->with('success', 'Berhasil memperbarui barangakun');
    }

    public function destroy($id)
    {
        $barangakun = Barang_akun::find($id);
        $barangakun->delete();

        return redirect('admin/akun')->with('success', 'Berhasil menghapus akun');
    }
}