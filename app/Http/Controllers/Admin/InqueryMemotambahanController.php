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
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Egulias\EmailValidator\Result\Reason\DetailedReason;

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
            // Anda harus menyesuaikan ini sesuai dengan tampilan dan data yang diperlukan untuk "Memo Tambahan"
            // Misalnya:
            return view('admin.inquery_memotambahan.index', compact('inquery', 'saldoTerakhir'));
        }
    }

    public function edit($id)
    {
        // if (auth()->check() && auth()->user()->menu['inquery perpanjangan stnk']) {

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
        $memos = Memo_ekspedisi::where(['status_memo' => null, 'status' => 'posting'])->get();
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

        if ($request->has('keterangan_tambahan') || $request->has('nominal_tambahan') || $request->has('qty') || $request->has('satuans') || $request->has('hargasatuan')) {
            for ($i = 0; $i < count($request->keterangan_tambahan); $i++) {
                // Check if either 'keterangan_tambahan' or 'nominal_tambahan' has input
                if (empty($request->keterangan_tambahan[$i]) && empty($request->qty[$i]) && empty($request->satuans[$i]) && empty($request->hargasatuan[$i]) && empty($request->nominal_tambahan[$i])) {
                    continue; // Skip validation if both are empty
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


        if ($error_pelanggans || $error_pesanans) {
            return back()
                ->withInput()
                ->with('error_pelanggans', $error_pelanggans)
                ->with('error_pesanans', $error_pesanans)
                ->with('data_pembelians4', $data_pembelians4);
        }

        $tanggal1 = Carbon::now('Asia/Jakarta');
        $format_tanggal = $tanggal1->format('d F Y');

        $tanggal = Carbon::now()->format('Y-m-d');
        $cetakpdf = Memotambahan::findOrFail($id);
        $cetakpdf->update([
            'memo_ekspedisi_id' => $request->memo_ekspedisi_id,
            'no_memo' => $request->kode_memosa,
            'nama_driver' => $request->nama_driversa,
            'telp' => $request->telps,
            'kendaraan_id' => $request->kendaraan_idsa,
            'no_kabin' => $request->no_kabinsa,
            'no_pol' => $request->no_polsa,
            'nama_rute' => $request->nama_rutesa,
            'grand_total' => str_replace(',', '.', str_replace('.', '', $request->grand_total)),
        ]);

        $transaksi_id = $cetakpdf->id;
        $detailIds = $request->input('detail_idstambahan');
        $allKeterangan = ''; // Initialize an empty string to accumulate keterangan values

        foreach ($data_pembelians4 as $data_pesanan) {
            $detailId = $data_pesanan['detail_id'];

            if ($detailId) {
                // Retrieve the existing Detail_memotambahan record
                $existingDetail = Detail_memotambahan::find($detailId);
                if ($existingDetail) {
                    // Update the existing Detail_memotambahan record
                    $existingDetail->update([
                        'memotambahan_id' => $cetakpdf->id,
                        'keterangan_tambahan' => $data_pesanan['keterangan_tambahan'],
                        'qty' => $data_pesanan['qty'],
                        'satuans' => $data_pesanan['satuans'],
                        'hargasatuan' => $data_pesanan['hargasatuan'],
                        'nominal_tambahan' =>  str_replace(',', '.', str_replace('.', '', $data_pesanan['nominal_tambahan'])),
                    ]);
                    // Retrieve the corresponding Detail_pengeluaran record
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

                if (!$existingDetail) {
                    $detailMemotambahan = Detail_memotambahan::create([
                        'memotambahan_id' => $cetakpdf->id,
                        'keterangan_tambahan' => $data_pesanan['keterangan_tambahan'],
                        'qty' => $data_pesanan['qty'],
                        'satuans' => $data_pesanan['satuans'],
                        'hargasatuan' => $data_pesanan['hargasatuan'],
                        'nominal_tambahan' =>  str_replace(',', '.', str_replace('.', '', $data_pesanan['nominal_tambahan'])),
                    ]);
                    // Use the $detailMemotambahan->id in the creation of Detail_pengeluaran
                    Detail_pengeluaran::create([
                        'detail_memotambahan_id' => $detailMemotambahan->id,
                        'memotambahan_id' => $cetakpdf->id,
                        'kode_detailakun' => $this->kodeakuns(),
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

        // foreach ($data_pembelians4 as $data_pesanan) {
        //     $detailId = $data_pesanan['detail_id'];

        //     if ($detailId) {
        //         // Detail_memotambahan::where('id', $detailId)->update([
        //         //     'memotambahan_id' => $cetakpdf->id,
        //         //     'keterangan_tambahan' => $data_pesanan['keterangan_tambahan'],
        //         //     'nominal_tambahan' => $data_pesanan['nominal_tambahan'],
        //         // ]);
        //         Detail_pengeluaran::where('id', $detailId)->update([
        //             'memotambahan_id' => $cetakpdf->id,
        //             'keterangan' => $data_pesanan['keterangan_tambahan'],
        //             'nominal' => $data_pesanan['nominal_tambahan'],
        //         ]);
        //     } else {
        //         $existingDetail = Detail_memotambahan::where([
        //             'memotambahan_id' => $cetakpdf->id,
        //             'keterangan' => $data_pesanan['keterangan_tambahan'],
        //         ])->first();

        //         if (!$existingDetail) {
        //             // Detail_memotambahan::create([
        //             //     'memotambahan_id' => $cetakpdf->id,
        //             //     'keterangan_tambahan' => $data_pesanan['keterangan_tambahan'],
        //             //     'nominal_tambahan' => $data_pesanan['nominal_tambahan'],
        //             // ]);
        //             Detail_pengeluaran::create([
        //                 'memotambahan_id' => $cetakpdf->id,
        //                 'barangakun_id' => 25,
        //                 'kode_akun' => 'KA000025',
        //                 'nama_akun' => 'MEMO TAMBAHAN',
        //                 'status' => 'pending',
        //                 'keterangan' => $data_pesanan['keterangan_tambahan'],
        //                 'nominal' => $data_pesanan['nominal_tambahan'],
        //             ]);
        //         }
        //     }
        // }


        $pengeluaran = Pengeluaran_kaskecil::where('memotambahan_id', $id)->first();
        $pengeluaran->update(
            [
                'kendaraan_id' => $request->kendaraan_id,
                'keterangan' => $allKeterangan, // Use accumulated keterangan values
                'grand_total' => str_replace(',', '.', str_replace('.', '', $request->grand_total)),
            ]
        );
        $detail_memo = Detail_memotambahan::where('memotambahan_id', $cetakpdf->id)->get();

        return view('admin.inquery_memotambahan.show', compact('cetakpdf', 'detail_memo'));
    }

    public function kodeakuns()
    {
        $ban = Detail_pengeluaran::all();
        if ($ban->isEmpty()) {
            $num = "000001";
        } else {
            $id = Detail_pengeluaran::getId();
            foreach ($id as $value);
            $idlm = $value->id;
            $idbr = $idlm + 1;
            $num = sprintf("%06s", $idbr);
        }

        $data = 'KKA';
        $kode_ban = $data . $num;
        return $kode_ban;
    }


    public function show($id)
    {
        $cetakpdf = Memotambahan::where('id', $id)->first();
        // $memotambahans = Memotambahan::where('memo_ekspedisi_id', $id)->first();
        $detail_memo = Detail_memotambahan::where('memotambahan_id', $cetakpdf->id)->get();
        return view('admin.inquery_memotambahan.show', compact('cetakpdf', 'detail_memo'));
    }

    public function unpostmemotambahan($id)
    {
        try {
            $item = Memotambahan::findOrFail($id);

            // hide dulu semenstara karena tidak ada memo inti
            // $biayatambahan = $item->memo_ekspedisi; // Adjust the relationship name accordingly

            // if (!$biayatambahan) {
            //     return 'memo tidak ada';
            // }

            $totaltambahan = $item->grand_total;

            // return $totaltambahan;

            // Update Saldo
            $lastSaldo = Saldo::latest()->first();

            if (!$lastSaldo) {
                return 'saldo tidak ada';
            }

            $sisaSaldo = $lastSaldo->sisa_saldo + $totaltambahan;

            Saldo::create([
                'sisa_saldo' => $sisaSaldo,
            ]);

            // Update Karyawan's Tabungan
            // $user = $biayatambahan->user;

            // if (!$user) {
            //     return 'user tidak ada';
            // }

            // $karyawan = $user->karyawan;

            // if (!$karyawan) {
            //     return 'karyawan tidak ada';
            // }

            // $tabungans = $karyawan->tabungan;
            // $deposits = $karyawan->deposit;

            // $karyawan->update([
            //     'deposit' => $deposits - $item->deposit_driver,
            //     'tabungan' => $tabungans - $item->deposit_driver,
            // ]);

            // Update Pengeluaran_kaskecil
            Pengeluaran_kaskecil::where('memotambahan_id', $id)->update([
                'status' => 'pending'
            ]);

            $detailpengeluaran = Detail_pengeluaran::where('memotambahan_id', $id);
            $detailpengeluaran->update([
                'status' => 'pending'
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

    public function postingmemotambahanfilter(Request $request)
    {
        $selectedIds = array_reverse(explode(',', $request->input('ids')));
        try {
            // Initialize total deduction amount
            $totalDeduction = 0;

            foreach ($selectedIds as $id) {
                $item = Memotambahan::findOrFail($id);

                // Pastikan hanya memproses memotambahan dengan status 'unpost'
                if ($item->status === 'unpost') {
                    // Accumulate total deduction amount
                    $totalDeduction += $item->grand_total;
                }
            }

            // Get the last saldo
            $lastSaldo = Saldo::latest()->first();

            if (!$lastSaldo) {
                return back()->with('error', 'Saldo tidak ditemukan');
            }

            // Check if saldo is sufficient
            if ($lastSaldo->sisa_saldo < $totalDeduction) {
                return back()->with('error', 'Saldo tidak mencukupi');
            }

            // Deduct the total amount from saldo
            $sisaSaldo = $lastSaldo->sisa_saldo - $totalDeduction;

            // Update saldo
            Saldo::create([
                'sisa_saldo' => $sisaSaldo,
            ]);

            // Update transactions and memo statuses
            foreach ($selectedIds as $id) {
                $item = Memotambahan::findOrFail($id);

                if ($item->status === 'unpost') {
                    Pengeluaran_kaskecil::where('memotambahan_id', $id)->update([
                        'status' => 'posting'
                    ]);

                    Detail_pengeluaran::where('memotambahan_id', $id)->update([
                        'status' => 'posting'
                    ]);

                    // Update the Memotambahan status
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
            // Initialize total restoration amount
            $totalRestoration = 0;

            foreach ($selectedIds as $id) {
                $item = Memotambahan::findOrFail($id);

                // Ensure only memos with status 'posting' are processed
                if ($item->status === 'posting') {
                    // Accumulate total restoration amount
                    $totalRestoration += $item->grand_total;
                }
            }

            // Get the last saldo
            $lastSaldo = Saldo::latest()->first();

            if (!$lastSaldo) {
                return back()->with('error', 'Saldo tidak ditemukan');
            }

            // Add the total restoration amount back to saldo
            $sisaSaldo = $lastSaldo->sisa_saldo + $totalRestoration;

            // Update saldo
            Saldo::create([
                'sisa_saldo' => $sisaSaldo,
            ]);

            // Update transactions and memo statuses
            foreach ($selectedIds as $id) {
                $item = Memotambahan::findOrFail($id);

                if ($item->status === 'posting') {
                    // Restore status of related transactions
                    Pengeluaran_kaskecil::where('memotambahan_id', $id)->update([
                        'status' => 'pending'
                    ]);

                    Detail_pengeluaran::where('memotambahan_id', $id)->update([
                        'status' => 'pending'
                    ]);

                    // Update the Memotambahan status
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

            // Assuming there's a foreign key relationship between Memo_ekspedisi and Memotambahan
            $biayatambahan = $item->memo_ekspedisi; // Adjust the relationship name accordingly

            if (!$biayatambahan) {
                return 'memo tidak ada';
            }

            $totaltambahan = $item->grand_total;

            // Update Saldo
            $lastSaldo = Saldo::latest()->first();

            if (!$lastSaldo) {
                return 'saldo tidak ada';
            }

            $sisaSaldo = $lastSaldo->sisa_saldo + $totaltambahan;

            Saldo::create([
                'sisa_saldo' => $sisaSaldo,
            ]);

            // Update Karyawan's Tabungan
            // $user = $biayatambahan->user;

            // if (!$user) {
            //     return 'user tidak ada';
            // }

            // $karyawan = $user->karyawan;

            // if (!$karyawan) {
            //     return 'karyawan tidak ada';
            // }

            // $tabungans = $karyawan->tabungan;
            // $deposits = $karyawan->deposit;

            // $karyawan->update([
            //     'deposit' => $deposits - $item->deposit_driver,
            //     'tabungan' => $tabungans - $item->deposit_driver,
            // ]);

            // Update Pengeluaran_kaskecil
            Pengeluaran_kaskecil::where('memotambahan_id', $id)->update([
                'status' => 'pending'
            ]);

            $detailpengeluaran = Detail_pengeluaran::where('memotambahan_id', $id);
            $detailpengeluaran->update([
                'status' => 'pending'
            ]);
            // Update Faktur_ekspedisi
            $detail_faktur = Detail_faktur::where('memotambahan_id', $id)->first();

            if ($detail_faktur) {
                $faktur_id = $detail_faktur->faktur_ekspedisi_id;

                Faktur_ekspedisi::where('id', $faktur_id)->update([
                    'status' => 'unpost'
                ]);

                // Additional checks and updates can be added if necessary
                // For example, you might want to check if the update was successful before proceeding

                // Update Memotambahan
                $item->update([
                    'status' => 'unpost',
                    'status_memo' => null
                ]);

                return back()->with('success', 'Berhasil');
            } else {
                // Handle the case where $detail_faktur is not found based on the provided $id
                return back()->with('error', 'Detail Faktur not found for the given ID');
            }
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // return back()->with('error', 'Memo tidak ditemukan');
        }
    }

    public function postingmemotambahan($id)
    {
        try {
            $item = Memotambahan::findOrFail($id);


            // semenstara hide dulu untuk memo yang tidak punya memo inti 
            // $biayatambahan = $item->memo_ekspedisi; 

            // if (!$biayatambahan) {
            //     return 'memo tidak ada';
            // }

            $totaltambahan = $item->grand_total;

            // Update Saldo
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
            // Update Pengeluaran_kaskecil
            Pengeluaran_kaskecil::where('memotambahan_id', $id)->update([
                'status' => 'posting'
            ]);

            $detailpengeluaran = Detail_pengeluaran::where('memotambahan_id', $id);
            $detailpengeluaran->update([
                'status' => 'posting'
            ]);
            // Update Memotambahan status
            $item->update([
                'status' => 'posting'
            ]);

            return back()->with('success', 'Berhasil');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // return back()->with('error', 'Memo tidak ditemukan');
        }
    }

    public function hapusmemotambahan($id)
    {
        $ban = Memotambahan::where('id', $id)->first();

        $ban->detail_memotambahan()->delete();
        $ban->pengeluaran_kaskecil()->delete();
        $ban->delete();
        return back()->with('success', 'Berhasil');
    }

    public function cetakpdf($id)
    {
        $cetakpdf = Memotambahan::where('id', $id)->first();
        // Generate PDF for Memotambahan
        $detail_memo = Detail_memotambahan::where('memotambahan_id', $cetakpdf->id)->get();
        $pdf = PDF::loadView('admin.inquery_memotambahan.cetak_pdf', compact('cetakpdf', 'detail_memo'));
        $pdf->setPaper('landscape'); // Set the paper size to portrait letter
        return $pdf->stream('Memo_ekspedisi.pdf');
    }


    public function cetak_memotambahanfilter(Request $request)
    {
        $selectedIds = explode(',', $request->input('ids'));

        // Now you can use $selectedIds to retrieve the selected IDs and generate the PDF as needed.

        $memos = Memotambahan::whereIn('id', $selectedIds)->orderBy('id', 'DESC')->get();

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('admin.inquery_memotambahan.cetak_pdffilter', compact('memos'));
        // $pdf->setPaper([0, 0, 600, 430], 'portrait'); // 612x396 piksel setara dengan 8.5x5.5 inci
        $pdf->setPaper('folio');

        return $pdf->stream('SelectedMemoTambahan.pdf');
    }

    //  public function unpostmemotambahan($id)
    //     {
    //         $item = Memotambahan::where('id', $id)->first();
    //         if (!$item) {
    //             return back()->with('error', 'Memo tidak ditemukan');
    //         }

    //         // Assuming there's a foreign key relationship between Memo_ekspedisi and Memotambahan
    //         $biayatambahan = Memotambahan::where('id', $id)->first();
    //         if (!$biayatambahan) {
    //             return back()->with('error', 'Biaya tambahan tidak ditemukan');
    //         }

    //         $totaltambahan = $biayatambahan->grand_total;

    //         $lastSaldo = Saldo::latest()->first();
    //         if (!$lastSaldo) {
    //             return back()->with('error', 'Saldo tidak ditemukan');
    //         }

    //         $sisaSaldo = $lastSaldo->sisa_saldo + $totaltambahan;
    //         Saldo::create([
    //             'sisa_saldo' => $sisaSaldo,
    //         ]);

    //         $memoekspedisi = Memo_ekspedisi::where('id', $id)->first();
    //         $user = User::where('id', $memoekspedisi->user_id)->first();
    //         if (!$user) {
    //             return back()->with('error', 'User tidak ditemukan');
    //         }
    //         $karyawan = Karyawan::where('id', $user->id)->first();
    //         if (!$karyawan) {
    //             return back()->with('error', 'Karyawan tidak ditemukan');
    //         }
    //         $tabungans = $karyawan->tabungan;
    //         $deposits = $karyawan->deposit;
    //         $karyawan->update([
    //             'deposit' => $deposits - $item->deposit_driver,
    //             'tabungan' => $tabungans - $item->deposit_driver,
    //         ]);

    //         Pengeluaran_kaskecil::where('memotambahan_id', $id)->update([
    //             'status' => 'pending'
    //         ]);

    //         // Update the Memo_ekspedisi status
    //         $item->update([
    //             'status' => 'unpost'
    //         ]);

    //         return back()->with('success', 'Berhasil');
    //     }

    // public function unpostmemotambahanselesai($id)
    // {
    //     $item = Memotambahan::where('id', $id)->first();
    //     if (!$item) {
    //         return back()->with('error', 'Memo tidak ditemukan');
    //     }

    //     // Assuming there's a foreign key relationship between Memo_ekspedisi and Memotambahan
    //     $biayatambahan = Memotambahan::where('id', $id)->first();
    //     if (!$biayatambahan) {
    //         return back()->with('error', 'Biaya tambahan tidak ditemukan');
    //     }

    //     $totaltambahan = $biayatambahan->grand_total;

    //     $lastSaldo = Saldo::latest()->first();
    //     if (!$lastSaldo) {
    //         return back()->with('error', 'Saldo tidak ditemukan');
    //     }

    //     $sisaSaldo = $lastSaldo->sisa_saldo + $totaltambahan;
    //     Saldo::create([
    //         'sisa_saldo' => $sisaSaldo,
    //     ]);

    //     $memoekspedisi = Memo_ekspedisi::where('id', $id)->first();
    //     $user = User::where('id', $memoekspedisi->user_id)->first();
    //     if (!$user) {
    //         return back()->with('error', 'User tidak ditemukan');
    //     }
    //     $karyawan = Karyawan::where('id', $user->id)->first();
    //     if (!$karyawan) {
    //         return back()->with('error', 'Karyawan tidak ditemukan');
    //     }

    //     $tabungans = $karyawan->tabungan;
    //     $deposits = $karyawan->deposit;
    //     $karyawan->update([
    //         'deposit' => $deposits - $item->deposit_driver,
    //         'tabungan' => $tabungans - $item->deposit_driver,
    //     ]);


    //     Pengeluaran_kaskecil::where('memotambahan_id', $id)->update([
    //         'status' => 'pending'
    //     ]);

    //     $detail_faktur = Detail_faktur::where('memotambahan_id', $id)->first();

    //     if ($detail_faktur) {
    //         $faktur_id = $detail_faktur->faktur_ekspedisi_id;

    //         Faktur_ekspedisi::where('id', $faktur_id)->update([
    //             'status' => 'unpost'
    //         ]);

    //         $item->update([
    //             'status' => 'unpost',
    //             'status_memo' => null
    //         ]);

    //         return back()->with('success', 'Berhasil');
    //     } else {
    //         // Handle the case where $detail_faktur is not found based on the provided $id
    //         return back()->with('error', 'Detail Faktur not found for the given ID');
    //     }
    // }

    // public function postingmemotambahan($id)
    // {
    //     $item = Memotambahan::where('id', $id)->first();
    //     if (!$item) {
    //         return back()->with('error', 'Memo tidak ditemukan');
    //     }

    //     // Assuming there's a foreign key relationship between Memo_ekspedisi and Memotambahan
    //     $biayatambahan = Memotambahan::where('id', $id)->first();
    //     if (!$biayatambahan) {
    //         return back()->with('error', 'Biaya tambahan tidak ditemukan');
    //     }
    //     $totaltambahan = $biayatambahan->grand_total;

    //     $lastSaldo = Saldo::latest()->first();
    //     if (!$lastSaldo) {
    //         return back()->with('error', 'Saldo tidak ditemukan');
    //     }

    //     $sisaSaldo = $lastSaldo->sisa_saldo - $totaltambahan;
    //     Saldo::create([
    //         'sisa_saldo' => $sisaSaldo,
    //     ]);

    //     $memoekspedisi = Memo_ekspedisi::where('id', $id)->first();
    //     $user = User::where('id', $memoekspedisi->user_id)->first();
    //     if (!$user) {
    //         return back()->with('error', 'User tidak ditemukan');
    //     }
    //     $karyawan = Karyawan::where('id', $user->id)->first();
    //     if (!$karyawan) {
    //         return back()->with('error', 'Karyawan tidak ditemukan');
    //     }
    //     $tabungans = $karyawan->tabungan;
    //     $deposits = $karyawan->deposit;
    //     $karyawan->update([
    //         'deposit' => $deposits + $item->deposit_driver,
    //         'tabungan' => $tabungans + $item->deposit_driver,
    //     ]);

    //     Pengeluaran_kaskecil::where('memotambahan_id', $id)->update([
    //         'status' => 'posting'
    //     ]);

    //     // Update the Memo_ekspedisi status
    //     $item->update([
    //         'status' => 'posting'
    //     ]);

    //     return back()->with('success', 'Berhasil');
    // }

    public function destroy($id)
    {
        $ban = Memotambahan::find($id);
        // $ban->detail_memo()->delete();
        $ban->delete();
        return redirect('admin/inquery_memotambahan')->with('success', 'Berhasil memperbarui memo tambahan');
    }

    public function deletedetailtambahan($id)
    {
        $item = Detail_memotambahan::find($id);

        if ($item) {
            // Temukan Memotambahan yang terkait dengan Detail_memotambahan
            $memo = Memotambahan::find($item->memotambahan_id);

            if ($memo) {
                // Kurangi nominal tambahan dari grand total
                $grand = $memo->grand_total;
                $nominal = $item->nominal_tambahan;
                $total = $grand - $nominal;

                // Perbarui grand total di Memotambahan
                $memo->update(['grand_total' => $total]);
            } else {
                return response()->json(['message' => 'Memo not found'], 404);
            }

            // Hapus Detail_memotambahan
            $item->delete();

            return response()->json(['message' => 'Data deleted successfully']);
        } else {
            return response()->json(['message' => 'Detail memo not found'], 404);
        }
    }
}