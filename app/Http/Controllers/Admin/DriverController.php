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

class DriverController extends Controller
{
    public function index()
    {
        $drivers = Karyawan::select('id', 'kode_karyawan', 'nama_lengkap', 'deposit', 'kasbon', 'bayar_kasbon', 'tabungan', 'telp')
            ->where('departemen_id', '2')
            ->orderBy('nama_lengkap')
            ->get();
        return view('admin.driver.index', compact('drivers'));
    }


    // public function show($id)
    // {
    //     $karyawan = Karyawan::where('id', $id)->first();
    //     return view('admin/driver.show', compact('karyawan'));
    // }

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

        $namaGambar2 = '';
        if ($request->hasFile('ft_ktp')) {
            $ft_ktp = str_replace(' ', '', $request->ft_ktp->getClientOriginalName());
            $namaGambar2 = 'karyawan/' . date('mYdHs') . rand(1, 10) . '_' . $ft_ktp;
            $request->ft_ktp->storeAs('public/uploads/', $namaGambar2);
        }

        $namaGambar3 = '';
        if ($request->hasFile('ft_sim')) {
            $ft_sim = str_replace(' ', '', $request->ft_sim->getClientOriginalName());
            $namaGambar3 = 'karyawan/' . date('mYdHs') . rand(1, 10) . '_' . $ft_sim;
            $request->ft_sim->storeAs('public/uploads/', $namaGambar3);
        }

        $namaGambar4 = '';
        if ($request->hasFile('ft_kk')) {
            $ft_kk = str_replace(' ', '', $request->ft_kk->getClientOriginalName());
            $namaGambar4 = 'ft_kk/' . date('mYdHs') . rand(1, 10) . '_' . $ft_kk;
            $request->ft_kk->storeAs('public/uploads/', $namaGambar4);
        }

        $namaGambar5 = '';
        if ($request->hasFile('ft_kk_penjamin')) {
            $ft_kk_penjamin = str_replace(' ', '', $request->ft_kk_penjamin->getClientOriginalName());
            $namaGambar5 = 'ft_kk_penjamin/' . date('mYdHs') . rand(1, 10) . '_' . $ft_kk_penjamin;
            $request->ft_kk_penjamin->storeAs('public/uploads/', $namaGambar5);
        }

        $namaGambar6 = '';
        if ($request->hasFile('ft_skck')) {
            $ft_skck = str_replace(' ', '', $request->ft_skck->getClientOriginalName());
            $namaGambar6 = 'ft_skck/' . date('mYdHs') . rand(1, 10) . '_' . $ft_skck;
            $request->ft_skck->storeAs('public/uploads/', $namaGambar6);
        }

        $namaGambar7 = '';
        if ($request->hasFile('ft_surat_pernyataan')) {
            $ft_surat_pernyataan = str_replace(' ', '', $request->ft_surat_pernyataan->getClientOriginalName());
            $namaGambar7 = 'ft_surat_pernyataan/' . date('mYdHs') . rand(1, 10) . '_' . $ft_surat_pernyataan;
            $request->ft_surat_pernyataan->storeAs('public/uploads/', $namaGambar7);
        }

        $namaGambar8 = '';
        if ($request->hasFile('ft_terbaru')) {
            $ft_terbaru = str_replace(' ', '', $request->ft_terbaru->getClientOriginalName());
            $namaGambar8 = 'ft_terbaru/' . date('mYdHs') . rand(1, 10) . '_' . $ft_terbaru;
            $request->ft_terbaru->storeAs('public/uploads/', $namaGambar8);
        }

        $namaGambar9 = '';
        if ($request->hasFile('ft_rumah')) {
            $ft_rumah = str_replace(' ', '', $request->ft_rumah->getClientOriginalName());
            $namaGambar9 = 'ft_rumah/' . date('mYdHs') . rand(1, 10) . '_' . $ft_rumah;
            $request->ft_rumah->storeAs('public/uploads/', $namaGambar9);
        }

        $namaGambar10 = '';
        if ($request->hasFile('ft_penjamin')) {
            $ft_penjamin = str_replace(' ', '', $request->ft_penjamin->getClientOriginalName());
            $namaGambar10 = 'ft_penjamin/' . date('mYdHs') . rand(1, 10) . '_' . $ft_penjamin;
            $request->ft_penjamin->storeAs('public/uploads/', $namaGambar10);
        }

