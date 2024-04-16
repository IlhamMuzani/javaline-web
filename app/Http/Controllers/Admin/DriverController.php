<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Departemen;
use App\Models\Karyawan;
use App\Models\User;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RekapExport;

class DriverController extends Controller
{
    // public function index(Request $request)
    // {
    //     $keyword = $request->keyword;

    //     if ($keyword) {
    //         $drivers = Karyawan::where('departemen_id', '2')
    //             ->where('nama_lengkap', 'like', "%$keyword%")
    //             ->orderBy('nama_lengkap')
    //             ->paginate(10);
    //     } else {
    //         $drivers = Karyawan::where('departemen_id', '2')
    //             ->orderBy('nama_lengkap')
    //             ->paginate(10);
    //     }

    //     return view('admin.driver.index', compact('drivers'));
    // }


    public function index()
    {
        // Check for authentication and menu access if needed
        // if (auth()->check() && auth()->user()->menu['karyawan']) {

        // Fetch drivers and order them by the 'nama_lengkap' column
        $drivers = Karyawan::select('id', 'kode_karyawan', 'nama_lengkap', 'deposit', 'kasbon', 'bayar_kasbon', 'tabungan')
            ->where('departemen_id', '2')
            ->orderBy('nama_lengkap')
            ->get();

        // Return the view with the sorted drivers
        return view('admin.driver.index', compact('drivers'));

        // } else {
        //     // Redirect back with an error message if authentication or access check fails
        //     return back()->with('error', 'Anda tidak memiliki akses');
        // }
    }


    public function show($id)
    {
        // if (auth()->check() && auth()->user()->menu['karyawan']) {

        $karyawan = Karyawan::where('id', $id)->first();
        return view('admin/driver.show', compact('karyawan'));
        // } else {
        //     // tidak memiliki akses
        //     return back()->with('error', array('Anda tidak memiliki akses'));
        // }
    }

    public function create()
    {
        // if (auth()->check() && auth()->user()->menu['karyawan']) {
        $departemens = Departemen::all();
        return view('admin/driver.create', compact('departemens'));
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
                // 'qrcode_karyawan' => 'http://192.168.1.46/javaline/karyawan/' . $kode
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

    // public function kode()
    // {
    //     $lastBarang = Karyawan::latest()->first();
    //     if (!$lastBarang) {
    //         $num = 1;
    //     } else {
    //         $lastCode = $lastBarang->kode_karyawan;
    //         $num = (int) substr($lastCode, strlen('AD')) + 1;
    //     }
    //     $formattedNum = sprintf("%06s", $num);
    //     $prefix = 'AD';
    //     $newCode = $prefix . $formattedNum;
    //     return $newCode;
    // }


    public function edit($id)
    {
        // if (auth()->check() && auth()->user()->menu['karyawan']) {

        $drivers = Karyawan::where('id', $id)->first();
        return view('admin/driver.update', compact('drivers'));
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
