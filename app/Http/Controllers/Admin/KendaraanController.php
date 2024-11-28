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
use App\Models\Bearing;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;

class KendaraanController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->check() && auth()->user()->menu['kendaraan']) {
            if ($request->has('keyword')) {
                $keyword = $request->keyword;
                $kendaraans = Kendaraan::with('jenis_kendaraan')
                    ->where(function ($query) use ($keyword) {
                        $query->whereHas('jenis_kendaraan', function ($query) use ($keyword) {
                            $query->where('nama_jenis_kendaraan', 'like', "%$keyword%");
                        })
                            ->orWhere('kode_kendaraan', 'like', "%$keyword%")
                            ->orWhere('no_kabin', 'like', "%$keyword%")
                            ->orWhere('no_pol', 'like', "%$keyword%");
                    })
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);
            } else {
                $kendaraans = Kendaraan::with('jenis_kendaraan')
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);
            }

            return view('admin.kendaraan.index', compact('kendaraans'));
        }
        return back()->with('error', array('Anda tidak memiliki akses'));
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

        if ($request->gambar_barcodesolar) {
            $gambar = str_replace(' ', '', $request->gambar_barcodesolar->getClientOriginalName());
            $namaGambar = 'gambar_barcodesolar/' . date('mYdHs') . rand(1, 10) . '_' . $gambar;
            $request->gambar_barcodesolar->storeAs('public/uploads/', $namaGambar);
        } else {
            $namaGambar = null;
        }

        if ($request->gambar_stnk) {
            $gambar = str_replace(' ', '', $request->gambar_stnk->getClientOriginalName());
            $namaGambarstnk = 'gambar_stnk/' . date('mYdHs') . rand(1, 10) . '_' . $gambar;
            $request->gambar_stnk->storeAs('public/uploads/', $namaGambarstnk);
        } else {
            $namaGambarstnk = null;
        }

        // Sisanya tetap sama
        $kode = $this->kode();
        $tanggal = Carbon::now()->format('Y-m-d');
        $kendaraan =  Kendaraan::create(array_merge(
            $request->all(),
            [
                'gambar_barcodesolar' => $namaGambar,
                'gambar_stnk' => $namaGambarstnk,
                'kode_kendaraan' => $this->kode(),
                'status_perjalanan' => 'Kosong',
                'status' => 'truk',
                'timer' => '0 00:00',
                'status_olimesin' => 'belum penggantian',
                'status_oligardan' => 'belum penggantian',
                'status_olitransmisi' => 'belum penggantian',
                'qrcode_kendaraan' => 'https://javaline.id/kendaraan/' . $kode,
                'tanggal' => Carbon::now('Asia/Jakarta'),
                'tanggal_awal' => $tanggal,
            ]
        ));

        Bearing::create(array_merge(
            $request->all(),
            [
                'kendaraan_id' => $kendaraan->id,
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

    public function cetakpdfsolar($id)
    {
        $cetakpdf = Kendaraan::where('id', $id)->first();

        // If Memo_ekspedisi is not found, try fetching Memotambahan
        if (!$cetakpdf) {
            $cetakpdf = Kendaraan::where('id', $id)->first();

            // If Memotambahan is not found, handle the error
            if (!$cetakpdf) {
                abort(404, 'Memo not found');
            }
            $pdf = PDF::loadView('admin.kendaraan.cetak_pdfsolar', compact('cetakpdf'));
            $pdf->setPaper('letter', 'portrait');
            return $pdf->stream('Barcode_Solar.pdf');
        }
        $pdf = PDF::loadView('admin.kendaraan.cetak_pdfsolar', compact('cetakpdf'));
        $pdf->setPaper('letter', 'portrait');
        return $pdf->stream('Barcode_Solar.pdf');
    }

    public function cetakpdfstnk($id)
    {
        $cetakpdf = Kendaraan::where('id', $id)->first();

        // If Memo_ekspedisi is not found, try fetching Memotambahan
        if (!$cetakpdf) {
            $cetakpdf = Kendaraan::where('id', $id)->first();

            // If Memotambahan is not found, handle the error
            if (!$cetakpdf) {
                abort(404, 'Memo not found');
            }
            $pdf = PDF::loadView('admin.kendaraan.cetak_pdfstnk', compact('cetakpdf'));
            $pdf->setPaper('letter', 'portrait');
            return $pdf->stream('Foto_Stnk.pdf');
        }
        $pdf = PDF::loadView('admin.kendaraan.cetak_pdfstnk', compact('cetakpdf'));
        $pdf->setPaper('letter', 'portrait');
        return $pdf->stream('Foto_Stnk.pdf');
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

        if ($request->gambar_barcodesolar) {
            Storage::disk('local')->delete('public/uploads/' . $kendaraan->gambar_barcodesolar);
            $gambar = str_replace(' ', '', $request->gambar_barcodesolar->getClientOriginalName());
            $namaGambar = 'gambar_barcodesolar/' . date('mYdHs') . rand(1, 10) . '_' . $gambar;
            $request->gambar_barcodesolar->storeAs('public/uploads/', $namaGambar);
        } else {
            $namaGambar = $kendaraan->gambar_barcodesolar;
        }

        if ($request->gambar_stnk) {
            Storage::disk('local')->delete('public/uploads/' . $kendaraan->gambar_stnk);
            $gambar = str_replace(' ', '', $request->gambar_stnk->getClientOriginalName());
            $namaGambarstnk = 'gambar_stnk/' . date('mYdHs') . rand(1, 10) . '_' . $gambar;
            $request->gambar_stnk->storeAs('public/uploads/', $namaGambarstnk);
        } else {
            $namaGambarstnk = $kendaraan->gambar_stnk;
        }

        $kendaraan->gpsid = $request->gpsid;
        $kendaraan->list_vehicle_id = $request->list_vehicle_id;
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
        $kendaraan->gambar_barcodesolar = $namaGambar;
        $kendaraan->gambar_stnk = $namaGambarstnk;
        $kendaraan->tanggal = Carbon::now('Asia/Jakarta');
        $kendaraan->tanggal_awal = Carbon::now()->format('Y-m-d');

        $kendaraan->save();

        return redirect('admin/kendaraan')->with('success', 'Berhasil memperbarui kendaraan');
    }

    public function destroy($id)
    {
        $kendaraan = Kendaraan::find($id);
        $kendaraan->bearing()->delete();
        $kendaraan->delete();

        return redirect('admin/kendaraan')->with('success', 'Berhasil menghapus Kendaraan');
    }
}