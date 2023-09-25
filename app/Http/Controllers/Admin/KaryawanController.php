<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Departemen;
use App\Models\Karyawan;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class KaryawanController extends Controller
{
    public function index()
    {
        if (auth()->check() && auth()->user()->menu['karyawan']) {
            $karyawans = Karyawan::all();
            return view('admin.karyawan.index', compact('karyawans'));
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }

    public function create()
    {
        if (auth()->check() && auth()->user()->menu['karyawan']) {
            $departemens = Departemen::all();
            return view('admin/karyawan.create', compact('departemens'));
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'departemen_id' => 'required',
                'no_ktp' => 'required',
                'no_sim' => 'required',
                'nama_lengkap' => 'required',
                'nama_kecil' => 'required',
                'gender' => 'required',
                'tanggal_lahir' => 'required',
                'tanggal_gabung' => 'required',
                'jabatan' => 'required',
                'telp' => 'required',
                'alamat' => 'required',
                'gambar' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            ],
            [
                'departemen_id.required' => 'Pilih departemen',
                'no_ktp.required' => 'Masukkan no ktp',
                'no_sim.required' => 'Masukkan no sim',
                'nama_lengkap.required' => 'Masukkan nama lengkap',
                'nama_kecil.required' => 'Masukkan nama kecil',
                'gender.required' => 'Pilih gender',
                'tanggal_lahir.required' => 'Masukkan tanggal lahir',
                'tanggal_gabung.required' => 'Masukkan tanggal gabung',
                'jabatan.required' => 'Pilih jabatan',
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
                'gaji' => '-',
                'pembayaran' => '-',
                'status' => 'null',
                'kode_karyawan' => $this->kode(),
                'qrcode_karyawan' => 'https://javaline.id/karyawan/' . $kode,
                // 'qrcode_karyawan' => 'http://192.168.1.46/javaline/karyawan/' . $kode
                'tanggal' => Carbon::now('Asia/Jakarta'),

            ]
        ));

        return redirect('admin/karyawan')->with('success', 'Berhasil menambahkan karyawan');
    }

    public function kode()
    {
        $id = Karyawan::getId();
        foreach ($id as $value);
        $idlm = $value->id;
        $idbr = $idlm + 1;
        $num = sprintf("%06s", $idbr);
        $data = 'AA';
        $kode_karyawan = $data . $num;

        return $kode_karyawan;
    }

    public function cetakpdf($id)
    {
        $cetakpdf = Karyawan::where('id', $id)->first();
        $html = view('admin/karyawan.cetak_pdf', compact('cetakpdf'));

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');

        $dompdf->render();

        $dompdf->stream();
    }

    public function show($id)
    {
        if (auth()->check() && auth()->user()->menu['karyawan']) {

            $karyawan = Karyawan::where('id', $id)->first();
            return view('admin/karyawan.show', compact('karyawan'));
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }

    public function edit($id)
    {
        if (auth()->check() && auth()->user()->menu['karyawan']) {

            $departemens = Departemen::all();
            $karyawan = Karyawan::where('id', $id)->first();
            return view('admin/karyawan.update', compact('karyawan', 'departemens'));
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'departemen_id' => 'required',
                'no_ktp' => 'required',
                'no_sim' => 'required',
                'nama_lengkap' => 'required',
                'nama_kecil' => 'required',
                'gender' => 'required',
                'tanggal_lahir' => 'required',
                'tanggal_gabung' => 'required',
                'jabatan' => 'required',
                'telp' => 'required',
                'alamat' => 'required',
                'gambar' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            ],
            [
                'departemen_id.required' => 'Pilih departemen',
                'no_ktp.required' => 'Masukkan no ktp',
                'no_sim.required' => 'Masukkan no sim',
                'nama_lengkap.required' => 'Masukkan nama lengkap',
                'nama_kecil.required' => 'Masukkan nama kecil',
                'gender.required' => 'Pilih gender',
                'tanggal_lahir.required' => 'Masukkan tanggal lahir',
                'tanggal_gabung.required' => 'Masukkan tanggal gabung',
                'jabatan.required' => 'Pilih jabatan',
                'telp.required' => 'Masukkan no telepon',
                'alamat.required' => 'Masukkan alamat',
                'gambar.image' => 'Gambar yang dimasukan salah!',
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

        Karyawan::where('id', $karyawan->id)
            ->update([
                'departemen_id' => $request->departemen_id,
                'no_ktp' => $request->no_ktp,
                'no_sim' => $request->no_sim,
                'nama_lengkap' => $request->nama_lengkap,
                'nama_kecil' => $request->nama_kecil,
                'gender' => $request->gender,
                'tanggal_lahir' => $request->tanggal_lahir,
                'tanggal_gabung' => $request->tanggal_gabung,
                'jabatan' => $request->jabatan,
                'telp' => $request->telp,
                'alamat' => $request->alamat,
                'gambar' => $namaGambar,
            'tanggal_awal' => Carbon::now('Asia/Jakarta'),
            ]);

        return redirect('admin/karyawan')->with('success', 'Berhasil mengubah karyawan');
    }
    public function destroy($id)
    {
        $karyawan = Karyawan::find($id);
        $karyawan->user()->delete();
        $karyawan->delete();

        return redirect('admin/karyawan')->with('success', 'Berhasil menghapus karyawan');
    }
}