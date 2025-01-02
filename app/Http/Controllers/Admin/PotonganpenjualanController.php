<?php

namespace App\Http\Controllers\admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use App\Models\Potongan_penjualan;
use App\Models\Tarif;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Validator;

class PotonganpenjualanController extends Controller
{
    public function index()
    {
        // if (auth()->check() && auth()->user()->menu['rute perjalanan']) {
        return view('admin/potongan_penjualan.create');
        // } else {
        //     // tidak memiliki akses
        //     return back()->with('error', array('Anda tidak memiliki akses'));
        // }
    }

    public function create()
    {
        // if (auth()->check() && auth()->user()->menu['rute perjalanan']) {

        return view('admin/potongan_penjualan.create');
        // } else {
        //     // tidak memiliki akses
        //     return back()->with('error', array('Anda tidak memiliki akses'));
        // }
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'keterangan' => 'required',
                'grand_total' => 'required',
            ],
            [
                'keterangan.required' => 'Masukkan keterangan',
                'grand_total.required' => 'Masukkan nominal',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $kode = $this->kode();
        $tanggal1 = Carbon::now('Asia/Jakarta');
        $format_tanggal = $tanggal1->format('d F Y');

        $tanggal = Carbon::now()->format('Y-m-d');
        $cetakpdf = Potongan_penjualan::create(array_merge(
            $request->all(),
            [
                'user_id' => auth()->user()->id,
                'kode_potongan' => $this->kode(),
                'grand_total' => str_replace('.', '', $request->grand_total),
                // 'qrcode_rute' => 'https://javaline.id/potongan_penjualan/' . $kode,
                'tanggal' =>  $format_tanggal,
                'tanggal_awal' =>  $tanggal,
                'status' => 'unpost',
            ],
        ));

        return view('admin.potongan_penjualan.show', compact('cetakpdf'));
    }

    public function cetakpdf($id)
    {
        $cetakpdf = Potongan_penjualan::where('id', $id)->first();

        $pdf = PDF::loadView('admin.potongan_penjualan.cetak_pdf', compact('cetakpdf'));
        $pdf->setPaper('letter', 'portrait'); // Set the paper size to portrait letter

        return $pdf->stream('Potongan_Penjualan.pdf');
    }

    public function kode()
    {
        // Ambil kode SPK terakhir yang sesuai format 'FQ%'
        $lastBarang = Potongan_penjualan::where('kode_potongan', 'like', 'FQ%')->orderBy('id', 'desc')->first();

        // Inisialisasi nomor urut
        $num = 1;

        // Jika ada kode terakhir, proses untuk mendapatkan nomor urut
        if ($lastBarang) {
            $lastCode = $lastBarang->kode_potongan;

            // Pastikan kode terakhir sesuai dengan format FQ[YYYYMMDD][NNNN]
            if (preg_match('/^FQ(\d{6})(\d{4})$/', $lastCode, $matches)) {
                $lastDate = $matches[1]; // Bagian tanggal: ymd (contoh: 241125)
                $lastMonth = substr($lastDate, 2, 2); // Ambil bulan dari tanggal (contoh: 11)
                $currentMonth = date('m'); // Bulan saat ini

                if ($lastMonth === $currentMonth) {
                    // Jika bulan sama, tambahkan nomor urut
                    $lastNum = (int)$matches[2]; // Bagian nomor urut (contoh: 0001)
                    $num = $lastNum + 1;
                }
            }
        }

        // Formatkan nomor urut menjadi 4 digit
        $formattedNum = sprintf("%04s", $num);

        // Buat kode baru
        $prefix = 'FQ';
        $tanggal = date('ymd'); // Format ymd (tahun, bulan, tanggal)
        $newCode = $prefix . $tanggal . $formattedNum;

        return $newCode;
    }
}
