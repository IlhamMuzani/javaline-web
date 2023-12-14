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
use App\Models\Biaya_tambahan;
use App\Models\Detail_memo;
use App\Models\Detail_memotambahan;
use App\Models\Kendaraan;
use App\Models\Memo_ekspedisi;
use App\Models\Memo_tambahan;
use App\Models\Memotambahan;
use App\Models\Pelanggan;
use App\Models\Penerimaan_kaskecil;
use App\Models\Potongan_memo;
use App\Models\Rute_perjalanan;
use App\Models\Saldo;
use App\Models\Typeban;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class MemoekspedisiController extends Controller
{
    public function index()
    {
        $kendaraans = Kendaraan::all();
        $drivers = User::whereHas('karyawan', function ($query) {
            $query->where('departemen_id', '2');
        })->get();
        $ruteperjalanans = Rute_perjalanan::all();
        $biayatambahan = Biaya_tambahan::all();
        $potonganmemos = Potongan_memo::all();
        $pelanggans = Pelanggan::all();
        $memos = Memo_ekspedisi::where('kategori', 'Memo Perjalanan')->get();
        $saldoTerakhir = Saldo::latest()->first();
        return view('admin.memo_ekspedisi.index', compact('memos', 'pelanggans', 'kendaraans', 'drivers', 'ruteperjalanans', 'biayatambahan', 'saldoTerakhir', 'potonganmemos'));
    }


    public function store(Request $request)
    {

        $kategori = $request->kategori;

        $commonData = [
            'kategori' => $kategori,
            // Add other common data fields here
        ];

        // Common validation logic
        $validasi_pelanggan = Validator::make(
            $request->all(),
            [
                'kategori' => 'required',
            ],
            [
                'kategori.required' => 'Pilih kategori',
            ]
        );

        if ($validasi_pelanggan->fails()) {
            $errors = $validasi_pelanggan->errors()->all();
            return back()->withInput()->with('error', $errors);
        }


        switch ($kategori) {
            case 'Memo Perjalanan':

                $validasi_pelanggan = Validator::make(
                    $request->all(),
                    [
                        'kategori' => 'required',
                        'kendaraan_id' => 'required',
                        'user_id' => 'required',
                        'rute_perjalanan_id' => 'required',
                        'sub_total' => 'required',
                    ],
                    [
                        'kategori.required' => 'Pilih kategori',
                        'kendaraan_id.required' => 'Pilih no kabin',
                        'user_id.required' => 'Pilih driver',
                        'rute_perjalanan_id.required' => 'Pilih rute perjalanan',
                        'sub_total.required' => 'Masukkan total harga',
                    ]
                );

                // $biayaTambahan = $request->biaya_tambahan;
                // $PotonganMemo = $request->potongan_memo;

                // if ($biayaTambahan && $PotonganMemo) {
                //     $errors = "Harus memilih salah satu biaya tambahan atau potongan memo";
                //     return back()->withInput()->with('erorrss', $errors);
                // }

                $error_pelanggans = array();

                if ($validasi_pelanggan->fails()) {
                    array_push($error_pelanggans, $validasi_pelanggan->errors()->all()[0]);
                }

                $error_pesanans = array();
                $data_pembelians = collect();
                $data_pembelians3 = collect();

                $biayaTambahan = $request->biaya_tambahan;
                $PotonganMemo = $request->potongan_memo;

                // biaya dan potongan tidak null 
                if (!$biayaTambahan == null && !$PotonganMemo == null) {

                    if ($request->has('potongan_id')) {
                        for ($i = 0; $i < count($request->potongan_id); $i++) {
                            $potongan_id = $request->input('potongan_id.' . $i, null);
                            $kode_potongan = $request->input('kode_potongan.' . $i, null);
                            $keterangan_potongan = $request->input('keterangan_potongan.' . $i, null);
                            $nominal_potongan = $request->input('nominal_potongan.' . $i, null);

                            $validasi_produk = Validator::make([
                                'potongan_id' => $potongan_id,
                                'kode_potongan' => $kode_potongan,
                                'keterangan_potongan' => $keterangan_potongan,
                                'nominal_potongan' => $nominal_potongan,
                            ], [
                                'potongan_id' => 'required',
                                'kode_potongan' => 'required',
                                'keterangan_potongan' => 'required',
                                'nominal_potongan' => 'required',
                            ]);

                            if ($validasi_produk->fails()) {
                                array_push($error_pesanans, "Potongan memo " . ($i + 1) . " belum lengkap!");
                            } else {
                                $data_pembelians3->push([
                                    'potongan_id' => $potongan_id,
                                    'kode_potongan' => $kode_potongan,
                                    'keterangan_potongan' => $keterangan_potongan,
                                    'nominal_potongan' => $nominal_potongan
                                ]);
                            }
                        }
                    } else {
                    }
                    
                    if ($request->has('biaya_id')) {
                        for ($i = 0; $i < count($request->biaya_id); $i++) {
                            $biaya_id = $request->input('biaya_id.' . $i, null);
                            $kode_biaya = $request->input('kode_biaya.' . $i, null);
                            $nama_biaya = $request->input('nama_biaya.' . $i, null);
                            $nominal = $request->input('nominal.' . $i, null);

                            $validasi_produk = Validator::make([
                                'biaya_id' => $biaya_id,
                                'kode_biaya' => $kode_biaya,
                                'nama_biaya' => $nama_biaya,
                                'nominal' => $nominal,
                            ], [
                                'biaya_id' => 'required',
                                'kode_biaya' => 'required',
                                'nama_biaya' => 'required',
                                'nominal' => 'required',
                            ]);

                            if ($validasi_produk->fails()) {
                                array_push($error_pesanans, "Tambahan biaya nomor " . ($i + 1) . " tidak valid!");
                            } else {
                                $data_pembelians->push([
                                    'biaya_id' => $biaya_id,
                                    'kode_biaya' => $kode_biaya,
                                    'nama_biaya' => $nama_biaya,
                                    'nominal' => $nominal
                                ]);
                            }
                        }
                    } else {
                    }
                  

                    if ($error_pelanggans || $error_pesanans) {
                        return back()
                            ->withInput()
                            ->with('error_pelanggans', $error_pelanggans)
                            ->with('error_pesanans', $error_pesanans)
                            ->with('data_pembelians', $data_pembelians)
                            ->with('data_pembelians3', $data_pembelians3);
                    }

                    $kode = $this->kode();
                    // tgl indo
                    $tanggal1 = Carbon::now('Asia/Jakarta');
                    $format_tanggal = $tanggal1->format('d F Y');

                    $tanggal = Carbon::now()->format('Y-m-d');

                    $cetakpdf = Memo_ekspedisi::create(array_merge(
                        $request->all(),
                        [
                            'kategori' => $request->kategori,
                            'kendaraan_id' => $request->kendaraan_id,
                            'no_kabin' => $request->no_kabin,
                            'golongan' => $request->golongan,
                            'km_awal' => $request->km_awal,
                            'user_id' => $request->user_id,
                            'kode_driver' => $request->kode_driver,
                            'nam_driver' => $request->nama_driver,
                            'telp' => $request->telp,
                            'rute_perjalanan_id' => $request->rute_perjalanan_id,
                            'kode_rute' => $request->kode_rute,
                            'nama_rute' => $request->nama_rute,
                            'saldo_deposit' => str_replace('.', '', $request->saldo_deposit),
                            'uang_jalan' => str_replace('.', '', $request->uang_jalan),
                            'uang_jaminan' => str_replace('.', '', $request->uang_jaminan),
                            'biaya_tambahan' => str_replace('.', '', $request->biaya_tambahan),
                            'potongan_memo' => str_replace('.', '', $request->potongan_memo),
                            'deposit_driver' => str_replace('.', '', $request->deposit_driver),
                            'deposit_drivers' => str_replace('.', '', $request->deposit_driver),
                            'sub_total' => str_replace('.', '', $request->sub_total),
                            // 'sisa_saldo' => $request->sisa_saldo,
                            'keterangan' => $request->keterangan,
                            // 'harga' => $request->harga,
                            'kode_memo' => $this->kode(),
                            'qrcode_memo' => 'https:///javaline.id/memo_ekspedisi/' . $kode,
                            'tanggal' => $format_tanggal,
                            'tanggal_awal' => $tanggal,
                            'status' => 'unpost'
                        ]
                    ));

                    $transaksi_id = $cetakpdf->id;

                    if ($cetakpdf) {
                        foreach ($data_pembelians as $data_pesanan) {
                            Detail_memo::create([
                                'memo_ekspedisi_id' => $cetakpdf->id,
                                'biaya_id' => $data_pesanan['biaya_id'],
                                'kode_biaya' => $data_pesanan['kode_biaya'],
                                'nama_biaya' => $data_pesanan['nama_biaya'],
                                'nominal' => str_replace('.', '', $data_pesanan['nominal']),
                            ]);
                        }
                    }

                    if ($cetakpdf) {
                        foreach ($data_pembelians3 as $data_pesanan) {
                            Detail_memo::create([
                                'memo_ekspedisi_id' => $cetakpdf->id,
                                'potongan_id' => $data_pesanan['potongan_id'],
                                'kode_potongan' => $data_pesanan['kode_potongan'],
                                'keterangan_potongan' => $data_pesanan['keterangan_potongan'],
                                'nominal_potongan' => str_replace('.', '', $data_pesanan['nominal_potongan']),
                            ]);
                        }
                    }

                    $detail_memo = Detail_memo::where('memo_ekspedisi_id', $cetakpdf->id)->get();

                    return view('admin.memo_ekspedisi.show', compact('cetakpdf', 'detail_memo'));
                }
                // jika biaya tambahan tidak null 
                if (!$biayaTambahan == null) {
                    if ($request->has('biaya_id')) {
                        for ($i = 0; $i < count($request->biaya_id); $i++) {
                            $biaya_id = $request->input('biaya_id.' . $i, null);
                            $kode_biaya = $request->input('kode_biaya.' . $i, null);
                            $nama_biaya = $request->input('nama_biaya.' . $i, null);
                            $nominal = $request->input('nominal.' . $i, null);

                            // If 'biaya_id' is not null, validate and process the data
                            if (!is_null($biaya_id)) {
                                $validasi_produk = Validator::make([
                                    'biaya_id' => $biaya_id,
                                    'kode_biaya' => $kode_biaya,
                                    'nama_biaya' => $nama_biaya,
                                    'nominal' => $nominal,
                                ], [
                                    'biaya_id' => 'required',
                                    'kode_biaya' => 'required',
                                    'nama_biaya' => 'required',
                                    'nominal' => 'required',
                                ]);

                                if ($validasi_produk->fails()) {
                                    array_push($error_pesanans, "Tambahan biaya nomor " . ($i + 1) . " tidak valid!");
                                } else {
                                    $data_pembelians->push([
                                        'biaya_id' => $biaya_id,
                                        'kode_biaya' => $kode_biaya,
                                        'nama_biaya' => $nama_biaya,
                                        'nominal' => $nominal
                                    ]);
                                }
                            } else {

                                if ($error_pelanggans || $error_pesanans) {
                                    return back()
                                        ->withInput()
                                        ->with('error_pelanggans', $error_pelanggans)
                                        ->with('error_pesanans', $error_pesanans)
                                        ->with('data_pembelians', $data_pembelians);
                                }

                                // 'biaya_id' is null, you can skip it

                                $kode = $this->kode();
                                // tgl indo
                                $tanggal1 = Carbon::now('Asia/Jakarta');
                                $format_tanggal = $tanggal1->format('d F Y');

                                $tanggal = Carbon::now()->format('Y-m-d');

                                $cetakpdf = Memo_ekspedisi::create(array_merge(
                                    $request->all(),
                                    [
                                        'kategori' => $request->kategori,
                                        'kendaraan_id' => $request->kendaraan_id,
                                        'no_kabin' => $request->no_kabin,
                                        'golongan' => $request->golongan,
                                        'km_awal' => $request->km_awal,
                                        'user_id' => $request->user_id,
                                        'kode_driver' => $request->kode_driver,
                                        'nam_driver' => $request->nama_driver,
                                        'telp' => $request->telp,
                                        'rute_perjalanan_id' => $request->rute_perjalanan_id,
                                        'kode_rute' => $request->kode_rute,
                                        'nama_rute' => $request->nama_rute,
                                        'saldo_deposit' => str_replace('.', '', $request->saldo_deposit),
                                        'uang_jalan' => str_replace('.', '', $request->uang_jalan),
                                        'uang_jaminan' => str_replace('.', '', $request->uang_jaminan),
                                        'biaya_tambahan' => str_replace('.', '', $request->biaya_tambahan),
                                        'deposit_driver' => str_replace('.', '', $request->deposit_driver),
                                        'deposit_drivers' => str_replace('.', '', $request->deposit_driver),
                                        'sub_total' => str_replace('.', '', $request->sub_total),
                                        // 'sisa_saldo' => $request->sisa_saldo,
                                        'keterangan' => $request->keterangan,
                                        // 'harga' => $request->harga,
                                        'kode_memo' => $this->kode(),
                                        'qrcode_memo' => 'https:///javaline.id/memo_ekspedisi/' . $kode,
                                        'tanggal' => $format_tanggal,
                                        'tanggal_awal' => $tanggal,
                                        'status' => 'unpost'
                                    ]
                                ));

                                $transaksi_id = $cetakpdf->id;

                                if ($cetakpdf) {

                                    foreach ($data_pembelians as $data_pesanan) {
                                        Detail_memo::create([
                                            'memo_ekspedisi_id' => $cetakpdf->id,
                                            'biaya_id' => $data_pesanan['biaya_id'],
                                            'kode_biaya' => $data_pesanan['kode_biaya'],
                                            'nama_biaya' => $data_pesanan['nama_biaya'],
                                            'nominal' => str_replace('.', '', $data_pesanan['nominal']),
                                        ]);
                                    }
                                }

                                $detail_memo = Detail_memo::where('memo_ekspedisi_id', $cetakpdf->id)->get();

                                return view('admin.memo_ekspedisi.show', compact('cetakpdf', 'detail_memo'));
                            }
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

                    $kode = $this->kode();
                    // tgl indo
                    $tanggal1 = Carbon::now('Asia/Jakarta');
                    $format_tanggal = $tanggal1->format('d F Y');

                    $tanggal = Carbon::now()->format('Y-m-d');
                    $cetakpdf = Memo_ekspedisi::create(array_merge(
                        $request->all(),
                        [
                            'kategori' => $request->kategori,
                            'kendaraan_id' => $request->kendaraan_id,
                            'no_kabin' => $request->no_kabin,
                            'golongan' => $request->golongan,
                            'km_awal' => $request->km_awal,
                            'user_id' => $request->user_id,
                            'kode_driver' => $request->kode_driver,
                            'nam_driver' => $request->nama_driver,
                            'telp' => $request->telp,
                            'rute_perjalanan_id' => $request->rute_perjalanan_id,
                            'kode_rute' => $request->kode_rute,
                            'nama_rute' => $request->nama_rute,
                            'saldo_deposit' => str_replace('.', '', $request->saldo_deposit),
                            'uang_jalan' => str_replace('.', '', $request->uang_jalan),
                            'uang_jaminan' => str_replace('.', '', $request->uang_jaminan),
                            'biaya_tambahan' => str_replace('.', '', $request->biaya_tambahan),
                            'deposit_driver' => str_replace('.', '', $request->deposit_driver),
                            'deposit_drivers' => str_replace('.', '', $request->deposit_driver),
                            'sub_total' => str_replace('.', '', $request->sub_total),
                            'keterangan' => $request->keterangan,
                            // 'sisa_saldo' => $request->sisa_saldo,
                            // 'harga' => $request->harga,
                            'kode_memo' => $this->kode(),
                            'qrcode_memo' => 'https:///tigerload.id/memo_ekspedisi/' . $kode,
                            'tanggal' => $format_tanggal,
                            'tanggal_awal' => $tanggal,
                            'status' => 'unpost',
                        ]
                    ));

                    $transaksi_id = $cetakpdf->id;

                    if ($cetakpdf) {

                        foreach ($data_pembelians as $data_pesanan) {
                            Detail_memo::create([
                                'memo_ekspedisi_id' => $cetakpdf->id,
                                'biaya_id' => $data_pesanan['biaya_id'],
                                'kode_biaya' => $data_pesanan['kode_biaya'],
                                'nama_biaya' => $data_pesanan['nama_biaya'],
                                'nominal' => str_replace('.', '', $data_pesanan['nominal']),
                            ]);
                        }
                    }

                    $detail_memo = Detail_memo::where('memo_ekspedisi_id', $cetakpdf->id)->get();

                    return view('admin.memo_ekspedisi.show', compact('cetakpdf', 'detail_memo'));
                }
                  // jika potongan tidak null
                if (!$PotonganMemo == null) {
                    if ($request->has('potongan_id')) {
                        for ($i = 0; $i < count($request->potongan_id); $i++) {
                            $potongan_id = $request->input('potongan_id.' . $i, null);
                            $kode_potongan = $request->input('kode_potongan.' . $i, null);
                            $keterangan_potongan = $request->input('keterangan_potongan.' . $i, null);
                            $nominal_potongan = $request->input('nominal_potongan.' . $i, null);

                            // If 'potongan_id' is not null, validate and process the data
                            if (!is_null($potongan_id)) {
                                $validasi_produk = Validator::make([
                                    'potongan_id' => $potongan_id,
                                    'kode_potongan' => $kode_potongan,
                                    'keterangan_potongan' => $keterangan_potongan,
                                    'nominal_potongan' => $nominal_potongan,
                                ], [
                                    'potongan_id' => 'required',
                                    'kode_potongan' => 'required',
                                    'keterangan_potongan' => 'required',
                                    'nominal_potongan' => 'required',
                                ]);

                                if ($validasi_produk->fails()) {
                                    array_push($error_pesanans, "Potongan memo " . ($i + 1) . " belum lengkap!");
                                } else {
                                    $data_pembelians3->push([
                                        'potongan_id' => $potongan_id,
                                        'kode_potongan' => $kode_potongan,
                                        'keterangan_potongan' => $keterangan_potongan,
                                        'nominal_potongan' => $nominal_potongan
                                    ]);
                                }
                            } else {

                                if ($error_pelanggans || $error_pesanans) {
                                    return back()
                                        ->withInput()
                                        ->with('error_pelanggans', $error_pelanggans)
                                        ->with('error_pesanans', $error_pesanans)
                                        ->with('data_pembelians3', $data_pembelians3);
                                }

                                // 'biaya_id' is null, you can skip it

                                $kode = $this->kode();
                                // tgl indo
                                $tanggal1 = Carbon::now('Asia/Jakarta');
                                $format_tanggal = $tanggal1->format('d F Y');

                                $tanggal = Carbon::now()->format('Y-m-d');

                                $cetakpdf = Memo_ekspedisi::create(array_merge(
                                    $request->all(),
                                    [
                                        'kategori' => $request->kategori,
                                        'kendaraan_id' => $request->kendaraan_id,
                                        'no_kabin' => $request->no_kabin,
                                        'golongan' => $request->golongan,
                                        'km_awal' => $request->km_awal,
                                        'user_id' => $request->user_id,
                                        'kode_driver' => $request->kode_driver,
                                        'nam_driver' => $request->nama_driver,
                                        'telp' => $request->telp,
                                        'rute_perjalanan_id' => $request->rute_perjalanan_id,
                                        'kode_rute' => $request->kode_rute,
                                        'nama_rute' => $request->nama_rute,
                                        'saldo_deposit' => str_replace('.', '', $request->saldo_deposit),
                                        'uang_jalan' => str_replace('.', '', $request->uang_jalan),
                                        'uang_jaminan' => str_replace('.', '', $request->uang_jaminan),
                                        'biaya_tambahan' => str_replace('.', '', $request->biaya_tambahan),
                                        'deposit_driver' => str_replace('.', '', $request->deposit_driver),
                                        'deposit_drivers' => str_replace('.', '', $request->deposit_driver),
                                        'potongan_memo' => str_replace('.', '', $request->potongan_memo),
                                        'sub_total' => str_replace('.', '', $request->sub_total),
                                        'keterangan' => $request->keterangan,
                                        'sisa_saldo' => $request->sisa_saldo,
                                        // 'harga' => $request->harga,
                                        'kode_memo' => $this->kode(),
                                        'qrcode_memo' => 'https:///javaline.id/memo_ekspedisi/' . $kode,
                                        'tanggal' => $format_tanggal,
                                        'tanggal_awal' => $tanggal,
                                        'status' => 'unpost'
                                    ]
                                ));

                                $transaksi_id = $cetakpdf->id;

                                if ($cetakpdf) {

                                    foreach ($data_pembelians3 as $data_pesanan) {
                                        Detail_memo::create([
                                            'memo_ekspedisi_id' => $cetakpdf->id,
                                            'potongan_id' => $data_pesanan['potongan_id'],
                                            'kode_potongan' => $data_pesanan['kode_potongan'],
                                            'keterangan_potongan' => $data_pesanan['keterangan_potongan'],
                                            'nominal_potongan' => str_replace('.', '', $data_pesanan['nominal_potongan']),

                                        ]);
                                    }
                                }

                                $detail_memo = Detail_memo::where('memo_ekspedisi_id', $cetakpdf->id)->get();

                                return view('admin.memo_ekspedisi.show', compact('cetakpdf', 'detail_memo'));
                            }
                        }
                    } else {
                    }

                    if ($error_pelanggans || $error_pesanans) {
                        return back()
                            ->withInput()
                            ->with('error_pelanggans', $error_pelanggans)
                            ->with('error_pesanans', $error_pesanans)
                            ->with('data_pembelians3', $data_pembelians3);
                    }

                    $kode = $this->kode();
                    // tgl indo
                    $tanggal1 = Carbon::now('Asia/Jakarta');
                    $format_tanggal = $tanggal1->format('d F Y');

                    $tanggal = Carbon::now()->format('Y-m-d');
                    $cetakpdf = Memo_ekspedisi::create(array_merge(
                        $request->all(),
                        [
                            'kategori' => $request->kategori,
                            'kendaraan_id' => $request->kendaraan_id,
                            'no_kabin' => $request->no_kabin,
                            'golongan' => $request->golongan,
                            'km_awal' => $request->km_awal,
                            'user_id' => $request->user_id,
                            'kode_driver' => $request->kode_driver,
                            'nam_driver' => $request->nama_driver,
                            'telp' => $request->telp,
                            'rute_perjalanan_id' => $request->rute_perjalanan_id,
                            'kode_rute' => $request->kode_rute,
                            'nama_rute' => $request->nama_rute,
                            'saldo_deposit' => str_replace('.', '', $request->saldo_deposit),
                            'uang_jalan' => str_replace('.', '', $request->uang_jalan),
                            'uang_jaminan' => str_replace('.', '', $request->uang_jaminan),
                            'biaya_tambahan' => str_replace('.', '', $request->biaya_tambahan),
                            'deposit_driver' => str_replace('.', '', $request->deposit_driver),
                            'deposit_drivers' => str_replace('.', '', $request->deposit_driver),
                            'potongan_memo' => str_replace('.', '', $request->potongan_memo),
                            'sub_total' => str_replace('.', '', $request->sub_total),
                            'keterangan' => $request->keterangan,
                            // 'sisa_saldo' => $request->sisa_saldo,
                            // 'harga' => $request->harga,
                            'kode_memo' => $this->kode(),
                            'qrcode_memo' => 'https:///tigerload.id/memo_ekspedisi/' . $kode,
                            'tanggal' => $format_tanggal,
                            'tanggal_awal' => $tanggal,
                            'status' => 'unpost',
                        ]
                    ));

                    $transaksi_id = $cetakpdf->id;

                    if ($cetakpdf) {
                        foreach ($data_pembelians3 as $data_pesanan) {
                            Detail_memo::create([
                                'memo_ekspedisi_id' => $cetakpdf->id,
                                'potongan_id' => $data_pesanan['potongan_id'],
                                'kode_potongan' => $data_pesanan['kode_potongan'],
                                'keterangan_potongan' => $data_pesanan['keterangan_potongan'],
                                'nominal_potongan' => str_replace('.', '', $data_pesanan['nominal_potongan']),
                            ]);
                        }
                    }

                    $detail_memo = Detail_memo::where('memo_ekspedisi_id', $cetakpdf->id)->get();

                    return view('admin.memo_ekspedisi.show', compact('cetakpdf', 'detail_memo'));
                }
                break;

            case 'Memo Borong':

                $validasi_pelanggan = Validator::make(
                    $request->all(),
                    [
                        'kategori' => 'required',
                        'kendaraan_id' => 'required',
                        'user_id' => 'required',
                        'pelanggan_id' => 'required',
                        'sub_total' => 'required'
                    ],
                    [
                        'kategori.required' => 'Pilih kategori',
                        'kendaraan_id.required' => 'Pilih no kabin',
                        'user_id.required' => 'Pilih driver',
                        'pelanggan_id.required' => 'Pilih rute pelanggan',
                        'sub_total.required' => 'Masukkan total harga',
                    ]
                );

                $error_pelanggans = array();

                if ($validasi_pelanggan->fails()) {
                    array_push($error_pelanggans, $validasi_pelanggan->errors()->all()[0]);
                }

                $error_pesanans = array();
                $data_pembelians = collect();

                if ($request->has('rute_id')) {
                    for ($i = 0; $i < count($request->rute_id); $i++) {
                        $validasi_produk = Validator::make($request->all(), [
                            'rute_id.' . $i => 'required',
                            'kode_rutes.' . $i => 'required',
                            'nama_rutes.' . $i => 'required',
                            'harga_rute.' . $i => 'required',
                            'jumlah.' . $i => 'required',
                            'satuan.' . $i => 'required',
                            'totalrute.' . $i => 'required',
                        ]);

                        if ($validasi_produk->fails()) {
                            array_push($error_pesanans, "Rute borong nomor " . $i + 1 . " belum dilengkapi!");
                        }


                        $rute_id = is_null($request->rute_id[$i]) ? '' : $request->rute_id[$i];
                        $kode_rutes = is_null($request->kode_rutes[$i]) ? '' : $request->kode_rutes[$i];
                        $nama_rutes = is_null($request->nama_rutes[$i]) ? '' : $request->nama_rutes[$i];
                        $harga_rute = is_null($request->harga_rute[$i]) ? '' : $request->harga_rute[$i];
                        $jumlah = is_null($request->jumlah[$i]) ? '' : $request->jumlah[$i];
                        $satuan = is_null($request->satuan[$i]) ? '' : $request->satuan[$i];
                        $totalrute = is_null($request->totalrute[$i]) ? '' : $request->totalrute[$i];

                        $data_pembelians->push(['rute_id' => $rute_id, 'kode_rutes' => $kode_rutes, 'nama_rutes' => $nama_rutes, 'harga_rute' => $harga_rute, 'jumlah' => $jumlah, 'satuan' => $satuan, 'totalrute' => $totalrute]);
                    }
                } else {
                }

                if ($error_pelanggans || $error_pesanans) {
                    return back()
                        ->withInput()
                        ->with('error_pelanggans', $error_pelanggans)
                        ->with('error_pesanans', $error_pesanans)
                        ->with('data_pembelians2', $data_pembelians);
                }

                $kode = $this->kodemb();
                // tgl indo
                $tanggal1 = Carbon::now('Asia/Jakarta');
                $format_tanggal = $tanggal1->format('d F Y');

                $tanggal = Carbon::now()->format('Y-m-d');
                $cetakpdf = Memo_ekspedisi::create(array_merge(
                    $request->all(),
                    [
                        'kategori' => $request->kategori,
                        'kendaraan_id' => $request->kendaraan_id,
                        'no_kabin' => $request->no_kabin,
                        'golongan' => $request->golongan,
                        'km_awal' => $request->km_awal,
                        'user_id' => $request->user_id,
                        'kode_driver' => $request->kode_driver,
                        'nam_driver' => $request->nama_driver,
                        'telp' => $request->telp,
                        'pelanggan_id' => $request->pelanggan_id,
                        'kode_pelanggan' => $request->kode_pelanggan,
                        'nama_pelanggan' => $request->nama_pelanggan,
                        'alamat_pelanggan' => $request->alamat_pelanggan,
                        'telp_pelanggan' => $request->telp_pelanggan,
                        'saldo_deposit' => str_replace('.', '', $request->saldo_deposit),
                        'uang_jaminan' => str_replace('.', '', $request->uang_jaminan),
                        'biaya_tambahan' => str_replace('.', '', $request->biaya_tambahan),
                        'deposit_driver' => str_replace('.', '', $request->depositsopir),
                        'total_borongs' => str_replace('.', '', $request->total_borongs),
                        'pphs' => str_replace('.', '', $request->pphs),
                        'total_borongs' => str_replace('.', '', $request->total_borongs),
                        'uang_jaminans' => str_replace('.', '', $request->depositsopir),
                        'deposit_drivers' => str_replace('.', '', $request->deposit_drivers),
                        'totals' => str_replace('.', '', $request->totals),
                        'sub_total' => str_replace('.', '', $request->sub_total),
                        'keterangan' => $request->keterangan,
                        // 'sisa_saldo' => $request->sisa_saldo,
                        'kode_memo' => $this->kodemb(),
                        'qrcode_memo' => 'https:///javaline.id/memo_ekspedisi/' . $kode,
                        'tanggal' => $format_tanggal,
                        'tanggal_awal' => $tanggal,
                        'status' => 'unpost'
                    ]
                ));

                $transaksi_id = $cetakpdf->id;

                if ($cetakpdf) {

                    foreach ($data_pembelians as $data_pesanan) {
                        Detail_memo::create([
                            'memo_ekspedisi_id' => $cetakpdf->id,
                            'rute_id' => $data_pesanan['rute_id'],
                            'kode_rutes' => $data_pesanan['kode_rutes'],
                            'nama_rutes' => $data_pesanan['nama_rutes'],
                            'harga_rute' => $data_pesanan['harga_rute'],
                            'jumlah' => $data_pesanan['jumlah'],
                            'satuan' => $data_pesanan['satuan'],
                            'totalrute' => str_replace('.', '', $data_pesanan['totalrute']),

                        ]);
                    }
                }

                $detail_memo = Detail_memo::where('memo_ekspedisi_id', $cetakpdf->id)->get();

                return view('admin.memo_ekspedisi.show', compact('cetakpdf', 'detail_memo'));

                break;


            case 'Memo Tambahan':

                $validasi_pelanggan = Validator::make(
                    $request->all(),
                    [
                        'memo_id' => 'required',
                    ],
                    [
                        'memo_id.required' => 'Pilih memo',
                    ]
                );

                $error_pelanggans = array();

                if ($validasi_pelanggan->fails()) {
                    array_push($error_pelanggans, $validasi_pelanggan->errors()->all()[0]);
                }

                $error_pesanans = array();
                $data_pembelians4 = collect();

                if ($request->has('keterangan_tambahan')) {
                    for ($i = 0; $i < count($request->keterangan_tambahan); $i++) {
                        $validasi_produk = Validator::make($request->all(), [
                            'keterangan_tambahan.' . $i => 'required',
                            'nominal_tambahan.' . $i => 'required',
                        ]);

                        if ($validasi_produk->fails()) {
                            array_push($error_pesanans, "Memo tambahan nomor " . $i + 1 . " belum dilengkapi!");
                        }

                        $keterangan_tambahan = is_null($request->keterangan_tambahan[$i]) ? '' : $request->keterangan_tambahan[$i];
                        $nominal_tambahan = is_null($request->nominal_tambahan[$i]) ? '' : $request->nominal_tambahan[$i];

                        $data_pembelians4->push(['keterangan_tambahan' => $keterangan_tambahan, 'nominal_tambahan' => $nominal_tambahan]);
                    }
                } else {
                }

                if ($error_pelanggans || $error_pesanans) {
                    return back()
                        ->withInput()
                        ->with('error_pelanggans', $error_pelanggans)
                        ->with('error_pesanans', $error_pesanans)
                        ->with('data_pembelians4', $data_pembelians4);
                }

                $kode = $this->kodemt();
                // tgl indo
                $tanggal1 = Carbon::now('Asia/Jakarta');
                $format_tanggal = $tanggal1->format('d F Y');

                $tanggal = Carbon::now()->format('Y-m-d');
                $memotambahan = Memotambahan::create(array_merge(
                    $request->all(),
                    [
                        'memo_id' => $request->memo_id,
                        'kode_memo' => $this->kodemt(),
                        'grand_total' => str_replace('.', '', $request->grand_total),
                        // 'qrcode_memo' => 'https:///javaline.id/memo_tambahan/' . $kode,
                        'tanggal_awal' => $format_tanggal,
                    ]
                ));

                $cetakpdf = Memo_ekspedisi::create(array_merge(
                    $request->all(),
                    [
                        'memotambahan_id' => $memotambahan->id,
                        'kode_memo' => $this->kodemt(),
                        // 'grand_total' => str_replace('.', '', $request->grand_total),
                        // 'qrcode_memo' => 'https:///javaline.id/memo_tambahan/' . $kode,
                        'tanggal_awal' => $tanggal,
                        'status' => 'unpost',
                    ]
                ));

                $transaksi_id = $memotambahan->id;
                if ($memotambahan) {
                    foreach ($data_pembelians4 as $data_pesanan) {
                        Detail_memotambahan::create([
                            'memotambahan_id' => $memotambahan->id,
                            'keterangan_tambahan' => $data_pesanan['keterangan_tambahan'],
                            'nominal_tambahan' => $data_pesanan['nominal_tambahan'],
                        ]);
                    }
                }

                $detail_memo = Detail_memotambahan::where('memotambahan_id', $memotambahan->id)->get();
                return view('admin.memo_ekspedisi.show', compact('cetakpdf', 'detail_memo', 'memotambahan'));

                break;

            default:
        }
    }

    public function kode()
    {
        $penerimaan = Memo_ekspedisi::all();
        if ($penerimaan->isEmpty()) {
            $num = "000001";
        } else {
            $id = Memo_ekspedisi::getId();
            foreach ($id as $value);
            $idlm = $value->id;
            $idbr = $idlm + 1;
            $num = sprintf("%06s", $idbr);
        }

        $data = 'MP';
        $kode_penerimaan = $data . $num;
        return $kode_penerimaan;
    }

    public function kodemb()
    {
        $penerimaan = Memo_ekspedisi::all();
        if ($penerimaan->isEmpty()) {
            $num = "000001";
        } else {
            $id = Memo_ekspedisi::getId();
            foreach ($id as $value);
            $idlm = $value->id;
            $idbr = $idlm + 1;
            $num = sprintf("%06s", $idbr);
        }

        $data = 'MB';
        $kode_penerimaan = $data . $num;
        return $kode_penerimaan;
    }


    public function kodemt()
    {
        $penerimaan = Memotambahan::all();
        if ($penerimaan->isEmpty()) {
            $num = "000001";
        } else {
            $id = Memotambahan::getId();
            foreach ($id as $value);
            $idlm = $value->id;
            $idbr = $idlm + 1;
            $num = sprintf("%06s", $idbr);
        }

        $data = 'MT';
        $kode_penerimaan = $data . $num;
        return $kode_penerimaan;
    }


    public function show($id)
    {
        $cetakpdf = Memo_ekspedisi::where('id', $id)->first();

        return view('admin.memo_ekspedisi.show', compact('cetakpdf'));
    }

    // public function cetakpdf($id)
    // {
    //     $cetakpdf = Memo_ekspedisi::where('id', $id)->first();
    //     $detail_memo = Detail_memo::where('memo_ekspedisi_id', $cetakpdf->id)->get();


    //     $pdf = PDF::loadView('admin.memo_ekspedisi.cetak_pdf', compact('cetakpdf', 'detail_memo'));
    //     $pdf->setPaper('letter', 'portrait'); // Set the paper size to portrait letter

    //     return $pdf->stream('Memo_ekspedisi.pdf');
    // }

    public function cetakpdf($id)
    {
        $inquery = Memo_ekspedisi::where('id', $id)->first();
        if ($inquery->kategori == "Memo Tambahan") {
            $cetakpdf = Memo_ekspedisi::where('id', $id)->first();
            $memotambahans = Memotambahan::where('id', $cetakpdf->memotambahan_id)->first();
            $detail_memo = Detail_memotambahan::where('memotambahan_id', $memotambahans->id)->get();
            $pdf = PDF::loadView('admin.memo_ekspedisi.cetak_pdf', compact('cetakpdf', 'detail_memo'));
            $pdf->setPaper('letter', 'portrait'); // Set the paper size to portrait letter

            return $pdf->stream('Memo_ekspedisi.pdf');
        } else {
            $cetakpdf = Memo_ekspedisi::where('id', $id)->first();
            // $memotambahans = Memotambahan::where('memo_id', $id)->first();
            $detail_memo = Detail_memo::where('memo_ekspedisi_id', $cetakpdf->id)->get();
            $pdf = PDF::loadView('admin.memo_ekspedisi.cetak_pdf', compact('cetakpdf', 'detail_memo'));
            $pdf->setPaper('letter', 'portrait'); // Set the paper size to portrait letter

            return $pdf->stream('Memo_ekspedisi.pdf');
        }
    }
}