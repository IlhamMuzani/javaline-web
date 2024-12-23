<?php

namespace App\Http\Controllers\admin;

use Illuminate\Support\Facades\DB;

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
use App\Models\Deposit_driver;
use App\Models\Detail_faktur;
use App\Models\Detail_memo;
use App\Models\Detail_memotambahan;
use App\Models\Detail_pengeluaran;
use App\Models\Faktur_ekspedisi;
use App\Models\Karyawan;
use App\Models\Kendaraan;
use App\Models\Memo_ekspedisi;
use App\Models\Memotambahan;
use App\Models\Pelanggan;
use App\Models\Penerimaan_kaskecil;
use App\Models\Pengeluaran_kaskecil;
use App\Models\Potongan_memo;
use App\Models\Rute_perjalanan;
use App\Models\Saldo;
use App\Models\Total_ujs;
use App\Models\Uangjaminan;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Egulias\EmailValidator\Result\Reason\DetailedReason;

class InqueryMemoekspedisiController extends Controller
{

    public function index(Request $request)
    {
        Memo_ekspedisi::where('status', 'posting')->update(['status_notif' => true]);

        $kategori = $request->kategori;
        $status = $request->status;
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;

        if ($kategori === 'Memo Tambahan') {
            $inquery = Memotambahan::query();
        } else {
            $inquery = Memo_ekspedisi::query();
        }

        if ($kategori) {
            $inquery->where('kategori', $kategori);
        }

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

        $saldoTerakhir = Saldo::latest()->first();

        if ($kategori === 'Memo Perjalanan') {
            $memoekspedisi = Memo_ekspedisi::get();
            $memoekspedisiJson = json_encode($memoekspedisi);
            return view('admin.inquery_memoekspedisi.index', compact('memoekspedisiJson', 'saldoTerakhir', 'inquery'));
        } elseif ($kategori === 'Memo Borong') {
            return view('admin.inquery_memoborong.index', compact('inquery', 'saldoTerakhir'));
        } elseif ($kategori === 'Memo Tambahan') {
            // Anda harus menyesuaikan ini sesuai dengan tampilan dan data yang diperlukan untuk "Memo Tambahan"
            // Misalnya:
            return view('admin.inquery_memotambahan.index', compact('inquery', 'saldoTerakhir'));
        } else {
            $memoekspedisi = Memo_ekspedisi::get();
            $memoekspedisiJson = json_encode($memoekspedisi);
            // Handle other categories or return a default view
            return view('admin.inquery_memoekspedisi.index', compact('memoekspedisiJson', 'saldoTerakhir', 'inquery'));
        }
    }


    public function edit($id)
    {
        // if (auth()->check() && auth()->user()->menu['inquery perpanjangan stnk']) {

        $inquery = Memo_ekspedisi::where('id', $id)->first();

        $kendaraans = Kendaraan::all();
        $drivers = User::whereHas('karyawan', function ($query) {
            $query->where('departemen_id', '2');
        })->get();
        $ruteperjalanans = Rute_perjalanan::all();
        $biayatambahan = Biaya_tambahan::all();
        $pelanggans = Pelanggan::all();
        $saldoTerakhir = Saldo::latest()->first();
        $potonganmemos = Potongan_memo::all();
        $memos = Memo_ekspedisi::where('status_memo', null)->get();
        return view('admin.inquery_memoekspedisi.update', compact(
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

        // } else {
        //     // tidak memiliki akses
        //     return back()->with('error', array('Anda tidak memiliki akses'));
        // }
    }

    public function cetak_memoekspedisifilter(Request $request)
    {
        $selectedIds = explode(',', $request->input('ids'));

        // Now you can use $selectedIds to retrieve the selected IDs and generate the PDF as needed.

        $memos = Memo_ekspedisi::whereIn('id', $selectedIds)->orderBy('id', 'DESC')->get();

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('admin.inquery_memoekspedisi.cetak_pdffilter', compact('memos'));
        $pdf->setPaper('landscape');

        return $pdf->stream('SelectedMemo.pdf');
    }

    public function cetak_memoekspedisinominalfilter(Request $request)
    {
        $selectedIds = explode(',', $request->input('ids'));

        // Now you can use $selectedIds to retrieve the selected IDs and generate the PDF as needed.

        $memos = Memo_ekspedisi::whereIn('id', $selectedIds)->orderBy('id', 'DESC')->get();

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('admin.inquery_memoekspedisi.cetak_pdffilter', compact('memos'));
        $pdf->setPaper('landscape');

        return $pdf->stream('SelectedMemo.pdf');
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
                'kendaraan_id' => 'required',
                'user_id' => 'required',
                'rute_perjalanan_id' => 'required',
                'deposit_driver' => 'required|numeric',
                'uang_jaminan' => [
                    'required',
                    function ($attribute, $value, $fail) {
                        if ($value == 0) {
                            $fail('Uang jaminan tidak boleh 0.');
                        }
                    },
                ],
                'sub_total' => 'required',
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
                'kategori.required' => 'Pilih kategori',
                'kendaraan_id.required' => 'Pilih no kabin',
                'user_id.required' => 'Pilih driver',
                'rute_perjalanan_id.required' => 'Pilih rute perjalanan',
                'deposit_driver.numeric' => 'Deposit harus berupa angka',
                'uang_jaminan.required' => 'Cek uang jaminan tidak boleh 0',
                'uang_jalan.*' => 'Uang jalan harus berupa angka atau dalam format Rupiah yang valid',
                'sub_total.required' => 'Masukkan total harga',
            ]
        );


        $error_pelanggans = array();

        if ($validasi_pelanggan->fails()) {
            array_push($error_pelanggans, $validasi_pelanggan->errors()->all()[0]);
        }

        $error_pesanans = array();

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

        $cetakpdf = Memo_ekspedisi::findOrFail($id);
        $cetakpdf->update(
            [
                'kategori' => $request->kategori,
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
                'keterangan' => $request->keterangan,
                'hasil_jumlah' => $hasil_jumlah,

                'biaya_id' => $request->biaya_id,
                'kode_biaya' => $request->kode_biaya,
                'nama_biaya' => $request->nama_biaya,
                'nominal' => $request->has('nominal') ? ($request->nominal != 0 ? str_replace('.', '', $request->nominal) : null) : null,

                'potongan_id' => $request->potongan_id,
                'kode_potongan' => $request->kode_potongan,
                'keterangan_potongan' => $request->keterangan_potongan,
                'nominal_potongan' => $request->has('nominal_potongan') ? ($request->nominal_potongan != 0 ? str_replace('.', '', $request->nominal_potongan) : null) : null,
            ]
        );

        $kodepengeluaran = $this->kodepengeluaran();

        $pengeluaran = Pengeluaran_kaskecil::where('memo_ekspedisi_id', $id)->first();
        $pengeluaran->update(
            [
                'kendaraan_id' => $request->kendaraan_id,
                'keterangan' => $request->keterangan,
                // 'grand_total' => str_replace('.', '', $request->uang_jalan),
                'grand_total' => $hasil_jumlah,

            ]
        );

        $detailpengeluaran = Detail_pengeluaran::where('memo_ekspedisi_id', $id)->first();
        $detailpengeluaran->update(
            [
                'keterangan' => $request->keterangan,
                // 'nominal' => str_replace('.', '', $request->uang_jalan),
                'nominal' => $hasil_jumlah,

            ]
        );

        $uangjaminan = Uangjaminan::where('memo_ekspedisi_id', $id)->first();
        $uangjaminan->update(
            [
                'memo_ekspedisi_id' => $cetakpdf->id,

                'nama_sopir' => $request->nama_driver,
                'keterangan' => $request->keterangan,
                'nominal' => str_replace(',', '.', str_replace('.', '', $request->uang_jaminan)),
            ]
        );

        return view('admin.inquery_memoekspedisi.show', compact('cetakpdf'));
    }


