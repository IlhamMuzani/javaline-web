<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Golongan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Dompdf\Dompdf;

class GolonganController extends Controller
{
    public function index()
    {
        if (auth()->check() && auth()->user()->menu['golongan']) {

            $golongans = Golongan::all();
            return view('admin/golongan.index', compact('golongans'));
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }

    public function create()
    {
        if (auth()->check() && auth()->user()->menu['golongan']) {

            return view('admin/golongan.create');
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
                'nama_golongan' => 'required',
            ],
            [
                'nama_golongan.required' => 'Masukkan nama golongan',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $kode = $this->kode();

        $tanggal = Carbon::now('Asia/Jakarta');
        $format_tanggal = $tanggal->format('d F Y');

        Golongan::create(array_merge(
            $request->all(),
            [
                'kode_golongan' => $kode,
                'qrcode_golongan' => 'http://192.168.1.46/javaline/golongan/' . $kode,
                'tanggal_awal' => $format_tanggal,
            ],
        ));

        return redirect('admin/golongan')->with('success', 'Berhasil menambahkan golongan');
    }

    public function kode()
    {
        $golongan = Golongan::all();
        if ($golongan->isEmpty()) {
            $num = "000001";
        } else {
            $id = Golongan::getId();
            foreach ($id as $value);
            $idlm = $value->id;
            $idbr = $idlm + 1;
            $num = sprintf("%06s", $idbr);
        }

        $data = 'AE';
        $kode_golongan = $data . $num;
        return $kode_golongan;
    }

    public function edit($id)
    {

        if (auth()->check() && auth()->user()->menu['golongan']) {

            $golongan = Golongan::where('id', $id)->first();
            return view('admin/golongan.update', compact('golongan'));
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_golongan' => 'required',
        ], [
            'nama_golongan.required' => 'Nama golongan tidak boleh Kosong',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        Golongan::where('id', $id)->update([
            'nama_golongan' => $request->nama_golongan,
            'tanggal_awal' => Carbon::now('Asia/Jakarta'),
        ]);

        return redirect('admin/golongan')->with('success', 'Berhasil memperbarui Golongan');
    }

    public function cetakpdf($id)
    {
        $cetakpdf = Golongan::where('id', $id)->first();
        $html = view('admin/golongan.cetak_pdf', compact('cetakpdf'));

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');

        $dompdf->render();

        $dompdf->stream();
    }


    public function destroy($id)
    {
        $golongan = Golongan::find($id);
        $golongan->kendaraan()->delete();
        $golongan->delete();

        return redirect('admin/golongan')->with('success', 'Berhasil menghapus Golongan');
    }
}