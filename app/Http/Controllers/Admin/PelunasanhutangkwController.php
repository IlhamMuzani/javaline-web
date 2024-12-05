<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Pelunasan_hutangkw;
use App\Models\Karyawan;
use Illuminate\Support\Facades\Validator;

class PelunasanhutangkwController extends Controller
{

    public function index()
    {
        $today = Carbon::today();

        $inquery = Pelunasan_hutangkw::whereDate('created_at', $today)
            ->orWhere(function ($query) use ($today) {
                $query->where('status', 'unpost')
                    ->whereDate('created_at', '<', $today);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.pelunasan_hutangkw.index', compact('inquery'));
    }

    public function create()
    {
        $SopirAll =
            Karyawan::whereIn('departemen_id', [1, 4, 5])->get();
        return view('admin.pelunasan_hutangkw.create', compact('SopirAll'));
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

        $kode = $this->kode();
        $subTotalInput = $request->input('sisa_saldo');
        $cleanedSubTotal = str_replace(['Rp', '.'], '', $subTotalInput);
        $cleanedSubTotal = str_replace(',', '.', $cleanedSubTotal);

        $tanggal1 = Carbon::now('Asia/Jakarta');
        $format_tanggal = $tanggal1->format('d F Y');

        $tanggal = Carbon::now()->format('Y-m-d');
        $penerimaan = Pelunasan_hutangkw::create(array_merge(
            $request->all(),
            [
                'kode_deposit' => $this->kode(),
                'karyawan_id' => $request->karyawan_id,
                'sisa_saldo' => $cleanedSubTotal,
                'saldo_masuk' => str_replace('.', '', $request->saldo_masuk),
                'sub_total' => $request->sub_total2,
                'tanggal' =>  $format_tanggal,
                'tanggal_awal' =>  $tanggal,
                'status' => 'unpost',
            ]
        ));
        $cetakpdf = Pelunasan_hutangkw::find($penerimaan->id);
        return view('admin.pelunasan_hutangkw.show', compact('cetakpdf'));
    }

    public function kode()
    {
        $lastBarang = Pelunasan_hutangkw::latest()->first();
        if (!$lastBarang) {
            $num = 1;
        } else {
            $lastCode = $lastBarang->kode_deposit;
            $num = (int) substr($lastCode, strlen('PH')) + 1;
        }
        $formattedNum = sprintf("%06s", $num);
        $prefix = 'PH';
        $newCode = $prefix . $formattedNum;
        return $newCode;
    }

    public function show($id)
    {
        $cetakpdf = Pelunasan_hutangkw::where('id', $id)->first();
        return view('admin.pelunasan_hutangkw.show', compact('cetakpdf'));
    }

    public function cetakpdf($id)
    {
        $cetakpdf = Pelunasan_hutangkw::where('id', $id)->first();
        $pdf = PDF::loadView('admin.pelunasan_hutangkw.cetak_pdf', compact('cetakpdf'));
        $pdf->setPaper('letter', 'portrait');
        return $pdf->stream('Faktur_Deposit_Driver.pdf');
    }
}