    public function kodepengeluaran()
    {
        $item = Pengeluaran_kaskecil::all();
        if ($item->isEmpty()) {
            $num = "000001";
        } else {
            $id = Pengeluaran_kaskecil::getId();
            foreach ($id as $value);
            $idlm = $value->id;
            $idbr = $idlm + 1;
            $num = sprintf("%06s", $idbr);
        }

        $data = 'KK';
        $kode_item = $data . $num;
        return $kode_item;
    }

    public function show($id)
    {
        $cetakpdf = Memo_ekspedisi::where('id', $id)->first();
        return view('admin.inquery_memoekspedisi.show', compact('cetakpdf'));
    }

    public function unpostmemo($id)
    {
        try {
            $item = Memo_ekspedisi::findOrFail($id);
            $user = $item->user;

            $uangJalan = $item->uang_jalan;
            $BiayaTambahan = $item->biaya_tambahan;
            $PotonganMemo = $item->potongan_memo;

            $lastSaldo = Saldo::latest()->first();
            if (!$lastSaldo) {
                return back()->with('error', 'Saldo tidak ditemukan');
            }

            $sisaSaldo = $lastSaldo->sisa_saldo + $uangJalan + $BiayaTambahan - $PotonganMemo;
            Saldo::create([
                'sisa_saldo' => $sisaSaldo,
            ]);

            $UangUJS = $item->uang_jaminan;
            $lastUjs = Total_ujs::latest()->first();
            if (!$lastUjs) {
                return response()->json(['error' => 'Ujs tidak ditemukan']);
            }

            $sisaUjs = $lastUjs->sisa_ujs - $UangUJS;
            $lastUjs->update(['sisa_ujs' => $sisaUjs]);

            $tabungans = $user->karyawan->tabungan;
            $deposits = $user->karyawan->deposit;

            $user->karyawan->update([
                'deposit' => $deposits - $item->deposit_driver,
                'tabungan' => $tabungans - $item->deposit_driver,
            ]);

            Pengeluaran_kaskecil::where('memo_ekspedisi_id', $id)->update([
                'status' => 'pending'
            ]);

            Detail_pengeluaran::where('memo_ekspedisi_id', $id)->update([
                'status' => 'pending'
            ]);

            Uangjaminan::where('memo_ekspedisi_id', $id)->update([
                'status' => 'pending'
            ]);

            $depositdriver = Deposit_driver::where('memo_ekspedisi_id', $id)->first();
            $depositdriver->update([
                'sub_total' => $tabungans - $item->deposit_driver,
                'nominal' => $item->deposit_driver,
                'sisa_saldo' => $tabungans - $item->deposit_driver,
                'status' => 'unpost',
            ]);

            // Update the Memo_ekspedisi status
            $item->update([
                'status' => 'unpost'
            ]);

            return back()->with('success', 'Berhasil');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // return back()->with('error', 'Memo tidak ditemukan');
        }
    }

