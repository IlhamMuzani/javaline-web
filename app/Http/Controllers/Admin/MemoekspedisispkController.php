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
use App\Models\Detail_notabon;
use App\Models\Detail_pengeluaran;
use App\Models\Detail_potongan;
use App\Models\Detail_tambahan;
use App\Models\Jarak_km;
use App\Models\Kendaraan;
use App\Models\Memo_ekspedisi;
use App\Models\Memo_tambahan;
use App\Models\Memotambahan;
use App\Models\Notabon_ujs;
use App\Models\Pelanggan;
use App\Models\Penerimaan_kaskecil;
use App\Models\Pengambilan_do;
use App\Models\Pengeluaran_kaskecil;
use App\Models\Potongan_memo;
use App\Models\Rute_perjalanan;
use App\Models\Saldo;
use App\Models\Spk;
use App\Models\Tarif_asuransi;
use App\Models\Typeban;
use App\Models\Uangjaminan;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MemoekspedisispkController extends Controller
{
    public function index()
    {
        // $kendaraans = Kendaraan::all();
        // $drivers = User::whereHas('karyawan', function ($query) {
        //     $query->where('departemen_id', '2');
        // })->get();

        $spks = Spk::where('voucher', '<', 2)
            ->where(function ($query) {
                $query->where('status_spk', '!=', 'faktur')
                    ->where('status_spk', '!=', 'invoice')
                    ->where('status_spk', '!=', 'pelunasan')
                    ->orWhereNull('status_spk');
            })
            ->orderBy('created_at', 'desc') // Change 'created_at' to the appropriate timestamp column
            ->get();

        $ruteperjalanans = Rute_perjalanan::all();
        $biayatambahan = Biaya_tambahan::all();
        $potonganmemos = Potongan_memo::all();
        $tarifs = Tarif_asuransi::all();
        $pelanggans = Pelanggan::all();
        // $memos = Memo_ekspedisi::where(function ($query) {
        //     $query->where(['status_memo' => null, 'status' => 'posting'])
        //         ->orWhere(['status_memo' => null, 'status' => 'unpost']);
        // })->get();
        $memos = Memo_ekspedisi::where(['status_memo' => null, 'status' => 'posting', 'status_memotambahan' => null])->get();
        $notas = Notabon_ujs::where(['status_memo' => null, 'status' => 'posting'])->get();
        $saldoTerakhir = Saldo::latest()->first();
        return view('admin.memo_ekspedisispk.index', compact('tarifs', 'notas', 'spks', 'memos', 'pelanggans', 'ruteperjalanans', 'biayatambahan', 'saldoTerakhir', 'potonganmemos'));
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
                // 'kendaraan_id' => 'required',
            ],
            [
                'kategori.required' => 'Pilih kategori',
                // 'kendaraan_id.required' => 'Pilih kendaraan',
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
                // $jarak = Jarak_km::first();
                // $kendaraan = Kendaraan::find($request->kendaraan_id);

                // if ($kendaraan == null) {
                //     return back();
                // }

                $validasi_pelanggan = Validator::make(
                    $request->all(),
                    [
                        'spk_id' => 'required',
                        'kode_memo' => 'unique:memo_ekspedisis,kode_memo',
                        'kategori' => 'required',
                        'kendaraan_id' => 'required',
                        'user_id' => 'required',
                        'rute_perjalanan_id' => 'required',
                        'uang_jaminan' => 'required|not_in:0',
                        // 'uang_jaminan' => 'required',
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
                        // 'km_akhir' => [
                        //     'required',
                        //     'numeric',
                        //     'min:' . ($kendaraan->km + 1),
                        //     function ($attribute, $value, $fail) use ($kendaraan, $jarak) {
                        //         if ($value - $kendaraan->km > $jarak->batas) {
                        //             $fail('Nilai km baru tidak boleh lebih dari ' . $jarak->batas . ' km dari km awal.');
                        //         }
                        //     },
                        // ],
                    ],
                    [
                        'spk.required' => 'Pilih Spk',
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
                        // 'km_akhir.required' => 'Masukkan nilai km',
                        // 'km_akhir.numeric' => 'Nilai Km harus berupa angka',
                        // 'km_akhir.min' => 'Nilai Km harus lebih tinggi dari Km awal',
                    ]
                );

                $error_pelanggans = array();

                if ($validasi_pelanggan->fails()) {
                    array_push($error_pelanggans, $validasi_pelanggan->errors()->all()[0]);
                }

                $error_pesanans = array();
                $data_pembelians = collect();
                $data_pembelians4 = collect();
                $data_pembeliansnota = collect();


                if ($request->has('biaya_tambahan_id') || $request->has('kode_biaya') || $request->has('nama_biaya') || $request->has('nominal')) {
                    for ($i = 0; $i < count($request->biaya_tambahan_id); $i++) {
                        // Check if either 'keterangan_tambahan' or 'nominal_tambahan' has input
                        if (empty($request->biaya_tambahan_id[$i]) && empty($request->kode_biaya[$i]) && empty($request->nama_biaya[$i]) && empty($request->nominal[$i])) {
                            continue; // Skip validation if both are empty
                        }

                        $validasi_produk = Validator::make($request->all(), [
                            'biaya_tambahan_id.' . $i => 'required',
                            'kode_biaya.' . $i => 'required',
                            'nama_biaya.' . $i => 'required',
                            'nominal.' . $i => 'required',
                        ]);

                        if ($validasi_produk->fails()) {
                            array_push($error_pesanans, "Biaya tambahan  nomor " . ($i + 1) . " belum dilengkapi!");
                        }

                        $biaya_tambahan_id = $request->biaya_tambahan_id[$i] ?? '';
                        $kode_biaya = $request->kode_biaya[$i] ?? '';
                        $nama_biaya = $request->nama_biaya[$i] ?? '';
                        $nominal = $request->nominal[$i] ?? '';

                        $data_pembelians->push([
                            'biaya_tambahan_id' => $biaya_tambahan_id,
                            'kode_biaya' => $kode_biaya,
                            'nama_biaya' => $nama_biaya,
                            'nominal' => $nominal,

                        ]);
                    }
                }

                if ($request->has('potongan_memo_id') || $request->has('kode_potongan') || $request->has('keterangan_potongan') || $request->has('nominal_potongan')) {
                    for ($i = 0; $i < count($request->potongan_memo_id); $i++) {
                        // Check if either 'keterangan_tambahan' or 'nominal_tambahan' has input
                        if (empty($request->potongan_memo_id[$i]) && empty($request->kode_potongan[$i]) && empty($request->keterangan_potongan[$i]) && empty($request->nominal_potongan[$i])) {
                            continue; // Skip validation if both are empty
                        }

                        $validasi_produk = Validator::make($request->all(), [
                            'potongan_memo_id.' . $i => 'required',
                            'kode_potongan.' . $i => 'required',
                            'keterangan_potongan.' . $i => 'required',
                            'nominal_potongan.' . $i => 'required',
                        ]);

                        if ($validasi_produk->fails()) {
                            array_push($error_pesanans, "Potongan nomor " . ($i + 1) . " belum dilengkapi!");
                        }

                        $potongan_memo_id = $request->potongan_memo_id[$i] ?? '';
                        $kode_potongan = $request->kode_potongan[$i] ?? '';
                        $keterangan_potongan = $request->keterangan_potongan[$i] ?? '';
                        $nominal_potongan = $request->nominal_potongan[$i] ?? '';

                        $data_pembelians4->push([
                            'potongan_memo_id' => $potongan_memo_id,
                            'kode_potongan' => $kode_potongan,
                            'keterangan_potongan' => $keterangan_potongan,
                            'nominal_potongan' => $nominal_potongan,

                        ]);
                    }
                }

                if ($request->has('notabon_ujs_id') || $request->has('kode_nota') || $request->has('nama_drivernota') || $request->has('nominal_nota')) {
                    for ($i = 0; $i < count($request->notabon_ujs_id); $i++) {
                        // Check if either 'keterangan_tambahan' or 'nominal_tambahan' has input
                        if (
                            empty($request->notabon_ujs_id[$i]) && empty($request->kode_nota[$i]) && empty($request->nama_drivernota[$i]) && empty($request->nominal_nota[$i])
                        ) {
                            continue; // Skip validation if both are empty
                        }

                        $validasi_produk = Validator::make($request->all(), [
                            'notabon_ujs_id.' . $i => 'required',
                            'kode_nota.' . $i => 'required',
                            'nama_drivernota.' . $i => 'required',
                            'nominal_nota.' . $i => 'required',
                        ]);

                        if ($validasi_produk->fails()) {
                            array_push($error_pesanans, "Nota bon nomor " . ($i + 1) . " belum dilengkapi!");
                        }

                        $notabon_ujs_id = $request->notabon_ujs_id[$i] ?? '';
                        $kode_nota = $request->kode_nota[$i] ?? '';
                        $nama_drivernota = $request->nama_drivernota[$i] ?? '';
                        $nominal_nota = $request->nominal_nota[$i] ?? '';

                        $data_pembeliansnota->push([
                            'notabon_ujs_id' => $notabon_ujs_id,
                            'kode_nota' => $kode_nota,
                            'nama_drivernota' => $nama_drivernota,
                            'nominal_nota' => $nominal_nota,

                        ]);
                    }
                }

                if ($error_pelanggans || $error_pesanans) {
                    return back()
                        ->withInput()
                        ->with('error_pelanggans', $error_pelanggans)
                        ->with('error_pesanans', $error_pesanans)
                        ->with('data_pembelians', $data_pembelians)
                        ->with('data_pembelians4', $data_pembelians4)
                        ->with('data_pembeliansnota', $data_pembeliansnota);
                }

                if ($validasi_pelanggan->fails()) {
                    $errors = $validasi_pelanggan->errors()->all();
                    return back()->withInput()->with('error', $errors);
                }

                session()->flash('last_deposit_driver', $request->input('deposit_driver'));

                $kendaraan_id = $request->input('kendaraan_id');
                $postedCount = Memo_ekspedisi::where(
                    'kendaraan_id',
                    $kendaraan_id
                )
                    ->where('status', 'rilis')
                    ->count();


                if (
                    $postedCount >= 1
                ) {
                    return back()->with('erorrss', 'DO sebelumnya belum terambil, hubungi driver untuk segera menyelesaikan do');
                }


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


                $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);
                $kendaraan->update([
                    'km' => $request->km_awal
                ]);

                $kms = $request->km_awal;

                // Periksa apakah selisih kurang dari 1000 atau lebih tinggi dari km_olimesin
                if (
                    $kms > $kendaraan->km_olimesin - 1000 || $kms > $kendaraan->km_olimesin
                ) {
                    $status_olimesins = "belum penggantian";
                    $kendaraan->status_olimesin = $status_olimesins;
                }

                if (
                    $kms > $kendaraan->km_oligardan - 5000 || $kms > $kendaraan->km_oligardan
                ) {
                    $status_olimesins = "belum penggantian";
                    $kendaraan->status_oligardan = $status_olimesins;
                }

                if (
                    $kms > $kendaraan->km_olitransmisi - 5000 || $kms > $kendaraan->km_olitransmisi
                ) {
                    $status_olimesins = "belum penggantian";
                    $kendaraan->status_olitransmisi = $status_olimesins;
                }

                // Update umur_ban for related ban
                foreach ($kendaraan->ban as $ban) {
                    $ban->update([
                        'umur_ban' => ($kms - $ban->km_pemasangan) + ($ban->jumlah_km ?? 0)
                    ]);
                }


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
                $notabon = str_replace('.', '', $request->nota_bon);
                $hasil_jumlah = $uang_jalans + $biaya_tambahan - $potongan_memos - $notabon;

                $spk_id = $request->spk_id;
                $spk = Spk::where('id', $spk_id)->first();
                $pengambilan_do = Pengambilan_do::where('spk_id', $spk->id)->first(); // Mengambil satu pengambilan_do

                $status_memo = 'rilis';
                if (
                    $pengambilan_do && in_array($pengambilan_do->status, ['unpost', 'posting'])
                ) {
                    $status_memo = 'rilis';
                } else {
                    $status_memo = 'unpost';
                }

                $cetakpdf = Memo_ekspedisi::create(array_merge(
                    $request->all(),
                    [
                        'kategori' => $request->kategori,
                        'spk_id' => $request->spk_id,
                        'admin' => auth()->user()->karyawan->nama_lengkap,
                        'kendaraan_id' => $request->kendaraan_id,
                        'no_kabin' => $request->no_kabin,
                        'no_pol' => $request->no_pol,
                        'golongan' => $request->golongan,
                        'km_awal' => $request->km_awal,
                        'km_akhir' => $request->km_akhir,
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
                        'nota_bon' => str_replace(',', '.', str_replace('.', '', $request->nota_bon)),
                        'hasil_jumlah' => $hasil_jumlah,
                        // 'sisa_saldo' => $request->sisa_saldo,
                        'keterangan' => $request->keterangan,
                        // 'harga' => $request->harga,
                        'kode_memo' => $this->kode(),
                        'qrcode_memo' => 'https://javaline.id/memo_ekspedisispk/' . $kode,
                        'tanggal' => $format_tanggal,
                        'tanggal_awal' => $tanggal,
                        'status' => $status_memo,
                    ]
                ));

                $transaksi_id = $cetakpdf->id;

                if ($cetakpdf) {

                    foreach ($data_pembelians as $data_pesanan) {
                        Detail_tambahan::create([
                            'memo_ekspedisi_id' => $cetakpdf->id,
                            'biaya_tambahan_id' => $data_pesanan['biaya_tambahan_id'],
                            'kode_biaya' => $data_pesanan['kode_biaya'],
                            'nama_biaya' => $data_pesanan['nama_biaya'],
                            'nominal' =>  str_replace(',', '.', str_replace('.', '', $data_pesanan['nominal'])),
                        ]);
                    }
                }

                if ($cetakpdf) {

                    foreach ($data_pembelians4 as $data_pesanan) {
                        Detail_potongan::create([
                            'memo_ekspedisi_id' => $cetakpdf->id,
                            'potongan_memo_id' => $data_pesanan['potongan_memo_id'],
                            'kode_potongan' => $data_pesanan['kode_potongan'],
                            'keterangan_potongan' => $data_pesanan['keterangan_potongan'],
                            'nominal_potongan' =>  str_replace(',', '.', str_replace('.', '', $data_pesanan['nominal_potongan'])),
                        ]);
                    }
                }

                if ($cetakpdf) {

                    foreach ($data_pembeliansnota as $data_pesanan) {
                        $detail = Detail_notabon::create([
                            'memo_ekspedisi_id' => $cetakpdf->id,
                            'notabon_ujs_id' => $data_pesanan['notabon_ujs_id'],
                            'kode_nota' => $data_pesanan['kode_nota'],
                            'nama_drivernota' => $data_pesanan['nama_drivernota'],
                            'nominal_nota' =>  str_replace(',', '.', str_replace('.', '', $data_pesanan['nominal_nota'])),
                        ]);
                        // $nota = Notabon_ujs::find($detail->notabon_ujs_id);
                        // if ($nota) {
                        //     $nota->update(['status_memo' => 'aktif']);
                        // }
                    }
                }

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

                $spk = Spk::where('id', $request->spk_id)->increment('voucher');

                $detail_nota = Detail_notabon::where('memo_ekspedisi_id', $cetakpdf->id)->get();

                return view('admin.memo_ekspedisispk.show', compact('cetakpdf', 'detail_nota'));
                break;

            case 'Memo Borong':
                // $jarak = Jarak_km::first();
                // $kendaraan = Kendaraan::find($request->kendaraan_id);
                // if ($kendaraan == null) {
                //     return back();
                // }
                $validasi_pelanggan = Validator::make(
                    $request->all(),
                    [
                        'spk_id' => 'required',
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
                        // 'km_akhir' => [
                        //     'required',
                        //     'numeric',
                        //     'min:' . ($kendaraan->km + 1),
                        //     function ($attribute, $value, $fail) use ($kendaraan, $jarak) {
                        //         if ($value - $kendaraan->km > $jarak->batas) {
                        //             $fail('Nilai km baru tidak boleh lebih dari ' . $jarak->batas . ' km dari km awal.');
                        //         }
                        //     },
                        // ],
                    ],
                    [
                        'spk.required' => 'Pilih Spk',
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
                        // 'km_akhir.required' => 'Masukkan nilai km',
                        // 'km_akhir.numeric' => 'Nilai Km harus berupa angka',
                        // 'km_akhir.min' => 'Nilai Km harus lebih tinggi dari Km awal',
                    ]
                );

                $error_pelanggans = array();

                if ($validasi_pelanggan->fails()) {
                    array_push($error_pelanggans, $validasi_pelanggan->errors()->all()[0]);
                }

                $error_pesanans = array();
                $data_pembelians = collect();
                $data_pembelians4 = collect();
                $data_pembeliansnota = collect();


                if ($request->has('biaya_tambahan_id') || $request->has('kode_biaya') || $request->has('nama_biaya') || $request->has('nominal')) {
                    for ($i = 0; $i < count($request->biaya_tambahan_id); $i++) {
                        // Check if either 'keterangan_tambahan' or 'nominal_tambahan' has input
                        if (empty($request->biaya_tambahan_id[$i]) && empty($request->kode_biaya[$i]) && empty($request->nama_biaya[$i]) && empty($request->nominal[$i])) {
                            continue; // Skip validation if both are empty
                        }

                        $validasi_produk = Validator::make($request->all(), [
                            'biaya_tambahan_id.' . $i => 'required',
                            'kode_biaya.' . $i => 'required',
                            'nama_biaya.' . $i => 'required',
                            'nominal.' . $i => 'required',
                        ]);

                        if ($validasi_produk->fails()) {
                            array_push($error_pesanans, "Biaya tambahan  nomor " . ($i + 1) . " belum dilengkapi!");
                        }

                        $biaya_tambahan_id = $request->biaya_tambahan_id[$i] ?? '';
                        $kode_biaya = $request->kode_biaya[$i] ?? '';
                        $nama_biaya = $request->nama_biaya[$i] ?? '';
                        $nominal = $request->nominal[$i] ?? '';

                        $data_pembelians->push([
                            'biaya_tambahan_id' => $biaya_tambahan_id,
                            'kode_biaya' => $kode_biaya,
                            'nama_biaya' => $nama_biaya,
                            'nominal' => $nominal,

                        ]);
                    }
                }

                if ($request->has('potongan_memo_id') || $request->has('kode_potongan') || $request->has('keterangan_potongan') || $request->has('nominal_potongan')) {
                    for (
                        $i = 0;
                        $i < count($request->potongan_memo_id);
                        $i++
                    ) {
                        // Check if either 'keterangan_tambahan' or 'nominal_tambahan' has input
                        if (
                            empty($request->potongan_memo_id[$i]) && empty($request->kode_potongan[$i]) && empty($request->keterangan_potongan[$i]) && empty($request->nominal_potongan[$i])
                        ) {
                            continue; // Skip validation if both are empty
                        }

                        $validasi_produk = Validator::make($request->all(), [
                            'potongan_memo_id.' . $i => 'required',
                            'kode_potongan.' . $i => 'required',
                            'keterangan_potongan.' . $i => 'required',
                            'nominal_potongan.' . $i => 'required',
                        ]);

                        if ($validasi_produk->fails()) {
                            array_push($error_pesanans, "Potongan nomor " . ($i + 1) . " belum dilengkapi!");
                        }

                        $potongan_memo_id = $request->potongan_memo_id[$i] ?? '';
                        $kode_potongan = $request->kode_potongan[$i] ?? '';
                        $keterangan_potongan = $request->keterangan_potongan[$i] ?? '';
                        $nominal_potongan = $request->nominal_potongan[$i] ?? '';

                        $data_pembelians4->push([
                            'potongan_memo_id' => $potongan_memo_id,
                            'kode_potongan' => $kode_potongan,
                            'keterangan_potongan' => $keterangan_potongan,
                            'nominal_potongan' => $nominal_potongan,

                        ]);
                    }
                }

                if ($request->has('notabon_ujs_id') || $request->has('kode_nota') || $request->has('nama_drivernota') || $request->has('nominal_nota')) {
                    for ($i = 0; $i < count($request->notabon_ujs_id); $i++) {
                        // Check if either 'keterangan_tambahan' or 'nominal_tambahan' has input
                        if (
                            empty($request->notabon_ujs_id[$i]) && empty($request->kode_nota[$i]) && empty($request->nama_drivernota[$i]) && empty($request->nominal_nota[$i])
                        ) {
                            continue; // Skip validation if both are empty
                        }

                        $validasi_produk = Validator::make($request->all(), [
                            'notabon_ujs_id.' . $i => 'required',
                            'kode_nota.' . $i => 'required',
                            'nama_drivernota.' . $i => 'required',
                            'nominal_nota.' . $i => 'required',
                        ]);

                        if ($validasi_produk->fails()) {
                            array_push($error_pesanans, "Nota bon nomor " . ($i + 1) . " belum dilengkapi!");
                        }

                        $notabon_ujs_id = $request->notabon_ujs_id[$i] ?? '';
                        $kode_nota = $request->kode_nota[$i] ?? '';
                        $nama_drivernota = $request->nama_drivernota[$i] ?? '';
                        $nominal_nota = $request->nominal_nota[$i] ?? '';

                        $data_pembeliansnota->push([
                            'notabon_ujs_id' => $notabon_ujs_id,
                            'kode_nota' => $kode_nota,
                            'nama_drivernota' => $nama_drivernota,
                            'nominal_nota' => $nominal_nota,

                        ]);
                    }
                }

                if ($error_pelanggans || $error_pesanans) {
                    return back()
                        ->withInput()
                        ->with('error_pelanggans', $error_pelanggans)
                        ->with('error_pesanans', $error_pesanans)
                        ->with('data_pembelians', $data_pembelians)
                        ->with('data_pembelians4', $data_pembelians4)
                        ->with('data_pembeliansnota', $data_pembeliansnota);
                }

                // if ($error_pelanggans || $error_pesanans) {
                //     return back()
                //         ->withInput()
                //         ->with('error_pelanggans', $error_pelanggans)
                //         ->with('error_pesanans', $error_pesanans)
                //         ->with('data_pembelians', $data_pembelians);
                // }

                $kendaraan_id = $request->input('kendaraan_id');
                $postedCount = Memo_ekspedisi::where(
                    'kendaraan_id',
                    $kendaraan_id
                )
                    ->where('status', 'rilis')
                    ->count();


                if (
                    $postedCount >= 1
                ) {
                    return back()->with('erorrss', 'DO sebelumnya belum terambil, hubungi driver untuk segera menyelesaikan do');
                }


                $deposit = $request->depositsopir;

                // Check if $deposit is not a numeric value
                if (!is_numeric($deposit)) {
                    return back()->with('erorrss', 'Deposit harus berupa angka');
                }
                if ($validasi_pelanggan->fails()) {
                    $errors = $validasi_pelanggan->errors()->all();
                    return back()->withInput()->with('error', $errors);
                }

                $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);
                $kendaraan->update([
                    'km' => $request->km_awal
                ]);

                $kms = $request->km_awal;

                // Periksa apakah selisih kurang dari 1000 atau lebih tinggi dari km_olimesin
                if (
                    $kms > $kendaraan->km_olimesin - 1000 || $kms > $kendaraan->km_olimesin
                ) {
                    $status_olimesins = "belum penggantian";
                    $kendaraan->status_olimesin = $status_olimesins;
                }

                if (
                    $kms > $kendaraan->km_oligardan - 5000 || $kms > $kendaraan->km_oligardan
                ) {
                    $status_olimesins = "belum penggantian";
                    $kendaraan->status_oligardan = $status_olimesins;
                }

                if (
                    $kms > $kendaraan->km_olitransmisi - 5000 || $kms > $kendaraan->km_olitransmisi
                ) {
                    $status_olimesins = "belum penggantian";
                    $kendaraan->status_olitransmisi = $status_olimesins;
                }

                // Update umur_ban for related ban
                foreach ($kendaraan->ban as $ban) {
                    $ban->update([
                        'umur_ban' => ($kms - $ban->km_pemasangan) + ($ban->jumlah_km ?? 0)
                    ]);
                }

                $kode = $this->kodemb();
                // tgl indo
                $tanggal1 = Carbon::now('Asia/Jakarta');
                $format_tanggal = $tanggal1->format('d F Y');

                $totalrute = str_replace('.', '', $request->totalrute); // Menghilangkan titik dari totalrute
                $totalrute = str_replace(',', '.', $totalrute); // Mengganti koma dengan titik untuk memastikan format angka yang benar

                $pphs = str_replace(',', '.', str_replace('.', '', $request->pphs)); // Menghilangkan titik dan mengganti koma dengan titik pada pphs
                $pphs =  round($pphs); // Mem-bulatkan nilai

                $notabons = str_replace('.', '', $request->nota_bons); // Menghilangkan titik dari biaya tambahan
                $biaya_tambahan = str_replace('.', '', $request->biaya_tambahan); // Menghilangkan titik dari biaya tambahan
                $biaya_tambahan = str_replace(',', '.', $biaya_tambahan); // Mengganti koma dengan titik untuk memastikan format angka yang benar

                $potongan_memos = $request->potongan_memoborong;
                // Jika nilai kosong, setel menjadi 0
                if (empty($potongan_memos)) {
                    $potongan_memos = 0;
                } else {
                    // Menghilangkan titik dan mengganti koma dengan titik pada angka
                    $potongan_memos = str_replace(',', '.', str_replace('.', '', $potongan_memos));
                    $potongan_memos = str_replace(',', '.', $potongan_memos); // Pastikan format angka yang benar
                }

                $hasil_jumlah = ($totalrute - $pphs) / 2 + $biaya_tambahan - $potongan_memos - $notabons;

                $spk_id = $request->spk_id;
                $spk = Spk::where('id', $spk_id)->first();
                $pengambilan_do = Pengambilan_do::where('spk_id', $spk->id)->first(); // Mengambil satu pengambilan_do

                $status_memo = 'rilis';
                if (
                    $pengambilan_do && in_array($pengambilan_do->status, ['unpost', 'posting'])
                ) {
                    $status_memo = 'rilis';
                } else {
                    $status_memo = 'unpost';
                }

                // $uang_jaminan = str_replace('.', '', $request->uang_jaminans); // Menghapus titik
                // $uang_jaminan = str_replace(',', '.', $uang_jaminan); // Mengganti koma menjadi titik
                // $uang_jaminan = round($uang_jaminan); // Membulatkan nilai
                $tanggal = Carbon::now()->format('Y-m-d');
                $cetakpdf = Memo_ekspedisi::create(array_merge(
                    $request->all(),
                    [
                        'kategori' => $request->kategori,
                        'spk_id' => $request->spk_id,
                        'admin' => auth()->user()->karyawan->nama_lengkap,
                        'kendaraan_id' => $request->kendaraan_id,
                        'no_kabin' => $request->no_kabin,
                        'no_pol' => $request->no_pol,
                        'golongan' => $request->golongan,
                        'km_awal' => $request->km_awal,
                        'km_akhir' => $request->km_akhir,
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
                        // 'potongan_memo' => str_replace(',', '.', str_replace('.', '', $request->potongan_memoborong)),
                        'potongan_memo' => $potongan_memos = is_null($request->potongan_memoborong) ? 0 : str_replace('.', '', $request->potongan_memoborong),

                        // 'uang_jaminan' => str_replace('.', '', $request->uang_jaminans),
                        // 'deposit_drivers' => str_replace('.', '', $request->depositsopir),
                        'totals' => str_replace(',', '.', str_replace('.', '', $request->totals)),
                        // 'sub_total' => str_replace('.', '', $request->sub_totalborong),
                        'uang_jaminans' => str_replace(',', '.', str_replace('.', '', $request->uang_jaminans)),
                        'sub_total' => str_replace(',', '.', str_replace('.', '', $request->sub_totalborong)),
                        'keterangan' => $request->keterangan,
                        // 'sisa_saldo' => $request->sisa_saldo,
                        'kode_memo' => $this->kodemb(),
                        'qrcode_memo' => 'https://javaline.id/memo_ekspedisispk/' . $kode,
                        'tanggal' => $format_tanggal,
                        'tanggal_awal' => $tanggal,
                        'rute_perjalanan_id' => $request->rute_id,
                        'kode_rute' => $request->kode_rutes,
                        'nama_rute' => $request->nama_rutes,
                        'harga_rute' => str_replace(',', '.', str_replace('.', '', $request->harga_rute)),
                        'jumlah' => $request->jumlah,
                        'satuan' => $request->satuan,
                        'totalrute' => str_replace(',', '.', str_replace('.', '', $request->totalrute)),
                        'nota_bons' => str_replace(',', '.', str_replace('.', '', $request->nota_bons)),
                        'status' => $status_memo,
                    ]
                ));

                $transaksi_id = $cetakpdf->id;

                if ($cetakpdf) {

                    foreach ($data_pembelians as $data_pesanan) {
                        Detail_tambahan::create([
                            'memo_ekspedisi_id' => $cetakpdf->id,
                            'biaya_tambahan_id' => $data_pesanan['biaya_tambahan_id'],
                            'kode_biaya' => $data_pesanan['kode_biaya'],
                            'nama_biaya' => $data_pesanan['nama_biaya'],
                            'nominal' =>  str_replace(',', '.', str_replace('.', '', $data_pesanan['nominal'])),
                        ]);
                    }
                }

                if ($cetakpdf) {

                    foreach ($data_pembelians4 as $data_pesanan) {
                        Detail_potongan::create([
                            'memo_ekspedisi_id' => $cetakpdf->id,
                            'potongan_memo_id' => $data_pesanan['potongan_memo_id'],
                            'kode_potongan' => $data_pesanan['kode_potongan'],
                            'keterangan_potongan' => $data_pesanan['keterangan_potongan'],
                            'nominal_potongan' =>  str_replace(',', '.', str_replace('.', '', $data_pesanan['nominal_potongan'])),
                        ]);
                    }
                }

                if ($cetakpdf) {

                    foreach ($data_pembeliansnota as $data_pesanan) {
                        $detail = Detail_notabon::create([
                            'memo_ekspedisi_id' => $cetakpdf->id,
                            'notabon_ujs_id' => $data_pesanan['notabon_ujs_id'],
                            'kode_nota' => $data_pesanan['kode_nota'],
                            'nama_drivernota' => $data_pesanan['nama_drivernota'],
                            'nominal_nota' =>  str_replace(',', '.', str_replace(
                                '.',
                                '',
                                $data_pesanan['nominal_nota']
                            )),
                        ]);
                        // $nota = Notabon_ujs::find($detail->notabon_ujs_id);
                        // if ($nota) {
                        //     $nota->update(['status_memo' => 'aktif']);
                        // }
                    }
                }

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

                $spk = Spk::where('id', $request->spk_id)->increment('voucher');
                $detail_nota = Detail_notabon::where('memo_ekspedisi_id', $cetakpdf->id)->get();

                return view('admin.memo_ekspedisispk.show', compact('cetakpdf', 'detail_nota'));

                break;


            case 'Memo Tambahan':

                $validasi_pelanggan = Validator::make(
                    $request->all(),
                    [
                        'kode_tambahan' => 'unique:memotambahans,kode_tambahan',
                        'memo_ekspedisi_id' => 'required',

                    ],
                    [
                        'kode_tambahan.unique' => 'Kode Memo sudah ada',
                        'memo_ekspedisi_id.required' => 'Pilih memo',
                        // 'kode_tambahan.unique' => 'Kode Memo sudah ada',

                    ]
                );


                $error_pelanggans = [];

                if ($validasi_pelanggan->fails()) {
                    $error_pelanggans[] = $validasi_pelanggan->errors()->first('memo_ekspedisi_id');
                }

                $error_pesanans = [];
                $data_pembelians4 = collect();
                $data_pembeliansnotas = collect();
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

                if ($request->has('notabon_ujs_ids') || $request->has('kode_notas') || $request->has('nama_drivernotas') || $request->has('nominal_notas')) {
                    for ($i = 0; $i < count($request->notabon_ujs_ids); $i++) {
                        // Check if either 'keterangan_tambahan' or 'nominal_tambahan' has input
                        if (
                            empty($request->notabon_ujs_ids[$i]) && empty($request->kode_notas[$i]) && empty($request->nama_drivernotas[$i]) && empty($request->nominal_notas[$i])
                        ) {
                            continue; // Skip validation if both are empty
                        }

                        $validasi_produk = Validator::make($request->all(), [
                            'notabon_ujs_ids.' . $i => 'required',
                            'kode_notas.' . $i => 'required',
                            'nama_drivernotas.' . $i => 'required',
                            'nominal_notas.' . $i => 'required',
                        ]);

                        if ($validasi_produk->fails()) {
                            array_push($error_pesanans, "Nota bon nomor " . ($i + 1) . " belum dilengkapi!");
                        }

                        $notabon_ujs_ids = $request->notabon_ujs_ids[$i] ?? '';
                        $kode_notas = $request->kode_notas[$i] ?? '';
                        $nama_drivernotas = $request->nama_drivernotas[$i] ?? '';
                        $nominal_notas = $request->nominal_notas[$i] ?? '';

                        $data_pembeliansnotas->push([
                            'notabon_ujs_ids' => $notabon_ujs_ids,
                            'kode_notas' => $kode_notas,
                            'nama_drivernotas' => $nama_drivernotas,
                            'nominal_notas' => $nominal_notas,

                        ]);
                    }
                }

                if ($error_pelanggans || $error_pesanans) {
                    return back()
                        ->withInput()
                        ->with('error_pelanggans', $error_pelanggans)
                        ->with('error_pesanans', $error_pesanans)
                        ->with('data_pembelians4', $data_pembelians4)
                        ->with('data_pembeliansnotas', $data_pembeliansnotas);
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
                    'nota_bontambahan' => str_replace(',', '.', str_replace('.', '', $request->nota_bontambahan ?? '0')),
                    'grand_total' => str_replace(',', '.', str_replace('.', '', $request->grand_total)),
                    'tanggal' => $format_tanggal,
                    'tanggal_awal' => $tanggal,
                    'status' => 'unpost',
                ]);

                $transaksi_id = $cetakpdf->id;
                $allKeterangan = ''; // Initialize an empty string to accumulate keterangan values
                $kodepengeluaran = $this->kodepengeluaran();

                if ($cetakpdf) {
                    // Ambil nomor terakhir untuk kode_detailakun yang ada di database
                    $lastDetail = Detail_pengeluaran::where('kode_detailakun', 'like', 'KKA%')->orderBy('id', 'desc')->first();
                    $lastNum = 0;
                    // return $lastDetail;
                    $currentMonth = date('m'); // Ambil bulan saat ini

                    // Jika tidak ada kode terakhir atau bulan saat ini berbeda dari bulan kode terakhir
                    if (!$lastDetail || $currentMonth != date('m', strtotime($lastDetail->created_at))) {
                        $lastNum = 0; // Mulai dari 0 jika bulan berbeda
                    } else {
                        // Ambil nomor terakhir dari kode terakhir
                        $lastCode = substr($lastDetail->kode_detailakun, -6);
                        $lastNum = (int)$lastCode; // Ubah menjadi integer
                    }

                    foreach ($data_pembelians4 as $index => $data_pesanan) {

                        $detailMemotambahan = Detail_memotambahan::create([
                            'memotambahan_id' => $cetakpdf->id,
                            'keterangan_tambahan' => $data_pesanan['keterangan_tambahan'],
                            'qty' => $data_pesanan['qty'],
                            'satuans' => $data_pesanan['satuans'],
                            'hargasatuan' => $data_pesanan['hargasatuan'],
                            'nominal_tambahan' =>  str_replace(',', '.', str_replace('.', '', $data_pesanan['nominal_tambahan'])),

                        ]);
                        // Cek apakah bulan berbeda dari kode terakhir
                        if (!$lastDetail || $currentMonth != date('m', strtotime($lastDetail->created_at))) {
                            $lastNum = 0; // Mulai dari 0 jika bulan berbeda atau tidak ada detail terakhir
                        } else {
                            // Ambil nomor terakhir dari kode terakhir
                            $lastCode = substr($lastDetail->kode_detailakun, -6);
                            $lastNum = (int)$lastCode; // Ubah menjadi integer
                        }

                        $num = $lastNum + $index + 1; // Tambahkan index untuk menghasilkan nomor unik
                        $formattedNum = sprintf("%06s", $num);

                        // Awalan untuk kode baru
                        $prefix = 'KKA';
                        $tahun = date('y');
                        $tanggal = date('dm');

                        // Buat kode baru dengan menggabungkan awalan, tanggal, tahun, dan nomor yang diformat
                        $newCode = $prefix . "/" . $tanggal . $tahun . "/" . $formattedNum;
                        // Use the $detailMemotambahan->id in the creation of Detail_pengeluaran
                        $detail_pengeluaran = Detail_pengeluaran::create([
                            'kode_detailakun' => $newCode,
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

                if ($cetakpdf) {

                    foreach ($data_pembeliansnotas as $data_pesanan) {
                        $detail = Detail_notabon::create([
                            'memotambahan_id' => $cetakpdf->id,
                            'notabon_ujs_id' => $data_pesanan['notabon_ujs_ids'],
                            'kode_nota' => $data_pesanan['kode_notas'],
                            'nama_drivernota' => $data_pesanan['nama_drivernotas'],
                            'nominal_nota' =>  str_replace(',', '.', str_replace('.', '', $data_pesanan['nominal_notas'])),
                        ]);
                    }
                }

                $tanggalx = Carbon::now()->format('Y-m-d');
                Pengeluaran_kaskecil::create([
                    'memotambahan_id' => $cetakpdf->id,
                    'user_id' => auth()->user()->id,
                    'kode_pengeluaran' => $this->kodepengeluaran(),
                    'kendaraan_id' => $request->kendaraan_idsa,
                    'keterangan' => $allKeterangan, // Use accumulated keterangan values
                    'grand_total' => str_replace(',', '.', str_replace('.', '', $request->grand_total)),
                    'jam' => $tanggal1->format('H:i:s'),
                    'tanggal' => $format_tanggal,
                    'tanggal_awal' => $tanggalx,
                    'qrcode_return' => 'https://javaline.id/pengeluaran_kaskecil/' . $kodepengeluaran,
                    'status' => 'pending',
                ]);

                $memos = Memo_ekspedisi::where('id', $cetakpdf->memo_ekspedisi_id)->update(['status_memotambahan' => 'digunakan']);
                $detail_memo = Detail_memotambahan::where('memotambahan_id', $cetakpdf->id)->get();

                return view('admin.tablememo.show', compact('cetakpdf', 'detail_memo'));

                break;

            default:
        }
    }


    public function kodejaminan()
    {
        try {
            return DB::transaction(function () {
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
            });
        } catch (\Throwable $e) {
            // Jika terjadi kesalahan, melanjutkan dengan kode berikutnya
            $lastCode = Uangjaminan::latest()->value('kode_jaminan');
            if (!$lastCode) {
                $lastNum = 0;
            } else {
                $lastNum = (int) substr($lastCode, strlen('ADM'));
            }
            $nextNum = $lastNum + 1;
            $formattedNextNum = sprintf("%06s", $nextNum);
            return 'ADM' . $formattedNextNum;
        }
    }

    public function kodeakuns()
    {
        try {
            return DB::transaction(function () {
                // Mengambil kode terbaru dari database dengan awalan 'KKA'
                $lastBarang = Detail_pengeluaran::where('kode_detailakun', 'like', 'KKA%')->latest()->first();

                // Mendapatkan bulan dari tanggal kode terakhir
                $lastMonth = $lastBarang ? date('m', strtotime($lastBarang->created_at)) : null;
                $currentMonth = date('m');

                // Jika tidak ada kode sebelumnya atau bulan saat ini berbeda dari bulan kode terakhir
                if (!$lastBarang || $currentMonth != $lastMonth) {
                    $num = 1; // Mulai dari 1 jika bulan berbeda
                } else {
                    // Jika ada kode sebelumnya, ambil nomor terakhir
                    $lastCode = $lastBarang->kode_detailakun;

                    // Pisahkan kode menjadi bagian-bagian terpisah
                    $parts = explode('/', $lastCode);
                    $lastNum = end($parts); // Ambil bagian terakhir sebagai nomor terakhir
                    $num = (int) $lastNum + 1; // Tambahkan 1 ke nomor terakhir
                }

                // Format nomor dengan leading zeros sebanyak 6 digit
                $formattedNum = sprintf("%06s", $num);

                // Awalan untuk kode baru
                $prefix = 'KKA';
                $tahun = date('y');
                $tanggal = date('dm');

                // Buat kode baru dengan menggabungkan awalan, tanggal, tahun, dan nomor yang diformat
                $newCode = $prefix . "/" . $tanggal . $tahun . "/" . $formattedNum;

                // Kembalikan kode
                return $newCode;
            });
        } catch (\Throwable $e) {
            // Jika terjadi kesalahan, melanjutkan dengan kode berikutnya
            $lastCode = Detail_pengeluaran::where('kode_detailakun', 'like', 'KKA%')->latest()->value('kode_detailakun');
            if (!$lastCode) {
                $lastNum = 0;
            } else {
                $parts = explode('/', $lastCode);
                $lastNum = end($parts);
            }
            $nextNum = (int) $lastNum + 1;
            $formattedNextNum = sprintf("%06s", $nextNum);
            $tahun = date('y');
            $tanggal = date('dm');
            return 'KKA/' . $tanggal . $tahun . "/" . $formattedNextNum;
        }
    }


    public function kodepengeluaran()
    {
        try {
            return DB::transaction(function () {
                // Mengambil kode terbaru dari database dengan awalan 'KK'
                $lastBarang = Pengeluaran_kaskecil::where('kode_pengeluaran', 'like', 'KK%')->latest()->first();

                // Mendapatkan bulan dari tanggal kode terakhir
                $lastMonth = $lastBarang ? date('m', strtotime($lastBarang->created_at)) : null;
                $currentMonth = date('m');

                // Jika tidak ada kode sebelumnya atau bulan saat ini berbeda dari bulan kode terakhir
                if (!$lastBarang || $currentMonth != $lastMonth) {
                    $num = 1; // Mulai dari 1 jika bulan berbeda
                } else {
                    // Jika ada kode sebelumnya, ambil nomor terakhir
                    $lastCode = $lastBarang->kode_pengeluaran;

                    // Pisahkan kode menjadi bagian-bagian terpisah
                    $parts = explode('/', $lastCode);
                    $lastNum = end($parts); // Ambil bagian terakhir sebagai nomor terakhir
                    $num = (int) $lastNum + 1; // Tambahkan 1 ke nomor terakhir
                }

                // Format nomor dengan leading zeros sebanyak 6 digit
                $formattedNum = sprintf("%06s", $num);

                // Awalan untuk kode baru
                $prefix = 'KK';
                $tahun = date('y');
                $tanggal = date('dm');

                // Buat kode baru dengan menggabungkan awalan, tanggal, tahun, dan nomor yang diformat
                $newCode = $prefix . "/" . $tanggal . $tahun . "/" . $formattedNum;

                // Kembalikan kode
                return $newCode;
            });
        } catch (\Throwable $e) {
            // Jika terjadi kesalahan, melanjutkan dengan kode berikutnya
            $lastCode = Pengeluaran_kaskecil::where('kode_pengeluaran', 'like', 'KK%')->latest()->value('kode_pengeluaran');
            if (!$lastCode) {
                $lastNum = 0;
            } else {
                $parts = explode('/', $lastCode);
                $lastNum = end($parts);
            }
            $nextNum = (int) $lastNum + 1;
            $formattedNextNum = sprintf("%06s", $nextNum);
            $tahun = date('y');
            $tanggal = date('dm');
            return 'KK/' . $tanggal . $tahun . "/" . $formattedNextNum;
        }
    }


    public function kode()
    {
        // Mengambil kode terbaru dari database dengan awalan 'MP'
        $lastBarang = Memo_ekspedisi::where('kode_memo', 'like', 'MP%')->latest()->first();

        // Mendapatkan bulan dari tanggal kode terakhir
        $lastMonth = $lastBarang ? date('m', strtotime($lastBarang->created_at)) : null;
        $currentMonth = date('m');

        // Jika tidak ada kode sebelumnya atau bulan saat ini berbeda dari bulan kode terakhir
        if (!$lastBarang || $currentMonth != $lastMonth) {
            $num = 1; // Mulai dari 1 jika bulan berbeda
        } else {
            // Jika ada kode sebelumnya, ambil nomor terakhir
            $lastCode = $lastBarang->kode_memo;

            // Pisahkan kode menjadi bagian-bagian terpisah
            $parts = explode('/', $lastCode);
            $lastNum = end($parts); // Ambil bagian terakhir sebagai nomor terakhir
            $num = (int) $lastNum + 1; // Tambahkan 1 ke nomor terakhir
        }

        // Format nomor dengan leading zeros sebanyak 6 digit
        $formattedNum = sprintf("%03s", $num);

        // Awalan untuk kode baru
        $prefix = 'MP';
        $tahun = date('y');
        $tanggal = date('dm');

        // Buat kode baru dengan menggabungkan awalan, tanggal, tahun, dan nomor yang diformat
        $newCode = $prefix . "/" . $tanggal . $tahun . "/" . $formattedNum;

        // Kembalikan kode
        return $newCode;
    }

    public function kodemb()
    {
        // Mengambil kode terbaru dari database dengan awalan 'MP'
        $lastBarang = Memo_ekspedisi::where('kode_memo', 'like', 'MB%')->latest()->first();

        // Mendapatkan bulan dari tanggal kode terakhir
        $lastMonth = $lastBarang ? date('m', strtotime($lastBarang->created_at)) : null;
        $currentMonth = date('m');

        // Jika tidak ada kode sebelumnya atau bulan saat ini berbeda dari bulan kode terakhir
        if (!$lastBarang || $currentMonth != $lastMonth) {
            $num = 1; // Mulai dari 1 jika bulan berbeda
        } else {
            // Jika ada kode sebelumnya, ambil nomor terakhir
            $lastCode = $lastBarang->kode_memo;

            // Pisahkan kode menjadi bagian-bagian terpisah
            $parts = explode('/', $lastCode);
            $lastNum = end($parts); // Ambil bagian terakhir sebagai nomor terakhir
            $num = (int) $lastNum + 1; // Tambahkan 1 ke nomor terakhir
        }

        // Format nomor dengan leading zeros sebanyak 6 digit
        $formattedNum = sprintf("%03s", $num);

        // Awalan untuk kode baru
        $prefix = 'MB';
        $tahun = date('y');
        $tanggal = date('dm');

        // Buat kode baru dengan menggabungkan awalan, tanggal, tahun, dan nomor yang diformat
        $newCode = $prefix . "/" . $tanggal . $tahun . "/" . $formattedNum;

        // Kembalikan kode
        return $newCode;
    }


    public function kodemt()
    {
        // Mengambil kode terbaru dari database dengan awalan 'MP'
        $lastBarang = Memotambahan::where('kode_tambahan', 'like', 'MT%')->latest()->first();

        // Mendapatkan bulan dari tanggal kode terakhir
        $lastMonth = $lastBarang ? date('m', strtotime($lastBarang->created_at)) : null;
        $currentMonth = date('m');

        // Jika tidak ada kode sebelumnya atau bulan saat ini berbeda dari bulan kode terakhir
        if (!$lastBarang || $currentMonth != $lastMonth) {
            $num = 1; // Mulai dari 1 jika bulan berbeda
        } else {
            // Jika ada kode sebelumnya, ambil nomor terakhir
            $lastCode = $lastBarang->kode_tambahan;

            // Pisahkan kode menjadi bagian-bagian terpisah
            $parts = explode('/', $lastCode);
            $lastNum = end($parts); // Ambil bagian terakhir sebagai nomor terakhir
            $num = (int) $lastNum + 1; // Tambahkan 1 ke nomor terakhir
        }

        // Format nomor dengan leading zeros sebanyak 6 digit
        $formattedNum = sprintf("%03s", $num);

        // Awalan untuk kode baru
        $prefix = 'MT';
        $tahun = date('y');
        $tanggal = date('dm');

        // Buat kode baru dengan menggabungkan awalan, tanggal, tahun, dan nomor yang diformat
        $newCode = $prefix . "/" . $tanggal . $tahun . "/" . $formattedNum;

        // Kembalikan kode
        return $newCode;
    }

    public function show($id)
    {
        $cetakpdf = Memo_ekspedisi::where('id', $id)->first();

        return view('admin.memo_ekspedisispk.show', compact('cetakpdf'));
    }

    // public function cetakpdf($id)
    // {
    //     $cetakpdf = Memo_ekspedisi::where('id', $id)->first();
    //     $detail_memo = Detail_memo::where('memo_ekspedisi_id', $cetakpdf->id)->get();


    //     $pdf = PDF::loadView('admin.memo_ekspedisispk.cetak_pdf', compact('cetakpdf', 'detail_memo'));
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
            $pdf = PDF::loadView('admin.memo_ekspedisispk.cetak_pdf', compact('cetakpdf', 'detail_memo'));
            $pdf->setPaper('letter', 'portrait'); // Set the paper size to portrait letter
            return $pdf->stream('Memo_ekspedisi.pdf');
        }

        // Generate PDF for Memo_ekspedisi
        $pdf = PDF::loadView('admin.memo_ekspedisispk.cetak_pdf', compact('cetakpdf'));
        $pdf->setPaper('letter', 'portrait'); // Set the paper size to portrait letter
        return $pdf->stream('Memo_ekspedisi.pdf');
    }

    public function tambah_spk(Request $request)
    {
        $rules = [
            'kode_spk' => 'unique:spks,kode_spk',
        ];

        // Define base validation messages
        $messages = [
            'kode_spk.unique' => 'Kode spk sudah ada',
        ];

        // Add additional rules if kategori is not 'non memo'
        if ($request->kategori !== 'non memo') {
            $rules['user_id'] = 'required';
            // $rules['rute_perjalanan_id'] = 'required';
            $rules['kendaraan_id'] = 'required';
            // $rules['uang_jalan'] = 'required';

            $messages['user_id.required'] = 'Pilih driver';
            $messages['rute_perjalanan_id.required'] = 'Pilih rute perjalanan';
            $messages['kendaraan_id.required'] = 'Pilih No Kabin';
            $messages['uang_jalan.*'] = 'Uang jalan harus berupa angka atau dalam format Rupiah yang valid';
        }

        // Validate the request
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return back()->withInput()->with('error', $errors);
        }

        $kode = $this->kode();
        // tgl indo
        $tanggal = Carbon::now()->format('Y-m-d');
        $tanggal1 = Carbon::now('Asia/Jakarta');
        $format_tanggal = $tanggal1->format('d F Y');
        $cetakpdf = Spk::create(array_merge(
            $request->all(),
            [
                'admin' => auth()->user()->karyawan->nama_lengkap,
                'kode_spk' => $this->kode(),
                'voucher' => '0',
                'pelanggan_id' => $request->pelanggan_id,
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
                'kode_spk' => $this->kode(),
                'qrcode_spk' => 'https://javaline.id/spk/' . $kode,
                'tanggal' => $format_tanggal,
                'tanggal_awal' => $tanggal,
                'status' => 'posting',
            ]
        ));
        return redirect()->back()->with('success', 'Berhasil menambahkan spk');
    }
}
