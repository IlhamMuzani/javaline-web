<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use App\Models\Jenis_kendaraan;
use App\Http\Controllers\Controller;
use App\Models\Kendaraan;
use Illuminate\Support\Facades\Validator;

class Jenis_kendaraanController extends Controller
{
    public function index()
    {
        if (auth()->check() && auth()->user()->menu['jenis kendaraan']) {

            $jenis_kendaraans = Jenis_kendaraan::all();
            return view('admin/jenis_kendaraan.index', compact('jenis_kendaraans'));
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }

    public function create()
    {
        if (auth()->check() && auth()->user()->menu['jenis kendaraan']) {

            return view('admin/jenis_kendaraan.create');
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
                'nama_jenis_kendaraan' => 'required',
                'panjang' => 'required',
                'lebar' => 'required',
                'tinggi' => 'required',
                'total_ban' => 'required',
            ],
            [
                'nama_jenis_kendaraan.required' => 'Masukkan nama jenis kendaraan',
                'panjang.required' => 'Masukkan panjang',
                'lebar.required' => 'Masukkan lebar',
                'tinggi.required' => 'Masukkan tinggi',
                'total_ban.required' => 'Masukkan total ban',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $number = mt_rand(1000000000, 9999999999);
        if ($this->qrcodeJenisExists($number)) {
            $number = mt_rand(1000000000, 9999999999);
        }

        Jenis_kendaraan::create(array_merge(
            $request->all(),
            [
                'kode_jenis_kendaraan' => $this->kode(),
                'qrcode_jenis' => $number,
                'tanggal_awal' => Carbon::now('Asia/Jakarta'), 
            ],
        ));

        return redirect('admin/jenis_kendaraan')->with('success', 'Berhasil menambahkan jenis kendaraan');
    }

    public function qrcodeJenisExists($number)
    {
        return Jenis_kendaraan::whereQrcodeJenis($number)->exists();
    }

    public function cetakpdf($id)
    {
        $cetakpdf = Jenis_kendaraan::where('id', $id)->first();
        $html = view('admin/jenis_kendaraan.cetak_pdf', compact('cetakpdf'));

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');

        $dompdf->render();

        $dompdf->stream();
    }

    public function kode()
    {
        $jenis = Jenis_kendaraan::all();
        if ($jenis->isEmpty()) {
            $num = "000001";
        } else {
            $id = Jenis_kendaraan::getId();
            foreach ($id as $value);
            $idlm = $value->id;
            $idbr = $idlm + 1;
            $num = sprintf("%06s", $idbr);
        }

        $data = 'AG';
        $kode_jenis = $data . $num;
        return $kode_jenis;
    }

    public function edit($id)
    {
        if (auth()->check() && auth()->user()->menu['jenis kendaraan']) {

            $jenis_kendaraan = Jenis_kendaraan::where('id', $id)->first();
            return view('admin/jenis_kendaraan.update', compact('jenis_kendaraan'));
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),
            [
                'nama_jenis_kendaraan' => 'required',
                'panjang' => 'required',
                'lebar' => 'required',
                'tinggi' => 'required',
                'total_ban' => 'required',
            ],
            [
                'nama_jenis_kendaraan.required' => 'Masukkan nama jenis kendaraan',
                'panjang.required' => 'Masukkan panjang',
                'lebar.required' => 'Masukkan lebar',
                'tinggi.required' => 'Masukkan tinggi',
                'total_ban.required' => 'Masukkan total ban',
            ]);

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $jenisKendaraan = Jenis_kendaraan::find($id);

        $jenisKendaraan->nama_jenis_kendaraan = $request->nama_jenis_kendaraan;
        $jenisKendaraan->panjang = $request->panjang;
        $jenisKendaraan->lebar = $request->lebar;
        $jenisKendaraan->tinggi = $request->tinggi;
        $jenisKendaraan->total_ban = $request->total_ban;
        $jenisKendaraan->tanggal_awal = Carbon::now('Asia/Jakarta');

        $jenisKendaraan->save();

        return redirect('admin/jenis_kendaraan')->with('success', 'Berhasil memperbarui jenis kendaraan');

    }

    public function destroy($id)
    {
        $jenis_kendaraan = Jenis_kendaraan::find($id);
        $jenis_kendaraan->delete();

        Kendaraan::where('jenis_kendaraan_id', $id)->update(['jenis_kendaraan_id' => null]);

        return redirect('admin/jenis_kendaraan')->with('success', 'Berhasil menghapus jenis kendaraan');
    }
}