    public function unpostmemoselesai($id)
    {
        try {
            $item = Memo_ekspedisi::findOrFail($id);
            $uangJalan = $item->uang_jalan;
            $BiayaTambahan = $item->biaya_tambahan;
            $PotonganMemo = $item->potongan_memo;

            $lastSaldo = Saldo::latest()->first();
            if (!$lastSaldo) {
                return back()->with('error', 'Saldo tidak ditemukan');
            }

            $sisaSaldo = $lastSaldo->sisa_saldo + $uangJalan + $BiayaTambahan - $PotonganMemo;
            Saldo::create([
                'sisa_saldo' => $sisaSaldo,
            ]);

            $user = $item->user;
            $karyawan = $user->karyawan;

            $tabungans = $karyawan->tabungan;
            $deposits = $karyawan->deposit;
            $karyawan->update([
                'deposit' => $deposits - $item->deposit_driver,
                'tabungan' => $tabungans - $item->deposit_driver,
            ]);

            Pengeluaran_kaskecil::where('memo_ekspedisi_id', $id)->update([
                'status' => 'pending'
            ]);

            Detail_pengeluaran::where('memo_ekspedisi_id', $id)->update([
                'status' => 'pending'
            ]);

            Uangjaminan::where('memo_ekspedisi_id', $id)->update([
                'status' => 'pending'
            ]);

            $depositdriver = Deposit_driver::where('memo_ekspedisi_id', $id)->first();
            $depositdriver->update([
                'sub_total' => $tabungans - $item->deposit_driver,
                'nominal' => $item->deposit_driver,
                'sisa_saldo' => $tabungans - $item->deposit_driver,
                'status' => 'unpost',
            ]);

            $detail_faktur = Detail_faktur::where('memo_ekspedisi_id', $id)->first();

            if ($detail_faktur) {
                $faktur_id = $detail_faktur->faktur_ekspedisi_id;

                Faktur_ekspedisi::where('id', $faktur_id)->update([
                    'status' => 'unpost'
                ]);

                $item->update([
                    'status' => 'unpost',
                    'status_memo' => null
                ]);

                return back()->with('success', 'Berhasil');
            } else {
                return back()->with('error', 'Detail Faktur not found for the given ID');
            }
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // return back()->with('error', 'Memo tidak ditemukan');
        }
    }


    //  yanng benar
    // public function postingfilter(Request $request)
    // {
    //     $selectedIds = explode(',', $request->input('ids'));

    //     try {
    //         // Initialize total deduction amount
    //         $totalDeduction = 0;

    //         foreach ($selectedIds as $id) {
    //             $item = Memo_ekspedisi::findOrFail($id);

    //             // Pastikan hanya memproses memo ekspedisi dengan status 'unpost'
    //             if ($item->status === 'unpost') {
    //                 // Accumulate total deduction amount
    //                 $totalDeduction += $item->uang_jalan + $item->biaya_tambahan - $item->potongan_memo;
    //             }
    //         }

    //         // Get the last saldo
    //         $lastSaldo = Saldo::latest()->first();

    //         if (!$lastSaldo) {
    //             return back()->with('error', 'Saldo tidak ditemukan');
    //         }

    //         // Check if saldo is sufficient
    //         if ($lastSaldo->sisa_saldo < $totalDeduction) {
    //             return back()->with('error', 'Saldo tidak mencukupi');
    //         }

    //         // Check if total uang jalan request is greater than saldo
    //         $totalUangJalanRequest = array_reduce($selectedIds, function ($carry, $id) {
    //             $item = Memo_ekspedisi::findOrFail($id);
    //             return $carry + $item->uang_jalan;
    //         }, 0);

    //         if ($lastSaldo->sisa_saldo < $totalUangJalanRequest) {
    //             return back()->with('error', 'Total request uang jalan melebihi saldo terakhir');
    //         }

    //         // Deduct the total amount from saldo
    //         $sisaSaldo = $lastSaldo->sisa_saldo - $totalDeduction;

    //         // Update saldo
    //         Saldo::create([
    //             'sisa_saldo' => $sisaSaldo,
    //         ]);

    //         // Update transactions and memo statuses
    //         foreach ($selectedIds as $id) {
    //             $item = Memo_ekspedisi::findOrFail($id);

    //             if ($item->status === 'unpost') {
    //                 $user = $item->user;

    //                 $uangJalan = $item->uang_jalan;
    //                 $BiayaTambahan = $item->biaya_tambahan;
    //                 $PotonganMemo = $item->potongan_memo;

    //                 $karyawan = $user->karyawan;

    //                 $tabungans = $karyawan->tabungan;
    //                 $deposits = $karyawan->deposit;
    //                 $karyawan->update([
    //                     'deposit' => $deposits + $item->deposit_driver,
    //                     'tabungan' => $tabungans + $item->deposit_driver,
    //                 ]);

    //                 Pengeluaran_kaskecil::where('memo_ekspedisi_id', $id)->update([
    //                     'status' => 'posting'
    //                 ]);

    //                 Detail_pengeluaran::where('memo_ekspedisi_id', $id)->update([
    //                     'status' => 'posting'
    //                 ]);

    //                 $tanggal1 = Carbon::now('Asia/Jakarta');
    //                 $format_tanggal = $tanggal1->format('d F Y');
    //                 $kodedeposit = $this->kodedeposit();
    //                 $tanggal = Carbon::now()->format('Y-m-d');
    //                 $depositDriverRecord = Deposit_driver::where('memo_ekspedisi_id', $item->id)->first();

    //                 if ($depositDriverRecord) {
    //                     // Jika record sudah ada, lakukan update
    //                     $depositDriverRecord->update([
    //                         'sub_total' => $tabungans + $item->deposit_driver,
    //                         'nominal' => $item->deposit_driver,
    //                         'sisa_saldo' => $tabungans + $item->deposit_driver,
    //                         'status' => 'unpost',
    //                     ]);
    //                 } else {
    //                     // Jika record belum ada, lakukan create
    //                     Deposit_driver::create([
    //                         'kode_deposit' => $this->kodedeposit(),
    //                         'kategori' => 'Pemasukan Deposit',
    //                         'memo_ekspedisi_id' => $item->id,
    //                         'nama_sopir' => $item->nama_driver,
    //                         'sub_total' => $tabungans + $item->deposit_driver,
    //                         'nominal' => $item->deposit_driver,
    //                         'saldo_masuk' => $item->deposit_driver,
    //                         'keterangan' => "Deposit Memo",
    //                         'sisa_saldo' => $tabungans + $item->deposit_driver,
    //                         'tanggal' => $format_tanggal,
    //                         'tanggal_awal' => $tanggal,
    //                         'status' => 'posting',
    //                     ]);
    //                 }

