<?php

namespace App\Http\Controllers\admin;

use Carbon\Carbon;
use App\Models\Ban;
use App\Models\Merek;
use App\Models\Ukuran;
use App\Models\Typeban;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Models\Pembelian_ban;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use App\Models\Biaya_tambahan;
use App\Models\Detail_memo;
use App\Models\Detail_memotambahan;
use App\Models\Kendaraan;
use App\Models\Memo_ekspedisi;
use App\Models\Memotambahan;
use App\Models\Pelanggan;
use App\Models\Penerimaan_kaskecil;
use App\Models\Potongan_memo;
use App\Models\Rute_perjalanan;
use App\Models\Saldo;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Egulias\EmailValidator\Result\Reason\DetailedReason;

class InqueryMemoekspedisiController extends Controller
{
    public function index(Request $request)
    {
        Memo_ekspedisi::where([
            ['status', 'posting']
        ])->update([
            'status_notif' => true
        ]);

        $status = $request->status;
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;

        $inquery = Memo_ekspedisi::query();

        if ($status) {
            $inquery->where('status', $status);
        }

        if ($tanggal_awal && $tanggal_akhir) {
            $inquery->whereBetween('tanggal_awal', [$tanggal_awal, $tanggal_akhir]);
        } elseif ($tanggal_awal) {
            $inquery->where('tanggal_awal', '>=', $tanggal_awal);
        } elseif ($tanggal_akhir) {
            $inquery->where('tanggal_awal', '<=', $tanggal_akhir);
        } else {
            // Jika tidak ada filter tanggal hari ini
            $inquery->whereDate('tanggal_awal', Carbon::today());
        }

        $inquery->orderBy('id', 'DESC');
        $inquery = $inquery->get();

        // Collect the ids of Memo_ekspedisi
        $memoIds = $inquery->pluck('id');

        // Query the associated Detail_memo using the collected ids
        $details = Detail_memo::whereIn('memo_ekspedisi_id', $memoIds)->first();

        return view('admin.inquery_memoekspedisi.index', compact('inquery', 'details'));
    }



    public function edit($id)
    {
        // if (auth()->check() && auth()->user()->menu['inquery perpanjangan stnk']) {

        $inquery = Memo_ekspedisi::where('id', $id)->first();
        if ($inquery->kategori == "Memo Tambahan") {
            $details = Detail_memo::where('memo_ekspedisi_id', $id)->get();
            $kendaraans = Kendaraan::all();
            $drivers = User::whereHas('karyawan', function ($query) {
                $query->where('departemen_id', '2');
            })->get();
            $ruteperjalanans = Rute_perjalanan::all();
            $biayatambahan = Biaya_tambahan::all();
            $pelanggans = Pelanggan::all();
            $saldoTerakhir = Saldo::latest()->first();
            $potonganmemos = Potongan_memo::all();
            $memos = Memo_ekspedisi::all();
            $memotambahans = Memotambahan::where('id', $inquery->memotambahan_id)->first();
            $detailstambahan = Detail_memotambahan::where('memotambahan_id', $memotambahans->id)->get();

            return view('admin.inquery_memoekspedisi.update', compact(
                'details',
                'detailstambahan',
                'inquery',
                'pelanggans',
                'kendaraans',
                'drivers',
                'ruteperjalanans',
                'biayatambahan',
                'potonganmemos',
                'memos',
                'saldoTerakhir'
            ));
        } else {
            $details = Detail_memo::where('memo_ekspedisi_id', $id)->get();
            $kendaraans = Kendaraan::all();
            $drivers = User::whereHas('karyawan', function ($query) {
                $query->where('departemen_id', '2');
            })->get();
            $ruteperjalanans = Rute_perjalanan::all();
            $biayatambahan = Biaya_tambahan::all();
            $pelanggans = Pelanggan::all();
            $saldoTerakhir = Saldo::latest()->first();
            $potonganmemos = Potongan_memo::all();
            $memos = Memo_ekspedisi::all();
            return view('admin.inquery_memoekspedisi.update', compact(
                'details',
                'inquery',
                'pelanggans',
                'kendaraans',
                'drivers',
                'ruteperjalanans',
                'biayatambahan',
                'potonganmemos',
                'memos',
                'saldoTerakhir'
            ));
        }




        // } else {
        //     // tidak memiliki akses
        //     return back()->with('error', array('Anda tidak memiliki akses'));
        // }
    }

