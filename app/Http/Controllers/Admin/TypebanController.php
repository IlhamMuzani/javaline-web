<?php

namespace App\Http\Controllers\admin;

use Carbon\Carbon;
use Dompdf\Dompdf;
use App\Models\Typeban;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class TypebanController extends Controller
{
    public function index()
    {
        if (auth()->check() && auth()->user()->menu['type ban']) {

            $type_bans = Typeban::all();
            return view('admin/type_ban.index', compact('type_bans'));
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }

    public function create()
    {
        if (auth()->check() && auth()->user()->menu['type ban']) {

            $type_ban = Typeban::all();
            return view('admin/type_ban.create', compact('type_ban',));
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
                'nama_type' => 'required',
                'kendaraan_id' => 'nullable',
            ],
            [
                'nama_type.required' => 'Masukkan nama type',
                // 'kendaraan_id.required' => 'Pilih kendaraan',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $number = mt_rand(1000000000, 9999999999);
        if ($this->qrcodeTypeExists($number)) {
            $number = mt_rand(1000000000, 9999999999);
        }


        Typeban::create(array_merge(
            $request->all(),
            [
                'kode_type' => $this->kode(),
                'qrcode_type' => $number,
                'tanggal_awal' => Carbon::now('Asia/Jakarta'),
            ],
        ));

        return redirect('admin/type_ban')->with('success', 'Berhasil menambahkan type ban');
    }

    public function qrcodeTypeExists($number)
    {
        return Typeban::whereQrcodeType($number)->exists();
    }

    public function cetakpdf($id)
    {
        $cetakpdf = Typeban::where('id', $id)->first();
        $html = view('admin/type_ban.cetak_pdf', compact('cetakpdf'));

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');

        $dompdf->render();

        $dompdf->stream();
    }

    public function kode()
    {
        $type = Typeban::all();
        if ($type->isEmpty()) {
            $num = "000001";
        } else {
            $id = Typeban::getId();
            foreach ($id as $value);
            $idlm = $value->id;
            $idbr = $idlm + 1;
            $num = sprintf("%06s", $idbr);
        }

        $data = 'AJ';
        $kode_type = $data . $num;
        return $kode_type;
    }

    public function edit($id)
    {
        if (auth()->check() && auth()->user()->menu['type ban']) {

            $type_ban = Typeban::where('id', $id)->first();
            return view('admin/type_ban.update', compact('type_ban'));
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_type' => 'required',
            'kendaraan_id' => 'nullable',
        ], [
            'nama_type.required' => 'Nama Type tidak boleh Kosong',
            // 'kendaraan_id.required' => 'Pilih Kendaraan',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        Typeban::where('id', $id)->update([
            'nama_type' => $request->nama_type,
            'kendaraan_id' => $request->kendaraan_id,
            'tanggal_awal' => Carbon::now('Asia/Jakarta'),
        ]);

        return redirect('admin/type_ban')->with('success', 'Berhasil memperbarui Type ban');
    }

    public function destroy($id)
    {
        $type_ban = Typeban::find($id);
        $type_ban->ban()->delete();
        $type_ban->delete();

        return redirect('admin/type_ban')->with('success', 'Berhasil menghapus Type ban');
    }
}