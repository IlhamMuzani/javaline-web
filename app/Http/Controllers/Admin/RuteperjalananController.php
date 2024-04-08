<?php

namespace App\Http\Controllers\admin;

use Carbon\Carbon;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Golongan;
use App\Models\Rute_perjalanan;
use Illuminate\Support\Facades\Validator;

class RuteperjalananController extends Controller
{
    public function index(Request $request)
    {
        // Ambil semua golongan
        $golongan = Golongan::all();
        if ($request->has('keyword')) {
            $keyword = $request->keyword;
            $rute_perjalanans = Rute_perjalanan::where('kode_rute', 'like', "%$keyword%")
                ->orWhere('nama_rute', 'like', "%$keyword%")
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        } else {
            $rute_perjalanans = Rute_perjalanan::orderBy('created_at', 'desc')
                ->paginate(10);
        }
        return view('admin.rute_perjalanan.index', compact('rute_perjalanans', 'golongan'));
    }


    public function create()
    {
        // if (auth()->check() && auth()->user()->menu['rute perjalanan']) {

        $golongan = Golongan::all();

        $rute_perjalanan = Rute_perjalanan::all();
        $provinces = [
            'Aceh', 'Sumatera Utara', 'Sumatera Barat', 'Riau', 'Kepulauan Riau',
            'Jambi', 'Bengkulu', 'Sumatera Selatan', 'Bangka Belitung', 'Lampung',
            'DKI Jakarta', 'Banten', 'Jawa Barat', 'Jawa Tengah', 'DI Yogyakarta',
            'Jawa Timur', 'Bali', 'Nusa Tenggara Barat', 'Nusa Tenggara Timur',
            'Kalimantan Barat', 'Kalimantan Tengah', 'Kalimantan Selatan', 'Kalimantan Timur', 'Kalimantan Utara',
            'Sulawesi Utara', 'Sulawesi Tengah', 'Sulawesi Selatan', 'Sulawesi Tenggara',
            'Gorontalo', 'Maluku', 'Maluku Utara', 'Papua Barat', 'Papua', 'Sulawesi Barat'
        ];
        return view('admin/rute_perjalanan.create', compact('rute_perjalanan', 'provinces', 'golongan'));
        // } else {
        //     // tidak memiliki akses
        //     return back()->with('error', array('Anda tidak memiliki akses'));
        // }
    }

    // public function store(Request $request)
    // {
    //     $validator = Validator::make(
    //         $request->all(),
    //         [
    //             'provinsi' => 'required',
    //             'nama_rute' => 'required',
    //         ],
    //         [
    //             'provinsi.required' => 'Pilih provinsi',
    //             'nama_rute.required' => 'Masukkan tujuan',
    //         ]
    //     );

    //     if ($validator->fails()) {
    //         $error = $validator->errors()->all();
    //         return back()->withInput()->with('error', $error);
    //     }

    //     $kode = $this->kode();

    //     Rute_perjalanan::create(array_merge(
    //         $request->all(),
    //         [
    //             'kode_rute' => $this->kode(),
    //             'golongan1' => $request->golongan1,
    //             'golongan2' => $request->golongan2,
    //             'golongan3' => $request->golongan3,
    //             'golongan4' => $request->golongan4,
    //             'golongan5' => $request->golongan5,
    //             'golongan6' => $request->golongan6,
    //             'golongan7' => $request->golongan7,
    //             'golongan8' => $request->golongan8,
    //             'golongan9' => $request->golongan9,
    //             'golongan10' => $request->golongan10,
    //             'qrcode_rute' => 'https://javaline.id/rute_perjalanan/' . $kode,
    //             'tanggal_awal' => Carbon::now('Asia/Jakarta'),
    //         ],
    //     ));