    //                 // Update the Memo_ekspedisi status
    //                 $item->update([
    //                     'status' => 'posting'
    //                 ]);
    //             }
    //         }

    //         return back()->with('success', 'Berhasil memposting memo yang dipilih');
    //     } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
    //         return back()->with('error', 'Terdapat memo yang tidak ditemukan');
    //     }
    // }
    //  sudah sedkit benar untuk filteran memo yang sudah ada masih salah di pemotongan saldo 
    // public function postingfilter(Request $request)
    // {
    //     $selectedIds = explode(',', $request->input('ids'));

    //     try {
    //         // Initialize total deduction amount
    //         $totalDeduction = 0;

    //         foreach ($selectedIds as $id) {
    //             // Check if the driver has already three or more posted memos
    //             $driverName = Memo_ekspedisi::findOrFail($id)->nama_driver;
    //             $postedCount = Memo_ekspedisi::where('nama_driver', $driverName)
    //                 ->where('status', 'posting')
    //                 ->count();

    //             // If the driver has three or more posted memos, skip this memo
    //             if ($postedCount >= 3) {
    //                 continue;
    //             }

    //             $item = Memo_ekspedisi::findOrFail($id);

    //             // Pastikan hanya memproses memo ekspedisi dengan status 'unpost'
    //             if ($item->status === 'unpost') {
    //                 // Accumulate total deduction amount
    //                 $totalDeduction += $item->uang_jalan + $item->biaya_tambahan - $item->potongan_memo;
    //             }
    //         }

    //         // Get the last saldo
    //         $lastSaldo = Saldo::latest()->first();

    //         if (!$lastSaldo) {
    //             return back()->with('error', 'Saldo tidak ditemukan');
    //         }

    //         // Check if saldo is sufficient
    //         if ($lastSaldo->sisa_saldo < $totalDeduction) {
    //             return back()->with('error', 'Saldo tidak mencukupi');
    //         }

    //         // Check if total uang jalan request is greater than saldo
    //         $totalUangJalanRequest = array_reduce($selectedIds, function ($carry, $id) {
    //             $item = Memo_ekspedisi::findOrFail($id);
    //             return $carry + $item->uang_jalan;
    //         }, 0);

    //         if ($lastSaldo->sisa_saldo < $totalUangJalanRequest) {
    //             return back()->with('error', 'Total request uang jalan melebihi saldo terakhir');
    //         }

    //         // Update transactions and memo statuses
    //         foreach ($selectedIds as $id) {
    //             $item = Memo_ekspedisi::findOrFail($id);

    //             // Hitung jumlah memo ekspedisi yang telah diposting dengan nama driver yang sama
    //             $postedCount = Memo_ekspedisi::where('nama_driver', $item->nama_driver)
    //                 ->where('status', 'posting')
    //                 ->count();

    //             // Jika jumlahnya sudah mencapai atau melebihi 3 dan memo ekspedisi ini belum diposting, lewati memo ekspedisi ini
    //             if ($postedCount >= 3 && $item->status !== 'posting') {
    //                 continue;
    //             }

    //             if ($item->status === 'unpost') {
    //                 $user = $item->user;

    //                 $uangJalan = $item->uang_jalan;
    //                 $BiayaTambahan = $item->biaya_tambahan;
    //                 $PotonganMemo = $item->potongan_memo;

    //                 $karyawan = $user->karyawan;

    //                 $tabungans = $karyawan->tabungan;
    //                 $deposits = $karyawan->deposit;
    //                 $karyawan->update([
    //                     'deposit' => $deposits + $item->deposit_driver,
    //                     'tabungan' => $tabungans + $item->deposit_driver,
    //                 ]);

    //                 Pengeluaran_kaskecil::where('memo_ekspedisi_id', $id)->update([
    //                     'status' => 'posting'
    //                 ]);

    //                 Detail_pengeluaran::where('memo_ekspedisi_id', $id)->update([
    //                     'status' => 'posting'
    //                 ]);

    //                 $tanggal1 = Carbon::now('Asia/Jakarta');
    //                 $format_tanggal = $tanggal1->format('d F Y');
    //                 $kodedeposit = $this->kodedeposit();
    //                 $tanggal = Carbon::now()->format('Y-m-d');
    //                 $depositDriverRecord = Deposit_driver::where('memo_ekspedisi_id', $item->id)->first();

    //                 if ($depositDriverRecord) {
    //                     // Jika record sudah ada, lakukan update
    //                     $depositDriverRecord->update([
    //                         'sub_total' => $tabungans + $item->deposit_driver,
    //                         'nominal' => $item->deposit_driver,
    //                         'sisa_saldo' => $tabungans + $item->deposit_driver,
    //                         'status' => 'unpost',
    //                     ]);
    //                 } else {
    //                     // Jika record belum ada, lakukan create
    //                     Deposit_driver::create([
    //                         'kode_deposit' => $this->kodedeposit(),
    //                         'kategori' => 'Pemasukan Deposit',
    //                         'memo_ekspedisi_id' => $item->id,
    //                         'nama_sopir' => $item->nama_driver,
    //                         'sub_total' => $tabungans + $item->deposit_driver,
    //                         'nominal' => $item->deposit_driver,
    //                         'saldo_masuk' => $item->deposit_driver,
    //                         'keterangan' => "Deposit Memo",
    //                         'sisa_saldo' => $tabungans + $item->deposit_driver,
    //                         'tanggal' => $format_tanggal,
    //                         'tanggal_awal' => $tanggal,
    //                         'status' => 'posting',
    //                     ]);
    //                 }

