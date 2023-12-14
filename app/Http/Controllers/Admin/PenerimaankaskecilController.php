<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Dompdf\Dompdf;
use App\Models\Merek;
use App\Models\Ukuran;
use App\Models\Supplier;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Models\Pembelian_ban;
use App\Models\Detail_pembelianban;
use App\Http\Controllers\Controller;
use App\Models\Ban;
use App\Models\Penerimaan_kaskecil;
use App\Models\Saldo;
use App\Models\Typeban;
use Illuminate\Support\Facades\Validator;

class PenerimaankaskecilController extends Controller
{
    public function index()
    {
        $saldoTerakhir = Saldo::latest()->first();
        return view('admin.penerimaan_kaskecil.index', compact('saldoTerakhir'));
    }


    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nominal' => 'required',
                // 'keterangan' => 'required', // Menambahkan aturan unique
            ],
            [
                'nominal.required' => 'Masukkan nominal',
                // 'keterangan.required' => 'Masukkan keterangan',
            ]
        );

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return back()->withInput()->with('error', $errors);
        }

        // Sisanya tetap sama
        $kode = $this->kode();
        // $tanggal = Carbon::now()->format('d F Y');

        // Mengonversi nilai sub_total dari format rupiah ke angka
        $subTotalInput = $request->input('sub_total');
        $cleanedSubTotal = (int) str_replace(['Rp', '.'], '', $subTotalInput);

        $saldoTerakhir = Saldo::latest()->first();
        $saldo = $saldoTerakhir->id;
        $tanggal1 = Carbon::now('Asia/Jakarta');
        $format_tanggal = $tanggal1->format('d F Y');

        $tanggal = Carbon::now()->format('Y-m-d');
        $penerimaan = Penerimaan_kaskecil::create(array_merge(
            $request->all(),
            [
                'kode_penerimaan' => $this->kode(),
                'saldo_id' => $saldo,
                'sub_total' => $cleanedSubTotal,
                'qr_code_penerimaan' => 'https:///javaline.id/penerimaan_kaskecil/' . $kode,
                'tanggaljam' => Carbon::now('Asia/Jakarta'),
                'jam' => $tanggal1->format('H:i:s'),
                'tanggal' =>  $format_tanggal,
                'tanggal_awal' =>  $tanggal,
                'status' => 'posting',
            ]
        ));

        $penerimaans = $penerimaan->id;


        $saldoSebelumnya = Saldo::latest()->first(); // Mendapatkan saldo terakhir
        $saldoSisa = $saldoSebelumnya->sisa_saldo - $cleanedSubTotal;

        // Menambahkan data ke tabel Saldo
        Saldo::create([
            'jam' => $tanggal1->format('H:i:s'),
            'tanggal' => Carbon::now('Asia/Jakarta'),
            'sisa_saldo' => $cleanedSubTotal,
            'status' => 'saldo masuk',
        ]);

        $cetakpdf = Penerimaan_kaskecil::find($penerimaans);


        return view('admin.penerimaan_kaskecil.show', compact('cetakpdf'));
    }

    public function kode()
    {
        $penerimaan = Penerimaan_kaskecil::all();
        if ($penerimaan->isEmpty()) {
            $num = "000001";
        } else {
            $id = Penerimaan_kaskecil::getId();
            foreach ($id as $value);
            $idlm = $value->id;
            $idbr = $idlm + 1;
            $num = sprintf("%06s", $idbr);
        }

        $data = 'FK';
        $kode_penerimaan = $data . $num;
        return $kode_penerimaan;
    }


    public function show($id)
    {
        $cetakpdf = Penerimaan_kaskecil::where('id', $id)->first();

        return view('admin.pembelian_ban.show', compact('cetakpdf'));
    }

    public function cetakpdf($id)
    {
        $cetakpdf = Penerimaan_kaskecil::where('id', $id)->first();

        $pdf = PDF::loadView('admin.penerimaan_kaskecil.cetak_pdf', compact('cetakpdf'));
        $pdf->setPaper('letter', 'portrait'); // Set the paper size to portrait letter

        return $pdf->stream('Faktur_Penerimaan_Kas_Kecil.pdf');
    }
}