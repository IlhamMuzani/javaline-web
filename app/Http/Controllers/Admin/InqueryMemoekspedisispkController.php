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
use App\Models\Detail_potongan;
use App\Models\Detail_tambahan;
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
use App\Models\Spk;
use App\Models\Total_ujs;
use App\Models\Uangjaminan;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Egulias\EmailValidator\Result\Reason\DetailedReason;

class InqueryMemoekspedisispkController extends Controller
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
            $inquery = Memo_ekspedisi::where('kategori', 'Memo Perjalanan');

            // Filter berdasarkan tanggal
            $inquery->whereDate('tanggal_awal', Carbon::today());

            // Urutkan data berdasarkan id secara descending
            $inquery->orderBy('id', 'DESC');

            // Ambil hasil query
            $inquery = $inquery->get();

            // Encode hasil query ke dalam format JSON
            $memoekspedisiJson = json_encode($inquery);

            // Kembalikan tampilan dengan hasil query dan saldo terakhir
            return view('admin.inquery_memoekspedisi.index', compact('memoekspedisiJson', 'saldoTerakhir', 'inquery'));
        }
    }



    public function search(Request $request)
    {
        $keyword = $request->input('keyword');

        // Lakukan pencarian dengan menggunakan whereHas di model User
        $users = User::whereHas('karyawan', function ($query) use ($keyword) {
            $query->where('departemen_id', '2')
                ->where('nama_lengkap', 'like', "%$keyword%");
        })
            ->with('karyawan.departemen') // Load relasi karyawan dan departemen
            ->paginate(10);

        // Mengembalikan respons JSON dengan data hasil pencarian
        return response()->json($users);
    }

    public function edit($id)
    {
        // if (auth()->check() && auth()->user()->menu['inquery perpanjangan stnk']) {

        $inquery = Memo_ekspedisi::where('id', $id)->first();

        $spks = Spk::where(
            'voucher',
            '<',
            2
        )
            ->where(function ($query) {
                $query->where('status_spk', '!=', 'faktur')
                    ->where('status_spk', '!=', 'invoice')
                    ->where('status_spk', '!=', 'pelunasan')
                    ->orWhereNull('status_spk');
            })
            ->orderBy('created_at', 'desc') // Change 'created_at' to the appropriate timestamp column
            ->get();

        $kendaraans = Kendaraan::all();
        $drivers = User::whereHas('karyawan', function ($query) {
            $query->where('departemen_id', '2');
        })->get();
        $ruteperjalanans = Rute_perjalanan::all();
        $biayatambahan = Biaya_tambahan::all();
        $pelanggans = Pelanggan::all();
        $saldoTerakhir = Saldo::latest()->first();
        $potonganmemos = Potongan_memo::all();
        $detailstambahan = Detail_tambahan::where('memo_ekspedisi_id', $id)->get();
        $details = Detail_potongan::where('memo_ekspedisi_id', $id)->get();
        $memos = Memo_ekspedisi::where('status_memo', null)->get();
        return view('admin.inquery_memoekspedisispk.update', compact(
            'inquery',
            'pelanggans',
            'kendaraans',
            'drivers',
            'ruteperjalanans',
            'biayatambahan',
            'potonganmemos',
            'memos',
            'detailstambahan',
            'details',
            'spks',
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
        $pdf->setPaper('folio');

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
                'spk_id' => 'required',
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
                'spk_id.required' => 'Pilih spk',
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
        $data_pembelians = collect();
        $data_pembelians4 = collect();

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
                    array_push($error_pesanans, "Biaya tambahan nomor " . ($i + 1) . " belum dilengkapi!");
                }

                $biaya_tambahan_id = $request->biaya_tambahan_id[$i] ?? '';
                $kode_biaya = $request->kode_biaya[$i] ?? '';
                $nama_biaya = $request->nama_biaya[$i] ?? '';
                $nominal = $request->nominal[$i] ?? '';

                $data_pembelians->push([
                    'detail_idd' => $request->detail_idss[$i] ?? null,
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
                    'detail_id' => $request->detail_ids[$i] ?? null,
                    'potongan_memo_id' => $potongan_memo_id,
                    'kode_potongan' => $kode_potongan,
                    'keterangan_potongan' => $keterangan_potongan,
                    'nominal_potongan' => $nominal_potongan,

                ]);
            }
        }

        if ($error_pelanggans || $error_pesanans) {
            return back()
                ->withInput()
                ->with('error_pelanggans', $error_pelanggans)
                ->with('error_pesanans', $error_pesanans)
                ->with('data_pembelians', $data_pembelians)
                ->with('data_pembelians4', $data_pembelians4);
        }

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
                'spk_id' => $request->spk_id,
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
                'biaya_tambahan' => str_replace(',', '.', str_replace('.', '', $request->biaya_tambahan)),
                'potongan_memo' => str_replace(',', '.', str_replace('.', '', $request->potongan_memo)),
                'deposit_driver' => $request->deposit_driver ? str_replace('.', '', $request->deposit_driver) : 0,
                'deposit_drivers' => $request->deposit_driver ? str_replace('.', '', $request->deposit_driver) : 0,
                // 'uang_jaminan' => round(str_replace(',', '.', str_replace('.', '', $request->uang_jaminan))),
                // 'sub_total' => round(str_replace(',', '.', str_replace('.', '', $request->sub_total))),
                'uang_jaminan' => str_replace(',', '.', str_replace('.', '', $request->uang_jaminan)),
                'sub_total' => str_replace(',', '.', str_replace('.', '', $request->sub_total)),
                'keterangan' => $request->keterangan,
                'hasil_jumlah' => $hasil_jumlah,

                // 'biaya_id' => $request->biaya_id,
                // 'kode_biaya' => $request->kode_biaya,
                // 'nama_biaya' => $request->nama_biaya,
                // 'nominal' => $request->has('nominal') ? ($request->nominal != 0 ? str_replace('.', '', $request->nominal) : null) : null,

                // 'potongan_id' => $request->potongan_id,
                // 'kode_potongan' => $request->kode_potongan,
                // 'keterangan_potongan' => $request->keterangan_potongan,
                // 'nominal_potongan' => $request->has('nominal_potongan') ? ($request->nominal_potongan != 0 ? str_replace('.', '', $request->nominal_potongan) : null) : null,
            ]
        );

        $transaksi_id = $cetakpdf->id;
        $detailIds = $request->input('detail_idss');
        $detailIds = $request->input('detail_ids');

        foreach ($data_pembelians as $data_pesanan) {
            $detailId = $data_pesanan['detail_idd'];

            if ($detailId) {
                Detail_tambahan::where('id', $detailId)->update([
                    'memo_ekspedisi_id' => $cetakpdf->id,
                    'biaya_tambahan_id' => $data_pesanan['biaya_tambahan_id'],
                    'kode_biaya' => $data_pesanan['kode_biaya'],
                    'nama_biaya' => $data_pesanan['nama_biaya'],
                    'nominal' =>  str_replace(',', '.', str_replace('.', '', $data_pesanan['nominal'])),

                ]);
            } else {
                $existingDetail = Detail_tambahan::where([
                    'memo_ekspedisi_id' => $cetakpdf->id,
                    'biaya_tambahan_id' => $data_pesanan['biaya_tambahan_id'],
                    'kode_biaya' => $data_pesanan['kode_biaya'],
                    'nama_biaya' => $data_pesanan['nama_biaya'],
                    'nominal' =>  str_replace(',', '.', str_replace('.', '', $data_pesanan['nominal'])),
                ])->first();


                if (!$existingDetail) {
                    Detail_tambahan::create([
                        'memo_ekspedisi_id' => $cetakpdf->id,
                        'biaya_tambahan_id' => $data_pesanan['biaya_tambahan_id'],
                        'kode_biaya' => $data_pesanan['kode_biaya'],
                        'nama_biaya' => $data_pesanan['nama_biaya'],
                        'nominal' =>  str_replace(',', '.', str_replace('.', '', $data_pesanan['nominal'])),
                    ]);
                }
            }
        }

        foreach ($data_pembelians4 as $data_pesanan) {
            $detailId = $data_pesanan['detail_id'];

            if ($detailId) {
                Detail_potongan::where('id', $detailId)->update([
                    'memo_ekspedisi_id' => $cetakpdf->id,
                    'potongan_memo_id' => $data_pesanan['potongan_memo_id'],
                    'kode_potongan' => $data_pesanan['kode_potongan'],
                    'keterangan_potongan' => $data_pesanan['keterangan_potongan'],
                    'nominal_potongan' =>  str_replace(',', '.', str_replace('.', '', $data_pesanan['nominal_potongan'])),
                ]);
            } else {
                $existingDetail = Detail_potongan::where([
                    'memo_ekspedisi_id' => $cetakpdf->id,
                    'potongan_memo_id' => $data_pesanan['potongan_memo_id'],
                    'kode_potongan' => $data_pesanan['kode_potongan'],
                    'keterangan_potongan' => $data_pesanan['keterangan_potongan'],
                    'nominal_potongan' =>  str_replace(',', '.', str_replace('.', '', $data_pesanan['nominal_potongan'])),
                ])->first();


                if (!$existingDetail) {
                    Detail_potongan::create([
                        'memo_ekspedisi_id' => $cetakpdf->id,
                        'potongan_memo_id' => $data_pesanan['potongan_memo_id'],
                        'kode_potongan' => $data_pesanan['kode_potongan'],
                        'keterangan_potongan' => $data_pesanan['keterangan_potongan'],
                        'nominal_potongan' =>  str_replace(',', '.', str_replace('.', '', $data_pesanan['nominal_potongan'])),
                    ]);
                }
            }
        }

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

            $UangUJS = $item->uang_jaminan; // Mengambil nilai dari objek atau model $item
            $UangUJS = round($UangUJS); // Mem-bulatkan nilai
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
                    'status' => 'posting memo',
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
                    'status' => 'posting memo',
                ]);
            }

            Spk::where('id', $item->spk_id)->update(['status_spk' => 'memo', 'status' => 'selesai']);
            // Update status Memo_ekspedisi
            $item->update(['status' => 'posting']);

            return response()->json(['success' => 'Berhasil memposting memo']);
            // return back()->with('success', 'Berhasil');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Gagal memposting memo: Memo tidak ditemukan']);
        }
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

            $UangUJS = $item->uang_jaminan; // Mengambil nilai dari objek atau model $item
            $UangUJS = round($UangUJS); // Mem-bulatkan nilai
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
                'status' => 'pending',
            ]);

            Spk::where('id', $item->spk_id)->update(['status_spk' => null, 'status' => 'posting']);
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

    // bener cek lagi 
    public function postingfilter(Request $request)
    {
        $selectedIds = array_reverse(explode(',', $request->input('ids')));

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
                    $UangUJS = $item->uang_jaminan; // Mengambil nilai dari objek atau model $item
                    $UangUJS = round($UangUJS); // Mem-bulatkan nilai
                    $totalDeductionujs += $UangUJS;
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
                            'status' => 'posting memo',
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
                            'status' => 'posting memo',
                        ]);
                    }

                    // Update status_spk
                    $spk = Spk::where('id', $item->spk_id)->first();
                    if ($spk) {
                        $spk->update(['status_spk' => 'memo', 'status' => 'selesai']);
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
                        $UangUJS = $item->uang_jaminan, // Mengambil nilai dari objek atau model $item
                        $UangUJS = round($UangUJS), // Mem-bulatkan nilai
                        'sisa_ujs' => $lastUjs->sisa_ujs + ($UangUJS)
                    ]);
                }
            }

            return back()->with('success', 'Berhasil memposting memo yang dipilih');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return back()->with('error', 'Terdapat memo yang tidak ditemukan');
        }
    }

    public function unpostfilter(Request $request)
    {
        $selectedIds = array_reverse(explode(',', $request->input('ids')));

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
                    $UangUJS = $item->uang_jaminan; // Mengambil nilai dari objek atau model $item
                    $UangUJS = round($UangUJS); // Mem-bulatkan nilai
                    $totalRestorationUJS += $UangUJS;
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
                            'status' => 'pending',
                        ]);
                    }

                    // Update status_spk
                    $spk = Spk::where(
                        'id',
                        $item->spk_id
                    )->first();
                    if ($spk) {
                        $spk->update(['status_spk' => null, 'status' => 'posting']);
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

    public function hapusmemo($id)
    {
        $memo = Memo_ekspedisi::where('id', $id)->first();
        $memo->deposit_driver()->delete();
        $memo->pengeluaran_kaskecil()->delete();
        $memo->detail_pengeluaran()->delete();
        $memo->uangjaminan()->delete();
        $memo->detail_tambahan()->delete();
        $memo->detail_potongan()->delete();
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

    public function deletedetailbiayatambahan($id)
    {
        $item = Detail_tambahan::find($id);

        if ($item) {
            $item->delete();
            return response()->json(['message' => 'Data deleted successfully']);
        } else {
            return response()->json(['message' => 'Detail Faktur not found'], 404);
        }
    }

    public function deletedetailbiayapotongan($id)
    {
        $item = Detail_potongan::find($id);

        if ($item) {
            $item->delete();
            return response()->json(['message' => 'Data deleted successfully']);
        } else {
            return response()->json(['message' => 'Detail Faktur not found'], 404);
        }
    }
}