    //                 // Update the Memo_ekspedisi status
    //                 $item->update([
    //                     'status' => 'posting'
    //                 ]);
    //             }
    //         }

    //         return back()->with('success', 'Berhasil memposting memo yang dipilih');
    //     } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
    //         return back()->with('error', 'Terdapat memo yang tidak ditemukan');
    //     }
    // }

    // bener cek lagi 
    public function postingfilter(Request $request)
    {
        $selectedIds = explode(',', $request->input('ids'));

        try {
            // Initialize total deduction amount
            $totalDeduction = 0;
            $totalDeductionujs = 0;

            foreach ($selectedIds as $id) {
                // Check if the driver has already three or more posted memos
                $driverName = Memo_ekspedisi::findOrFail($id)->nama_driver;
                $postedCount = Memo_ekspedisi::where('nama_driver', $driverName)
                    ->where('status', 'posting')
                    ->count();

                // If the driver has three or more posted memos, skip this memo
                if ($postedCount >= 3) {
                    continue;
                }

                $item = Memo_ekspedisi::findOrFail($id);

                // Pastikan hanya memproses memo ekspedisi dengan status 'unpost'
                if ($item->status === 'unpost' && $item->kategori === 'Memo Perjalanan') {
                    // Accumulate total deduction amount
                    $totalDeduction += $item->uang_jalan + $item->biaya_tambahan - $item->potongan_memo;
                    $totalDeductionujs += $item->uang_jaminan;
                }
            }

            // Get the last saldo
            $lastSaldo = Saldo::latest()->first();
            $lastUjs = Total_ujs::latest()->first();

            if (!$lastSaldo) {
                return back()->with('error', 'Saldo tidak ditemukan');
            }

            // Check if saldo is sufficient
            if ($lastSaldo->sisa_saldo < $totalDeduction) {
                return back()->with('error', 'Saldo tidak mencukupi');
            }

            // Check if total uang jalan request is greater than saldo
            $totalUangJalanRequest = array_reduce($selectedIds, function ($carry, $id) {
                $item = Memo_ekspedisi::findOrFail($id);
                return $carry + $item->uang_jalan;
            }, 0);

            if ($lastSaldo->sisa_saldo < $totalUangJalanRequest) {
                return back()->with('error', 'Total request uang jalan melebihi saldo terakhir');
            }

            // Update transactions and memo statuses
            foreach ($selectedIds as $id) {
                $item = Memo_ekspedisi::findOrFail($id);

                // Hitung jumlah memo ekspedisi yang telah diposting dengan nama driver yang sama
                $postedCount = Memo_ekspedisi::where('nama_driver', $item->nama_driver)
                    ->where('status', 'posting')
                    ->count();

                // Jika jumlahnya sudah mencapai atau melebihi 3 dan memo ekspedisi ini belum diposting, lewati memo ekspedisi ini
                if ($postedCount >= 3 && $item->status !== 'posting') {
                    continue;
                }

                if ($item->status === 'unpost' && $item->kategori === 'Memo Perjalanan') {
                    $user = $item->user;

                    $uangJalan = $item->uang_jalan;
                    $BiayaTambahan = $item->biaya_tambahan;
                    $PotonganMemo = $item->potongan_memo;

                    $karyawan = $user->karyawan;

                    $tabungans = $karyawan->tabungan;
                    $deposits = $karyawan->deposit;
                    $karyawan->update([
                        'deposit' => $deposits + $item->deposit_driver,
                        'tabungan' => $tabungans + $item->deposit_driver,
                    ]);

                    Pengeluaran_kaskecil::where('memo_ekspedisi_id', $id)->update([
                        'status' => 'posting'
                    ]);

                    Detail_pengeluaran::where('memo_ekspedisi_id', $id)->update([
                        'status' => 'posting'
                    ]);

                    Uangjaminan::where('memo_ekspedisi_id', $id)->update([
                        'status' => 'posting'
                    ]);

                    $tanggal1 = Carbon::now('Asia/Jakarta');
                    $format_tanggal = $tanggal1->format('d F Y');
                    $kodedeposit = $this->kodedeposit();
                    $tanggal = Carbon::now()->format('Y-m-d');
                    $depositDriverRecord = Deposit_driver::where('memo_ekspedisi_id', $item->id)->first();

                    if ($depositDriverRecord) {
                        // Jika record sudah ada, lakukan update
                        $depositDriverRecord->update([
                            'sub_total' => $tabungans + $item->deposit_driver,
                            'nominal' => $item->deposit_driver,
                            'sisa_saldo' => $tabungans + $item->deposit_driver,
                            'status' => 'posting',
                        ]);
                    } else {
                        // Jika record belum ada, lakukan create
                        Deposit_driver::create([
                            'kode_deposit' => $this->kodedeposit(),
                            'kategori' => 'Pemasukan Deposit',
                            'memo_ekspedisi_id' => $item->id,
                            'nama_sopir' => $item->nama_driver,
                            'sub_total' => $tabungans + $item->deposit_driver,
                            'nominal' => $item->deposit_driver,
                            'saldo_masuk' => $item->deposit_driver,
                            'keterangan' => "Deposit Memo",
                            'sisa_saldo' => $tabungans + $item->deposit_driver,
                            'tanggal' => $format_tanggal,
                            'tanggal_awal' => $tanggal,
                            'status' => 'posting',
                        ]);
                    }

                    // Update the Memo_ekspedisi status
                    $item->update([
                        'status' => 'posting'
                    ]);

                    // Update saldo deduction based on successfully posted memo
                    $lastSaldo->update([
                        'sisa_saldo' => $lastSaldo->sisa_saldo - ($item->uang_jalan + $item->biaya_tambahan - $item->potongan_memo)
                    ]);

                    $lastUjs->update([
                        'sisa_ujs' => $lastUjs->sisa_ujs + ($item->uang_jaminan)
                    ]);
                }
            }

            return back()->with('success', 'Berhasil memposting memo yang dipilih');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return back()->with('error', 'Terdapat memo yang tidak ditemukan');
        }
    }




