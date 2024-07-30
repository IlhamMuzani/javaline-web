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

class DriverController extends Controller
{
    public function index()
    {
        $drivers = Karyawan::select('id', 'kode_karyawan', 'nama_lengkap', 'deposit', 'kasbon', 'bayar_kasbon', 'tabungan')
            ->where('departemen_id', '2')
            ->orderBy('nama_lengkap')
            ->get();
        return view('admin.driver.index', compact('drivers'));
    }


    public function show($id)
    {
        $cetakpdf = Karyawan::where('id', $id)->first();
        return view('admin/driver.show', compact('cetakpdf'));
    }

    public function cetakpdf($id)
    {
        $cetakpdf = Karyawan::where('id', $id)->first();
        $pdf = PDF::loadView('admin.driver.cetak_pdf', compact('cetakpdf'));
        $pdf->setPaper('letter', 'portrait');
        return $pdf->stream('Saldo_deposit_sopir.pdf');
    }


    public function create()
    {
        $departemens = Departemen::all();
        return view('admin/driver.create', compact('departemens'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'no_ktp' => 'required',
                'no_sim' => 'required',
                'nama_lengkap' => 'required',
                'nama_kecil' => 'required',
                'gender' => 'required',
                'tanggal_lahir' => 'required',
                'tanggal_gabung' => 'required',
                // 'jabatan' => 'required',
                'telp' => 'required',
                'alamat' => 'required',
                'gambar' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            ],
            [
                'no_ktp.required' => 'Masukkan no ktp',
                'no_sim.required' => 'Masukkan no sim',
                'nama_lengkap.required' => 'Masukkan nama lengkap',
                'nama_kecil.required' => 'Masukkan nama kecil',
                'gender.required' => 'Pilih gender',
                'tanggal_lahir.required' => 'Masukkan tanggal lahir',
                'tanggal_gabung.required' => 'Masukkan tanggal gabung',
                // 'jabatan.required' => 'Pilih jabatan',
                'telp.required' => 'Masukkan no telepon',
                'alamat.required' => 'Masukkan alamat',
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
        Karyawan::create(array_merge(
            $request->all(),
            [
                'gambar' => $namaGambar,
                'tanggal_keluar' => '-',
                'departemen_id' => 2,
                'gaji' => 0,
                'pembayaran' => 0,
                'tabungan' => 0,
                'kasbon' => 0,
                'bayar_kasbon' => 0,
                'deposit' => 0,
                'bayar_kasbon' => 0,
                'pembayaran' => 0,
                'status' => 'null',
                'kode_karyawan' => $this->kode(),
                'qrcode_karyawan' => 'https://javaline.id/karyawan/' . $kode,
                'tanggal' => Carbon::now('Asia/Jakarta'),

            ]
        ));

        return redirect('admin/driver')->with('success', 'Berhasil menambahkan driver');
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
        $prefix = 'AD';
        $newCode = $prefix . $formattedNum;
        return $newCode;
    }

    public function edit($id)
    {
        $drivers = Karyawan::where('id', $id)->first();
        return view('admin/driver.update', compact('drivers'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'tabungan' => 'required',
            ],
            [
                'tabungan.required' => 'Masukkan deposit Driver',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $karyawan = Karyawan::findOrFail($id);

        $karyawan->deposit = $request->deposit;
        $karyawan->kasbon = $request->kasbon;
        $karyawan->bayar_kasbon = $request->bayar_kasbon;
        $karyawan->tabungan = $request->tabungan;
        $karyawan->nama_bank = $request->nama_bank;
        $karyawan->atas_nama = $request->atas_nama;
        $karyawan->norek = $request->norek;
        $karyawan->save();

        return redirect('admin/driver')->with('success', 'Berhasil mengubah deposit');
    }

    public function print_sopir(Request $request)
    {
        $inquery
            = Karyawan::where('departemen_id', '2')
            ->orderBy('nama_lengkap')
            ->get();
        $pdf = PDF::loadView('admin.driver.print', compact('inquery'));
        return $pdf->stream('Deposit_Sopir.pdf');
    }

    public function rekapexport()
    {
        $filename = 'rekap_transaksi.xlsx';
        return Excel::download(new RekapExport(), $filename);
    }
}