    public function update(Request $request, $id)
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
                        'sub_total' => 'required'
                    ],
                    [
                        'kategori.required' => 'Pilih kategori',
                        'kendaraan_id.required' => 'Pilih no kabin',
                        'user_id.required' => 'Pilih driver',
                        'rute_perjalanan_id.required' => 'Pilih rute perjalanan',
                        'sub_total.required' => 'Masukkan total harga',

                    ]
                );

                $error_pelanggans = array();

                if ($validasi_pelanggan->fails()) {
                    array_push($error_pelanggans, $validasi_pelanggan->errors()->all()[0]);
                }

                $error_pesanans = array();
                $data_pembelians = collect();

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
                                    'detail_id' => $request->detail_ids[$i] ?? null,
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


                            // tgl indo
                            $tanggal1 = Carbon::now('Asia/Jakarta');
                            $format_tanggal = $tanggal1->format('d F Y');

                            $tanggal = Carbon::now()->format('Y-m-d');
                            $cetakpdf = Memo_ekspedisi::findOrFail($id);

                            $cetakpdf->update([
                                'kategori' => $request->kategori,
                                'kendaraan_id' => $request->kendaraan_id,
                                'no_kabin' => $request->no_kabin,
                                'golongan' => $request->golongan,
                                'km_awal' => $request->km_awal,
                                'user_id' => $request->user_id,
                                'kode_driver' => $request->kode_driver,
                                'nam_driver' => $request->nama_driver,
                                'telp' => $request->telp,
                                'saldo_deposit' => $request->saldo_deposit,
                                'rute_perjalanan_id' => $request->rute_perjalanan_id,
                                'kode_rute' => $request->kode_rute,
                                'nama_rute' => $request->nama_rute,
                                'uang_jalan' => $request->uang_jalan,
                                'uang_jaminan' => $request->uang_jaminan,
                                'biaya_tambahan' => $request->biaya_tambahan,
                                'deposit_driver' => $request->deposit_driver,
                                'keterangan' => $request->keterangan,
                                'sisa_saldo' => $request->sisa_saldo,
                                'sub_total' => $request->sub_total,
                                // 'status' => 'posting',
                            ]);

                            $transaksi_id = $cetakpdf->id;

                            $detailIds = $request->input('detail_ids');

                            foreach ($data_pembelians as $data_pesanan) {
                                $detailId = $data_pesanan['detail_id'];

                                if ($detailId) {
                                    Detail_memo::where('id', $detailId)->update([
                                        'memo_ekspedisi_id' => $cetakpdf->id,
                                        'biaya_id' => $data_pesanan['biaya_id'],
                                        'kode_biaya' => $data_pesanan['kode_biaya'],
                                        'nama_biaya' => $data_pesanan['nama_biaya'],
                                        'nominal' => $data_pesanan['nominal'],
                                    ]);
                                } else {
                                    $existingDetail = Detail_memo::where([
                                        'memo_ekspedisi_id' => $cetakpdf->id,
                                    ])->first();

                                    if (!$existingDetail) {
                                        Detail_memo::create([
                                            'memo_ekspedisi_id' => $cetakpdf->id,
                                            'biaya_id' => $data_pesanan['biaya_id'],
                                            'kode_biaya' => $data_pesanan['kode_biaya'],
                                            'nama_biaya' => $data_pesanan['nama_biaya'],
                                            'nominal' => $data_pesanan['nominal'],
                                        ]);
                                    }
                                }
                            }

                            $cetakpdf = Memo_ekspedisi::find($transaksi_id);
                            $detail_memo = Detail_memo::where('memo_ekspedisi_id', $cetakpdf->id)->get();

                            return view('admin.inquery_memoekspedisi.show', compact('cetakpdf', 'detail_memo'));
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
                        'saldo_deposit' => $request->saldo_deposit,
                        'rute_perjalanan_id' => $request->rute_perjalanan_id,
                        'kode_rute' => $request->kode_rute,
                        'nama_rute' => $request->nama_rute,
                        'uang_jalan' => $request->uang_jalan,
                        'uang_jaminan' => $request->uang_jaminan,
                        'biaya_tambahan' => $request->biaya_tambahan,
                        'deposit_driver' => $request->deposit_driver,
                        'keterangan' => $request->keterangan,
                        'sisa_saldo' => $request->sisa_saldo,
                        'sub_total' => $request->sub_total,
                        // 'harga' => $request->harga,
                        'kode_memo' => $this->kode(),
                        'qrcode_memo' => 'https:///tigerload.id/memo_ekspedisi/' . $kode,
                        'tanggal' => $format_tanggal,
                        'tanggal_awal' => $tanggal,
                        // 'status' => 'posting',
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
                            'nominal' => $data_pesanan['nominal'],
                        ]);
                    }
                }

                $detail_memo = Detail_memo::where('memo_ekspedisi_id', $cetakpdf->id)->get();

                return view('admin.memo_ekspedisi.show', compact('cetakpdf', 'detail_memo'));
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

                        $data_pembelians->push([
                            'detail_id' => $request->detail_ids[$i] ?? null,
                            'rute_id' => $rute_id,
                            'kode_rutes' => $kode_rutes,
                            'nama_rutes' => $nama_rutes,
                            'harga_rute' => $harga_rute,
                            'jumlah' => $jumlah,
                            'satuan' => $satuan,
                            'totalrute' => $totalrute
                        ]);
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

                // tgl indo
                $tanggal1 = Carbon::now('Asia/Jakarta');
                $format_tanggal = $tanggal1->format('d F Y');
                $cetakpdf = Memo_ekspedisi::findOrFail($id);

                $tanggal = Carbon::now()->format('Y-m-d');
                $cetakpdf->update(
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
                        'saldo_deposit' => $request->saldo_deposit,
                        'pelanggan_id' => $request->pelanggan_id,
                        'kode_pelanggan' => $request->kode_pelanggan,
                        'nama_pelanggan' => $request->nama_pelanggan,
                        'alamat_pelanggan' => $request->alamat_pelanggan,
                        'telp_pelanggan' => $request->telp_pelanggan,
                        'uang_jaminan' => $request->uang_jaminan,
                        'biaya_tambahan' => $request->biaya_tambahan,
                        'deposit_driver' => $request->deposit_driver,
                        'total_borongs' => $request->total_borongs,
                        'pphs' => $request->pphs,
                        'uang_jaminans' => $request->uang_jaminans,
                        'deposit_drivers' => $request->deposit_drivers,
                        'totals' => $request->totals,
                        'keterangan' => $request->keterangan,
                        'sisa_saldo' => $request->sisa_saldo,
                        'sub_total' => $request->sub_total,
                        // 'status' => 'posting'
                    ]
                );

                $transaksi_id = $cetakpdf->id;

                $detailIds = $request->input('detail_ids');

                foreach ($data_pembelians as $data_pesanan) {
                    $detailId = $data_pesanan['detail_id'];

                    if ($detailId) {
                        Detail_memo::where('id', $detailId)->update([
                            'memo_ekspedisi_id' => $cetakpdf->id,
                            'rute_id' => $data_pesanan['rute_id'],
                            'kode_rutes' => $data_pesanan['kode_rutes'],
                            'nama_rutes' => $data_pesanan['nama_rutes'],
                            'harga_rute' => $data_pesanan['harga_rute'],
                            'jumlah' => $data_pesanan['jumlah'],
                            'satuan' => $data_pesanan['satuan'],
                            'totalrute' => $data_pesanan['totalrute'],
                        ]);
                    } else {
                        $existingDetail = Detail_memo::where([
                            'memo_ekspedisi_id' => $cetakpdf->id,
                        ])->first();
                        if (!$existingDetail) {
                            Detail_memo::create([
                                'memo_ekspedisi_id' => $cetakpdf->id,
                                'rute_id' => $data_pesanan['rute_id'],
                                'kode_rutes' => $data_pesanan['kode_rutes'],
                                'nama_rutes' => $data_pesanan['nama_rutes'],
                                'harga_rute' => $data_pesanan['harga_rute'],
                                'jumlah' => $data_pesanan['jumlah'],
                                'satuan' => $data_pesanan['satuan'],
                                'totalrute' => $data_pesanan['totalrute'],
                            ]);
                        }
                    }
                }

                $cetakpdf = Memo_ekspedisi::find($transaksi_id);
                $detail_memo = Detail_memo::where('memo_ekspedisi_id', $cetakpdf->id)->get();

                return view('admin.inquery_memoekspedisi.show', compact('cetakpdf', 'detail_memo'));

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

                        $data_pembelians4->push([
                            'detail_id' => $request->detail_idstambahan[$i] ?? null,
                            'keterangan_tambahan' => $keterangan_tambahan,
                            'nominal_tambahan' => $nominal_tambahan
                        ]);
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

                $tanggal1 = Carbon::now('Asia/Jakarta');
                $format_tanggal = $tanggal1->format('d F Y');
                $cetakpdf = Memo_ekspedisi::findOrFail($id);
                $memotambahan = Memotambahan::findOrFail($cetakpdf->memotambahan_id);

                $tanggal = Carbon::now()->format('Y-m-d');
                $memotambahan->update([
                    'grand_total' => str_replace('.', '', $request->grand_total),
                ]);

                $transaksi_id = $memotambahan->id;
                $detailIds = $request->input('detail_idstambahan');

                foreach ($data_pembelians4 as $data_pesanan) {
                    $detailId = $data_pesanan['detail_id'];

                    if ($detailId) {
                        Detail_memotambahan::where('id', $detailId)->update([
                            'memotambahan_id' => $memotambahan->id,
                            'keterangan_tambahan' => $data_pesanan['keterangan_tambahan'],
                            'nominal_tambahan' => $data_pesanan['nominal_tambahan'],
                        ]);
                    } else {
                        $existingDetail = Detail_memotambahan::where([
                            'memotambahan_id' => $memotambahan->id,
                            'keterangan_tambahan' => $data_pesanan['keterangan_tambahan'],
                        ])->first();

                        if (!$existingDetail) {
                            Detail_memotambahan::create([
                                'memotambahan_id' => $memotambahan->id,
                                'keterangan_tambahan' => $data_pesanan['keterangan_tambahan'],
                                'nominal_tambahan' => $data_pesanan['nominal_tambahan'],
                            ]);
                        }
                    }
                }
                // Fetch Memo_ekspedisi and its details after the updates
                $cetakpdf = Memo_ekspedisi::find($id);
                $memotambahan = Memotambahan::where('id', $cetakpdf->memotambahan_id)->first();
                $detail_memo = Detail_memotambahan::where('memotambahan_id', $memotambahan->id)->get();

                return view('admin.inquery_memoekspedisi.show', compact('cetakpdf', 'detail_memo', 'memotambahan'));

                break;

            default:
        }
    }

    public function show($id)
    {
        $inquery = Memo_ekspedisi::where('id', $id)->first();
        if ($inquery->kategori == "Memo Tambahan") {
            $cetakpdf = Memo_ekspedisi::where('id', $id)->first();
            $memotambahans = Memotambahan::where('id', $cetakpdf->memotambahan_id)->first();
            $detail_memo = Detail_memotambahan::where('memotambahan_id', $memotambahans->id)->get();
            return view('admin.inquery_memoekspedisi.show', compact('cetakpdf', 'detail_memo'));
        } else {
            $cetakpdf = Memo_ekspedisi::where('id', $id)->first();
            // $memotambahans = Memotambahan::where('memo_id', $id)->first();
            $detail_memo = Detail_memo::where('memo_ekspedisi_id', $cetakpdf->id)->get();
            return view('admin.inquery_memoekspedisi.show', compact('cetakpdf', 'detail_memo'));
        }
    }

    public function unpostmemo($id)
    {
        $ban = Memo_ekspedisi::where('id', $id)->first();

        $ban->update([
            'status' => 'unpost'
        ]);

        return back()->with('success', 'Berhasil');
    }

    public function postingmemo($id)
    {
        $ban = Memo_ekspedisi::where('id', $id)->first();

        $ban->update([
            'status' => 'posting'
        ]);

        return back()->with('success', 'Berhasil');
    }

    public function hapusmemo($id)
    {
        $ban = Memo_ekspedisi::where('id', $id)->first();

        $ban->delete();
        return back()->with('success', 'Berhasil');
    }

    public function destroy($id)
    {
        $ban = Memo_ekspedisi::find($id);
        // $ban->detail_memo()->delete();
        $ban->delete();
        return redirect('admin/inquery_memoekspedisi')->with('success', 'Berhasil memperbarui memo ekspedisi');
    }
}