<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Pengeluaran_asuransi;
use App\Models\Total_asuransi;

use Illuminate\Support\Facades\Validator;

class PengambilanasuransiController extends Controller
{
    public function index()
    {
        $saldoTerakhir = Total_asuransi::latest()->first();
        return view('admin.pengambilanasuransi.index', compact('saldoTerakhir'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nominal' => 'required',
            ],
            [
                'nominal.required' => 'Masukkan nominal',
            ]
        );

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return back()->withInput()->with('error', $errors);
        }

        // Sisanya tetap sama
        $kode = $this->kode();
        // $tanggal = Carbon::now()->format('d F Y');

        // Mengonversi nilai grand_total dari format rupiah ke angka
        $subTotalInput = $request->input('grand_total');
        $cleanedSubTotal = (int) str_replace(['Rp', '.'], '', $subTotalInput);

        // Ubah koma menjadi titik
        $cleanedSubTotal = str_replace(',', '.', $cleanedSubTotal);

        $saldoTerakhir = Total_asuransi::latest()->first();
        $saldo = $saldoTerakhir->id;
        $tanggal1 = Carbon::now('Asia/Jakarta');
        $format_tanggal = $tanggal1->format('d F Y');

        $tanggal = Carbon::now()->format('Y-m-d');
        $penerimaan = Pengeluaran_asuransi::create(array_merge(
            $request->all(),
            [
                'user_id' => auth()->user()->id,
                'kode_pengambilanasuransi' => $this->kode(),
                'total_asuransi_id' => $saldo,
                'nominal' => $request->nominal ? str_replace('.', '', $request->nominal) : null,
                'grand_total' => $cleanedSubTotal,
                'qr_code_pengeluran' => 'https:///javaline.id/pengambilanasuransi/' . $kode,
                'tanggaljam' => Carbon::now('Asia/Jakarta'),
                'jam' => $tanggal1->format('H:i:s'),
                'tanggal' =>  $format_tanggal,
                'tanggal_awal' =>  $tanggal,
                'status' => 'posting',
            ]
        ));

        $penerimaans = $penerimaan->id;


        $saldoSebelumnya = Total_asuransi::latest()->first(); // Mendapatkan saldo terakhir
        $saldoSisa = $saldoSebelumnya->sisa_asuransi - $cleanedSubTotal;

        // Menambahkan data ke tabel Saldo
        Total_asuransi::create([
            'jam' => $tanggal1->format('H:i:s'),
            'tanggal' => Carbon::now('Asia/Jakarta'),
            'sisa_asuransi' => $cleanedSubTotal,
            'status' => 'saldo keluar',
        ]);

        $cetakpdf = Pengeluaran_asuransi::find($penerimaans);


        return view('admin.pengambilanasuransi.show', compact('cetakpdf'));
    }

    public function kode()
    {
        $lastBarang = Pengeluaran_asuransi::latest()->first();
        if (!$lastBarang) {
            $num = 1;
        } else {
            $lastCode = $lastBarang->kode_pengambilanasuransi;
            $num = (int) substr($lastCode, strlen('PA')) + 1;
        }
        $formattedNum = sprintf("%06s", $num);
        $prefix = 'PA';
        $newCode = $prefix . $formattedNum;
        return $newCode;
    }

    public function cetakpdf($id)
    {
        $cetakpdf = Pengeluaran_asuransi::where('id', $id)->first();

        $pdf = PDF::loadView('admin.pengambilanasuransi.cetak_pdf', compact('cetakpdf'));
        $pdf->setPaper('letter', 'portrait'); // Set the paper size to portrait letter

        return $pdf->stream('Faktur_Pengambilan_asuransi.pdf');
    }
}