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
use App\Models\Penambahan_saldokasbon;
use App\Models\Total_kasbon;
use App\Models\Typeban;
use Illuminate\Support\Facades\Validator;

class PenambahansaldokasbonController extends Controller
{
    public function index()
    {
        $saldoTerakhir = Total_kasbon::latest()->first();
        return view('admin.penambahan_saldokasbon.index', compact('saldoTerakhir'));
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
                // 'nominal.numeric' => 'Nominal harus berupa angka',
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

        $subTotalInput = $request->input('sub_total');

        // Hilangkan 'Rp' dan titik
        $cleanedSubTotal = str_replace(['Rp', '.'], '', $subTotalInput);

        // Ubah koma menjadi titik
        $cleanedSubTotal = str_replace(',', '.', $cleanedSubTotal);

        $saldoTerakhir = Total_kasbon::latest()->first();
        $saldo = $saldoTerakhir->id;
        $tanggal1 = Carbon::now('Asia/Jakarta');
        $format_tanggal = $tanggal1->format('d F Y');

        $tanggal = Carbon::now()->format('Y-m-d');
        $penerimaan = Penambahan_saldokasbon::create(array_merge(
            $request->all(),
            [
                'kode_penerimaan' => $this->kode(),
                'nominal' => $request->nominal ? str_replace('.', '', $request->nominal) : null,
                'total_kasbon_id' => $saldo,
                'sub_total' => $cleanedSubTotal,
                'qr_code_penerimaan' => 'https:///javaline.id/penambahan_saldokasbon/' . $kode,
                'tanggaljam' => Carbon::now('Asia/Jakarta'),
                'jam' => $tanggal1->format('H:i:s'),
                'tanggal' =>  $format_tanggal,
                'tanggal_awal' =>  $tanggal,
                'status' => 'posting',
            ]
        ));


        $penerimaans = $penerimaan->id;


        $saldoSebelumnya = Total_kasbon::latest()->first(); // Mendapatkan saldo terakhir
        $saldoSisa = $saldoSebelumnya->sisa_kasbon - $cleanedSubTotal;

        // Menambahkan data ke tabel Total_kasbon
        Total_kasbon::create([
            'jam' => $tanggal1->format('H:i:s'),
            'tanggal' => Carbon::now('Asia/Jakarta'),
            'sisa_kasbon' => $cleanedSubTotal,
            'status' => 'saldo masuk',
        ]);

        $cetakpdf = Penambahan_saldokasbon::find($penerimaans);


        return view('admin.penambahan_saldokasbon.show', compact('cetakpdf'));
    }

    // public function kode()
    // {
    //     $penerimaan = Penambahan_saldokasbon::all();
    //     if ($penerimaan->isEmpty()) {
    //         $num = "000001";
    //     } else {
    //         $id = Penambahan_saldokasbon::getId();
    //         foreach ($id as $value);
    //         $idlm = $value->id;
    //         $idbr = $idlm + 1;
    //         $num = sprintf("%06s", $idbr);
    //     }

    //     $data = 'FK';
    //     $kode_penerimaan = $data . $num;
    //     return $kode_penerimaan;
    // }

    public function kode()
    {
        $lastBarang = Penambahan_saldokasbon::latest()->first();
        if (!$lastBarang) {
            $num = 1;
        } else {
            $lastCode = $lastBarang->kode_penerimaan;
            $num = (int) substr($lastCode, strlen('FKK')) + 1;
        }
        $formattedNum = sprintf("%06s", $num);
        $prefix = 'FKK';
        $newCode = $prefix . $formattedNum;
        return $newCode;
    }

    public function show($id)
    {
        $cetakpdf = Penambahan_saldokasbon::where('id', $id)->first();

        return view('admin.pembelian_ban.show', compact('cetakpdf'));
    }

    public function cetakpdf($id)
    {
        $cetakpdf = Penambahan_saldokasbon::where('id', $id)->first();

        $pdf = PDF::loadView('admin.penambahan_saldokasbon.cetak_pdf', compact('cetakpdf'));
        $pdf->setPaper('letter', 'portrait'); // Set the paper size to portrait letter

        return $pdf->stream('Faktur_Penerimaan_Kas_Kecil.pdf');
    }
}