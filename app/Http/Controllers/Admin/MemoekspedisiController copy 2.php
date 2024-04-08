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
use App\Models\Detail_pengeluaran;
use App\Models\Kendaraan;
use App\Models\Memo_ekspedisi;
use App\Models\Memo_tambahan;
use App\Models\Memotambahan;
use App\Models\Pelanggan;
use App\Models\Penerimaan_kaskecil;
use App\Models\Pengeluaran_kaskecil;
use App\Models\Potongan_memo;
use App\Models\Rute_perjalanan;
use App\Models\Saldo;
use App\Models\Typeban;
use App\Models\Uangjaminan;
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
        $memos = Memo_ekspedisi::where(['status_memo' => null, 'status' => 'posting'])->get();
        $saldoTerakhir = Saldo::latest()->first();
        return view('admin.memo_ekspedisi.index', compact('memos', 'pelanggans', 'kendaraans', 'drivers', 'ruteperjalanans', 'biayatambahan', 'saldoTerakhir', 'potonganmemos'));
    }


    public function store(Request $request)
    {

        $kategori = $request->kategori;

        $commonData = [
            'kategori' => $kategori,
            // Tambahkan bidang data umum lainnya di sini
        ];

        // Validasi umum
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

        $saldoTerakhir = Saldo::latest()->first();
        $sub_total = str_replace('.', '', $request->uang_jalan);

        // if ($sub_total > $saldoTerakhir->sisa_saldo) {
        //     return back()->with('erorrss', 'Sisa saldo tidak mencukupi');
        // }

        switch ($kategori) {
            case 'Memo Perjalanan':

                $validasi_pelanggan = Validator::make(
                    $request->all(),
                    [
                        'kode_memo' => 'unique:memo_ekspedisis,kode_memo',
                        'kategori' => 'required',
                        'kendaraan_id' => 'required',
                        'user_id' => 'required',
                        'rute_perjalanan_id' => 'required',
                        'uang_jaminan' => 'required|not_in:0',
                        'sub_total' => 'required',
                        'deposit_driver' => 'required|numeric',
                        'uang_jalan' => ['nullable', function ($attribute, $value, $fail) {
                            // Remove non-numeric characters
                            $numericValue = preg_replace('/[^0-9]/', '', $value);

                            // Check if the resulting string is numeric
                            if (!is_numeric($numericValue)) {
                                $fail('Uang jalan harus berupa angka atau dalam format Rupiah yang valid.');
                            }
                        }],
                    ],
                    [
                        'kode_memo.unique' => 'Kode Memo sudah ada',
                        'kategori.required' => 'Pilih kategori',
                        'kendaraan_id.required' => 'Pilih no kabin',
                        'user_id.required' => 'Pilih driver',
                        'rute_perjalanan_id.required' => 'Pilih rute perjalanan',
                        'uang_jaminan.required' => 'cek uang jaminan',
                        'sub_total.required' => 'Masukkan total harga',
                        'deposit_driver.required' => 'Masukkan deposit sopir',
                        'deposit_driver.numeric' => 'Deposit harus berupa angka',
                        'uang_jalan.*' => 'Uang jalan harus berupa angka atau dalam format Rupiah yang valid',
                    ]
                );

                if ($validasi_pelanggan->fails()) {
                    $errors = $validasi_pelanggan->errors()->all();
                    return back()->withInput()->with('error', $errors);
                }

                session()->flash('last_deposit_driver', $request->input('deposit_driver'));

                $nama_driver = $request->input('nama_driver');
                $postedCount = Memo_ekspedisi::where('nama_driver', $nama_driver)
                    ->where('status', 'posting')
                    ->count();

                // Jika jumlahnya sudah mencapai atau melebihi 3, lewati memo ekspedisi ini
                if (
                    $postedCount >= 3
                ) {
                    return back()->with('erorrss', 'Memo telah mencapai batas maksimal untuk driver: ' . $nama_driver . ' ' . 'buat faktur terlebih dahulu untuk memo yang sudah di posting');
                }

                $error_pelanggans = array();

                if ($validasi_pelanggan->fails()) {
                    array_push($error_pelanggans, $validasi_pelanggan->errors()->all()[0]);
                }

                $error_pesanans = array();

                $kode = $this->kode();
                // tgl indo
                $tanggal1 = Carbon::now('Asia/Jakarta');
                $format_tanggal = $tanggal1->format('d F Y');

                $tanggal = Carbon::now()->format('Y-m-d');


                $uang_jalans = str_replace('.', '', $request->uang_jalan); // Menghilangkan titik dari totalrute
                $uang_jalans = str_replace(',', '.', $uang_jalans); // Mengganti koma dengan titik untuk memastikan format angka yang benar

                $potongan_memos = str_replace(',', '.', str_replace('.', '', $request->potongan_memo)); // Menghilangkan titik dan mengganti koma dengan titik pada pphs

                $biaya_tambahan = str_replace('.', '', $request->biaya_tambahan); // Menghilangkan titik dari biaya tambahan
                $biaya_tambahan = str_replace(',', '.', $biaya_tambahan); // Mengganti koma dengan titik untuk memastikan format angka yang benar

                $hasil_jumlah = $uang_jalans + $biaya_tambahan - $potongan_memos;


                $cetakpdf = Memo_ekspedisi::create(array_merge(
                    $request->all(),
                    [
                        'kategori' => $request->kategori,
                        'admin' => auth()->user()->karyawan->nama_lengkap,
                        'kendaraan_id' => $request->kendaraan_id,
                        'no_kabin' => $request->no_kabin,
                        'no_pol' => $request->no_pol,
                        'golongan' => $request->golongan,
                        'km_awal' => $request->km_awal,
                        'user_id' => $request->user_id,
                        'kode_driver' => $request->kode_driver,
                        'nama_driver' => $request->nama_driver,
                        'telp' => $request->telp,
                        'rute_perjalanan_id' => $request->rute_perjalanan_id,
                        'kode_rute' => $request->kode_rute,
                        'nama_rute' => $request->nama_rute,
                        'saldo_deposit' => str_replace(',', '.', str_replace('.', '', $request->saldo_deposit)),
                        'uang_jalan' => str_replace(',', '.', str_replace('.', '', $request->uang_jalan)),
                        'uang_jalans' => str_replace(',', '.', str_replace('.', '', $request->uang_jalans)),
                        'uang_jaminan' => str_replace(',', '.', str_replace('.', '', $request->uang_jaminan)),
                        'biaya_tambahan' => str_replace(',', '.', str_replace('.', '', $request->biaya_tambahan)),
                        'potongan_memo' => str_replace(',', '.', str_replace('.', '', $request->potongan_memo)),
                        'deposit_driver' => $request->deposit_driver ? str_replace('.', '', $request->deposit_driver) : 0,
                        'deposit_drivers' => $request->deposit_driver ? str_replace('.', '', $request->deposit_driver) : 0,
                        'sub_total' => str_replace(',', '.', str_replace('.', '', $request->sub_total)),
                        'hasil_jumlah' => $hasil_jumlah,
                        // 'sisa_saldo' => $request->sisa_saldo,
                        'keterangan' => $request->keterangan,
                        // 'harga' => $request->harga,
                        'kode_memo' => $this->kode(),
                        'qrcode_memo' => 'https:///javaline.id/memo_ekspedisi/' . $kode,
                        'tanggal' => $format_tanggal,
                        'tanggal_awal' => $tanggal,
                        'status' => 'unpost',

                        'biaya_id' => $request->biaya_id,
                        'kode_biaya' => $request->kode_biaya,
                        'nama_biaya' => $request->nama_biaya,
                        'nominal' => $request->has('nominal') ? ($request->nominal != 0 ? str_replace('.', '', $request->nominal) : null) : null,

                        'potongan_id' => $request->potongan_id,
                        'kode_potongan' => $request->kode_potongan,
                        'keterangan_potongan' => $request->keterangan_potongan,
                        'nominal_potongan' => $request->has('nominal_potongan') ? ($request->nominal_potongan != 0 ? str_replace('.', '', $request->nominal_potongan) : null) : null,
                    ]
                ));

                $kodepengeluaran = $this->kodepengeluaran();

                Pengeluaran_kaskecil::create([
                    'memo_ekspedisi_id' => $cetakpdf->id,
                    'user_id' => auth()->user()->id,
                    'kode_pengeluaran' => $this->kodepengeluaran(),
                    'kendaraan_id' => $request->kendaraan_id,
                    'keterangan' => $request->keterangan,
                    // 'grand_total' => str_replace('.', '', $request->uang_jalan),
                    'grand_total' => $hasil_jumlah,
                    'jam' => $tanggal1->format('H:i:s'),
                    'tanggal' => $format_tanggal,
                    'tanggal_awal' => $tanggal,
                    'qrcode_return' => 'https://batlink.id/pengeluaran_kaskecil/' . $kodepengeluaran,
                    'status' => 'pending',
                ]);

                Detail_pengeluaran::create([
                    'memo_ekspedisi_id' => $cetakpdf->id,
                    'barangakun_id' => 4,
                    'kode_detailakun' => $this->kodeakuns(),
                    'kode_akun' => 'KA000004',
                    'nama_akun' => 'PERJALANAN',
                    'keterangan' => $request->keterangan,
                    // 'nominal' => str_replace('.', '', $request->uang_jalan),
                    'nominal' => $hasil_jumlah,
                    'status' => 'pending',
                ]);

                Uangjaminan::create([
                    'memo_ekspedisi_id' => $cetakpdf->id,
                    'user_id' => auth()->user()->id,
                    'kode_jaminan' => $this->kodejaminan(),
                    'nama_sopir' => $request->nama_driver,
                    'keterangan' => $request->keterangan,
                    'type' => 'JAMINAN',
                    'nominal' => str_replace(',', '.', str_replace('.', '', $request->uang_jaminan)),
                    'jam' => $tanggal1->format('H:i:s'),
                    'tanggal' => $format_tanggal,
                    'tanggal_awal' => $tanggal,
                    'status' => 'pending',
                ]);

                return view('admin.memo_ekspedisi.show', compact('cetakpdf'));
                break;

            case 'Memo Borong':

                $validator = Validator::make(
                    $request->all(),
                    [
                        'kode_memo' => 'unique:memo_ekspedisis,kode_memo',
                        'kategori' => 'required',
                        'kendaraan_id' => 'required',
                        'user_id' => 'required',
                        // 'pelanggan_id' => 'required',
                        'sub_total' => 'required',
                        'uang_jaminans' => 'required|not_in:0',
                        'jumlah' => 'required',
                        'satuan' => 'required',
                        'deposit_drivers' => 'required|numeric',
                        'harga_rute' => ['nullable', function ($attribute, $value, $fail) {
                            // Remove non-numeric characters
                            $numericValue = preg_replace('/[^0-9]/', '', $value);

                            // Check if the resulting string is numeric
                            if (!is_numeric($numericValue)) {
                                $fail('Uang jalan harus berupa angka atau dalam format Rupiah yang valid.');
                            }
                        }],
                    ],
                    [
                        'kode_memo.unique' => 'Kode Memo sudah ada',
                        'kategori.required' => 'Pilih kategori',
                        'kendaraan_id.required' => 'Pilih no kabin',
                        'user_id.required' => 'Pilih driver',
                        'uang_jaminans.required' => 'cCek uang jaminan',
                        'sub_total.required' => 'Masukkan total harga',
                        'jumlah.required' => 'Masukkan quantity',
                        'satuan.required' => 'Pilih satuan',
                        'deposit_drivers.numeric' => 'Deposit harus berupa angka',
                        'harga_rute.*' => 'Uang jalan harus berupa angka atau dalam format Rupiah yang valid',
                    ]
                );

                $deposit = $request->depositsopir;

                // Check if $deposit is not a numeric value
                if (!is_numeric($deposit)) {
                    return back()->with('erorrss', 'Deposit harus berupa angka');
                }
                if ($validator->fails()) {
                    $errors = $validator->errors()->all();
                    return back()->withInput()->with('error', $errors);
                }

                $kode = $this->kodemb();
                // tgl indo
                $tanggal1 = Carbon::now('Asia/Jakarta');
                $format_tanggal = $tanggal1->format('d F Y');

                $totalrute = str_replace('.', '', $request->totalrute); // Menghilangkan titik dari totalrute
                $totalrute = str_replace(',', '.', $totalrute); // Mengganti koma dengan titik untuk memastikan format angka yang benar

                $pphs = str_replace(',', '.', str_replace('.', '', $request->pphs)); // Menghilangkan titik dan mengganti koma dengan titik pada pphs
                $pphs =  round($pphs); // Mem-bulatkan nilai

                $biaya_tambahan = str_replace('.', '', $request->biaya_tambahan); // Menghilangkan titik dari biaya tambahan
                $biaya_tambahan = str_replace(',', '.', $biaya_tambahan); // Mengganti koma dengan titik untuk memastikan format angka yang benar

                $hasil_jumlah = ($totalrute - $pphs) / 2 + $biaya_tambahan;



                // $uang_jaminan = str_replace('.', '', $request->uang_jaminans); // Menghapus titik
                // $uang_jaminan = str_replace(',', '.', $uang_jaminan); // Mengganti koma menjadi titik
                // $uang_jaminan = round($uang_jaminan); // Membulatkan nilai
                $tanggal = Carbon::now()->format('Y-m-d');
                $cetakpdf = Memo_ekspedisi::create(array_merge(
                    $request->all(),
                    [
                        'kategori' => $request->kategori,
                        'admin' => auth()->user()->karyawan->nama_lengkap,
                        'kendaraan_id' => $request->kendaraan_id,
                        'no_kabin' => $request->no_kabin,
                        'no_pol' => $request->no_pol,
                        'golongan' => $request->golongan,
                        'km_awal' => $request->km_awal,
                        'user_id' => $request->user_id,
                        'kode_driver' => $request->kode_driver,
                        'nama_driver' => $request->nama_driver,
                        'telp' => $request->telp,
                        'pelanggan_id' => $request->pelanggan_id,
                        'kode_pelanggan' => $request->kode_pelanggan,
                        'nama_pelanggan' => $request->nama_pelanggan,
                        'alamat_pelanggan' => $request->alamat_pelanggan,
                        'telp_pelanggan' => $request->telp_pelanggan,
                        'saldo_deposit' => str_replace(',', '.', str_replace('.', '', $request->saldo_deposit)),
                        // 'biaya_tambahan' => str_replace('.', '', $request->biaya_tambahan),
                        // 'deposit_driver' => str_replace('.', '', $request->depositsopir),
                        'deposit_driver' => $request->depositsopir ? str_replace('.', '', $request->depositsopir) : 0,
                        'deposit_drivers' => $request->depositsopir ? str_replace('.', '', $request->depositsopir) : 0,
                        'total_borongs' => str_replace(',', '.', str_replace('.', '', $request->total_borongs)),
                        // 'pphs' => str_replace('.', '', $request->pphs),
                        'pphs' => str_replace(',', '.', str_replace('.', '', $request->pphs)),
                        'hasil_jumlah' => $hasil_jumlah,

                        'biaya_tambahan' => $biaya_tambahan = is_null($request->harga_tambahanborong) ? 0 : str_replace('.', '', $request->harga_tambahanborong),
                        // 'uang_jaminans' => str_replace('.', '', $request->uang_jaminans),

                        // 'uang_jaminan' => str_replace('.', '', $request->uang_jaminans),
                        // 'deposit_drivers' => str_replace('.', '', $request->depositsopir),
                        'totals' => str_replace(',', '.', str_replace('.', '', $request->totals)),
                        // 'sub_total' => str_replace('.', '', $request->sub_totalborong),
                        'uang_jaminans' => str_replace(',', '.', str_replace('.', '', $request->uang_jaminans)),
                        'sub_total' => str_replace(',', '.', str_replace('.', '', $request->sub_totalborong)),
                        'keterangan' => $request->keterangan,
                        // 'sisa_saldo' => $request->sisa_saldo,
                        'kode_memo' => $this->kodemb(),
                        'qrcode_memo' => 'https:///javaline.id/memo_ekspedisi/' . $kode,
                        'tanggal' => $format_tanggal,
                        'tanggal_awal' => $tanggal,
                        'status' => 'unpost',
                        'rute_perjalanan_id' => $request->rute_id,
                        'kode_rute' => $request->kode_rutes,
                        'nama_rute' => $request->nama_rutes,
                        'harga_rute' => str_replace(',', '.', str_replace('.', '', $request->harga_rute)),
                        'jumlah' => $request->jumlah,
                        'satuan' => $request->satuan,
                        'totalrute' => str_replace(',', '.', str_replace('.', '', $request->totalrute)),
                        'biaya_id' => $request->biaya_id,
                        'kode_biaya' => $request->kode_biaya,
                        'nama_biaya' => $request->nama_biaya,
                        'nominal' => $request->has('nominal') ? ($request->nominal != 0 ? str_replace('.', '', $request->nominal) : null) : null,

                    ]
                ));

                $kodepengeluaran = $this->kodepengeluaran();

                Pengeluaran_kaskecil::create([
                    'memo_ekspedisi_id' => $cetakpdf->id,
                    'user_id' => auth()->user()->id,
                    'kode_pengeluaran' => $this->kodepengeluaran(),
                    'kendaraan_id' => $request->kendaraan_id,
                    'keterangan' => $request->keterangan,
                    'grand_total' => $hasil_jumlah,
                    'jam' => $tanggal1->format('H:i:s'),
                    'tanggal' => $format_tanggal,
                    'tanggal_awal' => $tanggal,
                    'qrcode_return' => 'https://batlink.id/pengeluaran_kaskecil/' . $kodepengeluaran,
                    'status' => 'pending',
                ]);

                Detail_pengeluaran::create([
                    'memo_ekspedisi_id' => $cetakpdf->id,
                    'barangakun_id' => 4,
                    'kode_detailakun' => $this->kodeakuns(),
                    'kode_akun' => 'KA000004',
                    'nama_akun' => 'MEMO BORONG',
                    'keterangan' => $request->keterangan,
                    'nominal' => $hasil_jumlah,
                    'status' => 'pending',
                ]);

                Uangjaminan::create([
                    'memo_ekspedisi_id' => $cetakpdf->id,
                    'user_id' => auth()->user()->id,
                    'kode_jaminan' => $this->kodejaminan(),
                    'nama_sopir' => $request->nama_driver,
                    'keterangan' => $request->keterangan,
                    'type' => 'JAMINAN',
                    'nominal' => str_replace(',', '.', str_replace('.', '', $request->uang_jaminans)),
                    'jam' => $tanggal1->format('H:i:s'),
                    'tanggal' => $format_tanggal,
                    'tanggal_awal' => $tanggal,
                    'status' => 'pending',
                ]);


                return view('admin.memo_ekspedisi.show', compact('cetakpdf'));

                break;


            case 'Memo Tambahan':

                $validasi_pelanggan = Validator::make(
                    $request->all(),
                    [
                        'kode_tambahan' => 'unique:memotambahans,kode_tambahan',
                        // 'memo_ekspedisi_id' => 'required',

                    ],
                    [
                        'kode_tambahan.unique' => 'Kode Memo sudah ada',
                        // 'memo_ekspedisi_id.required' => 'Pilih memo',
                        // 'kode_tambahan.unique' => 'Kode Memo sudah ada',

                    ]
                );


                $error_pelanggans = [];

                if ($validasi_pelanggan->fails()) {
                    $error_pelanggans[] = $validasi_pelanggan->errors()->first('memo_ekspedisi_id');
                }

                $error_pesanans = [];
                $data_pembelians4 = collect();

                $saldoTerakhir = Saldo::latest()->first();
                $grand_total = str_replace(',', '.', str_replace('.', '', $request->grand_total));
                $sub_total = str_replace('.', '', $grand_total);

                // if ($sub_total > $saldoTerakhir->sisa_saldo) {
                //     return back()->with('erorrss', 'Sisa saldo tidak mencukupi');
                // }

                if ($request->has('keterangan_tambahan')) {
                    for ($i = 0; $i < count($request->keterangan_tambahan); $i++) {

                        $validasi_produk = Validator::make($request->all(), [
                            'keterangan_tambahan.' . $i => 'required',
                            'qty.' . $i => 'required',
                            // 'satuans.' . $i => 'required',
                            'hargasatuan.' . $i => 'required',
                            'nominal_tambahan.' . $i => 'required',
                        ]);

                        if ($validasi_produk->fails()) {
                            array_push($error_pesanans, "Memo nomor " . ($i + 1) . " belum dilengkapi!");
                        }

                        $keterangan_tambahan = $request->keterangan_tambahan[$i] ?? '';
                        $qty = $request->qty[$i] ?? '';
                        $satuans = $request->satuans[$i] ?? '';
                        $hargasatuan = $request->hargasatuan[$i] ?? '';
                        $nominal_tambahan = $request->nominal_tambahan[$i] ?? '';

                        $data_pembelians4->push(['keterangan_tambahan' => $keterangan_tambahan, 'qty' => $qty, 'satuans' => $satuans, 'hargasatuan' => $hargasatuan, 'nominal_tambahan' => $nominal_tambahan]);
                    }
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
                // Create Memotambahan record
                $cetakpdf = Memotambahan::create([
                    'memo_ekspedisi_id' => $request->memo_ekspedisi_id,
                    'admin' => auth()->user()->karyawan->nama_lengkap,
                    'kategori' => $request->kategori,
                    'no_memo' => $request->kode_memosa,
                    'nama_driver' => $request->nama_driversa,
                    'telp' => $request->telps,
                    'kendaraan_id' => $request->kendaraan_idsa,
                    'no_kabin' => $request->no_kabinsa,
                    'no_pol' => $request->no_polsa,
                    'nama_rute' => $request->nama_rutesa,
                    'kode_tambahan' => $kode,
                    'grand_total' => str_replace(',', '.', str_replace('.', '', $request->grand_total)),
                    'tanggal' => $format_tanggal,
                    'tanggal_awal' => $tanggal,
                    'status' => 'unpost',
                ]);

                $transaksi_id = $cetakpdf->id;
                $allKeterangan = ''; // Initialize an empty string to accumulate keterangan values
                $kodepengeluaran = $this->kodepengeluaran();

                if ($cetakpdf) {
                    foreach ($data_pembelians4 as $data_pesanan) {
                        $detailMemotambahan = Detail_memotambahan::create([
                            'memotambahan_id' => $cetakpdf->id,
                            'keterangan_tambahan' => $data_pesanan['keterangan_tambahan'],
                            'qty' => $data_pesanan['qty'],
                            'satuans' => $data_pesanan['satuans'],
                            'hargasatuan' => $data_pesanan['hargasatuan'],
                            'nominal_tambahan' =>  str_replace(',', '.', str_replace('.', '', $data_pesanan['nominal_tambahan'])),

                        ]);
                        // Use the $detailMemotambahan->id in the creation of Detail_pengeluaran
                        $detail_pengeluaran = Detail_pengeluaran::create([
                            'kode_detailakun' => $this->kodeakuns(),
                            'detail_memotambahan_id' => $detailMemotambahan->id,
                            'memotambahan_id' => $cetakpdf->id,
                            'barangakun_id' => 25,
                            'kode_akun' => 'KA000025',
                            'nama_akun' => 'MEMO TAMBAHAN',
                            'status' => 'pending',
                            'keterangan' => $data_pesanan['keterangan_tambahan'],
                            'qty' => $data_pesanan['qty'],
                            'satuans' => $data_pesanan['satuans'],
                            'hargasatuan' => $data_pesanan['hargasatuan'],
                            'nominal' =>  str_replace(',', '.', str_replace('.', '', $data_pesanan['nominal_tambahan'])),

                        ]);

                        $allKeterangan .= $data_pesanan['keterangan_tambahan'] . ', ';
                    }
                }

                Pengeluaran_kaskecil::create([
                    'memotambahan_id' => $cetakpdf->id,
                    'user_id' => auth()->user()->id,
                    'kode_pengeluaran' => $this->kodepengeluaran(),
                    'kendaraan_id' => $request->kendaraan_idsa,
                    'keterangan' => $allKeterangan, // Use accumulated keterangan values
                    'grand_total' => str_replace(',', '.', str_replace('.', '', $request->grand_total)),
                    'jam' => $tanggal1->format('H:i:s'),
                    'tanggal' => $format_tanggal,
                    'tanggal_awal' => $tanggal,
                    'qrcode_return' => 'https://batlink.id/pengeluaran_kaskecil/' . $kodepengeluaran,
                    'status' => 'pending',
                ]);


                // if ($cetakpdf) {
                //     foreach ($data_pembelians4 as $data_pesanan) {
                //         Detail_memotambahan::create([
                //             'memotambahan_id' => $cetakpdf->id,
                //             'keterangan_tambahan' => $data_pesanan['keterangan_tambahan'],
                //             'nominal_tambahan' => $data_pesanan['nominal_tambahan'],
                //         ]);
                //     }
                // }

                // if ($cetakpdf) {
                //     foreach ($data_pembelians4 as $data_pesanan) {
                //         Detail_pengeluaran::create([
                //             'detail_memotambahan_id' => ,
                //             'memotambahan_id' => $cetakpdf->id,
                //             'barangakun_id' => 25,
                //             'kode_akun' => 'KA000025',
                //             'nama_akun' => 'MEMO TAMBAHAN',
                //             'status' => 'pending',
                //             'keterangan' => $data_pesanan['keterangan_tambahan'],
                //             'nominal' => $data_pesanan['nominal_tambahan'],
                //         ]);
                //     }
                // }



                // Detail_pengeluaran::create([
                //     'memotambahan_id' => $cetakpdf->id,
                //     'barangakun_id' => 25,
                //     'kode_akun' => 'KA000025',
                //     'nama_akun' => 'MEMO TAMBAHAN',
                //     'keterangan' => $request->keterangan,
                //     'nominal' => str_replace('.', '', $request->grand_total),
                //     'status' => 'pending',
                // ]);

                $detail_memo = Detail_memotambahan::where('memotambahan_id', $cetakpdf->id)->get();

                return view('admin.tablememo.show', compact('cetakpdf', 'detail_memo'));

                break;

            default:
        }
    }

    // public function kodeakuns()
    // {
    //     $ban = Detail_pengeluaran::all();
    //     if ($ban->isEmpty()) {
    //         $num = "000001";
    //     } else {
    //         $id = Detail_pengeluaran::getId();
    //         foreach ($id as $value);
    //         $idlm = $value->id;
    //         $idbr = $idlm + 1;
    //         $num = sprintf("%06s", $idbr);
    //     }

    //     $data = 'KKA';
    //     $kode_ban = $data . $num;
    //     return $kode_ban;
    // }

    // public function kodepengeluaran()
    // {
    //     $item = Pengeluaran_kaskecil::all();
    //     if ($item->isEmpty()) {
    //         $num = "000001";
    //     } else {
    //         $id = Pengeluaran_kaskecil::getId();
    //         foreach ($id as $value);
    //         $idlm = $value->id;
    //         $idbr = $idlm + 1;
    //         $num = sprintf("%06s", $idbr);
    //     }

    //     $data = 'KK';
    //     $kode_item = $data . $num;
    //     return $kode_item;
    // }

    // public function kode()
    // {
    //     $penerimaan = Memo_ekspedisi::all();
    //     if ($penerimaan->isEmpty()) {
    //         $num = "000001";
    //     } else {
    //         $id = Memo_ekspedisi::getId();
    //         foreach ($id as $value);
    //         $idlm = $value->id;
    //         $idbr = $idlm + 1;
    //         $num = sprintf("%06s", $idbr);
    //     }

    //     $data = 'MP';
    //     $kode_penerimaan = $data . $num;
    //     return $kode_penerimaan;
    // }

    public function kodeakuns()
    {
        $lastBarang = Detail_pengeluaran::latest()->first();
        if (!$lastBarang) {
            $num = 1;
        } else {
            $lastCode = $lastBarang->kode_detailakun;
            $num = (int) substr($lastCode, strlen('KKA')) + 1;
        }
        $formattedNum = sprintf("%06s", $num);
        $prefix = 'KKA';
        $newCode = $prefix . $formattedNum;
        return $newCode;
    }

    public function kodepengeluaran()
    {
        $lastBarang = Pengeluaran_kaskecil::latest()->first();
        if (!$lastBarang) {
            $num = 1;
        } else {
            $lastCode = $lastBarang->kode_pengeluaran;
            $num = (int) substr($lastCode, strlen('KK')) + 1;
        }
        $formattedNum = sprintf("%06s", $num);
        $prefix = 'KK';
        $newCode = $prefix . $formattedNum;
        return $newCode;
    }

    public function kodejaminan()
    {
        $lastBarang = Uangjaminan::latest()->first();
        if (!$lastBarang) {
            $num = 1;
        } else {
            $lastCode = $lastBarang->kode_jaminan;
            $num = (int) substr($lastCode, strlen('ADM')) + 1;
        }
        $formattedNum = sprintf("%06s", $num);
        $prefix = 'ADM';
        $newCode = $prefix . $formattedNum;
        return $newCode;
    }



    public function kode()
    {
        // Mengambil kode terbaru dari database dengan awalan 'MP'
        $lastBarang = Memo_ekspedisi::where('kode_memo', 'like', 'MP%')->latest()->first();

        // Jika tidak ada kode sebelumnya, mulai dengan 1
        if (!$lastBarang) {
            $num = 1;
        } else {
            // Jika ada kode sebelumnya, ambil nomor terakhir
            $lastCode = $lastBarang->kode_memo;

            // Ambil nomor dari kode terakhir, tanpa awalan 'MP', lalu tambahkan 1
            $num = (int) substr($lastCode, strlen('MP')) + 1;
        }

        // Format nomor dengan leading zeros sebanyak 6 digit
        $formattedNum = sprintf("%06s", $num);

        // Awalan untuk kode baru
        $prefix = 'MP';

        // Buat kode baru dengan menggabungkan awalan dan nomor yang diformat
        $newCode = $prefix . $formattedNum;

        // Kembalikan kode
        return $newCode;
    }

    public function kodemb()
    {
        // Mengambil kode terbaru dari database dengan awalan 'MB'
        $lastBarang = Memo_ekspedisi::where('kode_memo', 'like', 'MB%')->latest()->first();

        // Jika tidak ada kode sebelumnya, mulai dengan 1
        if (!$lastBarang) {
            $num = 1;
        } else {
            // Jika ada kode sebelumnya, ambil nomor terakhir
            $lastCode = $lastBarang->kode_memo;

            // Ambil nomor dari kode terakhir, tanpa awalan 'MB', lalu tambahkan 1
            $num = (int) substr($lastCode, strlen('MB')) + 1;
        }

        // Format nomor dengan leading zeros sebanyak 6 digit
        $formattedNum = sprintf("%06s", $num);

        // Awalan untuk kode baru
        $prefix = 'MB';

        // Buat kode baru dengan menggabungkan awalan dan nomor yang diformat
        $newCode = $prefix . $formattedNum;

        // Kembalikan kode
        return $newCode;
    }

    public function kodemt()
    {
        $lastBarang = Memotambahan::latest()->first();
        if (!$lastBarang) {
            $num = 1;
        } else {
            $lastCode = $lastBarang->kode_tambahan;
            $num = (int) substr($lastCode, strlen('MT')) + 1;
        }
        $formattedNum = sprintf("%06s", $num);
        $prefix = 'MT';
        $newCode = $prefix . $formattedNum;
        return $newCode;
    }

    // public function kodemb()
    // {
    //     $penerimaan = Memo_ekspedisi::all();
    //     if ($penerimaan->isEmpty()) {
    //         $num = "000001";
    //     } else {
    //         $id = Memo_ekspedisi::getId();
    //         foreach ($id as $value);
    //         $idlm = $value->id;
    //         $idbr = $idlm + 1;
    //         $num = sprintf("%06s", $idbr);
    //     }

    //     $data = 'MB';
    //     $kode_penerimaan = $data . $num;
    //     return $kode_penerimaan;
    // }


    // public function kodemt()
    // {
    //     $penerimaan = Memotambahan::all();
    //     if ($penerimaan->isEmpty()) {
    //         $num = "000001";
    //     } else {
    //         $id = Memotambahan::getId();
    //         foreach ($id as $value);
    //         $idlm = $value->id;
    //         $idbr = $idlm + 1;
    //         $num = sprintf("%06s", $idbr);
    //     }

    //     $data = 'MT';
    //     $kode_penerimaan = $data . $num;
    //     return $kode_penerimaan;
    // }


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
        $cetakpdf = Memo_ekspedisi::where('id', $id)->first();

        // If Memo_ekspedisi is not found, try fetching Memotambahan
        if (!$cetakpdf) {
            $cetakpdf = Memotambahan::where('id', $id)->first();

            // If Memotambahan is not found, handle the error
            if (!$cetakpdf) {
                abort(404, 'Memo not found');
            }

            // Generate PDF for Memotambahan
            $detail_memo = Detail_memotambahan::where('memotambahan_id', $cetakpdf->id)->get();
            $pdf = PDF::loadView('admin.memo_ekspedisi.cetak_pdf', compact('cetakpdf', 'detail_memo'));
            $pdf->setPaper('letter', 'portrait'); // Set the paper size to portrait letter
            return $pdf->stream('Memo_ekspedisi.pdf');
        }

        // Generate PDF for Memo_ekspedisi
        $pdf = PDF::loadView('admin.memo_ekspedisi.cetak_pdf', compact('cetakpdf'));
        $pdf->setPaper('letter', 'portrait'); // Set the paper size to portrait letter
        return $pdf->stream('Memo_ekspedisi.pdf');
    }
}
