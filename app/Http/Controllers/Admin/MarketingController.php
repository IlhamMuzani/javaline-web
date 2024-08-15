<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Departemen;
use App\Models\Karyawan;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RekapExport;
use Illuminate\Support\Facades\Storage;

class MarketingController extends Controller
{
    public function index()
    {
        $marketings = Karyawan::with('departemen')
            ->select('id', 'kode_karyawan', 'nama_lengkap', 'alamat', 'telp', 'departemen_id')
            ->where('departemen_id', '4')
            ->orderBy('nama_lengkap')
            ->get();

        return view('admin.marketing.index', compact('marketings'));
    }


    public function show($id)
    {
        $cetakpdf = Karyawan::where('id', $id)->first();
        return view('admin/marketing.show', compact('cetakpdf'));
    }

    public function create()
    {
        $departemens = Departemen::all();
        return view('admin.marketing.create', compact('departemens'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama_lengkap' => 'required',
                'telp' => 'required',
                'gambar' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            ],
            [
                'nama_lengkap.required' => 'Masukkan nama lengkap',
                'telp.required' => 'Masukkan no telepon',
                'gambar.image' => 'Gambar yang dimasukan salah!',
            ]
        );

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return back()->withInput()->with('error', $errors);
        }
        if ($request->gambar) {
            $gambar = str_replace(' ', '', $request->gambar->getClientOriginalName());
            $namaGambar = 'karyawan/' . date('mYdHs') . rand(1, 10) . '_' . $gambar;
            $request->gambar->storeAs('public/uploads/', $namaGambar);
        } else {
            $namaGambar = '';
        }
        $kode = $this->kode();
        Karyawan::create([
            'departemen_id' => '4',
            'no_ktp' => $request->no_ktp,
            'no_sim' => $request->no_sim,
            'nama_lengkap' => $request->nama_lengkap,
            'nama_kecil' => $request->nama_kecil,
            'gender' => $request->gender,
            'tanggal_lahir' => $request->tanggal_lahir,
            'tanggal_gabung' => $request->tanggal_gabung,
            'telp' => $request->telp,
            'alamat' => $request->alamat,
            'nama_bank' => $request->nama_bank,
            'atas_nama' => $request->atas_nama,
            'norek' => $request->norek,
            'gambar' => $namaGambar,
            'gaji' => 0,
            'pembayaran' => 0,
            'tabungan' => 0,
            'kasbon' => 0,
            'bayar_kasbon' => 0,
            'deposit' => 0,
            'status' => 'null',
            'kode_karyawan' => $kode,
            'qrcode_karyawan' => 'https://javaline.id/karyawan/' . $kode,
            'tanggal' => Carbon::now('Asia/Jakarta'),
        ]);

        return redirect('admin/marketing')->with('success', 'Berhasil menambahkan marketing');
    }

    public function kode()
    {
        $lastBarang = Karyawan::latest()->first();
        if (!$lastBarang) {
            $num = 1;
        } else {
            $lastCode = $lastBarang->kode_karyawan;
            $num = (int) substr($lastCode, strlen('FE')) + 1;
        }
        $formattedNum = sprintf("%06s", $num);
        $prefix = 'AA';
        $newCode = $prefix . $formattedNum;
        return $newCode;
    }

    public function edit($id)
    {
        $marketing = Karyawan::where('id', $id)->first();
        return view('admin/marketing.update', compact('marketing'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama_lengkap' => 'required',
            ],
            [
                'nama_lengkap.required' => 'Masukkan nama marketing',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $karyawan = Karyawan::findOrFail($id);

        if ($request->gambar) {
            Storage::disk('local')->delete('public/uploads/' . $karyawan->gambar);
            $gambar = str_replace(' ', '', $request->gambar->getClientOriginalName());
            $namaGambar = 'karyawan/' . date('mYdHs') . rand(1, 10) . '_' . $gambar;
            $request->gambar->storeAs('public/uploads/', $namaGambar);
        } else {
            $namaGambar = $karyawan->gambar;
        }

        $karyawan->no_ktp = $request->no_ktp;
        $karyawan->no_sim = $request->no_sim;
        $karyawan->nama_lengkap = $request->nama_lengkap;
        $karyawan->nama_kecil = $request->nama_kecil;
        $karyawan->gender = $request->gender;
        $karyawan->tanggal_lahir = $request->tanggal_lahir;
        $karyawan->tanggal_gabung = $request->tanggal_gabung;
        $karyawan->telp = $request->telp;
        $karyawan->alamat = $request->alamat;
        $karyawan->nama_bank = $request->nama_bank;
        $karyawan->atas_nama = $request->atas_nama;
        $karyawan->norek = $request->norek;
        $karyawan->gambar = $namaGambar;
        $karyawan->tanggal_awal = Carbon::now('Asia/Jakarta');
        $karyawan->save();


        return redirect('admin/marketing')->with('success', 'Berhasil mengubah marketing');
    }

    public function destroy($id)
    {
        $karyawan = Karyawan::find($id);
        $karyawan->user()->delete();
        $karyawan->delete();

        return redirect('admin/marketing')->with('success', 'Berhasil menghapus karyawan');
    }
}
