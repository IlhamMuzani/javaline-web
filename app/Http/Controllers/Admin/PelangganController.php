<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Dompdf\Dompdf;
use App\Models\Supplier;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PelangganController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->check() && auth()->user()->menu['pelanggan']) {
            $query = Pelanggan::select('id', 'kode_pelanggan', 'nama_pell', 'nama_person', 'telp', 'qrcode_pelanggan');

            if ($request->has('keyword')) {
                $keyword = $request->input('keyword');
                $query->where(function ($q) use ($keyword) {
                    $q->where('kode_pelanggan', 'like', "%$keyword%")
                        ->orWhere('nama_pell', 'like', "%$keyword%")
                        ->orWhere('nama_person', 'like', "%$keyword%")
                        ->orWhere('telp', 'like', "%$keyword%");
                });
            }

            $pelanggans = $query->orderBy('created_at', 'desc')->paginate(10);

            return view('admin.pelanggan.index', compact('pelanggans'));
        } else {
            return back()->with('error', 'Anda tidak memiliki akses');
        }
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');

        // Ensure the query is properly formed
        $karyawans = Pelanggan::where('nama_pell', 'like', "%$keyword%")
            ->orWhere('kode_pelanggan', 'like', "%$keyword%")
            ->paginate(10);

        return response()->json($karyawans);
    }


    public function create()
    {
        if (auth()->check() && auth()->user()->menu['pelanggan']) {

            $karyawans = Karyawan::select('id', 'kode_karyawan', 'nama_lengkap', 'alamat', 'telp')
                ->where('departemen_id', '4')
                ->orderBy('nama_lengkap')
                ->get();
                
            return view('admin/pelanggan.create', compact('karyawans'));
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
                // 'nama_alias' => 'required',
                'alamat' => 'required',
                'karyawan_id' => 'required',
                // 'npwp' => 'required',
                // 'nama_person' => 'required',
                // 'jabatan' => 'required',
                // 'fax' => 'required',
                // 'telp' => 'required',
                // 'hp' => 'required',
                // 'email' => 'required',
            ],
            [
                'nama_pell.required' => 'Masukkan nama pelanggan',
                // 'nama_alias.required' => 'Masukkan nama alias',
                'alamat.required' => 'Masukkan alamat',
                'karyawan_id.required' => 'Pilih Marketing',
                // 'npwp.required' => 'Masukkan no npwp',
                // 'nama_person.required' => 'Masukkan nama',
                // 'jabatan.required' => 'Masukkan jabatan',
                // 'telp.required' => 'Masukkan no telepon',
                // 'fax.required' => 'Masukkan no fax',
                // 'hp.required' => 'Masukkan no hp',
                // 'email.required' => 'Masukkan email',
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
        $lastBarang = Pelanggan::latest()->first();
        if (!$lastBarang) {
            $num = 1;
        } else {
            $lastCode = $lastBarang->kode_pelanggan;
            $num = (int) substr($lastCode, strlen('AP')) + 1;
        }
        $formattedNum = sprintf("%06s", $num);
        $prefix = 'AD';
        $newCode = $prefix . $formattedNum;
        return $newCode;
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
            $karyawans = Karyawan::select('id', 'kode_karyawan', 'nama_lengkap', 'alamat', 'telp')
            ->where('departemen_id', '4')
            ->orderBy('nama_lengkap')
            ->get();
            return view('admin/pelanggan.update', compact('pelanggan', 'karyawans'));
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
                // 'nama_alias' => 'required',
                'alamat' => 'required',
                'karyawan_id' => 'required',
                // 'npwp' => 'required',
                // 'nama_person' => 'required',
                // 'jabatan' => 'required',
                // 'fax' => 'required',
                // 'telp' => 'required',
                // 'hp' => 'required',
                // 'email' => 'required',
                // 'gambar' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            ],
            [
                'nama_pell.required' => 'Masukkan nama pelanggan',
                // 'nama_alias.required' => 'Masukkan nama alias',
                'alamat.required' => 'Masukkan alamat',
                'karyawan_id.required' => 'Pilih marketing',
                // 'npwp.required' => 'Masukkan no npwp',
                // 'nama_person.required' => 'Masukkan nama',
                // 'jabatan.required' => 'Masukkan jabatan',
                // 'telp.required' => 'Masukkan no telepon',
                // 'fax.required' => 'Masukkan no fax',
                // 'hp.required' => 'Masukkan no hp',
                // 'email.required' => 'Masukkan email',
                // 'gambar.image' => 'Gambar yang dimasukan salah!',
            ]
        );

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return back()->withInput()->with('error', $errors);
        }

        $pelanggan = Pelanggan::findOrfail($id);

        $pelanggan->nama_pell = $request->nama_pell;
        $pelanggan->nama_alias = $request->nama_alias;
        $pelanggan->karyawan_id = $request->karyawan_id;
        $pelanggan->npwp = $request->npwp;
        $pelanggan->alamat = $request->alamat;
        $pelanggan->nama_person = $request->nama_person;
        $pelanggan->jabatan = $request->jabatan;
        $pelanggan->telp = $request->telp;
        $pelanggan->fax = $request->fax;
        $pelanggan->hp = $request->hp;
        $pelanggan->email = $request->email;
        $pelanggan->tanggal_awal = Carbon::now('Asia/Jakarta');

        $pelanggan->save();

        return redirect('admin/pelanggan')->with('success', 'Berhasil memperbarui pelanggan');
    }

    public function destroy($id)
    {
        $pelanggan = Pelanggan::find($id);
        $pelanggan->delete();

        return redirect('admin/pelanggan')->with('success', 'Berhasil menghapus Pelanggan');
    }
}