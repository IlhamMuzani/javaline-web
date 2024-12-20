<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Dompdf\Dompdf;
use App\Models\Merek_aki;
use App\Models\Ukuran;
use App\Models\Kendaraan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class MerekakiController extends Controller
{
    public function index()
    {
        if (auth()->check() && auth()->user()->menu['merek ban']) {

            $merek_akis = Merek_aki::all();
            return view('admin/merek_aki.index', compact('merek_akis'));
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
            return view('admin/merek_aki.create', compact('ukurans', 'kendaraans',));
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


        Merek_aki::create(array_merge(
            $request->all(),
            [
                'kode_merek' => $this->kode(),
                'qrcode_merek' => $number,
                'tanggal_awal' => Carbon::now('Asia/Jakarta'),
            ],
        ));

        return redirect('admin/merek-aki')->with('success', 'Berhasil menambahkan merek aki');
    }

    public function qrcodeMerekExists($number)
    {
        return Merek_aki::whereQrcodeMerek($number)->exists();
    }

    public function cetakpdf($id)
    {
        $cetakpdf = Merek_aki::where('id', $id)->first();
        $html = view('admin/merek_aki.cetak_pdf', compact('cetakpdf'));

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');

        $dompdf->render();

        $dompdf->stream();
    }

    // public function kode()
    // {
    //     $merek = Merek_aki::all();
    //     if ($merek->isEmpty()) {
    //         $num = "000001";
    //     } else {
    //         $id = Merek_aki::getId();
    //         foreach ($id as $value);
    //         $idlm = $value->id;
    //         $idbr = $idlm + 1;
    //         $num = sprintf("%06s", $idbr);
    //     }

    //     $data = 'AL';
    //     $kode_merek = $data . $num;
    //     return $kode_merek;
    // }

    public function kode()
    {
        $lastBarang = Merek_aki::latest()->first();
        if (!$lastBarang) {
            $num = 1;
        } else {
            $lastCode = $lastBarang->kode_merek;
            $num = (int) substr($lastCode, strlen('AL')) + 1;
        }
        $formattedNum = sprintf("%06s", $num);
        $prefix = 'AL';
        $newCode = $prefix . $formattedNum;
        return $newCode;
    }


    public function edit($id)
    {
        if (auth()->check() && auth()->user()->menu['merek ban']) {

            $merek_aki = Merek_aki::where('id', $id)->first();
            $kendaraans = Kendaraan::all();
            return view('admin/merek_aki.update', compact('merek_aki', 'kendaraans'));
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
            'nama_merek.required' => 'Nama Merek_aki tidak boleh Kosong',
            // 'kendaraan_id.required' => 'Pilih Kendaraan',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $merek = Merek_aki::find($id);

        $merek->nama_merek = $request->nama_merek;
        $merek->kendaraan_id = $request->kendaraan_id;
        $merek->tanggal_awal = Carbon::now('Asia/Jakarta');

        $merek->save();

        return redirect('admin/merek-aki')->with('success', 'Berhasil memperbarui Merek aki');
    }

    public function destroy($id)
    {
        $merek_aki = Merek_aki::find($id);
        $merek_aki->delete();

        return redirect('admin/merek-aki')->with('success', 'Berhasil menghapus Merek aki');
    }
}