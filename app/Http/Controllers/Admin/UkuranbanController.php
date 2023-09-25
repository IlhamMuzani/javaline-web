<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Dompdf\Dompdf;
use App\Models\Ukuran;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class UkuranbanController extends Controller
{
    public function index()
    {
        if (auth()->check() && auth()->user()->menu['ukuran ban']) {

            $ukuran_bans = Ukuran::all();
            return view('admin/ukuran_ban.index', compact('ukuran_bans'));
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }

    public function create()
    {
        if (auth()->check() && auth()->user()->menu['ukuran ban']) {

            return view('admin/ukuran_ban.create');
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
                'ukuran' => 'required',
            ],
            [
                'ukuran.required' => 'Masukkan ukuran',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $number = mt_rand(1000000000, 9999999999);
        if ($this->qrcodeUkuranExists($number)) {
            $number = mt_rand(1000000000, 9999999999);
        }

        Ukuran::create(array_merge(
            $request->all(),
            [
                'kode_ukuran_ban' => $this->kode(),
                'qrcode_ukuran' => $number,
                'tanggal_awal' => Carbon::now('Asia/Jakarta'), 
            ],
        ));

        return redirect('admin/ukuran_ban')->with('success', 'Berhasil menambahkan ukuran ban');
    }

    public function qrcodeUkuranExists($number)
    {
        return Ukuran::whereQrcodeUkuran($number)->exists();
    }

    public function cetakpdf($id)
    {
        $cetakpdf = Ukuran::where('id', $id)->first();
        $html = view('admin/ukuran_ban.cetak_pdf', compact('cetakpdf'));

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');

        $dompdf->render();

        $dompdf->stream();
    }

    public function kode()
    {
        $ukuran = Ukuran::all();
        if ($ukuran->isEmpty()) {
            $num = "000001";
        } else {
            $id = Ukuran::getId();
            foreach ($id as $value);
            $idlm = $value->id;
            $idbr = $idlm + 1;
            $num = sprintf("%06s", $idbr);
        }

        $data = 'AI';
        $kode_karyawan = $data . $num;
        return $kode_karyawan;
    }

    public function edit($id)
    {
        if (auth()->check() && auth()->user()->menu['ukuran ban']) {

            $ukuran_ban = Ukuran::where('id', $id)->first();
            return view('admin/ukuran_ban.update', compact('ukuran_ban'));
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'ukuran' => 'required',
        ], [
            'ukuran.required' => 'Ukuran tidak boleh Kosong',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        Ukuran::where('id', $id)->update([
            'ukuran' => $request->ukuran,
            'tanggal_awal' => Carbon::now('Asia/Jakarta'), 
        ]);
        
        return redirect('admin/ukuran_ban')->with('success', 'Berhasil memperbarui Ukuran ban');
    }

    public function destroy($id)
    {
        $ukuran = Ukuran::find($id);
        $ukuran->ban()->delete();
        $ukuran->delete();

        return redirect('admin/ukuran_ban')->with('success', 'Berhasil menghapus Ukuran');
    }
}