    // public function postingfilter(Request $request)
    // {
    //     $selectedIds = explode(',', $request->input('ids'));

    //     try {
    //         // Initialize total deduction amount
    //         $totalDeduction = 0;

    //         // Initialize array to store counts of entries with same driver name and status posting
    //         $driverCounts = [];

    //         foreach ($selectedIds as $id) {
    //             $item = Memo_ekspedisi::findOrFail($id);

    //             // Pastikan hanya memproses memo ekspedisi dengan status 'unpost'
    //             if ($item->status === 'unpost') {
    //                 // Menghitung jumlah data dengan nama sopir yang sama yang sudah diposting dengan status posting
    //                 $driverCounts[$item->nama_driver] = ($driverCounts[$item->nama_driver] ?? 0) + ($item->status === 'posting' ? 1 : 0);

    //                 // Memeriksa apakah sopir dengan nama yang sama sudah memiliki tiga entri yang diposting
    //                 if ($driverCounts[$item->nama_driver] > 3) {
    //                     return back()->with('error', 'Hanya maksimal 3 entri dengan nama sopir yang sama yang dapat diposting.');
    //                 }

    //                 // Accumulate total deduction amount
    //                 $totalDeduction += $item->uang_jalan + $item->biaya_tambahan - $item->potongan_memo;
    //             }
    //         }

    //         // Get the last saldo
    //         $lastSaldo = Saldo::latest()->first();

    //         if (!$lastSaldo) {
    //             return back()->with('error', 'Saldo tidak ditemukan');
    //         }

    //         // Check if saldo is sufficient for total deduction
    //         if ($lastSaldo->sisa_saldo < $totalDeduction) {
    //             return back()->with('error', 'Saldo tidak mencukupi');
    //         }

    //         // Deduct the total amount from saldo
    //         $sisaSaldo = $lastSaldo->sisa_saldo - $totalDeduction;

    //         // Update saldo
    //         $lastSaldo->update([
    //             'sisa_saldo' => $sisaSaldo,
    //         ]);

    //         // Update transactions and memo statuses
    //         foreach ($selectedIds as $id) {
    //             $item = Memo_ekspedisi::findOrFail($id);

    //             if ($item->status === 'unpost') {
    //                 $user = $item->user;

    //                 $uangJalan = $item->uang_jalan;
    //                 $BiayaTambahan = $item->biaya_tambahan;
    //                 $PotonganMemo = $item->potongan_memo;

    //                 $karyawan = $user->karyawan;

    //                 $tabungans = $karyawan->tabungan;
    //                 $deposits = $karyawan->deposit;
    //                 $karyawan->update([
    //                     'deposit' => $deposits + $item->deposit_driver,
    //                     'tabungan' => $tabungans + $item->deposit_driver,
    //                 ]);

    //                 Pengeluaran_kaskecil::where('memo_ekspedisi_id', $id)->update([
    //                     'status' => 'posting'
    //                 ]);

    //                 Detail_pengeluaran::where('memo_ekspedisi_id', $id)->update([
    //                     'status' => 'posting'
    //                 ]);

    //                 $tanggal1 = Carbon::now('Asia/Jakarta');
    //                 $format_tanggal = $tanggal1->format('d F Y');
    //                 $kodedeposit = $this->kodedeposit();
    //                 $tanggal = Carbon::now()->format('Y-m-d');
    //                 $depositDriverRecord = Deposit_driver::where('memo_ekspedisi_id', $item->id)->first();

    //                 if ($depositDriverRecord) {
    //                     // Jika record sudah ada, lakukan update
    //                     $depositDriverRecord->update([
    //                         'sub_total' => $tabungans + $item->deposit_driver,
    //                         'nominal' => $item->deposit_driver,
    //                         'sisa_saldo' => $tabungans + $item->deposit_driver,
    //                         'status' => 'unpost',
    //                     ]);
    //                 } else {
    //                     // Jika record belum ada, lakukan create
    //                     Deposit_driver::create([
    //                         'kode_deposit' => $this->kodedeposit(),
    //                         'kategori' => 'Pemasukan Deposit',
    //                         'memo_ekspedisi_id' => $item->id,
    //                         'nama_sopir' => $item->nama_driver,
    //                         'sub_total' => $tabungans + $item->deposit_driver,
    //                         'nominal' => $item->deposit_driver,
    //                         'saldo_masuk' => $item->deposit_driver,
    //                         'keterangan' => "Deposit Memo",
    //                         'sisa_saldo' => $tabungans + $item->deposit_driver,
    //                         'tanggal' => $format_tanggal,
    //                         'tanggal_awal' => $tanggal,
    //                         'status' => 'posting',
    //                     ]);
    //                 }

    //                 // Update the Memo_ekspedisi status
    //                 $item->update([
    //                     'status' => 'posting'
    //                 ]);
    //             }
    //         }

