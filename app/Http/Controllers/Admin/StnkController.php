<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Dompdf\Dompdf;
use App\Models\Kendaraan;
use Illuminate\Http\Request;
use App\Models\Stnk;
use App\Http\Controllers\Controller;
use App\Models\Jenis_kendaraan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class StnkController extends Controller
{
    public function index()
    {
        if (auth()->check() && auth()->user()->menu['stnk']) {

            $currentDate = now(); // Menggunakan Carbon untuk mendapatkan tanggal saat ini
            $oneMonthLater = $currentDate->copy()->addMonth(); // Menambahkan 1 bulan ke tanggal saat ini

            $stnks1 = Stnk::where('status_stnk', 'sudah perpanjang')
                ->whereDate('expired_stnk', '<', $oneMonthLater)
                ->get();

            foreach ($stnks1 as $stnk) {
                $stnk->update([
                    'status_stnk' => 'belum perpanjang',
                    'status_notif' => false,
                ]);
            }

            $stnks = Stnk::where(['status_stnk' => 'sudah perpanjang'])->get();
                
            return view('admin.stnk.index', compact('stnks'));
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }

    public function create()
    {
        if (auth()->check() && auth()->user()->menu['stnk']) {

            $stnks = Stnk::all();
            $kendaraans = Kendaraan::all();
            $jenis_kendaraans = Jenis_kendaraan::all();
            return view('admin.stnk.create', compact('stnks', 'kendaraans', 'jenis_kendaraans'));
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
                'kendaraan_id' => 'required',
                'nama_pemilik' => 'required',
                'alamat' => 'required',
                'merek' => 'required',
                'type' => 'required',
                'jenis_kendaraan_id' => 'required',
                'model' => 'required',
                'tahun_pembuatan' => 'required',
                'no_rangka' => 'required',
                'no_mesin' => 'required',
                'warna' => 'required',
                'warna_tnkb' => 'required',
                'tahun_registrasi' => 'required',
                'expired_stnk' => 'required',
            ],
            [
                'kendaraan_id' => 'pilih no_kabin',
                'nama_pemilik' => 'masukkan nama pemilik',
                'alamat' => 'masukkan alamat',
                'merek' => 'masukkan merek',
                'type' => 'masukkan type',
                'jenis_kendaraan_id' => 'pilih jenis kendaraan',
                'model' => 'masukkan model',
                'tahun_pembuatan' => 'pilih tahun pembuatan',
                'no_rangka' => 'masukkan no rangka',
                'no_mesin' => 'masukkan no mesin',
                'warna' => 'pilih warna',
                'warna_tnkb' => 'pilih warna tnkb',
                'tahun_registrasi' => 'pilih tahun registrasi',
                'expired_stnk' => 'masukkan tanggal expired',
            ]
        );

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return back()->withInput()->with('error', $errors);
        }

        $kode = $this->kode();

        Stnk::create(array_merge(
            $request->all(),
            [
                'kode_stnk' => $this->kode(),
                'qrcode_stnk' => 'https://javaline.id/stnk/' . $kode,
                'tanggal_awal' => Carbon::now('Asia/Jakarta'),
                'status_stnk' => 'sudah perpanjang',
                // 'status_notif' => false,
                // 'qrcode_stnk' => 'http://192.168.1.143/javaline/stnk/' . $kode
            ],
        ));

        return redirect('admin/stnk')->with('success', 'Berhasil menambahkan no. stnk');
    }

    public function kode()
    {

        $stnk = Stnk::all();
        if ($stnk->isEmpty()) {
            $num = "000001";
        } else {
            $id = Stnk::getId();
            foreach ($id as $value);
            $idlm = $value->id;
            $idbr = $idlm + 1;
            $num = sprintf("%06s", $idbr);
        }
        $data = 'AM';
        $kode_stnk = $data . $num;
        return $kode_stnk;
    }

    public function kendaraan($id)
    {
        $stnk = Kendaraan::where('id', $id)->first();

        return json_decode($stnk);
    }

    public function edit($id)
    {
        if (auth()->check() && auth()->user()->menu['stnk']) {
            $stnk = Stnk::where('id', $id)->first();
            $jenis_kendaraans = Jenis_kendaraan::all();
            $kendaraans = Kendaraan::all();
            return view('admin.stnk.update', compact('stnk', 'jenis_kendaraans', 'kendaraans'));
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
                'kendaraan_id' => 'required',
                'nama_pemilik' => 'required',
                'alamat' => 'required',
                'merek' => 'required',
                'type' => 'required',
                'jenis_kendaraan_id' => 'required',
                'model' => 'required',
                'tahun_pembuatan' => 'required',
                'no_rangka' => 'required',
                'no_mesin' => 'required',
                'warna' => 'required',
                'warna_tnkb' => 'required',
                'tahun_registrasi' => 'required',
                'expired_stnk' => 'required',
            ],
            [
                'kendaraan_id' => 'pilih no_kabin',
                'nama_pemilik' => 'masukkan nama pemilik',
                'alamat' => 'masukkan alamat',
                'merek' => 'masukkan merek',
                'type' => 'masukkan type',
                'jenis_kendaraan_id' => 'pilih jenis kendaraan',
                'model' => 'masukkan model',
                'tahun_pembuatan' => 'pilih tahun pembuatan',
                'no_rangka' => 'masukkan no rangka',
                'no_mesin' => 'masukkan no mesin',
                'warna' => 'pilih warna',
                'warna_tnkb' => 'pilih warna tnkb',
                'tahun_registrasi' => 'pilih tahun registrasi',
                'expired_stnk' => 'masukkan tanggal expired',
            ]
        );
        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }
        $stnk = Stnk::findOrFail($id);
        Stnk::where('id', $id)->update([
            'kendaraan_id' => $request->kendaraan_id,
            'nama_pemilik' => $request->nama_pemilik,
            'alamat' => $request->alamat,
            'merek' => $request->merek,
            'type' => $request->type,
            'jenis_kendaraan_id' => $request->jenis_kendaraan_id,
            'model' => $request->model,
            'tahun_pembuatan' => $request->tahun_pembuatan,
            'no_rangka' => $request->no_rangka,
            'no_mesin' => $request->no_mesin,
            'warna' => $request->warna,
            'warna_tnkb' => $request->warna_tnkb,
            'tahun_registrasi' => $request->tahun_registrasi,
            'nomor_bpkb' => $request->nomor_bpkb,
            'expired_stnk' => $request->expired_stnk,
            'tanggal_awal' => Carbon::now('Asia/Jakarta'), 
        ]);
        return redirect('admin/stnk')->with('success', 'Berhasil memperbarui No. Stnk');
    }
    public function cetakpdf($id)
    {
        $cetakpdf = Stnk::where('id', $id)->first();
        $html = view('admin.stnk.cetak_pdf', compact('cetakpdf'));
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream();
    }


    public function destroy($id)
    {
        $stnk = Stnk::find($id);
        $stnk->kendaraan()->delete();
        $stnk->delete();
        return redirect('admin/stnk')->with('success', 'Berhasil menghapus No. Stnk');
    }

    public function show($id)
    {
        if (auth()->check() && auth()->user()->menu['stnk']) {

            $stnk = Stnk::where('id', $id)->first();
            return view('admin.stnk.show', compact('stnk'));
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }
}