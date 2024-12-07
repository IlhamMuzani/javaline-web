<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Deposit_driver;
use App\Models\Karyawan;
use Illuminate\Support\Facades\Validator;

class NotabonController extends Controller
{
    public function index()
    {
        $SopirAll = Karyawan::where('departemen_id', '2')->get();
        return view('admin.nota_bon.index', compact('SopirAll'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'karyawan_id' => 'required',
                'nominal' => 'required',
            ],
            [
                'karyawan_id.required' => 'Pilih sopir',
                'nominal.required' => 'Masukkan nominal',
            ]
        );

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return back()->withInput()->with('error', $errors);
        }

        $kode = $this->kode();

        $tanggal1 = Carbon::now('Asia/Jakarta');
        $format_tanggal = $tanggal1->format('d F Y');

        $tanggal = Carbon::now()->format('Y-m-d');
        $penerimaan = Deposit_driver::create(array_merge(
            $request->all(),
            [
                'kode_nota' => $this->kode(),
                'user_id' => auth()->user()->id,
                'nominal' => str_replace(',', '.', str_replace('.', '', $request->nominal)),
                'keterangan' => $request->keterangan,
                'tanggal' =>  $format_tanggal,
                'tanggal_awal' =>  $tanggal,
                'status' => 'unpost',
            ]
        ));
        $cetakpdf = Deposit_driver::find($penerimaan->id);
        return view('admin.nota_bon.show', compact('cetakpdf'));
    }

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
        return view('admin.nota_bon.show', compact('cetakpdf'));
    }

    public function cetakpdf($id)
    {
        $cetakpdf = Deposit_driver::where('id', $id)->first();
        $pdf = PDF::loadView('admin.nota_bon.cetak_pdf', compact('cetakpdf'));
        $pdf->setPaper('letter', 'portrait');
        return $pdf->stream('Faktur_Deposit_Driver.pdf');
    }
}