    //         return back()->with('success', 'Berhasil memposting memo yang dipilih');
    //     } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
    //         return back()->with('error', 'Terdapat memo yang tidak ditemukan');
    //     }
    // }



    public function unpostfilter(Request $request)
    {
        $selectedIds = explode(',', $request->input('ids'));

        try {
            // Initialize total restoration amount
            $totalRestoration = 0;
            $totalRestorationUJS = 0;

            foreach ($selectedIds as $id) {
                $item = Memo_ekspedisi::findOrFail($id);

                // Ensure only memos with status 'posting' are processed
                if ($item->status === 'posting') {
                    // Accumulate total restoration amount
                    $totalRestoration += $item->uang_jalan + $item->biaya_tambahan - $item->potongan_memo;
                    $totalRestorationUJS += $item->uang_jaminan;
                }
            }

            // Get the last saldo
            $lastSaldo = Saldo::latest()->first();
            $lastUJS = Total_ujs::latest()->first();

            if (!$lastSaldo) {
                return back()->with('error', 'Saldo tidak ditemukan');
            }

            // Add the total restoration amount back to saldo
            $sisaSaldo = $lastSaldo->sisa_saldo + $totalRestoration;
            $sisaUJS = $lastUJS->sisa_ujs - $totalRestorationUJS;

            // Update saldo
            Saldo::create([
                'sisa_saldo' => $sisaSaldo,
            ]);

            Total_ujs::create([
                'sisa_ujs' => $sisaUJS,
            ]);

            // Update transactions and memo statuses
            foreach ($selectedIds as $id) {
                $item = Memo_ekspedisi::findOrFail($id);

                if ($item->status === 'posting') {
                    // Perform restoration of tabungan and deposit
                    $user = $item->user;
                    $tabungans = $user->karyawan->tabungan;
                    $deposits = $user->karyawan->deposit;

                    $user->karyawan->update([
                        'deposit' => $deposits - $item->deposit_driver,
                        'tabungan' => $tabungans - $item->deposit_driver,
                    ]);

                    // Restore status of related transactions
                    Pengeluaran_kaskecil::where('memo_ekspedisi_id', $id)->update([
                        'status' => 'pending'
                    ]);

                    Detail_pengeluaran::where('memo_ekspedisi_id', $id)->update([
                        'status' => 'pending'
                    ]);

                    Uangjaminan::where('memo_ekspedisi_id', $id)->update([
                        'status' => 'pending'
                    ]);

                    // Restore status of deposit driver
                    $depositDriverRecord = Deposit_driver::where('memo_ekspedisi_id', $item->id)->first();

                    if ($depositDriverRecord) {
                        $depositDriverRecord->update([
                            'status' => 'unpost',
                        ]);
                    }

                    // Update the Memo_ekspedisi status
                    $item->update([
                        'status' => 'unpost'
                    ]);
                }
            }

            return back()->with('success', 'Berhasil membatalkan posting memo yang dipilih');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return back()->with('error', 'Terdapat memo yang tidak ditemukan');
        }
    }

    // public function postingmemo($id)
    // {
    //     try {
    //         $item = Memo_ekspedisi::findOrFail($id);
    //         $user = $item->user;

    //         $uangJalan = $item->uang_jalan;
    //         $BiayaTambahan = $item->biaya_tambahan;
    //         $PotonganMemo = $item->potongan_memo;

    //         $lastSaldo = Saldo::latest()->first();
    //         if (!$lastSaldo) {
    //             return back()->with('error', 'Saldo tidak ditemukan');
    //         }
    //         $uangjalan = $item->uang_jalan;
    //         if ($lastSaldo->sisa_saldo < $uangjalan) {
    //             return back()->with('error', 'Saldo tidak mencukupi');
    //         }

    //         $sisaSaldo = $lastSaldo->sisa_saldo - $uangJalan - $BiayaTambahan + $PotonganMemo;
    //         Saldo::create([
    //             'sisa_saldo' => $sisaSaldo,
    //         ]);

    //         $karyawan = $user->karyawan;

    //         $tabungans = $karyawan->tabungan;
    //         $deposits = $karyawan->deposit;
    //         $karyawan->update([
    //             'deposit' => $deposits + $item->deposit_driver,
    //             'tabungan' => $tabungans + $item->deposit_driver,
    //         ]);


    //         Pengeluaran_kaskecil::where('memo_ekspedisi_id', $id)->update([
    //             'status' => 'posting'
    //         ]);

    //         Detail_pengeluaran::where('memo_ekspedisi_id', $id)->update([
    //             'status' => 'posting'
    //         ]);

    //         $tanggal1 = Carbon::now('Asia/Jakarta');
    //         $format_tanggal = $tanggal1->format('d F Y');
    //         $kodedeposit = $this->kodedeposit();
    //         $tanggal = Carbon::now()->format('Y-m-d');
    //         $depositDriverRecord = Deposit_driver::where('memo_ekspedisi_id', $item->id)->first();

    //         if ($depositDriverRecord) {
    //             // Jika record sudah ada, lakukan update
    //             $depositDriverRecord->update([
    //                 'sub_total' => $tabungans + $item->deposit_driver,
    //                 'nominal' => $item->deposit_driver,
    //                 'sisa_saldo' => $tabungans + $item->deposit_driver,
    //                 'status' => 'unpost',
    //             ]);
    //         } else {
    //             // Jika record belum ada, lakukan create
    //             Deposit_driver::create([
    //                 'kode_deposit' => $this->kodedeposit(),
    //                 'kategori' => 'Pemasukan Deposit',
    //                 'memo_ekspedisi_id' => $item->id,
    //                 'nama_sopir' => $item->nama_driver,
    //                 'sub_total' => $tabungans + $item->deposit_driver,
    //                 'nominal' => $item->deposit_driver,
    //                 'saldo_masuk' => $item->deposit_driver,
    //                 'keterangan' => "Deposit Memo",
    //                 'sisa_saldo' => $tabungans + $item->deposit_driver,
    //                 'tanggal' => $format_tanggal,
    //                 'tanggal_awal' => $tanggal,
    //                 'status' => 'posting',
    //             ]);
    //         }

