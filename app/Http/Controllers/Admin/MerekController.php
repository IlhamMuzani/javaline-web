<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Dompdf\Dompdf;
use App\Models\Merek;
use App\Models\Ukuran;
use App\Models\Kendaraan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class MerekController extends Controller
{
    public function index()
    {
        if (auth()->check() && auth()->user()->menu['merek ban']) {

            $merek_bans = Merek::all();
            return view('admin/merek_ban.index', compact('merek_bans'));
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }

    public function create()
    {
        if (auth()->check() && auth()->user()->menu['merek ban']) {

            $ukurans = Ukuran::all();
            $kendaraans = Kendaraan::all();
            return view('admin/merek_ban.create', compact('ukurans', 'kendaraans',));
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
                'nama_merek' => 'required',
                'kendaraan_id' => 'nullable',
            ],
            [
                'nama_merek.required' => 'Masukkan nama merek',
                // 'kendaraan_id.required' => 'Pilih kendaraan',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $number = mt_rand(1000000000, 9999999999);
        if ($this->qrcodeMerekExists($number)) {
            $number = mt_rand(1000000000, 9999999999);
        }


        Merek::create(array_merge(
            $request->all(),
            [
                'kode_merek' => $this->kode(),
                'qrcode_merek' => $number,
                'tanggal_awal' => Carbon::now('Asia/Jakarta'),
            ],
        ));

        return redirect('admin/merek_ban')->with('success', 'Berhasil menambahkan merek ban');
    }

    public function qrcodeMerekExists($number)
    {
        return Merek::whereQrcodeMerek($number)->exists();
    }

    public function cetakpdf($id)
    {
        $cetakpdf = Merek::where('id', $id)->first();
        $html = view('admin/merek_ban.cetak_pdf', compact('cetakpdf'));

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');

        $dompdf->render();

        $dompdf->stream();
    }

    public function kode()
    {
        $merek = Merek::all();
        if ($merek->isEmpty()) {
            $num = "000001";
        } else {
            $id = Merek::getId();
            foreach ($id as $value);
            $idlm = $value->id;
            $idbr = $idlm + 1;
            $num = sprintf("%06s", $idbr);
        }

        $data = 'AL';
        $kode_merek = $data . $num;
        return $kode_merek;
    }

    public function edit($id)
    {
        if (auth()->check() && auth()->user()->menu['merek ban']) {

            $merek_ban = Merek::where('id', $id)->first();
            $kendaraans = Kendaraan::all();
            return view('admin/merek_ban.update', compact('merek_ban', 'kendaraans'));
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_merek' => 'required',
            'kendaraan_id' => 'nullable',
        ], [
            'nama_merek.required' => 'Nama Merek tidak boleh Kosong',
            // 'kendaraan_id.required' => 'Pilih Kendaraan',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        Merek::where('id', $id)->update([
            'nama_merek' => $request->nama_merek,
            'kendaraan_id' => $request->kendaraan_id,
            'tanggal_awal' => Carbon::now('Asia/Jakarta'), 
        ]);

        return redirect('admin/merek_ban')->with('success', 'Berhasil memperbarui Merek ban');
    }

    public function destroy($id)
    {
        $merek_ban = Merek::find($id);
        $merek_ban->ban()->delete();
        $merek_ban->delete();

        return redirect('admin/merek_ban')->with('success', 'Berhasil menghapus Merek ban');
    }
}