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
        // Dapatkan kode barang terakhir
        $lastBarang = Potongan_penjualan::latest()->first();
        // Jika tidak ada barang dalam database
        if (!$lastBarang) {
            $num = 1;
        } else {
            // Dapatkan nomor dari kode barang terakhir dan tambahkan 1
            $lastCode = $lastBarang->kode_potongan;
            // Ambil angka setelah huruf dengan membuang karakter awalan
            $num = (int) substr($lastCode, strlen('PP')) + 1;
        }
        // Format nomor dengan panjang 6 digit (mis. 000001)
        $formattedNum = sprintf("%06s", $num);
        // Kode awalan
        $prefix = 'PP';
        // Gabungkan kode awalan dengan nomor yang diformat
        $newCode = $prefix . $formattedNum;
        return $newCode;
    }
}