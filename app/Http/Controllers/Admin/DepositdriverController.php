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
use App\Models\Deposit_driver;
use App\Models\Karyawan;
use App\Models\Penerimaan_kaskecil;
use App\Models\Saldo;
use App\Models\Typeban;
use Illuminate\Support\Facades\Validator;

class DepositdriverController extends Controller
{
    public function index()
    {
        $SopirAll = Karyawan::where('departemen_id', '2')->get();
        return view('admin.deposit_driver.index', compact('SopirAll'));
    }


    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'kategori' => 'required',
                'karyawan_id' => 'required',
                // 'keterangan' => 'required', // Menambahkan aturan unique
            ],
            [
                'kategori.required' => 'Pilih kategori',
                'karyawan_id.required' => 'Pilih sopir',
                // 'keterangan.required' => 'Masukkan keterangan',
            ]
        );

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return back()->withInput()->with('error', $errors);
        }

        $kategori = $request->kategori;
        if ($kategori == "Pemasukan Deposit") {
            $kode = $this->kode();
            // $tanggal = Carbon::now()->format('d F Y');

            $subTotalInput = $request->input('sisa_saldo');
            $cleanedSubTotal = str_replace(['Rp', '.'], '', $subTotalInput);
            $cleanedSubTotal = str_replace(',', '.', $cleanedSubTotal);

            $tanggal1 = Carbon::now('Asia/Jakarta');
            $format_tanggal = $tanggal1->format('d F Y');

            $tanggal = Carbon::now()->format('Y-m-d');
            $penerimaan = Deposit_driver::create(array_merge(
                $request->all(),
                [
                    'kode_deposit' => $this->kode(),
                    'sisa_saldo' => $cleanedSubTotal,
                    'saldo_masuk' => str_replace('.', '', $request->saldo_masuk),
                    'sub_total' => $request->sub_total2,
                    'tanggal' =>  $format_tanggal,
                    'tanggal_awal' =>  $tanggal,
                    'status' => 'unpost',
                ]
            ));

            $cetakpdf = Deposit_driver::find($penerimaan->id);
            return view('admin.deposit_driver.show', compact('cetakpdf'));
        } else {
            // Sisanya tetap sama
            $kode = $this->kode();
            
            $subTotalInput = $request->input('sisa_saldos');
            $cleanedSubTotal = str_replace(['Rp', '.'], '', $subTotalInput);
            $cleanedSubTotal = str_replace(',',
                '.',
                $cleanedSubTotal
            );

            $tanggal1 = Carbon::now('Asia/Jakarta');
            $format_tanggal = $tanggal1->format('d F Y');

            $tanggal = Carbon::now()->format('Y-m-d');
            $penerimaan = Deposit_driver::create(array_merge(
                $request->all(),
                [
                    'kode_deposit' => $this->kode(),
                    'sub_total' => $request->sub_total2,
                    'nominal' => str_replace('.', '', $request->nominals),
                    'keterangan' => $request->keterangans,
                    'sisa_saldo' => $cleanedSubTotal,
                    'tanggal' =>  $format_tanggal,
                    'tanggal_awal' =>  $tanggal,
                    'status' => 'unpost',
                ]
            ));

            // $karyawanId = $request->karyawan_id;
            // $karyawan = Karyawan::find($karyawanId);

            // if ($karyawan) {
            //     // Remove "Rp" and dots from the sub_total
            //     $subTotal = str_replace(['Rp', '.'], '', $request->sub_totals);

            //     $karyawan->update([
            //         'tabungan' => $subTotal,
            //     ]);
            // } else {
            //     // Handle the case where the Karyawan with the given ID is not found
            // }


            $cetakpdf = Deposit_driver::find($penerimaan->id);


            return view('admin.deposit_driver.show', compact('cetakpdf'));
        }
    }

    // public function kode()
    // {
    //     $penerimaan = Deposit_driver::all();
    //     if ($penerimaan->isEmpty()) {
    //         $num = "000001";
    //     } else {
    //         $id = Deposit_driver::getId();
    //         foreach ($id as $value);
    //         $idlm = $value->id;
    //         $idbr = $idlm + 1;
    //         $num = sprintf("%06s", $idbr);
    //     }

    //     $data = 'FD';
    //     $kode_penerimaan = $data . $num;
    //     return $kode_penerimaan;
    // }

    public function kode()
    {
        $lastBarang = Deposit_driver::latest()->first();
        if (!$lastBarang) {
            $num = 1;
        } else {
            $lastCode = $lastBarang->kode_deposit;
            $num = (int) substr($lastCode, strlen('FD')) + 1;
        }
        $formattedNum = sprintf("%06s", $num);
        $prefix = 'FD';
        $newCode = $prefix . $formattedNum;
        return $newCode;
    }

    public function show($id)
    {
        $cetakpdf = Deposit_driver::where('id', $id)->first();

        return view('admin.deposit_driver.show', compact('cetakpdf'));
    }

    public function cetakpdf($id)
    {
        $cetakpdf = Deposit_driver::where('id', $id)->first();

        $pdf = PDF::loadView('admin.deposit_driver.cetak_pdf', compact('cetakpdf'));
        $pdf->setPaper('letter', 'portrait'); // Set the paper size to portrait letter

        return $pdf->stream('Faktur_Deposit_Driver.pdf');
    }
}