<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Admin\GajikaryawanController;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Barang_akun;
use App\Models\Detail_gajikaryawan;
use App\Models\Detail_pengeluaran;
use App\Models\Karyawan;
use App\Models\Kasbon_karyawan;
use App\Models\Kendaraan;
use App\Models\Laporankir;
use App\Models\Laporanstnk;
use App\Models\LogPerpanjangankir;
use App\Models\Pelanggan;
use App\Models\Pengeluaran_kaskecil;
use App\Models\Perhitungan_gajikaryawan;
use App\Models\Saldo;
use App\Models\Satuan;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class InqueryPengeluarankaskecilController extends Controller
{
    public function index(Request $request)
    {
        Pengeluaran_kaskecil::where([
            ['status', 'posting']
        ])->update([
            'status_notif' => true
        ]);

        $status = $request->status;
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;

        $inquery = Pengeluaran_kaskecil::query();

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
        return view('admin.inquery_pengeluarankaskecil.index', compact('inquery', 'saldoTerakhir'));
    }

    public function edit($id)
    {
        $inquery = Pengeluaran_kaskecil::where('id', $id)->first();
        $details  = Detail_pengeluaran::where('pengeluaran_kaskecil_id', $id)->get();
        $kendaraans = Kendaraan::all();
        $barangakuns = Barang_akun::all();
        return view('admin.inquery_pengeluarankaskecil.update', compact('details', 'barangakuns', 'inquery', 'kendaraans'));
    }

    public function update(Request $request, $id)
    {
        $error_pesanans = array();
        $data_pembelians = collect();

        if ($request->has('barangakun_id')) {
            for ($i = 0; $i < count($request->barangakun_id); $i++) {
                $validasi_produk = Validator::make($request->all(), [
                    'barangakun_id.' . $i => 'required',
                    'kode_akun.' . $i => 'required',
                    'nama_akun.' . $i => 'required',
                    'nominal.' . $i => 'required',
                    'keterangan.' . $i => 'required',
                ]);

                if ($validasi_produk->fails()) {
                    array_push($error_pesanans, "Akun nomor " . ($i + 1) . " belum dilengkapi!"); // Corrected the syntax for concatenation and indexing
                }

                $barangakun_id = is_null($request->barangakun_id[$i]) ? '' : $request->barangakun_id[$i];
                $kode_akun = is_null($request->kode_akun[$i]) ? '' : $request->kode_akun[$i];
                $nama_akun = is_null($request->nama_akun[$i]) ? '' : $request->nama_akun[$i];
                $nominal = is_null($request->nominal[$i]) ? '' : $request->nominal[$i];
                $keterangan = is_null($request->keterangan[$i]) ? '' : $request->keterangan[$i];


                $data_pembelians->push([
                    'detail_id' => $request->detail_ids[$i] ?? null,
                    'barangakun_id' => $barangakun_id,
                    'kode_akun' => $kode_akun,
                    'nama_akun' => $nama_akun,
                    'nominal' => $nominal,
                    'keterangan' => $keterangan,

                ]);
            }
        }

        if ($error_pesanans) {
            return back()
                ->withInput()
                ->with('error_pesanans', $error_pesanans)
                ->with('data_pembelians', $data_pembelians);
        }

        $tanggal1 = Carbon::now('Asia/Jakarta');
        $format_tanggal = $tanggal1->format('d F Y');

        $tanggal = Carbon::now()->format('Y-m-d');
        $cetakpdf = Pengeluaran_kaskecil::findOrFail($id);

        // Update the main transaction
        $cetakpdf->update([
            'kendaraan_id' => $request->kendaraan_id,
            // 'keterangan' => $request->keterangan,
            'nama_pelanggan' => $request->nama_pelanggan,
            'grand_total' => str_replace('.', '', $request->grand_total),
            // 'tanggal' => $format_tanggal,
            // 'tanggal_awal' => $tanggal,
        ]);

        $transaksi_id = $cetakpdf->id;
        $detailIds = $request->input('detail_ids');
        $allKeterangan = ''; // Initialize an empty string to accumulate keterangan values

        foreach ($data_pembelians as $data_pesanan) {
            $detailId = $data_pesanan['detail_id'];

            if ($detailId) {
                Detail_pengeluaran::where('id', $detailId)->update([
                    'pengeluaran_kaskecil_id' => $cetakpdf->id,
                    'kendaraan_id' => $request->kendaraan_id,
                    'barangakun_id' => $data_pesanan['barangakun_id'],
                    'kode_akun' => $data_pesanan['kode_akun'],
                    'nama_akun' => $data_pesanan['nama_akun'],
                    'nominal' => $data_pesanan['nominal'],
                    'keterangan' => $data_pesanan['keterangan'],
                ]);
                $allKeterangan .= $data_pesanan['keterangan'] . ', ';
            } else {
                $existingDetail = Detail_pengeluaran::where([
                    'pengeluaran_kaskecil_id' => $cetakpdf->id,
                    'barangakun_id' => $data_pesanan['barangakun_id'],
                    'kode_akun' => $data_pesanan['kode_akun'],
                    'nama_akun' => $data_pesanan['nama_akun'],
                    'nominal' => $data_pesanan['nominal'],
                    'keterangan' => $data_pesanan['keterangan'],

                ])->first();

                if (!$existingDetail) {
                    Detail_pengeluaran::create([
                        'pengeluaran_kaskecil_id' => $cetakpdf->id,
                        'kode_detailakun' => $this->kodeakuns(),
                        'kendaraan_id' => $request->kendaraan_id,
                        'barangakun_id' => $data_pesanan['barangakun_id'],
                        'kode_akun' => $data_pesanan['kode_akun'],
                        'nama_akun' => $data_pesanan['nama_akun'],
                        'nominal' => $data_pesanan['nominal'],
                        'keterangan' => $data_pesanan['keterangan'],
                    ]);
                }
                $allKeterangan .= $data_pesanan['keterangan'] . ', ';
            }
            // $allKeterangan .= $data_pesanan['keterangan'] . ', ';
        }

        $allKeterangan = rtrim($allKeterangan, ', ');

        // Update $allKeterangan in $cetakpdf after creating Detail_pengeluaran
        $cetakpdf->update([
            'keterangan' => $allKeterangan,
        ]);

        $details = Detail_pengeluaran::where('pengeluaran_kaskecil_id', $cetakpdf->id)->get();

        return view('admin.inquery_pengeluarankaskecil.show', compact('cetakpdf', 'details'));
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
        $cetakpdf = Pengeluaran_kaskecil::where('id', $id)->first();
        $details = Detail_pengeluaran::where('pengeluaran_kaskecil_id', $id)->get();

        return view('admin.inquery_pengeluarankaskecil.show', compact('cetakpdf', 'details'));
    }

    public function unpostpengeluaran($id)
    {
        $item = Pengeluaran_kaskecil::where('id', $id)->first();
        $lastSaldo = Saldo::latest()->first();

        if (!$lastSaldo) {
            return back()->with('error', 'Saldo tidak ditemukan');
        }
        $sisaSaldo = $lastSaldo->sisa_saldo + $item->grand_total;
        Saldo::create([
            'sisa_saldo' => $sisaSaldo,
        ]);

        // Update all rows in detail_pengeluaran based on pengeluaran_kaskecil_id
        Detail_pengeluaran::where('pengeluaran_kaskecil_id', $id)
            ->update([
                'status' => 'unpost'
            ]);

        // Update laporan_kir
        $laporankir_id = $item->laporankir_id;
        if ($laporankir_id) {
            Laporankir::where('id', $laporankir_id)
                ->update([
                    'status' => 'unpost'
                ]);
        }

        $laporanstnk_id = $item->laporanstnk_id;
        if ($laporanstnk_id) {
            Laporanstnk::where('id', $laporanstnk_id)
                ->update([
                    'status' => 'unpost'
                ]);
        }

        $kasbon_karyawan_id = $item->kasbon_karyawan_id;
        $kasbon_karyawan_ids = Kasbon_karyawan::where('id', $item->kasbon_karyawan_id)->first();

        if ($kasbon_karyawan_id) {
            $kasbonkaryawan = Kasbon_karyawan::where('id', $kasbon_karyawan_id)
                ->update([
                    'status' => 'unpost'
                ]);

            $karyawan = Karyawan::where('id', $kasbon_karyawan_ids->karyawan_id)->first();
            $kasbon = $karyawan->kasbon;
            $total = $item->grand_total;
            $kasbons = $kasbon - $total;

            Karyawan::where('id', $kasbon_karyawan_ids->karyawan_id)
                ->update([
                    'kasbon' => $kasbons,
                ]);
        }

        $GajiKaryawanss = $item->perhitungan_gajikaryawan_id;
        if ($GajiKaryawanss) {
            $GajiKaryawan = Perhitungan_gajikaryawan::where('id', $item->perhitungan_gajikaryawan_id)->first();
            Perhitungan_gajikaryawan::where('id', $item->perhitungan_gajikaryawan_id)->update([
                'status' => 'unpost'
            ]);
            $detailGaji = Detail_gajikaryawan::where('perhitungan_gajikaryawan_id', $GajiKaryawan->id)->get();

            foreach ($detailGaji as $detail) {
                $detail->update([
                    'status' => 'unpost'
                ]);
            }

            foreach ($detailGaji as $detail) {
                $karyawan = Karyawan::find($detail->karyawan_id);
                if ($karyawan) {
                    $kasbon = $karyawan->kasbon_backup;
                    $bayar_kasbon = $karyawan->bayar_kasbon;

                    // Mengurangi kasbon dan menambah bayar_kasbon
                    $karyawan->update([
                        'kasbon' => $kasbon + $detail->pelunasan_kasbon,
                        'bayar_kasbon' => $bayar_kasbon - $detail->pelunasan_kasbon,
                    ]);

                    // Cek jika hasil pengurangan pelunasan_kasbon dari kasbon adalah 0
                    if (($kasbon - $detail->pelunasan_kasbon) == 0) {
                        // Set potongan_ke menjadi 0
                        $karyawan->update([
                            'potongan_ke' => $karyawan->potongan_backup,
                            'kasbon' => $karyawan->kasbon_backup,
                            'kasbon_backup' => null,
                            'potongan_backup' => null
                        ]);
                    } else {
                        // Jika tidak 0, tambahkan 1 ke potongan_ke
                        if ($detail->pelunasan_kasbon != 0) {
                            $karyawan->decrement('potongan_ke', 1);
                        }
                    }
                }
            }

            Detail_pengeluaran::where('perhitungan_gajikaryawan_id', $GajiKaryawan->id)->update([
                'status' => 'unpost'
            ]);
        }

        $item->update([
            'status' => 'unpost'
        ]);

        return back()->with('success', 'Berhasil');
    }

    public function postingpengeluaran($id)
    {
        $item = Pengeluaran_kaskecil::where('id', $id)->first();
        $lastSaldo = Saldo::latest()->first();

        if (!$lastSaldo) {
            return back()->with('error', 'Saldo tidak ditemukan');
        }

        $uangjalan = $item->grand_total;
        if ($lastSaldo->sisa_saldo < $uangjalan) {
            return back()->with('error', 'Saldo tidak mencukupi');
        }
        $sisaSaldo = $lastSaldo->sisa_saldo - $item->grand_total;
        Saldo::create([
            'sisa_saldo' => $sisaSaldo,
        ]);

        // Update all rows in detail_pengeluaran based on pengeluaran_kaskecil_id
        Detail_pengeluaran::where('pengeluaran_kaskecil_id', $id)
            ->update([
                'status' => 'posting'
            ]);

        // Update laporan_kir
        $laporankir_id = $item->laporankir_id;
        if ($laporankir_id) {
            Laporankir::where('id', $laporankir_id)
                ->update([
                    'status' => 'posting'
                ]);
        }

        $laporanstnk_id = $item->laporanstnk_id;
        if ($laporanstnk_id) {
            Laporanstnk::where('id', $laporanstnk_id)
                ->update([
                    'status' => 'posting'
                ]);
        }

        $kasbon_karyawan_id = $item->kasbon_karyawan_id;
        $kasbon_karyawan_ids = Kasbon_karyawan::where('id', $item->kasbon_karyawan_id)->first();
        if ($kasbon_karyawan_id) {
            $kasbonkaryawan = Kasbon_karyawan::where('id', $kasbon_karyawan_id)
                ->update([
                    'status' => 'posting'
                ]);

            $karyawan = Karyawan::where('id', $kasbon_karyawan_ids->karyawan_id)->first();
            $kasbon = $karyawan->kasbon;
            $total = $item->grand_total;
            $kasbons = $kasbon + $total;

            Karyawan::where('id', $kasbon_karyawan_ids->karyawan_id)
                ->update([
                    'kasbon' => $kasbons,
                ]);
        }


        $GajiKaryawanss = $item->perhitungan_gajikaryawan_id;
        if ($GajiKaryawanss) {
            $GajiKaryawan = Perhitungan_gajikaryawan::where('id', $item->perhitungan_gajikaryawan_id)->first();
            Perhitungan_gajikaryawan::where('id', $item->perhitungan_gajikaryawan_id)->update([
                'status' => 'posting'
            ]);
            $detailGaji = Detail_gajikaryawan::where('perhitungan_gajikaryawan_id', $GajiKaryawan->id)->get();

            foreach ($detailGaji as $detail) {
                $detail->update([
                    'status' => 'posting'
                ]);
            }

            // return;
            foreach ($detailGaji as $detail) {
                $karyawan = Karyawan::find($detail->karyawan_id);
                if ($karyawan) {
                    $kasbon = $karyawan->kasbon;
                    $bayar_kasbon = $karyawan->bayar_kasbon;

                    $karyawan->update(['kasbon_backup' => $kasbon]);

                    // Memastikan potongan_ke tidak null
                    if ($karyawan->potongan_ke === null) {
                        $karyawan->potongan_ke = 0;
                    }
                    // Mengurangi kasbon dan menambah bayar_kasbon
                    $karyawan->update([
                        'kasbon' => $kasbon - $detail->pelunasan_kasbon,
                        'bayar_kasbon' => $bayar_kasbon + $detail->pelunasan_kasbon,
                    ]);

                    // Cek jika hasil pengurangan pelunasan_kasbon dari kasbon adalah 0
                    if (($kasbon - $detail->pelunasan_kasbon) == 0) {
                        // Set potongan_ke menjadi 0
                        $karyawan->update([
                            'potongan_backup' => $karyawan->potongan_ke,
                            'potongan_ke' => 0
                        ]);
                    } else {
                        // Jika tidak 0, tambahkan 1 ke potongan_ke
                        if ($detail->pelunasan_kasbon != 0) {
                            $karyawan->increment('potongan_ke', 1);
                        }
                    }
                }
            }


            Detail_pengeluaran::where('perhitungan_gajikaryawan_id', $GajiKaryawan->id)->update([
                'status' => 'posting'
            ]);
        }



        // Update the main record
        $item->update([
            'status' => 'posting'
        ]);

        return back()->with('success', 'Berhasil');
    }

    public function postingpengeluaranfilter(Request $request)
    {
        $selectedIds = array_reverse(explode(',', $request->input('ids')));

        try {
            // Initialize total deduction amount
            $totalDeduction = 0;

            foreach ($selectedIds as $id) {
                $item = Pengeluaran_kaskecil::findOrFail($id);

                // Pastikan hanya memproses pengeluaran dengan status 'unpost'
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
                $item = Pengeluaran_kaskecil::findOrFail($id);

                if ($item->status === 'unpost') {
                    // Update the main record
                    $item->update([
                        'status' => 'posting'
                    ]);

                    // Update all rows in detail_pengeluaran based on pengeluaran_kaskecil_id
                    Detail_pengeluaran::where('pengeluaran_kaskecil_id', $id)
                        ->update([
                            'status' => 'posting'
                        ]);

                    $laporankir_id = $item->laporankir_id;
                    if ($laporankir_id) {
                        Laporankir::where('id', $laporankir_id)
                            ->update([
                                'status' => 'posting'
                            ]);
                    }

                    $laporanstnk_id = $item->laporanstnk_id;
                    if ($laporanstnk_id) {
                        Laporanstnk::where('id', $laporanstnk_id)
                            ->update([
                                'status' => 'posting'
                            ]);
                    }

                    $kasbon_karyawan_id = $item->kasbon_karyawan_id;
                    $kasbon_karyawan_ids = Kasbon_karyawan::where('id', $item->kasbon_karyawan_id)->first();
                    if ($kasbon_karyawan_id) {
                        $kasbonkaryawan = Kasbon_karyawan::where('id', $kasbon_karyawan_id)
                            ->update([
                                'status' => 'posting'
                            ]);

                        $karyawan = Karyawan::where(
                            'id',
                            $kasbon_karyawan_ids->karyawan_id
                        )->first();
                        $kasbon = $karyawan->kasbon;
                        $total = $item->grand_total;
                        $kasbons = $kasbon + $total;

                        Karyawan::where('id', $kasbon_karyawan_ids->karyawan_id)
                            ->update([
                                'kasbon' => $kasbons,
                            ]);
                    }


                    $GajiKaryawanss = $item->perhitungan_gajikaryawan_id;
                    if ($GajiKaryawanss) {
                        $GajiKaryawan = Perhitungan_gajikaryawan::where('id', $item->perhitungan_gajikaryawan_id)->first();
                        Perhitungan_gajikaryawan::where('id', $item->perhitungan_gajikaryawan_id)->update([
                            'status' => 'posting'
                        ]);
                        $detailGaji = Detail_gajikaryawan::where('perhitungan_gajikaryawan_id', $GajiKaryawan->id)->get();

                        foreach ($detailGaji as $detail) {
                            $detail->update([
                                'status' => 'posting'
                            ]);
                        }

                        // return;
                        // return;
                        foreach ($detailGaji as $detail) {
                            $karyawan = Karyawan::find($detail->karyawan_id);
                            if ($karyawan) {
                                $kasbon = $karyawan->kasbon;
                                $bayar_kasbon = $karyawan->bayar_kasbon;

                                $karyawan->update(['kasbon_backup' => $kasbon]);

                                // Memastikan potongan_ke tidak null
                                if ($karyawan->potongan_ke === null) {
                                    $karyawan->potongan_ke = 0;
                                }
                                // Mengurangi kasbon dan menambah bayar_kasbon
                                $karyawan->update([
                                    'kasbon' => $kasbon - $detail->pelunasan_kasbon,
                                    'bayar_kasbon' => $bayar_kasbon + $detail->pelunasan_kasbon,
                                ]);

                                // Cek jika hasil pengurangan pelunasan_kasbon dari kasbon adalah 0
                                if (($kasbon - $detail->pelunasan_kasbon) == 0) {
                                    // Set potongan_ke menjadi 0
                                    $karyawan->update([
                                        'potongan_backup' => $karyawan->potongan_ke,
                                        'potongan_ke' => 0
                                    ]);
                                } else {
                                    // Jika tidak 0, tambahkan 1 ke potongan_ke
                                    if ($detail->pelunasan_kasbon != 0) {
                                        $karyawan->increment('potongan_ke', 1);
                                    }
                                }
                            }
                        }


                        Detail_pengeluaran::where('perhitungan_gajikaryawan_id', $GajiKaryawan->id)->update([
                            'status' => 'posting'
                        ]);
                    }
                }
            }

            return back()->with('success', 'Berhasil memposting pengeluaran yang dipilih');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return back()->with('error', 'Terdapat pengeluaran yang tidak ditemukan');
        }
    }

    public function unpostpengeluaranfilter(Request $request)
    {
        $selectedIds = array_reverse(explode(',', $request->input('ids')));

        try {
            // Initialize total deduction amount
            $totalDeduction = 0;

            foreach ($selectedIds as $id) {
                $item = Pengeluaran_kaskecil::findOrFail($id);

                // Pastikan hanya memproses pengeluaran dengan status 'unpost'
                if ($item->status === 'posting') {
                    // Accumulate total deduction amount
                    $totalDeduction += $item->grand_total;
                }
            }

            // Get the last saldo
            $lastSaldo = Saldo::latest()->first();

            if (!$lastSaldo) {
                return back()->with('error', 'Saldo tidak ditemukan');
            }

            // Deduct the total amount from saldo
            $sisaSaldo = $lastSaldo->sisa_saldo + $totalDeduction;

            // Update saldo
            Saldo::create([
                'sisa_saldo' => $sisaSaldo,
            ]);

            // Update transactions and memo statuses
            foreach ($selectedIds as $id) {
                $item = Pengeluaran_kaskecil::findOrFail($id);

                if ($item->status === 'posting') {
                    // Update the main record
                    $item->update([
                        'status' => 'unpost'
                    ]);

                    // Update all rows in detail_pengeluaran based on pengeluaran_kaskecil_id
                    Detail_pengeluaran::where('pengeluaran_kaskecil_id', $id)
                        ->update([
                            'status' => 'unpost'
                        ]);

                    $laporankir_id = $item->laporankir_id;
                    if ($laporankir_id) {
                        Laporankir::where('id', $laporankir_id)
                            ->update([
                                'status' => 'unpost'
                            ]);
                    }

                    $laporanstnk_id = $item->laporanstnk_id;
                    if ($laporanstnk_id) {
                        Laporanstnk::where('id', $laporanstnk_id)
                            ->update([
                                'status' => 'unpost'
                            ]);
                    }

                    $kasbon_karyawan_id = $item->kasbon_karyawan_id;
                    $kasbon_karyawan_ids = Kasbon_karyawan::where('id', $item->kasbon_karyawan_id)->first();

                    if ($kasbon_karyawan_id) {
                        $kasbonkaryawan = Kasbon_karyawan::where('id', $kasbon_karyawan_id)
                            ->update([
                                'status' => 'unpost'
                            ]);

                        $karyawan = Karyawan::where('id', $kasbon_karyawan_ids->karyawan_id)->first();
                        $kasbon = $karyawan->kasbon;
                        $total = $item->grand_total;
                        $kasbons = $kasbon - $total;

                        Karyawan::where('id', $kasbon_karyawan_ids->karyawan_id)
                            ->update([
                                'kasbon' => $kasbons,
                            ]);
                    }

                    $GajiKaryawanss = $item->perhitungan_gajikaryawan_id;
                    if ($GajiKaryawanss) {
                        $GajiKaryawan = Perhitungan_gajikaryawan::where('id', $item->perhitungan_gajikaryawan_id)->first();
                        Perhitungan_gajikaryawan::where('id', $item->perhitungan_gajikaryawan_id)->update([
                            'status' => 'unpost'
                        ]);
                        $detailGaji = Detail_gajikaryawan::where('perhitungan_gajikaryawan_id', $GajiKaryawan->id)->get();

                        foreach ($detailGaji as $detail) {
                            $detail->update([
                                'status' => 'unpost'
                            ]);
                        }

                        foreach ($detailGaji as $detail) {
                            $karyawan = Karyawan::find($detail->karyawan_id);
                            if ($karyawan) {
                                $kasbon = $karyawan->kasbon_backup;
                                $bayar_kasbon = $karyawan->bayar_kasbon;

                                // Mengurangi kasbon dan menambah bayar_kasbon
                                $karyawan->update([
                                    'kasbon' => $kasbon + $detail->pelunasan_kasbon,
                                    'bayar_kasbon' => $bayar_kasbon - $detail->pelunasan_kasbon,
                                ]);

                                // Cek jika hasil pengurangan pelunasan_kasbon dari kasbon adalah 0
                                if (($kasbon - $detail->pelunasan_kasbon) == 0) {
                                    // Set potongan_ke menjadi 0
                                    $karyawan->update([
                                        'potongan_ke' => $karyawan->potongan_backup,
                                        'kasbon' => $karyawan->kasbon_backup,
                                        'kasbon_backup' => null,
                                        'potongan_backup' => null
                                    ]);
                                } else {
                                    // Jika tidak 0, tambahkan 1 ke potongan_ke
                                    if ($detail->pelunasan_kasbon != 0) {
                                        $karyawan->decrement('potongan_ke', 1);
                                    }
                                }
                            }
                        }

                        Detail_pengeluaran::where('perhitungan_gajikaryawan_id', $GajiKaryawan->id)->update([
                            'status' => 'unpost'
                        ]);
                    }
                }
            }

            return back()->with('success', 'Berhasil unpost pengeluaran yang dipilih');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return back()->with('error', 'Terdapat pengeluaran yang tidak ditemukan');
        }
    }

    public function hapuspengeluaran($id)
    {
        $item = Pengeluaran_kaskecil::where('id', $id)->first();

        // $item->detail_tagihan()->delete();
        $item->delete();

        return back()->with('success', 'Berhasil');
    }

    public function deletedetailpengeluaran($id)
    {
        $item = Detail_pengeluaran::find($id);

        if ($item) {
            $item->delete();
            return response()->json(['message' => 'Data deleted successfully']);
        } else {
            return response()->json(['message' => 'Detail Faktur not found'], 404);
        }
    }
}