        $kode = $this->kode();
        Karyawan::create(array_merge(
            $request->all(),
            [
                'gambar' => $namaGambar,
                'ft_ktp' => $namaGambar2,
                'ft_sim' => $namaGambar3,
                'ft_kk' => $namaGambar4,
                'ft_kk_penjamin' => $namaGambar5,
                'ft_skck' => $namaGambar6,
                'ft_surat_pernyataan' => $namaGambar7,
                'ft_terbaru' => $namaGambar8,
                'ft_rumah' => $namaGambar9,
                'ft_penjamin' => $namaGambar10,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
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
            $num = (int) substr($lastCode, strlen('ADR')) + 1;
        }
        $formattedNum = sprintf("%06s", $num);
        $prefix = 'ADR';
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
        // $validator = Validator::make(
        //     $request->all(),
        //     [
        //         'tabungan' => 'required',
        //     ],
        //     [
        //         'tabungan.required' => 'Masukkan deposit Driver',
        //     ]
        // );

        // if ($validator->fails()) {
        //     $error = $validator->errors()->all();
        //     return back()->withInput()->with('error', $error);
        // }

        $karyawan = Karyawan::findOrFail($id);

        if ($request->gambar) {
            Storage::disk('local')->delete('public/uploads/' . $karyawan->gambar);
            $gambar = str_replace(' ', '', $request->gambar->getClientOriginalName());
            $namaGambar = 'karyawan/' . date('mYdHs') . rand(1, 10) . '_' . $gambar;
            $request->gambar->storeAs('public/uploads/', $namaGambar);
        } else {
            $namaGambar = $karyawan->gambar;
        }

        if ($request->ft_ktp) {
            Storage::disk('local')->delete('public/uploads/' . $karyawan->ft_ktp);
            $ft_ktp = str_replace(' ', '', $request->ft_ktp->getClientOriginalName());
            $namaGambar2 = 'karyawan/' . date('mYdHs') . rand(1, 10) . '_' . $ft_ktp;
            $request->ft_ktp->storeAs('public/uploads/', $namaGambar2);
        } else {
            $namaGambar2 = $karyawan->ft_ktp;
        }

        if ($request->ft_sim) {
            Storage::disk('local')->delete('public/uploads/' . $karyawan->ft_sim);
            $ft_sim = str_replace(' ', '', $request->ft_sim->getClientOriginalName());
            $namaGambar3 = 'karyawan/' . date('mYdHs') . rand(1, 10) . '_' . $ft_sim;
            $request->ft_sim->storeAs('public/uploads/', $namaGambar3);
        } else {
            $namaGambar3 = $karyawan->ft_sim;
        }

        if ($request->ft_kk) {
            Storage::disk('local')->delete('public/uploads/' . $karyawan->ft_kk);
            $ft_kk = str_replace(' ', '', $request->ft_kk->getClientOriginalName());
            $namaGambar4 = 'ft_kk/' . date('mYdHs') . rand(1, 10) . '_' . $ft_kk;
            $request->ft_kk->storeAs('public/uploads/', $namaGambar4);
        } else {
            $namaGambar4 = $karyawan->ft_kk;
        }

        if ($request->ft_kk_penjamin) {
            Storage::disk('local')->delete('public/uploads/' . $karyawan->ft_kk_penjamin);
            $ft_kk_penjamin = str_replace(' ', '', $request->ft_kk_penjamin->getClientOriginalName());
            $namaGambar5 = 'ft_kk_penjamin/' . date('mYdHs') . rand(1, 10) . '_' . $ft_kk_penjamin;
            $request->ft_kk_penjamin->storeAs('public/uploads/', $namaGambar5);
        } else {
            $namaGambar5 = $karyawan->ft_kk_penjamin;
        }

        if ($request->ft_skck) {
            Storage::disk('local')->delete('public/uploads/' . $karyawan->ft_skck);
            $ft_skck = str_replace(' ', '', $request->ft_skck->getClientOriginalName());
            $namaGambar6 = 'ft_skck/' . date('mYdHs') . rand(1, 10) . '_' . $ft_skck;
            $request->ft_skck->storeAs('public/uploads/', $namaGambar6);
        } else {
            $namaGambar6 = $karyawan->ft_skck;
        }

        if ($request->ft_surat_pernyataan) {
            Storage::disk('local')->delete('public/uploads/' . $karyawan->ft_surat_pernyataan);
            $ft_surat_pernyataan = str_replace(' ', '', $request->ft_surat_pernyataan->getClientOriginalName());
            $namaGambar7 = 'ft_surat_pernyataan/' . date('mYdHs') . rand(1, 10) . '_' . $ft_surat_pernyataan;
            $request->ft_surat_pernyataan->storeAs('public/uploads/', $namaGambar7);
        } else {
            $namaGambar7 = $karyawan->ft_surat_pernyataan;
        }

        if ($request->ft_terbaru) {
            Storage::disk('local')->delete('public/uploads/' . $karyawan->ft_terbaru);
            $ft_terbaru = str_replace(' ', '', $request->ft_terbaru->getClientOriginalName());
            $namaGambar8 = 'ft_terbaru/' . date('mYdHs') . rand(1, 10) . '_' . $ft_terbaru;
            $request->ft_terbaru->storeAs('public/uploads/', $namaGambar8);
        } else {
            $namaGambar8 = $karyawan->ft_terbaru;
        }

        if ($request->ft_rumah) {
            Storage::disk('local')->delete('public/uploads/' . $karyawan->ft_rumah);
            $ft_rumah = str_replace(' ', '', $request->ft_rumah->getClientOriginalName());
            $namaGambar9 = 'ft_rumah/' . date('mYdHs') . rand(1, 10) . '_' . $ft_rumah;
            $request->ft_rumah->storeAs('public/uploads/', $namaGambar9);
        } else {
            $namaGambar9 = $karyawan->ft_rumah;
        }

        if ($request->ft_penjamin) {
            Storage::disk('local')->delete('public/uploads/' . $karyawan->ft_penjamin);
            $ft_penjamin = str_replace(' ', '', $request->ft_penjamin->getClientOriginalName());
            $namaGambar10 = 'ft_penjamin/' . date('mYdHs') . rand(1, 10) . '_' . $ft_penjamin;
            $request->ft_penjamin->storeAs('public/uploads/', $namaGambar10);
        } else {
            $namaGambar10 = $karyawan->ft_penjamin;
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
        $karyawan->latitude = $request->latitude;
        $karyawan->longitude = $request->longitude;
        $karyawan->gambar = $namaGambar;
        $karyawan->ft_ktp = $namaGambar2;
        $karyawan->ft_sim = $namaGambar3;
        $karyawan->ft_kk = $namaGambar4;
        $karyawan->ft_kk_penjamin = $namaGambar5;
        $karyawan->ft_skck = $namaGambar6;
        $karyawan->ft_surat_pernyataan = $namaGambar7;
        $karyawan->ft_terbaru = $namaGambar8;
        $karyawan->ft_rumah = $namaGambar9;
        $karyawan->ft_penjamin = $namaGambar10;
        $karyawan->save();

        return redirect('admin/driver')->with('success', 'Berhasil mengubah deposit');
    }

    // public function update(Request $request, $id)
    // {
    //     $validator = Validator::make(
    //         $request->all(),
    //         [
    //             'tabungan' => 'required',
    //         ],
    //         [
    //             'tabungan.required' => 'Masukkan deposit Driver',
    //         ]
    //     );

    //     if ($validator->fails()) {
    //         $error = $validator->errors()->all();
    //         return back()->withInput()->with('error', $error);
    //     }

    //     $karyawan = Karyawan::findOrFail($id);

    //     $karyawan->deposit = $request->deposit;
    //     $karyawan->kasbon = $request->kasbon;
    //     $karyawan->bayar_kasbon = $request->bayar_kasbon;
    //     $karyawan->tabungan = $request->tabungan;
    //     $karyawan->nama_bank = $request->nama_bank;
    //     $karyawan->atas_nama = $request->atas_nama;
    //     $karyawan->norek = $request->norek;
    //     $karyawan->save();

    //     return redirect('admin/driver')->with('success', 'Berhasil mengubah deposit');
    // }

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