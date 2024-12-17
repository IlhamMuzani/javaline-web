<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Supplier;
use App\Models\Sparepart;
use Illuminate\Http\Request;
use App\Models\Pembelian_aki;
use App\Http\Controllers\Controller;
use App\Models\Detail_pembelianaki;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class PembelianakiController extends Controller
{
    public function index()
    {
        if (auth()->check() && auth()->user()->menu['pembelian part']) {

            $pembelian_akis = Pembelian_aki::all();
            $suppliers = Supplier::all();
            $spareparts = Sparepart::all();

            return view('admin.pembelian_aki.index', compact('pembelian_akis', 'suppliers', 'spareparts'));
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }

    public function tabelpart()
    {
        $spareparts = Sparepart::all();
        return response()->json($spareparts);
    }

    // public function tabelpartmesin()
    // {
    //     $spareparts = Sparepart::where('kategori', 'mesin')->get();
    //     return response()->json($spareparts);
    // }


    public function create()
    {
        if (auth()->check() && auth()->user()->menu['pembelian part']) {

            $suppliers = Supplier::all();
            $spareparts = Sparepart::all();
            return view('admin/pembelian_aki/create', compact('suppliers', 'spareparts'));
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }

    public function tambah_supplier(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama_supp' => 'required',
                'alamat' => 'required',
            ],
            [
                'nama_supp.required' => 'Masukkan nama supplier',
                'alamat.required' => 'Masukkan Alamat',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }


        $kode_supp = $this->kode_supp();

        Supplier::create(array_merge(
            $request->all(),
            [
                'kode_supplier' => $this->kode_supp(),
                'qrcode_supplier' => 'https://javaline.id/supplier/' . $kode_supp,
                'tanggal_awal' => Carbon::now('Asia/Jakarta'),
            ]
        ));

        return Redirect::back()->with('success', 'Berhasil menambahkan supplier');
    }

    public function kode_supp()
    {
        $supplier = Supplier::all();
        if ($supplier->isEmpty()) {
            $num = "000001";
        } else {
            $id = Supplier::getId();
            foreach ($id as $value);
            $idlm = $value->id;
            $idbr = $idlm + 1;
            $num = sprintf("%06s", $idbr);
        }

        $data = 'AC';
        $kode_supplier = $data . $num;
        return $kode_supplier;
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

        if ($request->has('kategori')) {
            for ($i = 0; $i < count($request->kategori); $i++) {
                $validasi_produk = Validator::make($request->all(), [
                    'kategori.' . $i => 'required',
                    'sparepart_id.' . $i => 'required',
                    'kode_akidetail.' . $i => 'required',
                    'nama_barang.' . $i => 'required',
                    'satuan.' . $i => 'required',
                    'jumlah.' . $i => 'required',
                    'hargasatuan.' . $i => 'required',
                    'harga.' . $i => 'required',
                ]);

                if ($validasi_produk->fails()) {
                    array_push($error_pesanans, "Pembelian Aki nomor " . $i + 1 . " belum dilengkapi!");
                }


                $kategori = is_null($request->kategori[$i]) ? '' : $request->kategori[$i];
                $sparepart_id = is_null($request->sparepart_id[$i]) ? '' : $request->sparepart_id[$i];
                $kode_akidetail = is_null($request->kode_akidetail[$i]) ? '' : $request->kode_akidetail[$i];
                $nama_barang = is_null($request->nama_barang[$i]) ? '' : $request->nama_barang[$i];
                $satuan = is_null($request->satuan[$i]) ? '' : $request->satuan[$i];
                $jumlah = is_null($request->kategori[$i]) ? '' : $request->jumlah[$i];
                $hargasatuan = is_null($request->hargasatuan[$i]) ? '' : $request->hargasatuan[$i];
                $harga = is_null($request->harga[$i]) ? '' : $request->harga[$i];

                $data_pembelians->push([
                    'kategori' => $kategori,
                    'sparepart_id' => $sparepart_id,
                    'kode_akidetail' => $kode_akidetail,
                    'nama_barang' => $nama_barang,
                    'satuan' => $satuan,
                    'jumlah' => $jumlah,
                    'hargasatuan' => $hargasatuan,
                    'harga' => $harga,
                ]);
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
            'status' => 'posting',
            'status_notif' => false,
        ]);

        $transaksi_id = $transaksi->id;

        if ($transaksi) {
            foreach ($data_pembelians as $data_pesanan) {
                // Create a new Detailpembelian
                Detail_pembelianaki::create([
                    'pembelian_aki_id' => $transaksi->id,
                    'sparepart_id' => $data_pesanan['sparepart_id'],
                    'tanggal_awal' => Carbon::now('Asia/Jakarta'),
                    'kategori' => $data_pesanan['kategori'],
                    'kode_akidetail' => $data_pesanan['kode_akidetail'],
                    'nama_barang' => $data_pesanan['nama_barang'],
                    'jumlah' => $data_pesanan['jumlah'],
                    'satuan' => $data_pesanan['satuan'],
                    'hargasatuan' => $data_pesanan['hargasatuan'],
                    'harga' => $data_pesanan['harga'],
                ]);

                // Increment the quantity of the barang
                Sparepart::where('id', $data_pesanan['sparepart_id'])->increment('jumlah', $data_pesanan['jumlah']);
            }
        }

        $pembelians = Pembelian_aki::find($transaksi_id);

        $parts = Detail_pembelianaki::where('pembelian_aki_id', $pembelians->id)->get();

        return view('admin.pembelian_aki.show', compact('parts', 'pembelians'));
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

    public function sparepart($id)
    {
        $sparepart = Sparepart::where('id', $id)->first();

        return json_decode($sparepart);
    }

    public function show($id)
    {
        if (auth()->check() && auth()->user()->menu['pembelian part']) {

            $pembelian_aki = Pembelian_aki::find($id);
            $parts = Detail_pembelianaki::where('pembelian_aki_id', $pembelian_aki->id)->get();


            $pembelians = Pembelian_aki::where('id', $id)->first();

            return view('admin.pembelian_aki.show', compact('parts', 'pembelians'));
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }

    public function cetakpdf($id)
    {
        if (auth()->check() && auth()->user()->menu['pembelian part']) {

            $pembelians = Pembelian_aki::find($id);
            $parts = Detail_pembelianaki::where('pembelian_aki_id', $pembelians->id)->get();

            // Load the view and set the paper size to portrait letter
            $pembelianbans = Pembelian_aki::where('id', $id)->first();
            $pdf = PDF::loadView('admin.pembelian_aki.cetak_pdf', compact('parts', 'pembelians', 'pembelianbans'));
            $pdf->setPaper('letter', 'portrait'); // Set the paper size to portrait letter

            return $pdf->stream('Faktur_Pembelian_Ban.pdf');
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }
}