<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Supplier;
use App\Models\Sparepart;
use Illuminate\Http\Request;
use App\Models\Pembelian_aki;
use App\Http\Controllers\Controller;
use App\Models\Aki;
use App\Models\Merek_aki;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class PembelianakiController extends Controller
{

    public function index()
    {
        $today = Carbon::today();

        $inquery = Pembelian_aki::whereDate('created_at', $today)
            ->orWhere(function ($query) use ($today) {
                $query->where('status', 'unpost')
                    ->whereDate('created_at', '<', $today);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.pembelian_aki.index', compact('inquery'));
    }


    public function create()
    {
        if (auth()->check() && auth()->user()->menu['pembelian part']) {

            $pembelian_akis = Pembelian_aki::all();
            $suppliers = Supplier::all();
            $mereks = Merek_aki::all();

            return view('admin.pembelian_aki.create', compact('pembelian_akis', 'suppliers', 'mereks'));
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }

    public function store(Request $request)
    {
        $validasi_pelanggan = Validator::make($request->all(), [
            'supplier_id' => 'required',
        ], [
            'supplier_id.required' => 'Pilih nama supplier!',
        ]);

        $error_pelanggans = array();

        if ($validasi_pelanggan->fails()) {
            array_push($error_pelanggans, $validasi_pelanggan->errors()->all()[0]);
        }

        $error_pesanans = array();
        $data_pembelians = collect();

        if ($request->has('no_seri')) {
            for ($i = 0; $i < count($request->no_seri); $i++) {
                $validasi_produk = Validator::make($request->all(), [
                    'no_seri.' . $i => 'required',
                    'kondisi_aki.' . $i => 'required',
                    'merek_aki_id.' . $i => 'required',
                    'harga.' . $i => 'required',
                ]);

                if ($validasi_produk->fails()) {
                    array_push($error_pesanans, "Pembelian Aki nomor " . $i + 1 . " belum dilengkapi!");
                }


                $no_seri = is_null($request->no_seri[$i]) ? '' : $request->no_seri[$i];
                $kondisi_aki = is_null($request->kondisi_aki[$i]) ? '' : $request->kondisi_aki[$i];
                $merek_aki_id = is_null($request->merek_aki_id[$i]) ? '' : $request->merek_aki_id[$i];
                $harga = is_null($request->harga[$i]) ? '' : $request->harga[$i];

                $data_pembelians->push(['no_seri' => $no_seri, 'kondisi_aki' => $kondisi_aki, 'merek_aki_id' => $merek_aki_id,  'harga' => $harga]);
            }
        } else {
        }

        if ($error_pelanggans || $error_pesanans) {
            return back()
                ->withInput()
                ->with('error_pelanggans', $error_pelanggans)
                ->with('error_pesanans', $error_pesanans)
                ->with('data_pembelians', $data_pembelians);
        }

        // format tanggal indo
        $tanggal1 = Carbon::now('Asia/Jakarta');
        $format_tanggal = $tanggal1->format('d F Y');

        $tanggal = Carbon::now()->format('Y-m-d');
        $transaksi = Pembelian_aki::create([
            'user_id' => auth()->user()->id,
            'kode_pembelianaki' => $this->kode(),
            'supplier_id' => $request->supplier_id,
            'tanggal' => $format_tanggal,
            'tanggal_awal' => $tanggal,
            'grand_total' => str_replace(',', '.', str_replace('.', '', $request->grand_total)),
            'status' => 'posting',
            'status_notif' => false,
        ]);

        $transaksi_id = $transaksi->id;

        $kodeaki = $this->kodeaki();

        if ($transaksi) {
            foreach ($data_pembelians as $data_pesanan) {
                Aki::create([
                    'kode_aki' => $this->kodeaki(),
                    'pembelian_aki_id' => $transaksi->id,
                    'qrcode_aki' => 'https://javaline.id/aki/' . $this->kodeaki(),
                    'tanggal_awal' => Carbon::now()->format('Y-m-d'),
                    'no_seri' => $data_pesanan['no_seri'],
                    'kondisi_aki' => $data_pesanan['kondisi_aki'],
                    'merek_aki_id' => $data_pesanan['merek_aki_id'],
                    'status' => 'posting',
                    'status_aki' => 'stok',
                    'harga' =>  str_replace(',', '.', str_replace('.', '', $data_pesanan['harga'])),
                ]);
            }
        }

        $cetakpdf = Pembelian_aki::find($transaksi_id);

        $akis = Aki::where('pembelian_aki_id', $cetakpdf->id)->get();

        return view('admin.pembelian_aki.show', compact('akis', 'cetakpdf'));
    }

    public function aki($id)
    {
        $aki = Aki::with('merek_aki')->where('id', $id)->first();

        return json_decode($aki);
    }

    public function kode()
    {
        $pembelian_aki = Pembelian_aki::all();
        if ($pembelian_aki->isEmpty()) {
            $num = "000001";
        } else {
            $id = Pembelian_aki::getId();
            foreach ($id as $value);
            $idlm = $value->id;
            $idbr = $idlm + 1;
            $num = sprintf("%06s", $idbr);
        }

        $data = 'PA';
        $kode_pembelian_aki = $data . $num;
        return $kode_pembelian_aki;
    }

    public function kodeaki()
    {
        $ban = Aki::all();
        if ($ban->isEmpty()) {
            $num = "000001";
        } else {
            $id = Aki::getId();
            foreach ($id as $value);
            $idlm = $value->id;
            $idbr = $idlm + 1;
            $num = sprintf("%06s", $idbr);
        }

        $data = 'SA';
        $kode_ban = $data . $num;
        return $kode_ban;
    }

    public function show($id)
    {
        if (auth()->check() && auth()->user()->menu['pembelian part']) {

            $pembelian_aki = Pembelian_aki::find($id);
            $akis = Aki::where('pembelian_aki_id', $pembelian_aki->id)->get();


            $cetakpdf = Pembelian_aki::where('id', $id)->first();

            return view('admin.pembelian_aki.show', compact('akis', 'cetakpdf'));
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }

    public function cetakpdf($id)
    {
        if (auth()->check() && auth()->user()->menu['pembelian part']) {

            $cetakpdf = Pembelian_aki::find($id);
            $akis = Aki::where('pembelian_aki_id', $cetakpdf->id)->get();
            $pdf = PDF::loadView('admin.pembelian_aki.cetak_pdf', compact('akis', 'cetakpdf'));
            $pdf->setPaper('letter', 'portrait'); // Set the paper size to portrait letter

            return $pdf->stream('Faktur_Pembelian_Aki.pdf');
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }
}