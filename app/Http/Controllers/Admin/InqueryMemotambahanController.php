<?php

namespace App\Http\Controllers\admin;

use App\Exports\RekapujtambahanExport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use App\Models\Biaya_tambahan;
use App\Models\Detail_faktur;
use App\Models\Detail_memotambahan;
use App\Models\Detail_notabon;
use App\Models\Detail_pengeluaran;
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
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class InqueryMemotambahanController extends Controller
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
            return view('admin.inquery_memotambahan.index', compact('inquery', 'saldoTerakhir'));
        }
    }

    public function edit($id)
    {
        $inquery = Memotambahan::where('id', $id)->first();
        $details = Detail_memotambahan::where('memotambahan_id', $id)->get();
        $kendaraans = Kendaraan::all();
        $drivers = User::whereHas('karyawan', function ($query) {
            $query->where('departemen_id', '2');
        })->get();
        $ruteperjalanans = Rute_perjalanan::all();
        $biayatambahan = Biaya_tambahan::all();
        $pelanggans = Pelanggan::all();
        $saldoTerakhir = Saldo::latest()->first();
        $potonganmemos = Potongan_memo::all();
        $detailnotas = Detail_notabon::where('memotambahan_id', $id)->get();
        $notas = Notabon_ujs::where(['status' => 'posting'])->get();
        $memos = Memo_ekspedisi::where(['status_memo' => null, 'status' => 'posting', 'status_memotambahan' => null])->get();
        return view('admin.inquery_memotambahan.update', compact(
            'details',
            'inquery',
            'pelanggans',
            'kendaraans',
            'drivers',
            'ruteperjalanans',
            'biayatambahan',
            'potonganmemos',
            'memos',
            'detailnotas',
            'notas',
            'saldoTerakhir'
        ));
    }


    public function update(Request $request, $id)
    {

        $validasi_pelanggan = Validator::make(
            $request->all(),
            [
                'memo_ekspedisi_id' => 'required',
            ],
            [
                'memo_ekspedisi_id.required' => 'Pilih memo',
            ]
        );

        $error_pelanggans = array();

        if ($validasi_pelanggan->fails()) {
            array_push($error_pelanggans, $validasi_pelanggan->errors()->all()[0]);
        }

        $error_pesanans = array();
        $data_pembelians4 = collect();
        $data_pembeliansnota = collect();

        if ($request->has('keterangan_tambahan') || $request->has('nominal_tambahan') || $request->has('qty') || $request->has('satuans') || $request->has('hargasatuan')) {
            for ($i = 0; $i < count($request->keterangan_tambahan); $i++) {
                if (empty($request->keterangan_tambahan[$i]) && empty($request->qty[$i]) && empty($request->satuans[$i]) && empty($request->hargasatuan[$i]) && empty($request->nominal_tambahan[$i])) {
                    continue;
                }

                $validasi_produk = Validator::make($request->all(), [
                    'keterangan_tambahan.' . $i => 'required',
                    'nominal_tambahan.' . $i => 'required',
                ]);

                if ($validasi_produk->fails()) {
                    array_push($error_pesanans, "Biaya tambahan nomor " . ($i + 1) . " belum dilengkapi!");
                }

                $keterangan_tambahan = is_null($request->keterangan_tambahan[$i]) ? '' : $request->keterangan_tambahan[$i];
                $qty = is_null($request->qty[$i]) ? '' : $request->qty[$i];
                $satuans = is_null($request->satuans[$i]) ? '' : $request->satuans[$i];
                $hargasatuan = is_null($request->hargasatuan[$i]) ? '' : $request->hargasatuan[$i];
                $nominal_tambahan = is_null($request->nominal_tambahan[$i]) ? '' : $request->nominal_tambahan[$i];

                $data_pembelians4->push([
                    'detail_id' => $request->detail_idstambahan[$i] ?? null,
                    'keterangan_tambahan' => $keterangan_tambahan,
                    'qty' => $qty,
                    'satuans' => $satuans,
                    'hargasatuan' => $hargasatuan,
                    'nominal_tambahan' => $nominal_tambahan
                ]);
            }
        } else {
        }

        if ($request->has('notabon_ujs_id') || $request->has('kode_nota') || $request->has('nama_drivernota') || $request->has('nominal_nota')) {
            for ($i = 0; $i < count($request->notabon_ujs_id); $i++) {
                if (empty($request->notabon_ujs_id[$i]) && empty($request->kode_nota[$i]) && empty($request->nama_drivernota[$i]) && empty($request->nominal_nota[$i])) {
                    continue;
                }

                $validasi_produk = Validator::make($request->all(), [
                    'notabon_ujs_id.' . $i => 'required',
                    'kode_nota.' . $i => 'required',
                    'nama_drivernota.' . $i => 'required',
                    'nominal_nota.' . $i => 'required',
                ]);

                if ($validasi_produk->fails()) {
                    array_push($error_pesanans, "Biaya tambahan nomor " . ($i + 1) . " belum dilengkapi!");
                }

                $notabon_ujs_id = $request->notabon_ujs_id[$i] ?? '';
                $kode_nota = $request->kode_nota[$i] ?? '';
                $nama_drivernota = $request->nama_drivernota[$i] ?? '';
                $nominal_nota = $request->nominal_nota[$i] ?? '';

                $data_pembeliansnota->push([
                    'detail_iddd' => $request->detail_idnotas[$i] ?? null,
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
                ->with('data_pembelians4', $data_pembelians4)
                ->with('data_pembeliansnota', $data_pembeliansnota);
        }

        $tanggal1 = Carbon::now('Asia/Jakarta');
        $format_tanggal = $tanggal1->format('d F Y');

        $tanggal = Carbon::now()->format('Y-m-d');
        $cetakpdf = Memotambahan::findOrFail($id);
        $previousMemoEkspedisiId = $cetakpdf->memo_ekspedisi_id;
        $cetakpdf->update([
            'memo_ekspedisi_id' => $request->memo_ekspedisi_id,
            'no_memo' => $request->kode_memosa,
            'nama_driver' => $request->nama_driversa,
            'telp' => $request->telps,
            'kendaraan_id' => $request->kendaraan_idsa,
            'no_kabin' => $request->no_kabinsa,
            'no_pol' => $request->no_polsa,
            'nama_rute' => $request->nama_rutesa,
            'nota_bontambahan' => str_replace(',', '.', str_replace('.', '', $request->nota_bontambahan ?? '0')),
            'grand_total' => str_replace(',', '.', str_replace('.', '', $request->grand_total)),
        ]);

        $transaksi_id = $cetakpdf->id;
        $detailIds = $request->input('detail_idstambahan');
        $allKeterangan = '';

        foreach ($data_pembelians4 as $data_pesanan) {
            $detailId = $data_pesanan['detail_id'];

            if ($detailId) {
                $existingDetail = Detail_memotambahan::find($detailId);
                if ($existingDetail) {
                    $existingDetail->update([
                        'memotambahan_id' => $cetakpdf->id,
                        'keterangan_tambahan' => $data_pesanan['keterangan_tambahan'],
                        'qty' => $data_pesanan['qty'],
                        'satuans' => $data_pesanan['satuans'],
                        'hargasatuan' => $data_pesanan['hargasatuan'],
                        'nominal_tambahan' =>  str_replace(',', '.', str_replace('.', '', $data_pesanan['nominal_tambahan'])),
                    ]);
                    $existingPengeluaran = Detail_pengeluaran::where('detail_memotambahan_id', $detailId)->first();

                    if ($existingPengeluaran) {
                        $existingPengeluaran->update([
                            'memotambahan_id' => $cetakpdf->id,
                            'keterangan' => $existingDetail->keterangan_tambahan,
                            'qty' => $existingDetail->qty,
                            'satuans' => $existingDetail->satuans,
                            'hargasatuan' => $existingDetail->hargasatuan,
                            'nominal' => $existingDetail->nominal_tambahan,
                        ]);
                    }
                    $allKeterangan .= $data_pesanan['keterangan_tambahan'] . ', ';
                }
            } else {
                $existingDetail = Detail_memotambahan::where([
                    'memotambahan_id' => $cetakpdf->id,
                    'keterangan_tambahan' => $data_pesanan['keterangan_tambahan'],
                ])->first();

                $lastDetail = Detail_pengeluaran::where('kode_detailakun', 'like', 'KKA%')->orderBy('id', 'desc')->first();
                $lastNum = 0;
                $currentMonth = date('m');
                if (!$lastDetail || $currentMonth != date('m', strtotime($lastDetail->created_at))) {
                    $lastNum = 0;
                } else {
                    $lastCode = substr($lastDetail->kode_detailakun, -6);
                    $lastNum = (int)$lastCode;
                }

                if (!$existingDetail) {
                    $detailMemotambahan = Detail_memotambahan::create([
                        'memotambahan_id' => $cetakpdf->id,
                        'keterangan_tambahan' => $data_pesanan['keterangan_tambahan'],
                        'qty' => $data_pesanan['qty'],
                        'satuans' => $data_pesanan['satuans'],
                        'hargasatuan' => $data_pesanan['hargasatuan'],
                        'nominal_tambahan' =>  str_replace(',', '.', str_replace('.', '', $data_pesanan['nominal_tambahan'])),
                    ]);

                    $num = $lastNum + 1;
                    $formattedNum = sprintf("%06s", $num);

                    $prefix = 'KKA';
                    $tahun = date('y');
                    $tanggal = date('dm');

                    $newCode = $prefix . "/" . $tanggal . $tahun . "/" . $formattedNum;

                    Detail_pengeluaran::create([
                        'detail_memotambahan_id' => $detailMemotambahan->id,
                        'memotambahan_id' => $cetakpdf->id,
                        'kode_detailakun' => $newCode,
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
        }

        foreach ($data_pembeliansnota as $data_pesanan) {
            $detailId = $data_pesanan['detail_iddd'];

            if ($detailId) {
                $detail = Detail_notabon::where('id', $detailId)->update([
                    'memotambahan_id' => $cetakpdf->id,
                    'notabon_ujs_id' => $data_pesanan['notabon_ujs_id'],
                    'kode_nota' => $data_pesanan['kode_nota'],
                    'nama_drivernota' => $data_pesanan['nama_drivernota'],
                    'nominal_nota' =>  str_replace(',', '.', str_replace('.', '', $data_pesanan['nominal_nota'])),
                ]);
                // $nota = Notabon_ujs::find($detail->notabon_ujs_id);
                // if ($nota) {
                //     $nota->update(['status_memo' => 'aktif']);
                // }
            } else {
                $existingDetail = Detail_notabon::where([
                    'memotambahan_id' => $cetakpdf->id,
                    'notabon_ujs_id' => $data_pesanan['notabon_ujs_id'],
                    'kode_nota' => $data_pesanan['kode_nota'],
                    'nama_drivernota' => $data_pesanan['nama_drivernota'],
                    'nominal_nota' =>  str_replace(',', '.', str_replace('.', '', $data_pesanan['nominal_nota'])),
                ])->first();


                if (!$existingDetail) {
                    $detail = Detail_notabon::create([
                        'memotambahan_id' => $cetakpdf->id,
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
        }

        $pengeluaran = Pengeluaran_kaskecil::where('memotambahan_id', $id)->first();
        $pengeluaran->update(
            [
                'kendaraan_id' => $request->kendaraan_idsa,
                'keterangan' => $allKeterangan,
                'grand_total' => str_replace(',', '.', str_replace('.', '', $request->grand_total)),
            ]
        );

        $memoNew = $request->memo_ekspedisi_id;
        if ($memoNew) {
            Memo_ekspedisi::where('id', $memoNew)->update(['status_memotambahan' => 'digunakan']);
            if ($previousMemoEkspedisiId != $memoNew) {
                Memo_ekspedisi::where('id', $previousMemoEkspedisiId)->update(['status_memotambahan' => null]);
            }
        }

        $detail_memo = Detail_memotambahan::where('memotambahan_id', $cetakpdf->id)->get();
        $detail_nota = Detail_notabon::where('memotambahan_id', $cetakpdf->id)->get();
        return view('admin.inquery_memotambahan.show', compact('cetakpdf', 'detail_memo', 'detail_nota'));
    }

    public function kodeakuns()
    {
        try {
            return DB::transaction(function () {
                $lastBarang = Detail_pengeluaran::where('kode_detailakun', 'like', 'KKA%')->latest()->first();
                $lastMonth = $lastBarang ? date('m', strtotime($lastBarang->created_at)) : null;
                $currentMonth = date('m');
                if (!$lastBarang || $currentMonth != $lastMonth) {
                    $num = 1;
                } else {
                    $lastCode = $lastBarang->kode_detailakun;
                    $parts = explode('/', $lastCode);
                    $lastNum = end($parts);
                    $num = (int) $lastNum + 1;
                }
                $formattedNum = sprintf("%06s", $num);
                $prefix = 'KKA';
                $tahun = date('y');
                $tanggal = date('dm');

                $newCode = $prefix . "/" . $tanggal . $tahun . "/" . $formattedNum;

                return $newCode;
            });
        } catch (\Throwable $e) {
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

    public function show($id)
    {
        $cetakpdf = Memotambahan::where('id', $id)->first();
        $detail_memo = Detail_memotambahan::where('memotambahan_id', $cetakpdf->id)->get();
        $detail_nota = Detail_notabon::where('memotambahan_id', $cetakpdf->id)->get();
        return view('admin.inquery_memotambahan.show', compact('cetakpdf', 'detail_memo', 'detail_nota'));
    }

    public function unpostmemotambahan($id)
    {
        try {
            $item = Memotambahan::findOrFail($id);
            $totaltambahan = $item->grand_total;
            $lastSaldo = Saldo::latest()->first();

            if (!$lastSaldo) {
                return 'saldo tidak ada';
            }
            $sisaSaldo = $lastSaldo->sisa_saldo + $totaltambahan;
            Saldo::create([
                'sisa_saldo' => $sisaSaldo,
            ]);
            Pengeluaran_kaskecil::where('memotambahan_id', $id)->update([
                'status' => 'pending'
            ]);

            $detailpengeluaran = Detail_pengeluaran::where('memotambahan_id', $id);
            $detailpengeluaran->update([
                'status' => 'pending'
            ]);

            $item->update([
                'status' => 'unpost'
            ]);

            return back()->with('success', 'Berhasil');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        }
    }

    public function postingmemotambahanfilter(Request $request)
    {
        $selectedIds = array_reverse(explode(',', $request->input('ids')));
        try {
            $totalDeduction = 0;

            foreach ($selectedIds as $id) {
                $item = Memotambahan::findOrFail($id);

                if ($item->status === 'unpost') {
                    $totalDeduction += $item->grand_total;
                }
            }

            $lastSaldo = Saldo::latest()->first();

            if (!$lastSaldo) {
                return back()->with('error', 'Saldo tidak ditemukan');
            }

            if ($lastSaldo->sisa_saldo < $totalDeduction) {
                return back()->with('error', 'Saldo tidak mencukupi');
            }

            $sisaSaldo = $lastSaldo->sisa_saldo - $totalDeduction;
            Saldo::create([
                'sisa_saldo' => $sisaSaldo,
            ]);
            foreach ($selectedIds as $id) {
                $item = Memotambahan::findOrFail($id);

                if ($item->status === 'unpost') {
                    Pengeluaran_kaskecil::where('memotambahan_id', $id)->update([
                        'status' => 'posting'
                    ]);

                    Detail_pengeluaran::where('memotambahan_id', $id)->update([
                        'status' => 'posting'
                    ]);
                    $item->update([
                        'status' => 'posting'
                    ]);
                }
            }

            return back()->with('success', 'Berhasil memposting memo yang dipilih');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return back()->with('error', 'Terdapat memo yang tidak ditemukan');
        }
    }

    public function unpostmemotambahanfilter(Request $request)
    {
        $selectedIds = array_reverse(explode(',', $request->input('ids')));

        try {
            $totalRestoration = 0;

            foreach ($selectedIds as $id) {
                $item = Memotambahan::findOrFail($id);
                if ($item->status === 'posting') {
                    // Accumulate total restoration amount
                    $totalRestoration += $item->grand_total;
                }
            }

            $lastSaldo = Saldo::latest()->first();

            if (!$lastSaldo) {
                return back()->with('error', 'Saldo tidak ditemukan');
            }

            $sisaSaldo = $lastSaldo->sisa_saldo + $totalRestoration;
            Saldo::create([
                'sisa_saldo' => $sisaSaldo,
            ]);

            foreach ($selectedIds as $id) {
                $item = Memotambahan::findOrFail($id);

                if ($item->status === 'posting') {
                    Pengeluaran_kaskecil::where('memotambahan_id', $id)->update([
                        'status' => 'pending'
                    ]);

                    Detail_pengeluaran::where('memotambahan_id', $id)->update([
                        'status' => 'pending'
                    ]);
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

    public function unpostmemotambahanselesai($id)
    {
        try {
            $item = Memotambahan::findOrFail($id);

            $biayatambahan = $item->memo_ekspedisi;

            if (!$biayatambahan) {
                return 'memo tidak ada';
            }

            $totaltambahan = $item->grand_total;

            $lastSaldo = Saldo::latest()->first();

            if (!$lastSaldo) {
                return 'saldo tidak ada';
            }

            $sisaSaldo = $lastSaldo->sisa_saldo + $totaltambahan;

            Saldo::create([
                'sisa_saldo' => $sisaSaldo,
            ]);

            Pengeluaran_kaskecil::where('memotambahan_id', $id)->update([
                'status' => 'pending'
            ]);

            $detailpengeluaran = Detail_pengeluaran::where('memotambahan_id', $id);
            $detailpengeluaran->update([
                'status' => 'pending'
            ]);
            $detail_faktur = Detail_faktur::where('memotambahan_id', $id)->first();

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

    public function postingmemotambahan($id)
    {
        try {
            $item = Memotambahan::findOrFail($id);

            $totaltambahan = $item->grand_total;
            $lastSaldo = Saldo::latest()->first();

            if (!$lastSaldo) {
                return 'gagal';
            }


            $uangjalan = $item->grand_total;
            if ($lastSaldo->sisa_saldo < $uangjalan) {
                return back()->with('error', 'Saldo tidak mencukupi');
            }

            $sisaSaldo = $lastSaldo->sisa_saldo - $totaltambahan;
            Saldo::create([
                'sisa_saldo' => $sisaSaldo,
            ]);
            Pengeluaran_kaskecil::where('memotambahan_id', $id)->update([
                'status' => 'posting'
            ]);

            $detailpengeluaran = Detail_pengeluaran::where('memotambahan_id', $id);
            $detailpengeluaran->update([
                'status' => 'posting'
            ]);
            $item->update([
                'status' => 'posting'
            ]);

            return back()->with('success', 'Berhasil');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        }
    }

    public function hapusmemotambahan($id)
    {
        $item = Memotambahan::find($id);

        if ($item) {
            Memo_ekspedisi::where('id', $item->memo_ekspedisi_id)->update(['status_memotambahan' => null]);

            $item->detail_memotambahan()->delete();
            $item->pengeluaran_kaskecil()->delete();
            $item->delete();

            return back()->with('success', 'Berhasil');
        } else {
            return back()->with('error', 'Memotambahan tidak ditemukan');
        }
    }

    public function cetakpdf($id)
    {
        $cetakpdf = Memotambahan::where('id', $id)->first();
        $detail_memo = Detail_memotambahan::where('memotambahan_id', $cetakpdf->id)->get();
        $detail_nota = Detail_notabon::where('memotambahan_id', $cetakpdf->id)->get();
        $pdf = PDF::loadView('admin.inquery_memotambahan.cetak_pdf', compact('cetakpdf', 'detail_memo', 'detail_nota'));
        $pdf->setPaper('landscape'); // Set the paper size to portrait letter
        return $pdf->stream('Memo_ekspedisi.pdf');
    }


    public function cetak_memotambahanfilter(Request $request)
    {
        $selectedIds = explode(',', $request->input('ids'));

        $memos = Memotambahan::whereIn('id', $selectedIds)->orderBy('id', 'DESC')->get();

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('admin.inquery_memotambahan.cetak_pdffilter', compact('memos'));
        $pdf->setPaper('folio');

        return $pdf->stream('SelectedMemoTambahan.pdf');
    }

    public function destroy($id)
    {
        $ban = Memotambahan::find($id);
        $ban->delete();
        return redirect('admin/inquery_memotambahan')->with('success', 'Berhasil memperbarui memo tambahan');
    }

    public function deletedetailtambahan($id)
    {
        $item = Detail_memotambahan::find($id);

        if ($item) {
            $memo = Memotambahan::find($item->memotambahan_id);

            if ($memo) {
                $grand = $memo->grand_total;
                $nominal = $item->nominal_tambahan;
                $total = $grand - $nominal;
                $memo->update(['grand_total' => $total]);
            } else {
                return response()->json(['message' => 'Memo not found'], 404);
            }
            $item->detail_pengeluaran()->delete();
            $item->delete();

            return response()->json(['message' => 'Data deleted successfully']);
        } else {
            return response()->json(['message' => 'Detail memo not found'], 404);
        }
    }

    public function deletememotambahanfilter(Request $request)
    {
        $selectedIds = explode(',', $request->input('ids'));

        $memotambahans = Memotambahan::whereIn('id', $selectedIds)->orderBy('id', 'DESC')->get();

        foreach ($memotambahans as $memotambahan) {
            if ($memotambahan && $memotambahan->status == 'unpost') {

                Memo_ekspedisi::where('id', $memotambahan->memo_ekspedisi_id)->update(['status_memotambahan' => null]);
                $memotambahan->detail_memotambahan()->delete();
                $memotambahan->pengeluaran_kaskecil()->delete();
                $memotambahan->delete();
            }
        }

        return back()->with('success', 'Berhasil menghapus Memo tambahan');
    }

    public function excel_memotambahanfilter(Request $request)
    {
        $selectedIds = explode(',', $request->input('ids'));

        $memotambahan = Memotambahan::whereIn('id', $selectedIds)->orderBy('id', 'DESC')->get();

        if (!$memotambahan) {
            return redirect()->back()->withErrors(['error' => 'Data Memo tidak ditemukan']);
        }

        // Ekspor sebagai CSV
        return Excel::download(new RekapujtambahanExport($memotambahan), 'rekap_ujtambahan.csv', \Maatwebsite\Excel\Excel::CSV);
    }
}