    //         // Update the Memo_ekspedisi status
    //         $item->update([
    //             'status' => 'posting'
    //         ]);

    //         return back()->with('success', 'Berhasil');
    //     } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
    //         // return back()->with('error', 'Memo tidak ditemukan');
    //     }
    // }

    public function postingmemo($id)
    {
        try {
            $item = Memo_ekspedisi::findOrFail($id);
            $user = $item->user;

            // Hitung jumlah memo ekspedisi yang telah diposting dengan nama driver yang sama
            $postedCount = Memo_ekspedisi::where('nama_driver', $item->nama_driver)
                ->where('status', 'posting')
                ->count();

            // Jika jumlahnya sudah mencapai atau melebihi 3, lewati memo ekspedisi ini
            if ($postedCount >= 3) {
                return response()->json(['error' => 'Memo Perjalanan telah mencapai batas maksimal']);
            }

            $uangJalan = $item->uang_jalan;
            $BiayaTambahan = $item->biaya_tambahan;
            $PotonganMemo = $item->potongan_memo;

            $lastSaldo = Saldo::latest()->first();
            if (!$lastSaldo) {
                return response()->json(['error' => 'Saldo tidak ditemukan']);
            }

            if ($lastSaldo->sisa_saldo < $uangJalan) {
                return response()->json(['error' => 'Saldo tidak mencukupi']);
            }

            $UangUJS = $item->uang_jaminan;
            $lastUjs = Total_ujs::latest()->first();
            if (!$lastUjs) {
                return response()->json(['error' => 'Ujs tidak ditemukan']);
            }

            $sisaUjs = $lastUjs->sisa_ujs + $UangUJS;
            $lastUjs->update(['sisa_ujs' => $sisaUjs]);

            // Hitung sisa saldo setelah dipotong
            $sisaSaldo = $lastSaldo->sisa_saldo - $uangJalan - $BiayaTambahan + $PotonganMemo;
            // Update saldo
            $lastSaldo->update(['sisa_saldo' => $sisaSaldo]);

            // Update informasi karyawan
            $karyawan = $user->karyawan;
            $tabungans = $karyawan->tabungan;
            $deposits = $karyawan->deposit;
            $karyawan->update([
                'deposit' => $deposits + $item->deposit_driver,
                'tabungan' => $tabungans + $item->deposit_driver,
            ]);

            // Update status pengeluaran
            Pengeluaran_kaskecil::where('memo_ekspedisi_id', $id)->update(['status' => 'posting']);
            Detail_pengeluaran::where('memo_ekspedisi_id', $id)->update(['status' => 'posting']);

            Uangjaminan::where('memo_ekspedisi_id', $id)->update([
                'status' => 'posting'
            ]);
            // Tambahkan atau perbarui record deposit driver
            $tanggal1 = Carbon::now('Asia/Jakarta');
            $format_tanggal = $tanggal1->format('d F Y');
            $tanggal = Carbon::now()->format('Y-m-d');
            $depositDriverRecord = Deposit_driver::where('memo_ekspedisi_id', $item->id)->first();

            if ($depositDriverRecord) {
                // Jika record sudah ada, lakukan update
                $depositDriverRecord->update([
                    'sub_total' => $tabungans + $item->deposit_driver,
                    'nominal' => $item->deposit_driver,
                    'sisa_saldo' => $tabungans + $item->deposit_driver,
                    'status' => 'unpost',
                ]);
            } else {
                // Jika record belum ada, lakukan create
                Deposit_driver::create([
                    'kode_deposit' => $this->kodedeposit(),
                    'kategori' => 'Pemasukan Deposit',
                    'memo_ekspedisi_id' => $item->id,
                    'nama_sopir' => $item->nama_driver,
                    'sub_total' => $tabungans + $item->deposit_driver,
                    'nominal' => $item->deposit_driver,
                    'saldo_masuk' => $item->deposit_driver,
                    'keterangan' => "Deposit Memo",
                    'sisa_saldo' => $tabungans + $item->deposit_driver,
                    'tanggal' => $format_tanggal,
                    'tanggal_awal' => $tanggal,
                    'status' => 'posting',
                ]);
            }

            // Update status Memo_ekspedisi
            $item->update(['status' => 'posting']);

            return response()->json(['success' => 'Berhasil memposting memo']);
            // return back()->with('success', 'Berhasil');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Gagal memposting memo: Memo tidak ditemukan']);
        }
    }


    public function hapusmemo($id)
    {
        $memo = Memo_ekspedisi::where('id', $id)->first();
        $memo->deposit_driver()->delete();
        $memo->pengeluaran_kaskecil()->delete();
        $memo->detail_pengeluaran()->delete();
        $memo->uangjaminan()->delete();
        $memo->delete();
        return back()->with('success', 'Berhasil');
    }

    public function kodedeposit()
    {
        $penerimaan = Deposit_driver::all();
        if ($penerimaan->isEmpty()) {
            $num = "000001";
        } else {
            $id = Deposit_driver::getId();
            foreach ($id as $value);
            $idlm = $value->id;
            $idbr = $idlm + 1;
            $num = sprintf("%06s", $idbr);
        }

        $data = 'FD';
        $kode_penerimaan = $data . $num;
        return $kode_penerimaan;
    }
}