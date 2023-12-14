<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Dompdf\Dompdf;
use App\Models\Divisi;
use App\Models\Golongan;
use App\Models\Kendaraan;
use Illuminate\Http\Request;
use App\Models\Jenis_kendaraan;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class KendaraanController extends Controller
{
    public function index()
    {
        if (auth()->check() && auth()->user()->menu['kendaraan']) {
            // Retrieve the vehicles ordered by the latest input
            $kendaraans = Kendaraan::orderBy('created_at', 'desc')->get();

            return view('admin/kendaraan.index', compact('kendaraans'));
        } else {
            // tidak memiliki akses
            return back()->with('error', ['Anda tidak memiliki akses']);
        }
    }

    public function create()
    {
        if (auth()->check() && auth()->user()->menu['kendaraan']) {

            $jenis_kendaraans = Jenis_kendaraan::all();
            $golongans = Golongan::all();
            $divisis = Divisi::all();
            $drivers = User::whereHas('karyawan', function ($query) {
                $query->where('departemen_id', '2');
            })->get();

            return view('admin/kendaraan.create', compact('jenis_kendaraans', 'golongans', 'divisis', 'drivers'));
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
                'no_kabin' => 'required',
                'no_pol' => 'required|unique:kendaraans,no_pol', // Menambahkan aturan unique
                'no_rangka' => 'required',
                'no_mesin' => 'required',
                'warna' => 'required',
                'km' => 'nullable',
                'expired_kir' => 'required',
                'expired_stnk' => 'required',
                'jenis_kendaraan_id' => 'required',
                'golongan_id' => 'required',
                'divisi_id' => 'required',
                // 'user_id' => 'required',
            ],
            [
                'no_kabin.required' => 'Masukkan no kabin',
                'no_pol.required' => 'Masukkan no pol',
                'no_rangka.required' => 'Masukkan no rangka',
                'no_mesin.required' => 'Masukkan no mesin',
                'warna.required' => 'Masukkan warna',
                // 'km.required' => 'Masukkan km',
                'expired_kir.required' => 'Pilih expired no kir',
                'expired_stnk.required' => 'Pilih expired no stnk',
                'jenis_kendaraan_id.required' => 'Pilih jenis kendaraan',
                'golongan_id.required' => 'Pilih Golongan',
                'divisi_id_mobil.required' => 'Pilih devisi mobil',
                // 'user_id.required' => 'Pilih driver',
                'no_pol.unique' => 'Nomor polisi sudah terdaftar.', // Pesan untuk validasi unique
            ]
        );

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return back()->withInput()->with('error', $errors);
        }

        // Sisanya tetap sama
        $kode = $this->kode();
        $tanggal = Carbon::now()->format('Y-m-d');
        Kendaraan::create(array_merge(
            $request->all(),
            [
                'kode_kendaraan' => $this->kode(),
                'status' => 'truk',
                'timer' => '0 00:00',
                'status_olimesin' => 'belum penggantian',
                'status_oligardan' => 'belum penggantian',
                'status_olitransmisi' => 'belum penggantian',
                'qrcode_kendaraan' => 'https:///javaline.id/kendaraan/' . $kode,
                'tanggal' => Carbon::now('Asia/Jakarta'),
                'tanggal_awal' => $tanggal,
            ]
        ));
        return redirect('admin/kendaraan')->with('success', 'Berhasil menambahkan kendaraan');
    }


    public function cetakpdf($id)
    {
        $cetakpdf = Kendaraan::where('id', $id)->first();
        $html = view('admin/kendaraan.cetak_pdf', compact('cetakpdf'));

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');

        $dompdf->render();

        $dompdf->stream();
    }


    public function kode()
    {
        $kendaraan = Kendaraan::all();
        if ($kendaraan->isEmpty()) {
            $num = "000001";
        } else {
            $id = Kendaraan::getId();
            foreach ($id as $value);
            $idlm = $value->id;
            $idbr = $idlm + 1;
            $num = sprintf("%06s", $idbr);
        }

        $data = 'AH';
        $kode_kendaraan = $data . $num;
        return $kode_kendaraan;
    }

    public function show($id)
    {
        if (auth()->check() && auth()->user()->menu['kendaraan']) {

            $kendaraan = Kendaraan::where('id', $id)->first();
            return view('admin/kendaraan.show', compact('kendaraan'));
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }

    public function edit($id)
    {
        if (auth()->check() && auth()->user()->menu['kendaraan']) {

            $kendaraan = Kendaraan::where('id', $id)->first();
            $jenis_kendaraans = Jenis_kendaraan::all();
            $golongans = Golongan::all();
            $divisis = Divisi::all();
            $drivers = User::whereHas('karyawan', function ($query) {
                $query->where('departemen_id', '2');
            })->get();
            return view('admin/kendaraan.update', compact('drivers', 'kendaraan', 'jenis_kendaraans', 'golongans', 'divisis'));
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
                'no_kabin' => 'required',
                'no_pol' => 'required',
                'no_rangka' => 'required',
                'no_mesin' => 'required',
                'warna' => 'required',
                'expired_kir' => 'required',
                'expired_stnk' => 'required',
                'jenis_kendaraan_id' => 'required',
                'golongan_id' => 'required',
                'divisi_id' => 'required',
                // 'user_id' => 'required',
            ],
            [
                'no_kabin.required' => 'Masukkan no kabin',
                'no_pol.required' => 'Masukkan no pol',
                'no_rangka.required' => 'Masukkan no rangka',
                'no_mesin.required' => 'Masukkan no mesin',
                'warna.required' => 'Masukkan warna',
                'expired_kir.required' => 'Pilih expired no kir',
                'expired_stnk.required' => 'Pilih expired no stnk',
                'jenis_kendaraan_id.required' => 'Pilih jenis kendaraan',
                'golongan_id.required' => 'Pilih Golongan',
                // 'user_id.required' => 'Pilih Driver',
            ]
        );

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return back()->withInput()->with('error', $errors);
        }

        $kendaraan = Kendaraan::findOrFail($id);

        $kendaraan->no_kabin = $request->no_kabin;
        $kendaraan->no_pol = $request->no_pol;
        $kendaraan->no_rangka = $request->no_rangka;
        $kendaraan->warna = $request->warna;
        $kendaraan->no_mesin = $request->no_mesin;
        $kendaraan->expired_kir = $request->expired_kir;
        $kendaraan->expired_stnk = $request->expired_stnk;
        $kendaraan->jenis_kendaraan_id = $request->jenis_kendaraan_id;
        $kendaraan->golongan_id = $request->golongan_id;
        $kendaraan->divisi_id = $request->divisi_id;
        $kendaraan->user_id = $request->user_id;
        $kendaraan->km = $request->km;
        $kendaraan->tanggal = Carbon::now('Asia/Jakarta');
        $kendaraan->tanggal_awal = Carbon::now()->format('Y-m-d');

        $kendaraan->save();

        return redirect('admin/kendaraan')->with('success', 'Berhasil memperbarui kendaraan');
    }

    public function destroy($id)
    {
        $kendaraan = Kendaraan::find($id);
        $kendaraan->merek()->delete();
        $kendaraan->delete();

        return redirect('admin/kendaraan')->with('success', 'Berhasil menghapus Kendaraan');
    }
}