    //     return redirect('admin/rute_perjalanan')->with('success', 'Berhasil menambahkan rute perjalanan');
    // }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'provinsi' => 'required',
                'nama_rute' => 'required',
            ],
            [
                'provinsi.required' => 'Pilih provinsi',
                'nama_rute.required' => 'Masukkan tujuan',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $kode = $this->kode();
        $nama_rute_uppercase = strtoupper($request->nama_rute);
        Rute_perjalanan::create(array_merge(
            $request->all(),
            [
                'kode_rute' => $this->kode(),
                'qrcode_rute' => 'https://javaline.id/rute_perjalanan/' . $kode,
                'nama_rute' =>  $nama_rute_uppercase,
                'tanggal_awal' => Carbon::now('Asia/Jakarta'),
                'golongan1' => $request->golongan1 ? str_replace('.', '', $request->golongan1) : null,
                'golongan2' => $request->golongan2 ? str_replace('.', '', $request->golongan2) : null,
                'golongan3' => $request->golongan3 ? str_replace('.', '', $request->golongan3) : null,
                'golongan4' => $request->golongan4 ? str_replace('.', '', $request->golongan4) : null,
                'golongan5' => $request->golongan5 ? str_replace('.', '', $request->golongan5) : null,
                'golongan6' => $request->golongan6 ? str_replace('.', '', $request->golongan6) : null,
                'golongan7' => $request->golongan7 ? str_replace('.', '', $request->golongan7) : null,
                'golongan8' => $request->golongan8 ? str_replace('.', '', $request->golongan8) : null,
                'golongan9' => $request->golongan9 ? str_replace('.', '', $request->golongan9) : null,
                'golongan10' => $request->golongan10 ? str_replace('.', '', $request->golongan10) : null,
            ],
        ));

        return redirect('admin/rute_perjalanan')->with('success', 'Berhasil menambahkan rute perjalanan');
    }

    public function cetakpdf($id)
    {
        $cetakpdf = Rute_perjalanan::where('id', $id)->first();
        $html = view('admin/rute_perjalanan.cetak_pdf', compact('cetakpdf'));

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');

        $dompdf->render();

        $dompdf->stream();
    }

    // public function kode()
    // {
    //     $type = Rute_perjalanan::all();
    //     if ($type->isEmpty()) {
    //         $num = "000001";
    //     } else {
    //         $id = Rute_perjalanan::getId();
    //         foreach ($id as $value);
    //         $idlm = $value->id;
    //         $idbr = $idlm + 1;
    //         $num = sprintf("%06s", $idbr);
    //     }

    //     $data = 'RT';
    //     $kode_type = $data . $num;
    //     return $kode_type;
    // }

    public function kode()
    {
        $lastBarang = Rute_perjalanan::latest()->first();
        if (!$lastBarang) {
            $num = 1;
        } else {
            $lastCode = $lastBarang->kode_rute;
            $num = (int) substr($lastCode, strlen('RT')) + 1;
        }
        $formattedNum = sprintf("%06s", $num);
        $prefix = 'RT';
        $newCode = $prefix . $formattedNum;
        return $newCode;
    }

    public function edit($id)
    {
        // if (auth()->check() && auth()->user()->menu['rute perjalanan']) {
        $golongan = Golongan::all();
        $rute_perjalanan = Rute_perjalanan::where('id', $id)->first();
        $provinces = [
            'Aceh', 'Sumatera Utara', 'Sumatera Barat', 'Riau', 'Kepulauan Riau',
            'Jambi', 'Bengkulu', 'Sumatera Selatan', 'Bangka Belitung', 'Lampung',
            'DKI Jakarta', 'Banten', 'Jawa Barat', 'Jawa Tengah', 'DI Yogyakarta',
            'Jawa Timur', 'Bali', 'Nusa Tenggara Barat', 'Nusa Tenggara Timur',
            'Kalimantan Barat', 'Kalimantan Tengah', 'Kalimantan Selatan', 'Kalimantan Timur', 'Kalimantan Utara',
            'Sulawesi Utara', 'Sulawesi Tengah', 'Sulawesi Selatan', 'Sulawesi Tenggara',
            'Gorontalo', 'Maluku', 'Maluku Utara', 'Papua Barat', 'Papua', 'Sulawesi Barat'
        ];

        return view('admin/rute_perjalanan.update', compact('rute_perjalanan', 'provinces', 'golongan'));
        // } else {
        //     // tidak memiliki akses
        //     return back()->with('error', array('Anda tidak memiliki akses'));
        // }
    }

    // public function update(Request $request, $id)
    // {
    //     $validator = Validator::make(
    //         $request->all(),
    //         [
    //             'provinsi' => 'required',
    //             'nama_rute' => 'required',
    //         ],
    //         [
    //             'provinsi.required' => 'Pilih provinsi',
    //             'nama_rute.required' => 'Masukkan tujuan',
    //         ]
    //     );

    //     if ($validator->fails()) {
    //         $error = $validator->errors()->all();
    //         return back()->withInput()->with('error', $error);
    //     }

    //     $rute_perjalanan = Rute_perjalanan::findOrFail($id);

    //     $rute_perjalanan->provinsi = $request->provinsi;
    //     $rute_perjalanan->nama_rute = $request->nama_rute;
    //     $rute_perjalanan->golongan1 = $request->golongan1;
    //     $rute_perjalanan->golongan2 = $request->golongan2;
    //     $rute_perjalanan->golongan3 = $request->golongan3;
    //     $rute_perjalanan->golongan4 = $request->golongan4;
    //     $rute_perjalanan->golongan5 = $request->golongan5;
    //     $rute_perjalanan->golongan6 = $request->golongan6;
    //     $rute_perjalanan->golongan7 = $request->golongan7;
    //     $rute_perjalanan->golongan8 = $request->golongan8;
    //     $rute_perjalanan->golongan9 = $request->golongan9;
    //     $rute_perjalanan->golongan10 = $request->golongan10;

    //     $rute_perjalanan->save();

    //     return redirect('admin/rute_perjalanan')->with('success', 'Berhasil memperbarui rute perjalanan');
    // }

    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'provinsi' => 'required',
                'nama_rute' => 'required',
            ],
            [
                'provinsi.required' => 'Pilih provinsi',
                'nama_rute.required' => 'Masukkan tujuan',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }
        $nama_rute_uppercase = strtoupper($request->nama_rute);
        $rute_perjalanan = Rute_perjalanan::findOrFail($id);

        $rute_perjalanan->provinsi = $request->provinsi;
        $rute_perjalanan->nama_rute = $nama_rute_uppercase;
        $rute_perjalanan->golongan1 = $request->golongan1 ? str_replace('.', '', $request->golongan1) : null;
        $rute_perjalanan->golongan2 = $request->golongan2 ? str_replace('.', '', $request->golongan2) : null;
        $rute_perjalanan->golongan3 = $request->golongan3 ? str_replace('.', '', $request->golongan3) : null;
        $rute_perjalanan->golongan4 = $request->golongan4 ? str_replace('.', '', $request->golongan4) : null;
        $rute_perjalanan->golongan5 = $request->golongan5 ? str_replace('.', '', $request->golongan5) : null;
        $rute_perjalanan->golongan6 = $request->golongan6 ? str_replace('.', '', $request->golongan6) : null;
        $rute_perjalanan->golongan7 = $request->golongan7 ? str_replace('.', '', $request->golongan7) : null;
        $rute_perjalanan->golongan8 = $request->golongan8 ? str_replace('.', '', $request->golongan8) : null;
        $rute_perjalanan->golongan9 = $request->golongan9 ? str_replace('.', '', $request->golongan9) : null;
        $rute_perjalanan->golongan10 = $request->golongan10 ? str_replace('.', '', $request->golongan10) : null;


        $rute_perjalanan->save();

        return redirect('admin/rute_perjalanan')->with('success', 'Berhasil memperbarui rute perjalanan');
    }

    public function destroy($id)
    {
        $rute_perjalanan = Rute_perjalanan::find($id);
        $rute_perjalanan->delete();

        return redirect('admin/rute_perjalanan')->with('success', 'Berhasil menghapus rute perjalanan');
    }
}
