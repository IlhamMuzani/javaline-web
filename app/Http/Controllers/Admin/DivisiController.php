<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Dompdf\Dompdf;
use App\Models\Divisi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class DivisiController extends Controller
{
    public function index()
    {
        if (auth()->check() && auth()->user()->menu['divisi mobil']) {

            $divisis = Divisi::all();
            return view('admin/divisi.index', compact('divisis'));

        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }

    public function create()
    {
        if (auth()->check() && auth()->user()->menu['divisi mobil']) {

            return view('admin/divisi.create');
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
                'nama_divisi' => 'required',
            ],
            [
                'nama_divisi.required' => 'Masukkan nama',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $number = mt_rand(1000000000, 9999999999);
        if ($this->qrcodeDivisiExists($number)) {
            $number = mt_rand(1000000000, 9999999999);
        }

        Divisi::create(array_merge(
            $request->all(),
            [
                'kode_divisi' => $this->kode(),
                'qrcode_divisi' => $number,
                'tanggal_awal' => Carbon::now('Asia/Jakarta'), 

            ]
        ));

        return redirect('admin/divisi')->with('success', 'Berhasil menambahkan divisi');
    }

    public function qrcodeDivisiExists($number)
    {
        return Divisi::whereQrcodeDivisi($number)->exists();
    }

    public function cetakpdf($id)
    {
        $cetakpdf = Divisi::where('id', $id)->first();
        $html = view('admin/divisi.cetak_pdf', compact('cetakpdf'));

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');

        $dompdf->render();

        $dompdf->stream();
    }

    public function kode()
    {
        $divisi = Divisi::all();
        if ($divisi->isEmpty()) {
            $num = "000001";
        } else {
            $id = Divisi::getId();
            foreach ($id as $value);
            $idlm = $value->id;
            $idbr = $idlm + 1;
            $num = sprintf("%06s", $idbr);
        }

        $data = 'AF';
        $kode_divisi = $data . $num;
        return $kode_divisi;
    }

    public function edit($id)
    {

        if (auth()->check() && auth()->user()->menu['divisi mobil']) {

            $divisi = Divisi::where('id', $id)->first();
            return view('admin/divisi.update', compact('divisi'));
            
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_divisi' => 'required',
        ], [
            'nama_divisi.required' => 'Nama tidak boleh Kosong',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        Divisi::where('id', $id)->update([
            'nama_divisi' => $request->nama_divisi,
            'tanggal_awal' => Carbon::now('Asia/Jakarta'), 

        ]);

        return redirect('admin/divisi')->with('success', 'Berhasil memperbarui divisi');
    }

    public function destroy($id)
    {
        $divisi = Divisi::find($id);
        $divisi->kendaraan()->delete();
        $divisi->delete();

        return redirect('admin/divisi')->with('success', 'Berhasil menghapus divisi');
    }
}