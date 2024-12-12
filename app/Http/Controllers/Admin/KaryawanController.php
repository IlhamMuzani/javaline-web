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
    public function index(Request $request)
    {
        if (auth()->check() && auth()->user()->menu['karyawan']) {
            $query = Karyawan::with('departemen')
                ->select('id', 'kode_karyawan', 'nama_lengkap', 'telp', 'departemen_id', 'qrcode_karyawan', 'nama_bank')
                ->whereIn('departemen_id', [1, 5]); // Filter untuk departemen_id 1 dan 5

            if ($request->has('keyword')) {
                $keyword = $request->keyword;
                $query->where(function ($query) use ($keyword) {
                    $query->whereHas('departemen', function ($query) use ($keyword) {
                        $query->where('nama', 'like', "%$keyword%");
                    })
                        ->orWhere('kode_karyawan', 'like', "%$keyword%")
                        ->orWhere('nama_lengkap', 'like', "%$keyword%")
                        ->orWhere('telp', 'like', "%$keyword%");
                });
            }

            $karyawans = $query->orderBy('created_at')->paginate(10);

            return view('admin.karyawan.index', compact('karyawans'));
        }
        return back()->with('error', array('Anda tidak memiliki akses'));
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        $karyawans = Karyawan::with('departemen')
            ->where('nama_lengkap', 'like', "%$keyword%")
            ->paginate(10);
        return response()->json($karyawans);
    }


    public function create()
    {
        if (auth()->check() && auth()->user()->menu['karyawan']) {
            $departemens = Departemen::select('id', 'nama')->get();
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
                'telp.required' => 'Masukkan no telepon',
                'alamat.required' => 'Masukkan alamat',
                'gambar.image' => 'Gambar yang dimasukan salah!',
            ]
        );

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return back()->withInput()->with('error', $errors);
        }

        $namaGambar = '';
        if ($request->hasFile('gambar')) {
            $gambar = str_replace(' ', '', $request->gambar->getClientOriginalName());
            $namaGambar = 'karyawan/' . date('mYdHs') . rand(1, 10) . '_' . $gambar;
            $request->gambar->storeAs('public/uploads/', $namaGambar);
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

        // Pemilihan kode karyawan berdasarkan departemen
        $kode_karyawan = ($request->departemen_id == 2) ? $this->kodedriver() : $this->kode();

        Karyawan::create([
            'departemen_id' => $request->departemen_id,
            'no_ktp' => $request->no_ktp,
            'no_sim' => $request->no_sim,
            'nama_lengkap' => $request->nama_lengkap,
            'nama_kecil' => $request->nama_kecil,
            'gender' => $request->gender,
            'tanggal_lahir' => $request->tanggal_lahir,
            'tanggal_gabung' => $request->tanggal_gabung,
            'telp' => $request->telp,
            'alamat' => $request->alamat,
            'alamat2' => $request->alamat2,
            'alamat3' => $request->alamat3,
            'gmail' => $request->gmail,
            'nama_bank' => $request->nama_bank,
            'atas_nama' => $request->atas_nama,
            'norek' => $request->norek,
            'gambar' => $namaGambar,
            'ft_ktp' => $namaGambar2,
            'ft_sim' => $namaGambar3,
            'gaji' => 0,
            'pembayaran' => 0,
            'tabungan' => 0,
            'kasbon' => 0,
            'bayar_kasbon' => 0,
            'deposit' => 0,
            'status' => 'null',
            'kode_karyawan' => $kode_karyawan,
            'qrcode_karyawan' => 'https://javaline.id/karyawan/' . $kode_karyawan,
            'tanggal' => Carbon::now('Asia/Jakarta'),
        ]);

        return redirect('admin/karyawan')->with('success', 'Berhasil menambahkan karyawan');
    }



    public function kode()
    {
        // Cari karyawan terakhir dengan kode_karyawan yang diawali dengan 'AA'
        $lastBarang = Karyawan::where('kode_karyawan', 'like', 'AA%')->latest()->first();
        if (!$lastBarang) {
            $num = 1;
        } else {
            $lastCode = $lastBarang->kode_karyawan;
            $num = (int) substr($lastCode, strlen('AA')) + 1;
        }
        $formattedNum = sprintf("%06s", $num);
        $prefix = 'AA';
        $newCode = $prefix . $formattedNum;
        return $newCode;
    }

    public function kodedriver()
    {
        // Cari karyawan terakhir dengan kode_karyawan yang diawali dengan 'ADR'
        $lastBarang = Karyawan::where('kode_karyawan', 'like', 'ADR%')->latest()->first();
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
            $karyawan = Karyawan::with('departemen')
                ->select(
                    'id',
                    'kode_karyawan',
                    'nama_lengkap',
                    'no_ktp',
                    'no_sim',
                    'alamat',
                    'tanggal_lahir',
                    'tanggal_gabung',
                    'telp',
                    'departemen_id',
                    'qrcode_karyawan',
                    'gambar',
                    'ft_ktp',
                    'ft_sim',
                    'ft_kk',
                    'ft_kk_penjamin',
                    'ft_skck',
                    'ft_surat_pernyataan',
                    'ft_terbaru',
                    'ft_rumah',
                    'ft_penjamin',
                )
                ->where('id', $id)
                ->first();

            if (!$karyawan) {
                return back()->with('error', 'Karyawan tidak ditemukan');
            }

            return view('admin.karyawan.show', compact('karyawan'));
        } else {
            // tidak memiliki akses
            return back()->with('error', 'Anda tidak memiliki akses');
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
                // 'jabatan' => 'required',
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
                // 'jabatan.required' => 'Pilih jabatan',
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

        $karyawan->departemen_id = $request->departemen_id;
        $karyawan->no_ktp = $request->no_ktp;
        $karyawan->no_sim = $request->no_sim;
        $karyawan->nama_lengkap = $request->nama_lengkap;
        $karyawan->nama_kecil = $request->nama_kecil;
        $karyawan->gender = $request->gender;
        $karyawan->tanggal_lahir = $request->tanggal_lahir;
        $karyawan->tanggal_gabung = $request->tanggal_gabung;
        $karyawan->telp = $request->telp;
        $karyawan->alamat = $request->alamat;
        $karyawan->alamat2 = $request->alamat2;
        $karyawan->alamat3 = $request->alamat3;
        $karyawan->gmail = $request->gmail;
        $karyawan->nama_bank = $request->nama_bank;
        $karyawan->atas_nama = $request->atas_nama;
        $karyawan->norek = $request->norek;
        $karyawan->gambar = $namaGambar;
        $karyawan->ft_ktp = $namaGambar2;
        $karyawan->ft_sim = $namaGambar3;
        $karyawan->tanggal_awal = Carbon::now('Asia/Jakarta');
        $karyawan->save();

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