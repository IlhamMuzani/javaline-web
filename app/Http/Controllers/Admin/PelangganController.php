<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Dompdf\Dompdf;
use App\Models\Supplier;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PelangganController extends Controller
{
    public function index()
    {
        if (auth()->check() && auth()->user()->menu['pelanggan']) {

            $pelanggans = Pelanggan::all();
            return view('admin/pelanggan.index', compact('pelanggans'));
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }

    public function create()
    {
        if (auth()->check() && auth()->user()->menu['pelanggan']) {

            return view('admin/pelanggan.create');
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
                'nama_pell' => 'required',
                'nama_alias' => 'required',
                'alamat' => 'required',
                'npwp' => 'required',
                'nama_person' => 'required',
                'jabatan' => 'required',
                'fax' => 'required',
                'telp' => 'required',
                'hp' => 'required',
                'email' => 'required',
            ],
            [
                'nama_pell.required' => 'Masukkan nama pelanggan',
                'nama_alias.required' => 'Masukkan nama alias',
                'alamat.required' => 'Masukkan alamat',
                'npwp.required' => 'Masukkan no npwp',
                'nama_person.required' => 'Masukkan nama',
                'jabatan.required' => 'Masukkan jabatan',
                'telp.required' => 'Masukkan no telepon',
                'fax.required' => 'Masukkan no fax',
                'hp.required' => 'Masukkan no hp',
                'email.required' => 'Masukkan email',
            ]
        );

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return back()->withInput()->with('error', $errors);
        }

        $kode = $this->kode();

        Pelanggan::create(array_merge(
            $request->all(),
            [
                'kode_pelanggan' => $this->kode(),
                'qrcode_pelanggan' => 'https://javaline.id/pelanggan/' . $kode,
                'tanggal_awal' => Carbon::now('Asia/Jakarta'),
                // 'qrcode_pelanggan' => 'http://192.168.1.46/javaline/pelanggan/' . $kode
            ]
        ));

        return redirect('admin/pelanggan')->with('success', 'Berhasil menambahkan Pelanggan');
    }

    public function cetakpdf($id)
    {
        $cetakpdf = Pelanggan::where('id', $id)->first();
        $html = view('admin/pelanggan.cetak_pdf', compact('cetakpdf'));

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');

        $dompdf->render();

        $dompdf->stream();
    }

    public function kode()
    {
        $supplier = Pelanggan::all();
        if ($supplier->isEmpty()) {
            $num = "000001";
        } else {
            $id = Pelanggan::getId();
            foreach ($id as $value);
            $idlm = $value->id;
            $idbr = $idlm + 1;
            $num = sprintf("%06s", $idbr);
        }

        $data = 'AD';
        $kode_pelanggan = $data . $num;
        return $kode_pelanggan;
    }

    public function show($id)
    {
        if (auth()->check() && auth()->user()->menu['pelanggan']) {

            $pelanggan = Pelanggan::where('id', $id)->first();
            return view('admin/pelanggan.show', compact('pelanggan'));
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }

    public function edit($id)
    {
        if (auth()->check() && auth()->user()->menu['pelanggan']) {

            $pelanggan = Pelanggan::where('id', $id)->first();
            return view('admin/pelanggan.update', compact('pelanggan'));
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
                'nama_pell' => 'required',
                'nama_alias' => 'required',
                'alamat' => 'required',
                'npwp' => 'required',
                'nama_person' => 'required',
                'jabatan' => 'required',
                'fax' => 'required',
                'telp' => 'required',
                'hp' => 'required',
                'email' => 'required',
                'gambar' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            ],
            [
                'nama_pell.required' => 'Masukkan nama pelanggan',
                'nama_alias.required' => 'Masukkan nama alias',
                'alamat.required' => 'Masukkan alamat',
                'npwp.required' => 'Masukkan no npwp',
                'nama_person.required' => 'Masukkan nama',
                'jabatan.required' => 'Masukkan jabatan',
                'telp.required' => 'Masukkan no telepon',
                'fax.required' => 'Masukkan no fax',
                'hp.required' => 'Masukkan no hp',
                'email.required' => 'Masukkan email',
                'gambar.image' => 'Gambar yang dimasukan salah!',
            ]
        );

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return back()->withInput()->with('error', $errors);
        }

        $pelanggan = Pelanggan::findOrfail($id);


        Pelanggan::where('id', $pelanggan->id)
            ->update([
                'nama_pell' => $request->nama_pell,
                'nama_alias' => $request->nama_alias,
                'npwp' => $request->npwp,
                'alamat' => $request->alamat,
                'nama_person' => $request->nama_person,
                'jabatan' => $request->jabatan,
                'telp' => $request->telp,
                'fax' => $request->fax,
                'hp' => $request->hp,
                'email' => $request->email,
                'tanggal_awal' => Carbon::now('Asia/Jakarta'),
            ]);

        return redirect('admin/pelanggan')->with('success', 'Berhasil memperbarui pelanggan');
    }

    public function destroy($id)
    {
        $pelanggan = Pelanggan::find($id);
        $pelanggan->delete();

        return redirect('admin/pelanggan')->with('success', 'Berhasil menghapus Pelanggan');
    }
}