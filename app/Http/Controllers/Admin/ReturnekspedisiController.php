<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Detail_return;
use App\Models\Karyawan;
use App\Models\Kendaraan;
use App\Models\Pelanggan;
use App\Models\Return_ekspedisi;
use App\Models\Satuan;
use App\Models\Tarif;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class ReturnekspedisiController extends Controller
{
    public function index()
    {
        $pelanggans = Pelanggan::all();
        $barangs = Barang::all();
        $kendaraans = Kendaraan::all();
        $drivers = User::whereHas('karyawan', function ($query) {
            $query->where('departemen_id', '2');
        })->get();

        return view('admin.return_ekspedisi.index', compact('pelanggans', 'barangs', 'kendaraans', 'drivers'));
    }

    public function store(Request $request)
    {
        $validasi_pelanggan = Validator::make(
            $request->all(),
            [
                'pelanggan_id' => 'required',
                'kendaraan_id' => 'required',
                'user_id' => 'required',
            ],
            [
                'pelanggan_id.required' => 'Pilih Pelanggan',
                'kendaraan_id.required' => 'Pilih Kendaraan',
                'user_id.required' => 'Pilih Sopir',
            ]
        );

        $error_pelanggans = array();

        if ($validasi_pelanggan->fails()) {
            array_push($error_pelanggans, $validasi_pelanggan->errors()->all()[0]);
        }

        $error_pesanans = array();
        $data_pembelians = collect();

        if ($request->has('barang_id')) {
            for ($i = 0; $i < count($request->barang_id); $i++) {
                $validasi_produk = Validator::make($request->all(), [
                    'barang_id.' . $i => 'required',
                    'kode_barang.' . $i => 'required',
                    'nama_barang.' . $i => 'required',
                    'satuan.' . $i => 'required',
                    'jumlah.' . $i => 'required',
                ]);

                if ($validasi_produk->fails()) {
                    array_push($error_pesanans, "Barang nomor " . ($i + 1) . " belum dilengkapi!"); // Corrected the syntax for concatenation and indexing
                }

                $barang_id = is_null($request->barang_id[$i]) ? '' : $request->barang_id[$i];
                $kode_barang = is_null($request->kode_barang[$i]) ? '' : $request->kode_barang[$i];
                $nama_barang = is_null($request->nama_barang[$i]) ? '' : $request->nama_barang[$i];
                $satuan = is_null($request->satuan[$i]) ? '' : $request->satuan[$i];
                $jumlah = is_null($request->jumlah[$i]) ? '' : $request->jumlah[$i];

                $data_pembelians->push([
                    'barang_id' => $barang_id,
                    'kode_barang' => $kode_barang,
                    'nama_barang' => $nama_barang,
                    'satuan' => $satuan,
                    'jumlah' => $jumlah,
                ]);
            }
        }


        if ($error_pelanggans || $error_pesanans) {
            return back()
                ->withInput()
                ->with('error_pelanggans', $error_pelanggans)
                ->with('error_pesanans', $error_pesanans)
                ->with('data_pembelians', $data_pembelians);
        }

        $kode = $this->kode();
        // format tanggal indo
        $tanggal1 = Carbon::now('Asia/Jakarta');
        $format_tanggal = $tanggal1->format('d F Y');

        $tanggal = Carbon::now()->format('Y-m-d');
        $cetakpdf = Return_ekspedisi::create([
            'admin' => auth()->user()->karyawan->nama_lengkap,
            'kode_return' => $this->kode(),
            'pelanggan_id' => $request->pelanggan_id,
            'kode_pelanggan' => $request->kode_pelanggan,
            'nama_pelanggan' => $request->nama_pelanggan,
            'alamat_pelanggan' => $request->alamat_pelanggan,
            'telp_pelanggan' => $request->telp_pelanggan,
            'kendaraan_id' => $request->kendaraan_id,
            'no_kabin' => $request->no_kabin,
            'no_pol' => $request->no_pol,
            'jenis_kendaraan' => $request->jenis_kendaraan,
            'user_id' => $request->user_id,
            'kode_driver' => $request->kode_driver,
            'nama_driver' => $request->nama_driver,
            'telp' => $request->telp,
            'tanggal' => $format_tanggal,
            'tanggal_awal' => $tanggal,
            'qrcode_return' => 'https://javaline.id/return_ekspedisi/' . $kode,
            'status' => 'posting',
            'status_notif' => false,
        ]);

        $transaksi_id = $cetakpdf->id;

        if ($cetakpdf) {
            foreach ($data_pembelians as $data_pesanan) {
                Detail_return::create([
                    'return_ekspedisi_id' => $cetakpdf->id,
                    'barang_id' => $data_pesanan['barang_id'],
                    'kode_barang' => $data_pesanan['kode_barang'],
                    'nama_barang' => $data_pesanan['nama_barang'],
                    'satuan' => $data_pesanan['satuan'],
                    'jumlah' => $data_pesanan['jumlah'],
                ]);
            }
        }

        $details = Detail_return::where('return_ekspedisi_id', $cetakpdf->id)->get();

        return view('admin.return_ekspedisi.show', compact('cetakpdf', 'details'));
    }


    // public function kode()
    // {
    //     $item = Return_ekspedisi::all();
    //     if ($item->isEmpty()) {
    //         $num = "000001";
    //     } else {
    //         $id = Return_ekspedisi::getId();
    //         foreach ($id as $value);
    //         $idlm = $value->id;
    //         $idbr = $idlm + 1;
    //         $num = sprintf("%06s", $idbr);
    //     }

    //     $data = 'SR';
    //     $kode_item = $data . $num;
    //     return $kode_item;
    // }

    public function kode()
    {
        $lastBarang = Return_ekspedisi::latest()->first();
        if (!$lastBarang) {
            $num = 1;
        } else {
            $lastCode = $lastBarang->kode_return;
            $num = (int) substr($lastCode, strlen('SR')) + 1;
        }
        $formattedNum = sprintf("%06s", $num);
        $prefix = 'SR';
        $newCode = $prefix . $formattedNum;
        return $newCode;
    }

    public function tambah_barang(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama_barang' => 'required',
                'harga_beli' => 'required',
            ],
            [
                'nama_barang.required' => 'Masukkan nama barang',
                'harga_beli.required' => 'Masukkan harga beli',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return response()->json(['success' => false, 'message' => $error]);
        }

        $kodebarang = $this->kodebarang();

        Barang::create(array_merge(
            $request->all(),
            [
                'kode_barang' => $this->kodebarang(),
                // 'qrcode_rute' => 'https://javaline.id/rute_perjalanan/' . $kode,
                'tanggal_awal' => Carbon::now('Asia/Jakarta'),
            ],
        ));

        return back()->with('success', 'Berhasil menambahkan barang');
    }


    public function kodebarang()
    {
        $type = Barang::all();
        if ($type->isEmpty()) {
            $num = "000001";
        } else {
            $id = Barang::getId();
            foreach ($id as $value);
            $idlm = $value->id;
            $idbr = $idlm + 1;
            $num = sprintf("%06s", $idbr);
        }

        $data = 'BB';
        $kode_type = $data . $num;
        return $kode_type;
    }

    public function show($id)
    {
        $cetakpdf = Return_ekspedisi::where('id', $id)->first();

        return view('admin.memo_ekspedisi.show', compact('cetakpdf'));
    }

    public function cetakpdf($id)
    {
        $cetakpdf = Return_ekspedisi::where('id', $id)->first();
        $details = Detail_return::where('return_ekspedisi_id', $cetakpdf->id)->get();

        $pdf = PDF::loadView('admin.return_ekspedisi.cetak_pdf', compact('cetakpdf', 'details'));
        $pdf->setPaper('letter', 'portrait'); // Set the paper size to portrait letter

        return $pdf->stream('Return_Ekspedisi.pdf');
    }
}