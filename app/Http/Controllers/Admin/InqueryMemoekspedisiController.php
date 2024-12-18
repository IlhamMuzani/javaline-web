<?php

namespace App\Http\Controllers\admin;

use App\Exports\MemoperjalananExport;
use App\Exports\RekapujExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Biaya_tambahan;
use App\Models\Deposit_driver;
use App\Models\Detail_faktur;
use App\Models\Detail_notabon;
use App\Models\Detail_pengeluaran;
use App\Models\Detail_potongan;
use App\Models\Detail_tambahan;
use App\Models\Faktur_ekspedisi;
use App\Models\Kendaraan;
use App\Models\Memo_ekspedisi;
use App\Models\Memotambahan;
use App\Models\Notabon_ujs;
use App\Models\Pelanggan;
use App\Models\Pengeluaran_kaskecil;
use App\Models\Potongan_memo;
use App\Models\Rute_perjalanan;
use App\Models\Saldo;
use App\Models\Spk;
use App\Models\Total_ujs;
use App\Models\Uangjaminan;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

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
            return view('admin.inquery_memotambahan.index', compact('inquery', 'saldoTerakhir'));
        } else {
            $inquery = Memo_ekspedisi::where('kategori', 'Memo Perjalanan');
            $inquery->whereDate('tanggal_awal', Carbon::today());
            $inquery->orderBy('id', 'DESC');
            $inquery = $inquery->get();
            $memoekspedisiJson = json_encode($inquery);
            return view('admin.inquery_memoekspedisi.index', compact('memoekspedisiJson', 'saldoTerakhir', 'inquery'));
        }
    }



    public function search(Request $request)
    {
        $keyword = $request->input('keyword');

        $users = User::whereHas('karyawan', function ($query) use ($keyword) {
            $query->where('departemen_id', '2')
                ->where('nama_lengkap', 'like', "%$keyword%");
        })
            ->with('karyawan.departemen')
            ->paginate(10);
        return response()->json($users);
    }

    public function edit($id)
    {
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
        $detailstambahan = Detail_tambahan::where('memo_ekspedisi_id', $id)->get();
        $details = Detail_potongan::where('memo_ekspedisi_id', $id)->get();
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
            'detailstambahan',
            'details',
            'saldoTerakhir'
        ));
    }

    public function cetak_memoekspedisifilter(Request $request)
    {
        $selectedIds = explode(',', $request->input('ids'));
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
        ];
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
                    $numericValue = preg_replace('/[^0-9]/', '', $value);
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
        $data_pembelians = collect();
        $data_pembelians4 = collect();

        if ($request->has('biaya_tambahan_id') || $request->has('kode_biaya') || $request->has('nama_biaya') || $request->has('nominal')) {
            for ($i = 0; $i < count($request->biaya_tambahan_id); $i++) {
                if (empty($request->biaya_tambahan_id[$i]) && empty($request->kode_biaya[$i]) && empty($request->nama_biaya[$i]) && empty($request->nominal[$i])) {
                    continue;
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
                if (empty($request->potongan_memo_id[$i]) && empty($request->kode_potongan[$i]) && empty($request->keterangan_potongan[$i]) && empty($request->nominal_potongan[$i])) {
                    continue;
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

        $uang_jalans = str_replace('.', '', $request->uang_jalan);
        $uang_jalans = str_replace(',', '.', $uang_jalans);

        $potongan_memos = str_replace(',', '.', str_replace('.', '', $request->potongan_memo));

        $biaya_tambahan = str_replace('.', '', $request->biaya_tambahan);
        $biaya_tambahan = str_replace(',', '.', $biaya_tambahan);

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
                'biaya_tambahan' => str_replace(',', '.', str_replace('.', '', $request->biaya_tambahan)),
                'potongan_memo' => str_replace(',', '.', str_replace('.', '', $request->potongan_memo)),
                'deposit_driver' => $request->deposit_driver ? str_replace('.', '', $request->deposit_driver) : 0,
                'deposit_drivers' => $request->deposit_driver ? str_replace('.', '', $request->deposit_driver) : 0,
                'uang_jaminan' => str_replace(',', '.', str_replace('.', '', $request->uang_jaminan)),
                'sub_total' => str_replace(',', '.', str_replace('.', '', $request->sub_total)),
                'keterangan' => $request->keterangan,
                'hasil_jumlah' => $hasil_jumlah,
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
                'grand_total' => $hasil_jumlah,
            ]
        );

        $detailpengeluaran = Detail_pengeluaran::where('memo_ekspedisi_id', $id)->first();
        $detailpengeluaran->update(
            [
                'keterangan' => $request->keterangan,
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
        $detail_nota = Detail_notabon::where('memo_ekspedisi_id', $cetakpdf->id)->get();
        return view('admin.inquery_memoekspedisi.show', compact('cetakpdf', 'detail_nota'));
    }

    public function unpostmemo($id)
    {
        try {
            $item = Memo_ekspedisi::findOrFail($id);
            $user = $item->user;

            $uangJalan = $item->uang_jalan;
            $BiayaTambahan = $item->biaya_tambahan;
            $PotonganMemo = $item->potongan_memo;
            $Notabon = $item->nota_bon;

            $lastSaldo = Saldo::latest()->first();
            if (!$lastSaldo) {
                return back()->with('error', 'Saldo tidak ditemukan');
            }

            $sisaSaldo = $lastSaldo->sisa_saldo + $uangJalan + $BiayaTambahan - $PotonganMemo - $Notabon;
            
            Saldo::create([
                'sisa_saldo' => $sisaSaldo,
            ]);

            $UangUJS = $item->uang_jaminan;
            $UangUJS = round($UangUJS);
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

            $detailnotes = Detail_notabon::where('memo_ekspedisi_id', $item->id)->get();

            foreach ($detailnotes as $detail) {
                $nota_bon = Notabon_ujs::where('id', $detail->notabon_ujs_id)
                    ->where('status', 'selesai')
                    ->first();

                if ($nota_bon) {
                    $nota_bon->update([
                        'status_memo' => null,
                        'status' => 'posting',
                    ]);
                }
            }

            $item->update([
                'status' => 'unpost'
            ]);

            return back()->with('success', 'Berhasil');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        }
    }

    public function postingmemo($id)
    {
        try {
            $item = Memo_ekspedisi::findOrFail($id);
            $user = $item->user;

            $postedCount = Memo_ekspedisi::where('nama_driver', $item->nama_driver)
                ->where('status', 'posting')
                ->count();
            if ($postedCount >= 3) {
                return response()->json(['error' => 'Memo Perjalanan telah mencapai batas maksimal']);
            }

            $uangJalan = $item->uang_jalan;
            $BiayaTambahan = $item->biaya_tambahan;
            $PotonganMemo = $item->potongan_memo;
            $Notabon = $item->nota_bon;

            $lastSaldo = Saldo::latest()->first();
            if (!$lastSaldo) {
                return response()->json(['error' => 'Saldo tidak ditemukan']);
            }

            if ($lastSaldo->sisa_saldo < $uangJalan) {
                return response()->json(['error' => 'Saldo tidak mencukupi']);
            }

            $UangUJS = $item->uang_jaminan;
            $UangUJS = round($UangUJS);
            $lastUjs = Total_ujs::latest()->first();
            if (!$lastUjs) {
                return response()->json(['error' => 'Ujs tidak ditemukan']);
            }

            $sisaUjs = $lastUjs->sisa_ujs + $UangUJS;
            
            // return response()->json(['error' => $sisaUjs]);

            $lastUjs->update(['sisa_ujs' => $sisaUjs]);

            $sisaSaldo = $lastSaldo->sisa_saldo - $uangJalan - $BiayaTambahan + $PotonganMemo + $Notabon;

            // return response()->json(['error' => $sisaSaldo]);

            $lastSaldo->update(['sisa_saldo' => $sisaSaldo]);
            $karyawan = $user->karyawan;
            $tabungans = $karyawan->tabungan;
            $deposits = $karyawan->deposit;
            $karyawan->update([
                'deposit' => $deposits + $item->deposit_driver,
                'tabungan' => $tabungans + $item->deposit_driver,
            ]);
            

            Pengeluaran_kaskecil::where('memo_ekspedisi_id', $id)->update(['status' => 'posting']);
            Detail_pengeluaran::where('memo_ekspedisi_id', $id)->update(['status' => 'posting']);

            Uangjaminan::where('memo_ekspedisi_id', $id)->update([
                'status' => 'posting'
            ]);
            $tanggal1 = Carbon::now('Asia/Jakarta');
            $format_tanggal = $tanggal1->format('d F Y');
            $tanggal = Carbon::now()->format('Y-m-d');
            $depositDriverRecord = Deposit_driver::where('memo_ekspedisi_id', $item->id)->first();

            if ($depositDriverRecord) {
                $depositDriverRecord->update([
                    'sub_total' => $tabungans + $item->deposit_driver,
                    'nominal' => $item->deposit_driver,
                    'sisa_saldo' => $tabungans + $item->deposit_driver,
                    'status' => 'posting memo',
                ]);
            } else {
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


            $detailnotes = Detail_notabon::where('memo_ekspedisi_id', $item->id)->get();

            foreach ($detailnotes as $detail) {
                $nota_bon = Notabon_ujs::where('id', $detail->notabon_ujs_id)
                    ->where('status', 'posting')
                    ->first();

                if ($nota_bon) {
                    $nota_bon->update([
                        'status_memo' => 'aktif',
                        'status' => 'selesai'
                    ]);
                }
            }

            $item->update(['status' => 'posting']);

            return response()->json(['success' => 'Berhasil memposting memo']);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Gagal memposting memo: Memo tidak ditemukan']);
        }
    }

    public function postingfilter(Request $request)
    {
        $selectedIds = array_reverse(explode(',', $request->input('ids')));

        try {
            $totalDeduction = 0;
            $totalDeductionujs = 0;

            foreach ($selectedIds as $id) {
                $driverName = Memo_ekspedisi::findOrFail($id)->nama_driver;
                $postedCount = Memo_ekspedisi::where('nama_driver', $driverName)
                    ->where('status', 'posting')
                    ->count();

                if ($postedCount >= 3) {
                    continue;
                }

                $item = Memo_ekspedisi::findOrFail($id);

                if ($item->status === 'unpost' && $item->kategori === 'Memo Perjalanan') {
                    $totalDeduction += $item->uang_jalan + $item->biaya_tambahan - $item->potongan_memo - $item->nota_bon;
                    $UangUJS = $item->uang_jaminan;
                    $UangUJS = round($UangUJS);
                    $totalDeductionujs += $UangUJS;
                }
            }

            $lastSaldo = Saldo::latest()->first();
            $lastUjs = Total_ujs::latest()->first();

            if (!$lastSaldo) {
                return back()->with('error', 'Saldo tidak ditemukan');
            }

            if ($lastSaldo->sisa_saldo < $totalDeduction) {
                return back()->with('error', 'Saldo tidak mencukupi');
            }

            $totalUangJalanRequest = array_reduce($selectedIds, function ($carry, $id) {
                $item = Memo_ekspedisi::findOrFail($id);
                return $carry + $item->uang_jalan;
            }, 0);

            if ($lastSaldo->sisa_saldo < $totalUangJalanRequest) {
                return back()->with('error', 'Total request uang jalan melebihi saldo terakhir');
            }

            foreach ($selectedIds as $id) {
                $item = Memo_ekspedisi::findOrFail($id);
                $postedCount = Memo_ekspedisi::where('nama_driver', $item->nama_driver)
                    ->where('status', 'posting')
                    ->count();
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
                        $depositDriverRecord->update([
                            'sub_total' => $tabungans + $item->deposit_driver,
                            'nominal' => $item->deposit_driver,
                            'sisa_saldo' => $tabungans + $item->deposit_driver,
                            'status' => 'posting memo',
                        ]);
                    } else {
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
                    $spk = Spk::where('id', $item->spk_id)->first();
                    if ($spk) {
                        $spk->update(['status_spk' => 'memo', 'status' => 'selesai']);
                    }

                    $detailnotes = Detail_notabon::where('memo_ekspedisi_id', $item->id)->get();

                    foreach ($detailnotes as $detail) {
                        $nota_bon = Notabon_ujs::where('id', $detail->notabon_ujs_id)
                            ->where('status', 'posting')
                            ->first();

                        if ($nota_bon) {
                            $nota_bon->update([
                                'status_memo' => 'aktif',
                                'status' => 'selesai',
                            ]);
                        }
                    }

                    $item->update([
                        'status' => 'posting'
                    ]);
                    $lastSaldo->update([
                        'sisa_saldo' => $lastSaldo->sisa_saldo - ($item->uang_jalan + $item->biaya_tambahan - $item->potongan_memo - $item->nota_bon)
                    ]);

                    $lastUjs->update([
                        $UangUJS = $item->uang_jaminan,
                        $UangUJS = round($UangUJS),
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
            $totalRestoration = 0;
            $totalRestorationUJS = 0;

            foreach ($selectedIds as $id) {
                $item = Memo_ekspedisi::findOrFail($id);
                if ($item->status === 'posting') {
                    $totalRestoration += $item->uang_jalan + $item->biaya_tambahan - $item->potongan_memo - $item->nota_bon;
                    $UangUJS = $item->uang_jaminan;
                    $UangUJS = round($UangUJS);
                    $totalRestorationUJS += $UangUJS;
                }
            }

            $lastSaldo = Saldo::latest()->first();
            $lastUJS = Total_ujs::latest()->first();

            if (!$lastSaldo) {
                return back()->with('error', 'Saldo tidak ditemukan');
            }
            $sisaSaldo = $lastSaldo->sisa_saldo + $totalRestoration;
            $sisaUJS = $lastUJS->sisa_ujs - $totalRestorationUJS;

            Saldo::create([
                'sisa_saldo' => $sisaSaldo,
            ]);

            Total_ujs::create([
                'sisa_ujs' => $sisaUJS,
            ]);

            foreach ($selectedIds as $id) {
                $item = Memo_ekspedisi::findOrFail($id);

                if ($item->status === 'posting') {
                    $user = $item->user;
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

                    $depositDriverRecord = Deposit_driver::where('memo_ekspedisi_id', $item->id)->first();

                    if ($depositDriverRecord) {
                        $depositDriverRecord->update([
                            'status' => 'pending',
                        ]);
                    }

                    $spk = Spk::where(
                        'id',
                        $item->spk_id
                    )->first();
                    if ($spk) {
                        $spk->update(['status_spk' => null, 'status' => 'posting']);
                    }

                    $detailnotes = Detail_notabon::where('memo_ekspedisi_id', $item->id)->get();

                    foreach ($detailnotes as $detail) {
                        $nota_bon = Notabon_ujs::where('id', $detail->notabon_ujs_id)
                            ->where('status', 'selesai')
                            ->first();

                        if ($nota_bon) {
                            $nota_bon->update([
                                'status_memo' => null,
                                'status' => 'posting',
                            ]);
                        }
                    }

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
        $memo->detail_notabon()->delete();
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

    public function rekapexportmemoperjalanan(Request $request)
    {
        $tanggal_awal = $request->input('tanggal_awal');
        $tanggal_akhir = $request->input('tanggal_akhir');
        $kategori = $request->input('kategori');
        $status = $request->input('status');
        return Excel::download(new MemoperjalananExport($tanggal_awal, $tanggal_akhir, $kategori, $status), 'memo_ekspedisi.xlsx');
    }

    public function excel_memoekspedisifilter(Request $request)
    {
        $selectedIds = explode(',', $request->input('ids'));

        $memo_ekspedisi = Memo_ekspedisi::whereIn('id', $selectedIds)->orderBy('id', 'DESC')->get();

        if (!$memo_ekspedisi) {
            return redirect()->back()->withErrors(['error' => 'Data Memo tidak ditemukan']);
        }

        // Ekspor sebagai CSV
        return Excel::download(new RekapujExport($memo_ekspedisi), 'rekap_uj.csv', \Maatwebsite\Excel\Excel::CSV);
    }
}