<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Kendaraan;
use App\Models\Sparepart;
use Illuminate\Http\Request;
use App\Models\Pengambilan_do;
use App\Http\Controllers\Controller;
use App\Models\Detail_inventory;
use App\Models\Detail_pembelianpart;
use App\Models\Detail_pemakaian;
use App\Models\Spk;
use Illuminate\Support\Facades\Validator;

class PengambilandoController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        $inquery = Pengambilan_do::whereDate('created_at', $today)
            ->orWhere(function ($query) use ($today) {
                $query->where('status', 'unpost')
                    ->whereDate('created_at', '<', $today);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.pengambilan_do.index', compact('inquery'));
    }
    public function create()
    {
        $spks = Spk::orderBy('created_at', 'desc')
            ->get();

        return view('admin.pengambilan_do.create', compact('spks'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'spk_id' => 'required',
                'latitude' => 'required',
            ],
            [
                'spk_id.required' => 'Pilih SPK',
                'latitude.required' => 'Pilih titik tujuan',
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

        $projects = Pengambilan_do::create(array_merge(
            $request->all(),
            [
                'kode_pengambilan' => $kode,
                'spk_id' => $request->spk_id,
                'kendaraan_id' => $request->kendaraan_id,
                'rute_perjalanan_id' => $request->rute_perjalanan_id,
                'user_id' => $request->user_id,
                'tanggal_awal' => $tanggal,
                'tanggal' => $format_tanggal,
                'status' => 'posting',
            ]
        ));
        $projects->save();

        return redirect('admin/pengambilan_do')->with('success', 'Berhasil menyimpan');
    }

    public function show($id)
    {
        $cetakpdf = Pengambilan_do::where('id', $id)->first();

        return view('admin.pengambilan_do.show', compact('cetakpdf'));
    }

    public function cetakpdf($id)
    {
        $cetakpdf = Pengambilan_do::where('id', $id)->first();

        $pdf = PDF::loadView('admin.pengambilan_do.cetak_pdf', compact('cetakpdf'));
        $pdf->setPaper('letter', 'portrait'); 

        return $pdf->stream('Pengambilan_do.pdf');
    }

    public function kode()
    {
        $lastItem = Pengambilan_do::latest()->first();
        if (!$lastItem) {
            $num = 1;
        } else {
            $lastCode = $lastItem->kode_pengambilan;
            $num = (int) substr($lastCode, strlen('APD')) + 1;
        }
        $formattedNum = sprintf("%06s", $num);
        $prefix = 'APD';
        $newCode = $prefix . $formattedNum;
        return $newCode;
    }
    public function destroy($id)
    {
        $part = Pengambilan_do::find($id);
        $part->delete();
        return;
    }
}